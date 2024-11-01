<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>

<!DOCTYPE html>
<html lang="<?=$language?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Two-Factor Authentication</title>
<link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
<style>
    /* Additional styling for 2FA page to match theme */
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f5f5f5;
        font-family: Arial, sans-serif;
    }
    .container {
        text-align: center;
    }
    .logo img {
        max-width: 100px;
    }
    .auth-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        width: 300px;
        margin-top: 20px;
    }
    .auth-form h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }
    .auth-form input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .auth-form button {
        width: 100%;
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .auth-form button:hover {
        background-color: #444;
    }
    .resend-link {
        display: block;
        margin-top: 15px;
        font-size: 0.9em;
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
            <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
            <h1>AMO & LINAT</h1>
        </div>

        <!-- Authentication Form -->
        <div class="auth-form">
            <h2>Two-Factor Authentication</h2>
            <p>Enter verification code</p>
            <form action="<?= $basePath ?>/<?=$language?>/inventory/list" method="post">
                <label for="otp">Code</label>
                <input type="text" id="otp" name="otp" placeholder="Enter code" required>

                <button type="submit">Confirm</button>
                <a href="<?= $basePath ?>/en/user/resend_otp" class="resend-link">Resend code</a>
            </form>
        </div>
    </div>
</body>
</html>
