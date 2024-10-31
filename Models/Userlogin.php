<?php

require_once __DIR__ . '/../Models/Model.php';

class User extends Model {
    public $email;
    private $password;
    public $name;
    public $birthday;

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

    public function login($email, $password) {
        $sql = "SELECT password FROM userlogin WHERE email = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $this->__construct($email);

                $infoSql = "SELECT name, birthday FROM userinfo WHERE email = ?";
                $infoStmt = $this->conn->prepare($infoSql);
                $infoStmt->bind_param("s", $email);
                $infoStmt->execute();
                $infoResult = $infoStmt->get_result();

                if ($infoData = $infoResult->fetch_assoc()) {
                    $this->name = $infoData['name'];
                    $this->birthday = $infoData['birthday'];
                }
                return true;  
            }
        }

        return false;
    }
}

?>
