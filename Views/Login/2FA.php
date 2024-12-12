<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/2fa.css" ?>>

    <title>Two-Factor Authentication</title>
    <style>
       
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

            <form action="<?= $basePath ?>/<?= $language ?>/user/authentication" method="post">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" placeholder="Enter code" required>
                <p><?=$data['error']?></p>


                <button type="submit">Confirm</button>
                <a onclick="resendCode()" class="resend-link">Resend code</a>
            </form>
        </div>
    </div>

    <script>
       const basePath = '<?= $basePath ?>';
       const language = '<?= $language ?>';
    </script>
    
    <script src="<?= htmlspecialchars($basePath . '/js/resendCode.js') ?>"></script>

</body>
</html>
