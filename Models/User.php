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

    // constrcutor 
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

    // login
    public function login($email, $password) {
        $sql = "SELECT password FROM userlogin WHERE email = ?"; // get password associated with provided email
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword); 
            $stmt->fetch();
            
            $inputHash = sha1($password);
    
            if ($inputHash === $hashedPassword) { 
    
                $roleSql = "SELECT group_id FROM usergroup WHERE email = ?";
                $roleStmt = $this->conn->prepare($roleSql);
                $roleStmt->bind_param("s", $email);
                $roleStmt->execute();
                $roleResult = $roleStmt->get_result();
    
                //this will be used for the menu
                $roles = [];
                while ($row = $roleResult->fetch_assoc()) {
                    $roles[] = $row['group_id'];
                }
                //a super admin has admin access. the point is to give super admin the higher privilege
                if (in_array(2, $roles)) {
                    $this->role = 'super admin'; // higher privilege role
                } else if (in_array(1, $roles)) {
                    $this->role = 'admin';
                }

                // get user name
                $infoSql = "SELECT name FROM userinfo WHERE email = ?"; // get name associated with email
                $infoStmt = $this->conn->prepare($infoSql);
                $infoStmt->bind_param("s", $email);
                $infoStmt->execute();
                $infoResult = $infoStmt->get_result();
    
                if ($infoData = $infoResult->fetch_assoc()) {
                    //to be stored in the session
                    $this->name = $infoData['name'];
                } else {
                }
    
                $this->email = $email;  
                return true;
            } else {
            }
        } else {
        }
    
        return false; 
    }
    // 2-factor authentication
    // send email with authentication code
    public function sendAuthenticationCode($email){
        $code = bin2hex(random_bytes(4));
        $hashedCode = sha1($code); // hash code to store in db
        $codeExpiry = date("Y-m-d H:i:s", time() + 60 * 5); // set expiration time for code (5 minutes)

        // store code and expiry time in db
        $sql = "UPDATE userlogin 
        SET authentication_code = ?,
                    authentication_code_expires_at = ?
                WHERE email = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $hashedCode, $codeExpiry, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->affected_rows> 0){

            $mail = require "mailer.php";

            // send email to user
            $mail->setFrom('sender-email@gmail.com'); // replace with sender's email
            $mail->addAddress($email);
            $mail->Subject = "Authentication";
            $mail->Body = <<<END
            <html>
                <body>
                    <p> A new login has been detected </p>
                    <p>Your code is <strong>$code</strong></p>
                    <p> This code will expire in 5 minutes.</p>
                </body>
            </html>

            END;

            try{
                $mail->send();
                return true;
                 echo "Message was sent";
            } catch (Exception $e){
                 echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                return false;
            }
        }
    }

    // check if user has entered the correct authentication code
    public function isAuthenticated($email, $code) {
        // get authentication code and authentication code expiry associated with provided email
        $sql = "SELECT authentication_code, authentication_code_expires_at FROM userlogin WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();  
        $stmt->bind_result($storedCode, $expiryDate); // store authentication code and authentication code expiry stored in db
        $stmt->fetch();
    
        if ($stmt->num_rows == 0) {  
            $stmt->close();  
            return false; 
        }

        $inputHash = sha1($code); // hash authentication code enetred by user
    
        //convert times to same format for comparison
        $currentTime = new DateTime(); 
        $expiryDate = new DateTime($expiryDate); 
    
        if ($inputHash !== $storedCode) { // check if code entered by user matches code stored in db
            //echo "Code error";
            $stmt->close();
            return false; 
        }
    
        if ($currentTime > $expiryDate) {  // check if expiration date has passed
            //echo "Code has expired";
            $stmt->close();
            return false; 
        }
    
        // update code and expiration time to null once user has been authenticated (enetred the correct code)
        $sql = "UPDATE userlogin 
                SET authentication_code = NULL, authentication_code_expires_at = NULL 
                WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        // check if update worked
        if ($stmt->affected_rows > 0) {
            $stmt->close();  
            return true; 
        }
    
        $stmt->close();  
        return false; 
    }

    // forgot password
    // send email for forgot password
    public function sendResetPasswordLink($email){
        $code = bin2hex(random_bytes(4));
        $hashedCode = sha1($code); // hash code to store in db
        $expiry = date("Y-m-d H:i:s", time() + 60 * 5); // set expiration time for code (5 minutes)

        // store code and expiry time in db at the provided email
        $sql = "UPDATE userlogin 
        SET reset_token_hash = ?,
                    reset_token_expires_at = ?
                WHERE email = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $hashedCode, $expiry, $email);
        $stmt->execute();
        $stmt->store_result();

        // send email to user with link to reset password form and reset password code
        if ($stmt->affected_rows> 0){
            $basePath = $this->getBasePath();
            $mail = require "mailer.php";

            $mail->setFrom('sender-email@gmail.com'); // replace with sender's email
            $mail->addAddress($email);
            $mail->Subject = "Password Reset";
            $resetUrl = $basePath . "/Red-Team/en/user/reset";
            $mail->Body = <<<END
            
              Click <a href="$resetUrl">here</a> to reset your password.
              <p>Your password reset code is: $code </p>

            END;
            
            try{
                $mail->send();
                 echo "Message was sent";
                 return true;
            } catch (Exception $e){
                 echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                 return false;
            }
        }
    }

        // check if entered code matches code in database 
        public function resetPassword($code, $email, $password, $confirmPassword) {
            // get reset code and reset code expiry associated with provided email
            $sql = "SELECT reset_token_hash, reset_token_expires_at FROM userlogin WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email); 
            $stmt->execute();
            $stmt->store_result();  
            $stmt->bind_result($storedCode, $expiryDate); // store code and code expiry from db 
            $stmt->fetch();
        
            if ($stmt->num_rows == 0) {  
                $stmt->close();  
                return false; 
            }
        
            $inputHash = sha1($code); // hash code entered by user

            //convert times to same format for comparison
            $currentTime = new DateTime(); 
            $expiryDate = new DateTime($expiryDate); 
        
            if ($inputHash !== $storedCode) { // check if codes match
                echo "Wrong code.";
                return false; 
            }
        
            if ($currentTime > $expiryDate) {  // check if expiration date has passed
                echo "Code has expired.";
                return false; 
            }
        
            if ($password !== $confirmPassword) { // check if passwords match
                echo "Passwords do not match.";
                return false; 
            }
        
            $password_hash = hash("sha1", $password); // hash password
        
            // set tokens and expiration times to null
            // store hashed password in db
            $sql = "UPDATE userlogin 
                    SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL 
                    WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $password_hash, $email);
            $stmt->execute();
        
            // check if update was successful
            if ($stmt->affected_rows > 0) {
                $stmt->close();  
                return true; 
            }
        
            $stmt->close();  
            return false; 
        }
        

    // list employees 
    public static function list() {
        // get employee info
        $sql = "
                SELECT 
                u.email,
                ui.name AS employeeName,
                ui.birthday,
                CASE
                    WHEN MAX(ug.group_id) = 2 THEN 'super admin'
                    WHEN MAX(ug.group_id) = 1 THEN 'admin'
                    ELSE 'user'
                END AS adminType
            FROM userlogin u
            INNER JOIN userinfo ui ON u.email = ui.email
            INNER JOIN usergroup ug ON u.email = ug.email
            GROUP BY u.email, ui.name, ui.birthday
            ORDER BY CASE 
                WHEN MAX(ug.group_id) = 2 THEN 1
                WHEN MAX(ug.group_id) = 1 THEN 2
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

    // get user by their email
    public static function getUserByEmail($email) {
        $conn = Database::getConnection();
    
        // check if db connection is null 
        if ($conn === null) {
            echo "Error: Database connection is null.";
            return false;
        }

        // get user associated with provided email
        $sql = "SELECT * FROM userinfo WHERE email = ?"; 
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_object();
    }
    
    // update user by their email
    public static function updateUserByEmail($email, $name, $birthday, $role) {
        $conn = Database::getConnection();
    
        // check if db connection is null 
        if ($conn === null) {
            echo "Error: Database connection is null.";
            return false;
        }
    
        // update user's information (name, birthday, email)
        $sql = "
            UPDATE userinfo 
            SET name = ?, birthday = ?
            WHERE email = ?
        ";
    
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            return false;
        }
    
        $stmt->bind_param("sss", $name, $birthday, $email);
    
        if (!$stmt->execute()) {
            echo "Error updating employee information: " . $stmt->error;
            return false;
        }
    
        // if user role is changed to super admin
        if ($role === 'super admin') {
            // insert to usergroup table
            $sqlInsertSuperAdmin = "
                INSERT INTO usergroup (email, group_id) VALUES (?, 2)
                ON DUPLICATE KEY UPDATE group_id = group_id
            ";
    
            $stmtInsertSuperAdmin = $conn->prepare($sqlInsertSuperAdmin);
            if (!$stmtInsertSuperAdmin) {
                echo "Error preparing statement for assigning super admin role: " . $conn->error;
                return false;
            }
            $stmtInsertSuperAdmin->bind_param("s", $email);
            if (!$stmtInsertSuperAdmin->execute()) {
                echo "Error assigning super admin role: " . $stmtInsertSuperAdmin->error;
                return false;
            }
    
         // if user role is changed to admin
        } else if ($role === 'admin') {
            // remove super admin entry in usergroup table
            $sqlRemoveSuperAdmin = "
                DELETE FROM usergroup 
                WHERE email = ? AND group_id = 2
            ";
    
            $stmtRemoveSuperAdmin = $conn->prepare($sqlRemoveSuperAdmin);
            if (!$stmtRemoveSuperAdmin) {
                echo "Error preparing statement for removing super admin role: " . $conn->error;
                return false;
            }
            $stmtRemoveSuperAdmin->bind_param("s", $email);
            if (!$stmtRemoveSuperAdmin->execute()) {
                echo "Error removing super admin role: " . $stmtRemoveSuperAdmin->error;
                return false;
            }
        }
    
        return true;
    }

    // assign user role by their email
    public static function assignRoleByEmail($email, $role) {
        global $conn;

        // insert into usergroup table
        $sql = "INSERT INTO usergroup (email, group_id) 
                SELECT ?, id 
                FROM groups 
                WHERE name = ?
                ON DUPLICATE KEY UPDATE group_id = VALUES(group_id)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            return false;
        }

        $stmt->bind_param("ss", $email, $role);
        
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error assigning role: " . $stmt->error;
            return false;
        }
    }

    // delete user(s) by their email
    public static function deleteUsersByEmails($emails) {
        $conn = Database::getConnection();

        if ($conn === null) {
            echo "Error: Database connection is null.";
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($emails), '?'));

        try {
            $conn->begin_transaction();

            // Delete from usergroup table
            $sqlUserGroup = "DELETE FROM usergroup WHERE email IN ($placeholders)";
            $stmtUserGroup = $conn->prepare($sqlUserGroup);
            if (!$stmtUserGroup) {
                throw new Exception("Error preparing statement for deleting usergroup: " . $conn->error);
            }
            $types = str_repeat('s', count($emails));
            $stmtUserGroup->bind_param($types, ...$emails);
            if (!$stmtUserGroup->execute()) {
                throw new Exception("Error deleting from usergroup: " . $stmtUserGroup->error);
            }

            // Delete from userinfo table
            $sqlUserInfo = "DELETE FROM userinfo WHERE email IN ($placeholders)";
            $stmtUserInfo = $conn->prepare($sqlUserInfo);
            if (!$stmtUserInfo) {
                throw new Exception("Error preparing statement for deleting userinfo: " . $conn->error);
            }
            $stmtUserInfo->bind_param($types, ...$emails);
            if (!$stmtUserInfo->execute()) {
                throw new Exception("Error deleting from userinfo: " . $stmtUserInfo->error);
            }

            // Delete from userlogin table
            $sqlUserLogin = "DELETE FROM userlogin WHERE email IN ($placeholders)";
            $stmtUserLogin = $conn->prepare($sqlUserLogin);
            if (!$stmtUserLogin) {
                throw new Exception("Error preparing statement for deleting userlogin: " . $conn->error);
            }
            $stmtUserLogin->bind_param($types, ...$emails);
            if (!$stmtUserLogin->execute()) {
                throw new Exception("Error deleting from userlogin: " . $stmtUserLogin->error);
            }

            $conn->commit();
            return true;

        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
            return false;
        }
    }

    // add new user 
    public static function addNewUser($firstName, $lastName, $birthday, $email, $password, $role) {
        $conn = Database::getConnection();

        $conn->begin_transaction();
        $hashedPassword = sha1($password);

        // insert into userlogin table
        try {
            $sqlUserLogin = "INSERT INTO userlogin (email, password) VALUES (?, ?)";
            $stmtUserLogin = $conn->prepare($sqlUserLogin);
            $stmtUserLogin->bind_param("ss", $email, $hashedPassword);
            if (!$stmtUserLogin->execute()) {
                throw new Exception("Error inserting into userlogin: " . $stmtUserLogin->error);
            }

            $sqlUserInfo = "INSERT INTO userinfo (email, name, birthday) VALUES (?, ?, ?)";
            $stmtUserInfo = $conn->prepare($sqlUserInfo);
            $name = $firstName . ' ' . $lastName;
            $stmtUserInfo->bind_param("sss", $email, $name, $birthday);
            if (!$stmtUserInfo->execute()) {
                throw new Exception("Error inserting into userinfo: " . $stmtUserInfo->error);
            }

            // insert into user group table
            if ($role === 'super admin') { // if user is super admin
                $sqlUserGroupAdmin = "INSERT INTO usergroup (email, group_id) VALUES (?, 1)";
                $stmtUserGroupAdmin = $conn->prepare($sqlUserGroupAdmin);
                $stmtUserGroupAdmin->bind_param("s", $email);
                if (!$stmtUserGroupAdmin->execute()) {
                    throw new Exception("Error inserting admin role into usergroup: " . $stmtUserGroupAdmin->error);
                }

                $sqlUserGroupSuperAdmin = "INSERT INTO usergroup (email, group_id) VALUES (?, 2)";
                $stmtUserGroupSuperAdmin = $conn->prepare($sqlUserGroupSuperAdmin);
                $stmtUserGroupSuperAdmin->bind_param("s", $email);
                if (!$stmtUserGroupSuperAdmin->execute()) {
                    throw new Exception("Error inserting super admin role into usergroup: " . $stmtUserGroupSuperAdmin->error);
                }
            } else { // if user is admin
                $groupId = 1; 
                $sqlUserGroup = "INSERT INTO usergroup (email, group_id) VALUES (?, ?)";
                $stmtUserGroup = $conn->prepare($sqlUserGroup);
                $stmtUserGroup->bind_param("si", $email, $groupId);
                if (!$stmtUserGroup->execute()) {
                    throw new Exception("Error inserting into usergroup: " . $stmtUserGroup->error);
                }
            }

            $conn->commit();
            return true;

        } catch (Exception $e) {
            $conn->rollback();
            echo $e->getMessage();
            return false;
        }
    }
}


// public function generateOTP($length = 6) {
//     return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
// }

// public function sendOTPEmail($toEmail, $otp) {
//     $subject = "Your 2FA Verification Code";
//     $message = "Your OTP code is: $otp\n\nPlease use this code to verify your identity. The code is valid for 5 minutes.";
//     $headers = "From: no-reply@yourdomain.com";

//     // Send email
//     if (mail($toEmail, $subject, $message, $headers)) {
//         echo "OTP has been sent to $toEmail.";
//     } else {
//         echo "Failed to send OTP. Please try again.";
//     }
// }


?>



