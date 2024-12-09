<?php
$language = $_SESSION['language'] ?? 'en';
$basePath = dirname($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/employeeModify.css" ?>>
    <title>Modify Employee</title>
    <style>
      
    </style>
</head>
<body>
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>



<div class="main-content">
    <!-- Header -->
     <div class="content-wrapper">
    <div class="header">
    <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo" width="50" height="50"><?= MODIFY_EMPLOYEE ?></h1>
    </div>
    </div>

    <!-- Modify Employee Form -->
    <div class="form-container">
        <form action="<?=$basePath?>/<?=$language?>/user/updateSave/<?= htmlspecialchars($user->email) ?>" method="POST">
            <input name="email" type="hidden" value="<?= htmlspecialchars($user->email) ?>">

            <label><?=NAME?>:</label>
            <input name="name" value="<?= htmlspecialchars($user->name) ?>">

            <label><?=BIRTHDAY?>:</label>
            <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user->birthday) ?>">

            <label><?=ADMIN_TYPE?>:</label>
<select name="role" id="role">
    <option value="admin" <?php echo (isset($user->role) && $user->role == 'admin') ? 'selected' : ''; ?>>Admin</option>
    <option value="super admin" <?php echo (isset($user->role) && $user->role == 'super admin') ? 'selected' : ''; ?>>Super Admin</option>
</select>

            <!-- Actions -->
            <div class="actions">
                <button type="submit"><?=SAVE_UPDATE?></button>
                <a href="<?=$basePath?>/<?=$language?>/user/list"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
</div>


<script>
    document.querySelector("form").addEventListener("submit", function (event) {
        const roleSelect = document.getElementById("role");
        const selectedRole = roleSelect.value;

        if (selectedRole === "super admin") {
            console.log("Granting Super Admin with Admin access...");
        }
    });



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
