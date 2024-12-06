<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
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

        .auth-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
        }

        .auth-form h2 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .auth-form p {
            font-size: 1em;
            color: #666;
            margin-bottom: 20px;
        }

        .auth-form label {
            display: block;
            text-align: left;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .auth-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .auth-form button {
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

        .auth-form button:hover {
            background-color: #444;
        }

        .resend-link {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #333;
            text-decoration: none;
        }

        .resend-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="<?= $basePath ?>/images/logo.png" alt="Amo & Linat Logo" style="width: 225px;">
        </div>

        <!-- Authentication Form -->
        <div class="auth-form">
            <h2>Two-Factor Authentication</h2>
            <p>Enter verification code</p>
    <!--replace /user/verify with /user/authentication" method="post">-->
            <form action="<?= $basePath ?>/<?= $language ?>/user/authentication" method="post">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" placeholder="Enter code" required>

                <button type="submit">Confirm</button>
                <a href="<?= $basePath ?>/en/user/resend_otp" class="resend-link">Resend code</a>
            </form>
        </div>
    </div>
</body>
</html>
