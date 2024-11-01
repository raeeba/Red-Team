<?php

require_once __DIR__ . '/../Models/Model.php';

class User extends Model {
    public $email;
    private $password;
    public $name;
    public $birthday;
    public $role;
    public $group_id;

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
    public function login($email, $password, $role) {
        // SQL query to fetch the hashed password and user's role
        $sql = "SELECT ul.password, ug.group_id, g.name AS role_name
                FROM userlogin ul
                LEFT JOIN usergroup ug ON ul.email = ug.email
                LEFT JOIN groups g ON ug.group_id = g.id
                WHERE ul.email = ?";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword, $groupId, $roleName);
            $stmt->fetch();
            
            // Debug: Print out fetched role name to confirm what was retrieved
            echo "<pre>Debug: Fetched role from DB - '$roleName'</pre>";
    
            // Hash the input password using SHA-1 and compare with the stored hash
            $inputHash = sha1($password);
            echo "<pre>Debug: Password hash from input - $inputHash</pre>";
    
            if ($inputHash === $hashedPassword) {
                echo "<pre>Debug: Password verified successfully.</pre>";
    
                // Assign user data to the object properties
                $this->email = $email;
                $this->role = $roleName; // Assign role name to the user object
                $this->group_id = $groupId;
    
                return true;
            } else {
                echo "<pre>Debug: Password verification failed.</pre>";
            }
        } else {
            echo "<pre>Debug: No user found with that email.</pre>";
        }
    
        return false; // If no matching user or verification fails, return false
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
