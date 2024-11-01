<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Side Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            width: 300px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            position: fixed;
        }

        .sidebar .language-switch {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .sidebar .language-switch button {
            background-color: #e5e5e5;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 45%;
        }

        .sidebar .language-switch button.selected {
            background-color: #ffb84d;
            color: #ffffff;
        }

        .sidebar .welcome {
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar .welcome h2 {
            font-size: 1.5em;
            margin: 0;
        }

        .sidebar .welcome p {
            color: #888;
            margin: 5px 0 20px;
        }

        .sidebar .menu-item {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 40px;
            border-radius: 15px;
            transition: background-color 0.3s ease;
            font-size: 1.5em;
        }

        .sidebar .menu-item:hover {
            background-color: #f0f0f0;
        }

        .sidebar .menu-item.active {
            background-color: #ffb84d;
            color: #ffffff;
        }

        .sidebar .menu-item img {
            width: 35px;
            margin-right: 20px;
        }

        .sidebar .footer {
            position: absolute;
            bottom: 20px;
            text-align: center;
            width: calc(100% - 40px);
        }

        .sidebar .footer img {
            max-width: 80px;
            margin-bottom: 10px;
        }

        .sidebar .footer p {
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <!-- Language Switch -->
        <div class="language-switch">
            <button class="selected">FR</button>
            <button>ENG</button>
        </div>

        <!-- Welcome Message -->
        <div class="welcome">
            <h2>Welcome, <?=$name?>!</h2>
            <p><?=$email?></p>
        </div>

        <!-- Menu Items -->
        <div class="menu-item active">
            <img src="inventory-icon.png" alt="Inventory Icon">
            <span>Inventory</span>
        </div>
        <div class="menu-item">
            <img src="calculator-icon.png" alt="Calculator Icon">
            <span>Calculator</span>
        </div>
        <div class="menu-item">
            <img src="employee-icon.png" alt="Employee Icon">
            <span>Manage Employees</span>
        </div>
        <div class="menu-item">
            <img src="signout-icon.png" alt="Sign Out Icon">
            <span>Sign Out</span>
        </div>

        <!-- Footer -->
        <div class="footer">
            <img src="logo.png" alt="Amo & Linat Logo">
            <p>AMO & LINAT</p>
        </div>
    </div>
</body>
</html>
