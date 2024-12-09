<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/reset.css" ?>>

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
           
            <form action="<?= $basePath ?>/<?= $language ?>/user/reset-password" method="post">
            
            <input type="hidden" name="token" value="<?= htmlspecialchars($token)?>">
               <label for="password"><?= PASSWORD ?></label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                
                <input type="confirm-password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                
                <button type="submit"><?= FORGOT_PASSWORD ?></button>
            </form>
        </div>
    </div>
</body>
</html>