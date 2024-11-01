<?php
$basePath = dirname($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
            <?php include_once dirname(__DIR__) . "/nav.php";?>

            <h1>AMO & LINAT</h1>
        </div>

</body>
</html>
