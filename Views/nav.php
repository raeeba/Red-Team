<?php
// Ensure session is started if not already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set $name and $email with session fallbacks if they aren't provided
$name = isset($name) ? $name : (isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest');
$email = isset($email) ? $email : (isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A');
$role = isset($role) ? $role : (isset($_SESSION['role']) ? $_SESSION['role'] : 'admin'); // Default to 'admin'

?>

<?php

$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/nav.css" ?>>
    <title>Side Menu</title>
    <style>
       
       
    </style>
</head>
<body>
<div class="sidebar">
        <!-- Language Switch -->
        <div class="language-switch">
            <button id="lang-fr" onclick="switchLanguage('fr')">FR</button>
            <button id="lang-eng" onclick="switchLanguage('en')">ENG</button>
        </div>

        <!-- Welcome Message -->
        <div class="welcome">
            <h2><?= WELCOME ?>, <?= $name ?>!</h2>
            <p><?= $email ?></p>
        </div>

        <!-- Menu Items -->
        <div class="menu-item" id="inventory" onclick="selectMenuItem('inventory')">
            <img src="<?= $basePath ?>/images/inventory.png" alt="Inventory Icon">
            <span><?= INVENTORY ?></span>
        </div>
        <div class="menu-item" id="calculator" onclick="selectMenuItem('calculator')">
            <img src="<?= $basePath ?>/images/calculator.png" alt="Calculator Icon">
            <span><?= CALCULATOR ?></span>
        </div>

        <?php if ($role === 'super admin'): ?>
        <div class="menu-item" id="employees" onclick="selectMenuItem('employees')">
            <img src="<?= $basePath ?>/images/employee.png" alt="Employee Icon">
            <span><?= EMPLOYEE_MANAGER ?></span>
        </div>
        <?php endif; ?>

        <div class="menu-item" id="signout" >
            <img src="<?= $basePath ?>/images/signout.png" alt="Sign Out Icon">
            <span><?= SIGN_OUT ?></span>
        </div>

       <div class="logo">
         <img src="<?= $basePath ?>/images/logo.png" alt="Amo & Linat Logo" width="250" height="150">
        </div>
         <div class="bottom">
        <p>AMO & LINAT - <?= ALL_RIGHTS ?></p>
    </div>
</div>
<script>
        const basePath = '<?= $basePath ?>';
        const language = '<?= $language ?>';
</script>
<script src="<?= htmlspecialchars($basePath . '/js/nav.js') ?>"></script>
</body>
</html>