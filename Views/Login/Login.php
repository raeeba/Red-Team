<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = (isset($_SESSION['language']))? $_SESSION['language']: "en";
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/login.css" ?>>

    <title>Login</title>
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <h1><img src="<?= $basePath ?>/images/logo.png" alt="Amo & Linat Logo" style="width: 225px;"></h1>
        </div>

        <!-- Login Form -->
        <div class="login-form">
            <h2><?= WELCOME_MESSAGE ?></h2>
    
            <form action="<?= $basePath ?>/<?= $language ?>/user/verify" method="post">
                <label for="email"><?= EMAIL ?></label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                
                <label for="password"><?= PASSWORD ?></label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <p><?=$data['error']??""?></p>
                
                <button type="submit"><?= LOGIN ?></button>
                <a href="<?= $basePath ?>/<?= $language ?>/user/forgot" class="forgot-password"><?= FORGOT_PASSWORD ?></a>
            </form>
        </div>
    </div>
</body>
</html>
