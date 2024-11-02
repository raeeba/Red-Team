<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Manage Employees</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 320px; /* This can be adjusted to fit your sidebar width */
            padding: 40px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5em;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .header h1 img {
            margin-right: 10px;
            width: 50px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-bar button {
            background-color: #ffb84d;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            font-size: 1em;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .employee-table th,
        .employee-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .employee-table th {
            background-color: #f2f2f2;
        }

        .employee-table td.admin {
            color: green;
            font-weight: bold;
        }

        .employee-table td.super-admin {
            color: blue;
            font-weight: bold;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .actions button {
            background-color: #ffb84d;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #e69d3c;
        }

        .actions button.delete {
            background-color: red;
            transition: background-color 0.3s ease;
        }

        .actions button.delete:hover {
            background-color: darkred;
        }

        .actions button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.8em;
            color: #888;
        }
    </style>
</head>
<body>
<div class="logo">
    <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    <h1>AMO & LINAT</h1>
</div>

<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1><img src="employee-icon.png" alt="Manage Employees Icon">MODIFY EMPLOYEES</h1>
        <div class="search-bar">
            <input type="text" placeholder="Enter employee">
            <button><img src="search-icon.png" alt="Search Icon"></button>
        </div>
    </div>
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    <!-- Employees Table -->
    <form id="employeeForm" method="post" action="delete_employees.php">
        <table class="employee-table">
            <thead>
            <tr>
                <th>Select</th>
                <th>#</th>
                <th>Name</th>
                <th>Admin Type</th>
                <th>Email</th>
                <th>Birthday</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['employees'] as $index => $row) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='selected_employees[]' value='" . $row->email . "' onchange='updateButtons()'></td>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td>" . $row->name . "</td>";
                echo "<td class='center'>" . $row->adminType . "</td>";
                echo "<td>" . $row->email . "</td>";
                echo "<td class='center'>" . $row->birthday . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

        <!-- Actions -->
        <div class="actions">
            <button type="button" onclick="addEmployee()">Add Employee</button>
            <button type="button" id="modifyButton" onclick="modifyEmployee()" disabled>Modify Employee Information</button>
            <button type="submit" class="delete">Delete Selected Employee(s)</button>
        </div>
    </form>
</div>

<!-- Footer -->
<div class="footer">
    <p>AMO & LINAT - All rights reserved.</p>
</div>

<script>
    function addEmployee() {
        window.location.href = 'add_employee.php';
    }

    function modifyEmployee() {
        const selectedEmployees = document.querySelectorAll('input[name="selected_employees[]"]:checked');
        if (selectedEmployees.length === 1) {
            const email = selectedEmployees[0].value;
            // Redirect to the modify employee page with the selected employee's email
            window.location.href = 'modify_employee.php?email=' + encodeURIComponent(email);
        } else {
            alert('Please select exactly one employee to modify.');
        }
    }

    function updateButtons() {
        const selectedEmployees = document.querySelectorAll('input[name="selected_employees[]"]:checked');
        const modifyButton = document.getElementById('modifyButton');
        modifyButton.disabled = selectedEmployees.length !== 1;
    }

    // Call updateButtons on page load to ensure the modify button is correctly enabled/disabled
    window.onload = updateButtons;
</script>
</body>
</html>
