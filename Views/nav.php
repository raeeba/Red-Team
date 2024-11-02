<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
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
            <button id="lang-fr" onclick="switchLanguage('fr')">FR</button>
            <button id="lang-eng" onclick="switchLanguage('en')">ENG</button>
        </div>

        <!-- Welcome Message -->
        <div class="welcome">
        <h2><?= isset($name) && !empty($name) ? 'Welcome, ' . $name : 'Welcome, User' ?>!</h2>
    <p><?= isset($email) && !empty($email) ? $email : 'User' ?></p>
        </div>

        <!-- Menu Items -->
        <div class="menu-item" id="inventory" onclick="selectMenuItem('inventory')">
            <img src="inventory-icon.png" alt="Inventory Icon">
            <span><?=INVENTORY?></span>
        </div>
        <div class="menu-item" id="calculator" onclick="selectMenuItem('calculator')">
            <img src="calculator-icon.png" alt="Calculator Icon">
            <span><?=CALCULATOR?></span>
        </div>
        <div class="menu-item" id="employees" onclick="selectMenuItem('employees')">
            <img src="employee-icon.png" alt="Employee Icon">
            <span><?=EMPLOYEE_MANAGER?></span>
        </div>
        <div class="menu-item" id="signout" onclick="selectMenuItem('signout')">
            <img src="signout-icon.png" alt="Sign Out Icon">
            <span><?=SIGN_OUT?></span>
        </div>

        <!-- Footer -->
        <div class="footer">
            <img src="logo.png" alt="Amo & Linat Logo">
            <p>AMO & LINAT</p>
        </div>
    </div>

    <script>
        const basePath = '<?= $basePath ?>';
        const language = '<?= $language ?>';

        // Function to select and store the active menu item in localStorage
        function selectMenuItem(itemId) {
            localStorage.setItem('activeMenuItem', itemId);
            setActiveMenuItem();
            navigateToView(itemId);
        }

        // Function to set the active menu item based on localStorage
        function setActiveMenuItem() {
            const activeItem = localStorage.getItem('activeMenuItem');
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.classList.remove('active');
            });
            if (activeItem) {
                const selectedItem = document.getElementById(activeItem);
                if (selectedItem) {
                    selectedItem.classList.add('active');
                }
            }
        }

        // Function to navigate to the correct view based on the selected menu item
        function navigateToView(itemId) {
            let viewUrl = '';
            switch (itemId) {
                case 'inventory':
                    viewUrl = `${basePath}/${language}/inventory/list`;
                    break;
                case 'calculator':
                    viewUrl = `${basePath}/${language}/calculator/view`;
                    break;
                case 'employees':
                    viewUrl = `${basePath}/${language}/user/list`;
                    break;
                case 'signout':
                    viewUrl = `${basePath}/${language}/user/signout`;
                    break;
                default:
                    viewUrl = `${basePath}/${language}/inventory/list`;
            }
            window.location.href = viewUrl;
        }

        // Call setActiveMenuItem on page load to maintain the state
        window.onload = function() {
            setActiveMenuItem();
            setLanguage();
        }

        // Function to switch language and store the selection in localStorage
        function switchLanguage(language) {
            localStorage.setItem('selectedLanguage', language);
            setLanguage();
            location.reload(); // Refresh the page to apply language changes
        }

        // Function to set the selected language button based on localStorage
        function setLanguage() {
            const selectedLanguage = localStorage.getItem('selectedLanguage') || language;
            const languageButtons = document.querySelectorAll('.language-switch button');
            languageButtons.forEach(button => {
                button.classList.remove('selected');
                if (button.textContent.toLowerCase() === selectedLanguage) {
                    button.classList.add('selected');
                }
            });
        }
    </script>
</body>
</html>
