<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>


<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            max-width: 400px;
            width: 100%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .logo h1 {
            font-size: 24px;
            color: #333;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .login-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
        }

        .login-form h2 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .login-form label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
            color: #666;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-form .forgot-password {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #333;
            text-decoration: none;
        }

        .login-form .forgot-password:hover {
            text-decoration: underline;
        }
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
            <h2><?= RESET_PASSWORD ?></h2>
           
            <form action="<?= $basePath ?>/<?= $language ?>/user/reset-password" method="post">
                <label for="email"><?= CONFIRM_EMAIL ?></label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                
                <label for="password"><?= CONFIRM_PASSWORD ?></label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <p><?=$data['error']??""?></p>

                <button type="submit"><?= FORGOT_PASSWORD ?></button>
            </form>
        </div>
    </div>
</body>
</html>