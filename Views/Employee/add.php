<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 320px; /* This can be adjusted to fit your sidebar width */
            padding: 40px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5em;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .header h1 img {
            margin-right: 10px;
            width: 50px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="date"],
        .form-container input[type="password"] {
            width: 90%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container .role-container {
            margin-top: 15px;
            display: flex;
            align-items: center;
        }

        .form-container .role-container label {
            font-weight: normal;
            margin-right: 10px;
        }

        .form-container .actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .form-container .actions button {
            background-color: #ffb84d;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .form-container .actions button:hover {
            background-color: #e69d3c;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
<div class="logo">
    <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    <h1>AMO & LINAT</h1>
</div>

<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1><img src="employee-icon.png" alt="Add Employee Icon">ADD EMPLOYEE</h1>
    </div>

    <!-- Add Employee Form -->
    <div class="form-container">
        <form action="<?= $basePath ?>/<?=$language?>/user/addSave" method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name" placeholder="Enter first name" required>

            <label>Last Name:</label>
            <input type="text" name="last_name" placeholder="Enter last name" required>

            <label>Birthday:</label>
            <input type="date" name="birthday" required>

            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter email" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <div class="role-container">
                <label>Role:</label>
                <input type="radio" id="super_admin" name="role" value="super admin" required>
                <label for="super_admin">Super Admin</label>
                <input type="radio" id="admin" name="role" value="admin">
                <label for="admin">Admin</label>
            </div>

            <!-- Actions -->
            <div class="actions">
                <button type="submit">Add Employee</button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>AMO & LINAT - All rights reserved.</p>
</div>
</body>
</html>
