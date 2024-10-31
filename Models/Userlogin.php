<?php

require_once __DIR__ . '/../Models/Model.php';

class User extends Model {
    public $email;
    private $password;
    public $name;
    public $birthday;
    public $roles;

    public function __construct($email = "") {
        parent::__construct();
        $this->email = $email;

        if (!empty($email)) {
            $sql = "SELECT password FROM userlogin WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($data = $result->fetch_assoc()) {
                $this->password = $data['password'];
            }
        } else {
            $this->password = "";
        }
    }
    public function login($email, $password, $selectedRole) {
        // Query to get the hashed password and role from the database
        $sql = "SELECT ul.password, g.name AS role FROM userlogin ul
                JOIN usergroup ug ON ul.email = ug.email
                JOIN groups g ON ug.group_id = g.id
                WHERE ul.email = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword, $actualRole);
            $stmt->fetch();
    
            // Verify password and check if the role matches the selected role
            if (password_verify($password, $hashedPassword) && strtolower($actualRole) === strtolower($selectedRole)) {
                // Fetch user info
                $infoSql = "SELECT name, birthday FROM userinfo WHERE email = ?";
                $infoStmt = $this->conn->prepare($infoSql);
                $infoStmt->bind_param("s", $email);
                $infoStmt->execute();
                $infoResult = $infoStmt->get_result();
    
                if ($infoData = $infoResult->fetch_assoc()) {
                    $this->name = $infoData['name'];
                    $this->birthday = $infoData['birthday'];
                    $this->role = $actualRole;
                }
    
                return true; // Login successful and role verified
            }
        }
    
        return false; // Login failed or role mismatch
    }
}
?>
