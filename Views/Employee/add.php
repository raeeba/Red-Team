<?php
$language = $_SESSION['language'];
$basePath = dirname($_SERVER['PHP_SELF']);

?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/employeeAdd.css" ?>>
    <title>Add Employee</title>
    <style>
        
      
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
