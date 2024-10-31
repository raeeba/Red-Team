<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="/Red-Team/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="logo.png" alt="Amo & Linat Logo"> <!-- Replace logo.png with your actual logo image path -->
            <h1>AMO & LINAT</h1>
        </div>

        <!-- Role Selection -->
        <div class="role-selection">
        <button id="superAdminBtn" class="role-btn active" onclick="toggleRole('superAdmin')">SUPER ADMIN</button>
        <button id="adminBtn" class="role-btn" onclick="toggleRole('admin')">ADMIN</button>
    </div>

    <script src="script.js"></script>

        <!-- Login Form -->
        <div class="login-form">
            <h2>LOGIN</h2>
            <form action="/en/user/verify" method="post">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Email" required>
    
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Password" required>

    <!-- Hidden input to store the selected role -->
    <input type="hidden" id="role" name="role" value="superAdmin">
    
    <button type="submit">Login</button>
    <a href="/Login/Forgot.php" class="forgot-password">Forgot password?</a>
</form>
        </div>
    </div>
<script>
function toggleRole(role) {
    const superAdminBtn = document.getElementById("superAdminBtn");
    const adminBtn = document.getElementById("adminBtn");
    const roleInput = document.getElementById("role"); // Hidden input for role

    if (role === "superAdmin") {
        superAdminBtn.classList.add("active");
        adminBtn.classList.remove("active");
        roleInput.value = "superAdmin";
    } else if (role === "admin") {
        adminBtn.classList.add("active");
        superAdminBtn.classList.remove("active");
        roleInput.value = "admin";
    }
}


</script>
    
</body>
</html>
