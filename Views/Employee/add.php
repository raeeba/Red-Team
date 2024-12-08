<?php
$language = $_SESSION['language'];

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
            text-align:center
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
        .content-wrapper {
    max-width: 600px; /* Match the width of the form-container */
    margin: 0 auto; /* Center the container horizontally */
    text-align: center; /* Center align text within the container */
}
      
    </style>
</head>
<body>
<div class="logo">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>

</div>
<div class="main-content">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo" width="100" height="50"><?= ADD_EMPLOYEE ?></h1>
        </div>
        </div>

        <!-- Add Employee Form -->
        <div class="form-container">
            <form action="<?= $basePath ?>/<?=$language?>/user/addSave" method="POST">
                <label><?= FIRST_NAME ?>:</label>
                <input type="text" name="first_name" placeholder="Enter first name" required>

                <label><?= LAST_NAME ?>:</label>
                <input type="text" name="last_name" placeholder="Enter last name" required>

                <label><?= BIRTHDAY ?>:</label>
                <input type="date" id="birthday" name="birthday" required>

                <label><?= EMAIL ?>:</label>
                <input type="email" name="email" placeholder="Enter email" required>

                <label><?= PASSWORD ?>:</label>
                <input type="password" name="password" placeholder="Enter password" required>

                <div class="role-container">
                    <label><?= ADMIN_TYPE ?>:</label>
                    <input type="radio" id="super_admin" name="role" value="super admin" required>
                    <label for="super_admin"><?= SUPER_ADMIN ?></label>
                    <input type="radio" id="admin" name="role" value="admin">
                    <label for="admin"><?= ADMIN ?></label>
                </div>

                <!-- Actions -->
                <div class="actions">
                    <button type="submit"><?= ADD_EMPLOYEE ?></button>
                </div>
            </form>
        </div>
    </div>



    <script>
    const today = new Date();
    const minAgeDate = new Date(today.getFullYear() - 80, today.getMonth(), today.getDate());
    const maxAgeDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

    // Format dates as YYYY-MM-DD
    const maxDateStr = maxAgeDate.toISOString().split('T')[0];
    const minDateStr = minAgeDate.toISOString().split('T')[0];

    const birthdayInput = document.getElementById('birthday');
    birthdayInput.max = maxDateStr;
    birthdayInput.min = minDateStr;
</script>

</body>
</html>
