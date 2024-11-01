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
        <div class="role-selection">
            <button id="superAdminBtn" class="role-btn active" onclick="toggleRole('super admin')">SUPER ADMIN</button>
            <button id="adminBtn" class="role-btn" onclick="toggleRole('admin')">ADMIN</button>
        </div>

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

    <script>
        function toggleRole(role) {
            const superAdminBtn = document.getElementById("superAdminBtn");
            const adminBtn = document.getElementById("adminBtn");
            const roleInput = document.getElementById("role");

            if (role === "super admin") { // Use the exact value as in the database
                superAdminBtn.classList.add("active");
                adminBtn.classList.remove("active");
                roleInput.value = "super admin"; // Match the database value exactly
            } else if (role === "admin") {
                adminBtn.classList.add("active");
                superAdminBtn.classList.remove("active");
                roleInput.value = "admin"; // Match the database value exactly
            }
        }
    </script>
</body>
</html>
