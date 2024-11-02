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
        // Assuming you have a proper DB connection established
        $sql = "
            SELECT 
                u.email, 
                ui.name, 
                ui.birthday,
                ug.group_id AS role
            FROM userlogin u
            INNER JOIN userinfo ui ON u.email = ui.email
            INNER JOIN usergroup ug ON u.email = ug.email
            WHERE u.email = ?
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            $user = new stdClass();
            $user->email = $row['email'];
            $user->name = $row['name'];
            $user->birthday = $row['birthday'];
            // Mapping role: assuming group_id 2 means 'super admin', 1 means 'admin'
            $user->role = ($row['role'] == 2) ? 'super admin' : 'admin';
            return $user;
        }
    
        return null;
    }
    
    public static function updateUserByEmail($email, $name, $birthday, $role) {
        // Get the database connection from the Database class
        $conn = Database::getConnection();
    
        if ($conn === null) {
            echo "Error: Database connection is null.";
            return false;
        }
    
        // Prepare the SQL statement to update userinfo table
        $sql = "
            UPDATE userinfo 
            SET name = ?, birthday = ?
            WHERE email = ?
        ";
    
        // Prepare the statement using the database connection
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            return false;
        }
    
        // Bind parameters for userinfo update
        $stmt->bind_param("sss", $name, $birthday, $email);
    
        // Execute the statement
        if (!$stmt->execute()) {
            echo "Error updating employee information: " . $stmt->error;
            return false;
        }
    
        // Handle role assignments in the usergroup table
        if ($role === 'super admin') {
            // Add the super admin role (group_id = 2)
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
            // Remove the super admin role (group_id = 2) if user is demoted
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
    // Assuming $conn is your database connection
    global $conn;

    // Insert or update the role in the usergroup table based on email and role
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

    // Bind parameters
    $stmt->bind_param("ss", $email, $role);
    
    // Execute the statement and return the result
    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error assigning role: " . $stmt->error;
        return false;
    }
}
public static function deleteUsersByEmails($emails) {
    // Get the database connection
    $conn = Database::getConnection();

    if ($conn === null) {
        echo "Error: Database connection is null.";
        return false;
    }

    // Use placeholders for a prepared statement
    $placeholders = implode(',', array_fill(0, count($emails), '?'));

    try {
        // Start a transaction
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

        // Commit the transaction
        $conn->commit();
        return true;

    } catch (Exception $e) {
        // Rollback the transaction if there's an error
        $conn->rollback();
        echo $e->getMessage();
        return false;
    }
}
public static function addNewUser($firstName, $lastName, $birthday, $email, $password, $role) {
    // Get the database connection
    $conn = Database::getConnection();

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into userlogin table
        $sqlUserLogin = "INSERT INTO userlogin (email, password) VALUES (?, ?)";
        $stmtUserLogin = $conn->prepare($sqlUserLogin);
        $stmtUserLogin->bind_param("ss", $email, $password);
        if (!$stmtUserLogin->execute()) {
            throw new Exception("Error inserting into userlogin: " . $stmtUserLogin->error);
        }

        // Insert into userinfo table
        $sqlUserInfo = "INSERT INTO userinfo (email, name, birthday) VALUES (?, ?, ?)";
        $stmtUserInfo = $conn->prepare($sqlUserInfo);
        $name = $firstName . ' ' . $lastName;
        $stmtUserInfo->bind_param("sss", $email, $name, $birthday);
        if (!$stmtUserInfo->execute()) {
            throw new Exception("Error inserting into userinfo: " . $stmtUserInfo->error);
        }

        // Insert into usergroup table (for role)
        $groupId = ($role === 'super admin') ? 2 : 1; // Assuming 2 is for Super Admin and 1 is for Admin
        $sqlUserGroup = "INSERT INTO usergroup (email, group_id) VALUES (?, ?)";
        $stmtUserGroup = $conn->prepare($sqlUserGroup);
        $stmtUserGroup->bind_param("si", $email, $groupId);
        if (!$stmtUserGroup->execute()) {
            throw new Exception("Error inserting into usergroup: " . $stmtUserGroup->error);
        }

        // Commit the transaction
        $conn->commit();
        return true;

    } catch (Exception $e) {
        // Rollback the transaction if there's an error
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



