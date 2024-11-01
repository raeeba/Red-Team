<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>

<!DOCTYPE html>
<html lang="<?= $language?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
            <h1>AMO & LINAT</h1>
        </div>

        <!-- Role Selection -->
      
        <!-- Login Form -->
        <div class="login-form">
            <h2><?=WELCOME_MESSAGE?></h2>
           
            <form action="<?= $basePath ?>/<?=$language?>/user/verify" method="post">
                <label for="email"><?=EMAIL?></label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                
                <label for="password"><?=PASSWORD?></label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <!-- Hidden input to store the selected role -->
                <input type="hidden" id="role" name="role" value="super admin">
                
                <button type="submit"><?=LOGIN?></button>
                <a href="<?= $basePath ?>/Login/Forgot.php" class="forgot-password"><?=FORGOT_PASSWORD?></a>
            </form>
        </div>
    </div>

   
    </script>
</body>
</html>
