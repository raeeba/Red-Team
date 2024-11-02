<?php

require_once __DIR__ . '/../Models/Model.php';

class User extends Model {
    public $email;
    private $password;
    public $name;
    public $birthday;
    public $role;
    public $group_id;
    public $adminType;

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
            
            // Hash the input password using SHA-1 and compare with the stored hash
            $inputHash = sha1($password);
            echo "<pre>Debug: Password hash from input - $inputHash</pre>";
    
            if ($inputHash === $hashedPassword) {
                echo "<pre>Debug: Password verified successfully.</pre>";
    
                // Get the roles of the user from groupsuser table
                $roleSql = "SELECT group_id FROM usergroup WHERE email = ?";
                $roleStmt = $this->conn->prepare($roleSql);
                $roleStmt->bind_param("s", $email);
                $roleStmt->execute();
                $roleResult = $roleStmt->get_result();
    
                $roles = [];
                while ($row = $roleResult->fetch_assoc()) {
                    $roles[] = $row['group_id'];
                }
    
                // Determine role based on group membership
                if (in_array(2, $roles)) {
                    $this->role = 'super admin'; // Higher privilege role
                } else if (in_array(1, $roles)) {
                    $this->role = 'admin';
                }
                $infoSql = "SELECT name FROM userinfo WHERE email = ?";
                $infoStmt = $this->conn->prepare($infoSql);
                $infoStmt->bind_param("s", $email);
                $infoStmt->execute();
                $infoResult = $infoStmt->get_result();
    
                if ($infoData = $infoResult->fetch_assoc()) {
                    $this->name = $infoData['name'];
                    echo "<pre>Debug: Fetched user name - " . $this->name . "</pre>";
                } else {
                    echo "<pre>Debug: No user found in userinfo with email: " . $email . "</pre>";
                }
    
                $this->email = $email; // Store user email for session use
                return true;
            } else {
                echo "<pre>Debug: Password verification failed.</pre>";
            }
        } else {
            echo "<pre>Debug: No user found with that email.</pre>";
        }
    
        return false; // Login failed
    }
    
    public static function list() {
        $sql = "
        SELECT 
        u.email,
        ui.name AS employeeName,
        ui.birthday,
        CASE
            WHEN ug.group_id = 2 THEN 'super admin'
            WHEN ug.group_id = 1 THEN 'admin'
            ELSE 'user'
        END AS adminType
    FROM userlogin u
    INNER JOIN userinfo ui ON u.email = ui.email
    INNER JOIN usergroup ug ON u.email = ug.email
    GROUP BY u.email
    ORDER BY CASE 
        WHEN adminType = 'super admin' THEN 1
        WHEN adminType = 'admin' THEN 2
        ELSE 3
    END
    ";
    
        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $employees = [];
        while ($row = $result->fetch_assoc()) {
            $employee = new User();
            $employee->name = $row['employeeName'];
            $employee->email = $row['email'];
            $employee->birthday = $row['birthday'];
            $employee->adminType = $row['adminType'];
    
            $employees[] = $employee;
        }
    
        return $employees;
    }

    

    

    public function generateOTP($length = 6) {
        return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

    public function sendOTPEmail($toEmail, $otp) {
        $subject = "Your 2FA Verification Code";
        $message = "Your OTP code is: $otp\n\nPlease use this code to verify your identity. The code is valid for 5 minutes.";
        $headers = "From: no-reply@yourdomain.com";

        // Send email
        if (mail($toEmail, $subject, $message, $headers)) {
            echo "OTP has been sent to $toEmail.";
        } else {
            echo "Failed to send OTP. Please try again.";
        }
    }
}
?>
