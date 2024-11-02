<?php
$employee = $data['employee'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Modify Employee</title>
</head>
<body>
    <h1>Modify Employee</h1>
    <form method="post" action="<?= $basePath ?>/employee/modify">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($employee->name) ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($employee->email) ?>" readonly>
        
        <label for="birthday">Birthday:</label>
        <input type="text" id="birthday" name="birthday" value="<?= htmlspecialchars($employee->birthday) ?>" required>
        
        <label for="adminType">Admin Type:</label>
        <input type="radio" id="superAdmin" name="adminType" value="super admin" <?= $employee->adminType == 'super admin' ? 'checked' : '' ?>>Super Admin
        <input type="radio" id="admin" name="adminType" value="admin" <?= $employee->adminType == 'admin' ? 'checked' : '' ?>>Admin
        
        <button type="submit">Modify Employee</button>
    </form>
</body>
</html>
