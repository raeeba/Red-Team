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
            <form>
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Value" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Value" required>
                
                <button type="submit">Login</button>
                <a href="#" class="forgot-password">Forgot password?</a>
            </form>
        </div>
    </div>

    
</body>
</html>
