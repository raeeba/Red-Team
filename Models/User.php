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
            
            $inputHash = sha1($password);
    
            if ($inputHash === $hashedPassword) {
    
                $roleSql = "SELECT group_id FROM usergroup WHERE email = ?";
                $roleStmt = $this->conn->prepare($roleSql);
                $roleStmt->bind_param("s", $email);
                $roleStmt->execute();
                $roleResult = $roleStmt->get_result();
    
                $roles = [];
                while ($row = $roleResult->fetch_assoc()) {
                    $roles[] = $row['group_id'];
                }
    
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
            $mail->setFrom('noreplyamolinat@gmail.com');
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
                // echo "Message was sent";
            } catch (Exception $e){
                // echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                return false;
            }
        }
    }

    // check if user is authenticated
    public function isAuthenticated($email, $code) {
        $sql = "SELECT authentication_code, authentication_code_expires_at FROM userlogin WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();  
        $stmt->bind_result($storedCode, $expiryDate);
        $stmt->fetch();
    
        if ($stmt->num_rows == 0) {  
            $stmt->close();  
            return false; 
        }

        $inputHash = sha1($code);
    
        //convert times to same format for comparison
        $currentTime = new DateTime(); 
        $expiryDate = new DateTime($expiryDate); 
    
        if ($inputHash !== $storedCode) { // check if codes match
            echo "Code error";
            $stmt->close();
            return false; 
        }
    
        if ($currentTime > $expiryDate) {  // check if expiration date has passed
            echo "Time error";
            $stmt->close();
            return false; 
        }
    
        // set code and expiration time to null
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

        $sql = "UPDATE userlogin 
        SET reset_token_hash = ?,
                    reset_token_expires_at = ?
                WHERE email = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $hashedCode, $expiry, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->affected_rows> 0){
            $basePath = $this->getBasePath();
            $mail = require "mailer.php";

            $mail->setFrom('noreplyamolinat@gmail.com');
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
            } catch (Exception $e){
                 echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        }
    }

        // check if entered code matches code in database 
        public function resetPassword($code, $password, $confirmPassword) {
            $sql = "SELECT reset_token_hash, reset_token_expires_at FROM userlogin WHERE reset_token_hash = ?";
            $inputHash = sha1($code);
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $inputHash);
            $stmt->execute();
            $stmt->store_result();  
            $stmt->bind_result($storedCode, $expiryDate);
            $stmt->fetch();
        
            if ($stmt->num_rows == 0) {  
                $stmt->close();  
                return false; 
            }

            $inputHash = sha1($code);
        
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
        
            $password_hash = hash("sha1", $password);
        
            // set tokens and expiration times to null
            $sql = "UPDATE userlogin 
                    SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL 
                    WHERE reset_token_hash = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $password_hash, $inputHash);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                $stmt->close();  
                return true; 
            }
        
            $stmt->close();  
            return false; 
        }
        

    
    public static function list() {
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
    public static function getUserByEmail($email) {
        $conn = Database::getConnection();
    
    if ($conn === null) {
        echo "Error: Database connection is null.";
        return false;
    }

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
    
    public static function updateUserByEmail($email, $name, $birthday, $role) {
        $conn = Database::getConnection();
    
        if ($conn === null) {
            echo "Error: Database connection is null.";
            return false;
        }
    
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
    
        if ($role === 'super admin') {
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
    
        } else if ($role === 'admin') {
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
public static function assignRoleByEmail($email, $role) {
    global $conn;

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
public static function addNewUser($firstName, $lastName, $birthday, $email, $password, $role) {
    $conn = Database::getConnection();

    $conn->begin_transaction();
    $hashedPassword = sha1($password);

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

        if ($role === 'super admin') {
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
        } else {
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



