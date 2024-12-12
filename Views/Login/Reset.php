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
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <h1><img src="<?= $basePath ?>/images/logo.png" alt="Amo & Linat Logo" style="width: 225px;"></h1>
        </div>

        <!-- Forgot Form -->
        <div class="login-form">
            <h2><?= RESET_PASSWORD ?></h2>
           
            <form action="<?= $basePath ?>/en/user/reset" method="post">
            
                <label for="code"><?= CODE ?></label>
                <input type="text" id="code" name="code" placeholder="Code" required>

                <label for="code"><?= EMAIL ?></label>
                <input type="email" id="email" name="email" placeholder="Email" required>

                <label for="password"><?= ENTER_NEW_PASSWORD ?></label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                
                <label for="confirmPassword"><?= CONFIRM_PASSWORD ?></label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                
                <button type="submit"><?= CONFIRM ?></button>
            </form>
        </div>
    </div>
</body>
</html>