<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>


<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/forgot.css" ?>>

    <title>Forgot Password</title>
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <h1><img src="<?= $basePath ?>/images/logo.png" alt="Amo & Linat Logo" style="width: 225px;"></h1>
        </div>

        <!-- Forgot Form -->
        <div class="login-form">
            <h2><?= FORGOT_PASSWORD ?></h2>
           
            <form action="<?= $basePath ?>/<?= $language ?>/user/forgot" method="post">
                <label for="email"><?= EMAIL ?></label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                
                <!-- Hidden input to store the selected role -->
                <input type="hidden" id="role" name="role" value="super admin">
                
                <button type="submit"><?= FORGOT_PASSWORD ?></button>
            </form>
        </div>
    </div>
</body>
</html>