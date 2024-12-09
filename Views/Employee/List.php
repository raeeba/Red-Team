<?php
$language = $_SESSION['language'];
$basePath = dirname($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/employeeList.css" ?>>
    <title>Manage Employees</title>
    <style>
       
    </style>
</head>
<body>
<script>
 
</script>
<div class="logo">
    <?php include_once dirname(__DIR__) . "/nav.php"; ?>
</div>

<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1>
            <img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo" width="100" height="50">
            <?= MODIFY_EMPLOYEE ?>
        </h1>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Enter employee" onkeyup="filterEmployees()">
            <button>
                <img src="<?= $basePath ?>/images/search.png" alt="Search Icon" width="20" height="20">
            </button>
        </div>
    </div>

    <!-- Employees Table -->
    <form id="employeeForm" method="post" action="<?= $basePath ?>/<?= $language ?>/user/delete">
        <table class="employee-table" id="employeeTable">
            <thead>
            <tr>
                <th><?= SELECTED ?></th>
                <th>#</th>
                <th><?= NAME ?></th>
                <th><?= ADMIN_TYPE ?></th>
                <th><?= EMAIL ?></th>
                <th><?= BIRTHDAY ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['employees'] as $index => $row) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='selected_employees[]' value='" . htmlspecialchars($row->email) . "' onchange='updateButtons()'></td>";
                echo "<td>" . ($index + 1) . "</td>";
                echo "<td class='employee-name'>" . htmlspecialchars($row->name) . "</td>";
                echo "<td class='center'>" . htmlspecialchars($row->adminType) . "</td>";
                echo "<td>" . htmlspecialchars($row->email) . "</td>";
                echo "<td class='center'>" . htmlspecialchars($row->birthday) . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

        <!-- Actions -->
        <div class="actions">
            <button type="button" onclick="addEmployee()"><?= ADD_EMPLOYEE ?></button>
            <button type="button" id="modifyButton" onclick="modifyEmployee()" disabled><?= MODIFY_EMPLOYEE ?></button>
            <button type="submit" id = "deleteButton" class="delete" onclick="return confirm('Are you sure you want to delete the selected employees?')">
            <?= DELETE_EMPLOYEE ?>
            </button>
        </div>
    </form>

    <!-- Modify Form -->
    <form id="modifyForm" method="post" action="<?= $basePath ?>/<?= $language ?>/user/modify" style="display:none;">
        <input type="hidden" name="email" id="modifyEmailInput" value="">
    </form>
</div>

<!-- Footer -->


<script>
    function addEmployee() {
        window.location.href = `${basePath}/${language}/user/add`;
    }

    function modifyEmployee() {
        const selectedEmployees = document.querySelectorAll('input[name="selected_employees[]"]:checked');
        if (selectedEmployees.length === 1) {
            const email = selectedEmployees[0].value;
            const modifyEmailInput = document.getElementById('modifyEmailInput');
            if (!modifyEmailInput) {
                console.error("Modify email input field is missing.");
                return;
            }
            modifyEmailInput.value = email; // Set the email in the hidden input
            document.getElementById('modifyForm').submit(); // Submit the form
        } else if (selectedEmployees.length === 0) {
            alert('Please select an employee to modify.');
        } else {
            alert('Please select exactly one employee to modify.');
        }
    }

    function updateButtons() {
        const selectedEmployees = document.querySelectorAll('input[name="selected_employees[]"]:checked');
        const modifyButton = document.getElementById('modifyButton');
        modifyButton.disabled = selectedEmployees.length !== 1;
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = selectedEmployees.length === 0;

    }

    function filterEmployees() {
        const searchInput = document.getElementById("searchInput").value.toLowerCase();
        const employeeTable = document.getElementById("employeeTable");
        const rows = employeeTable.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
            const nameCell = rows[i].getElementsByClassName("employee-name")[0];
            if (nameCell) {
                const employeeName = nameCell.textContent.toLowerCase();
                rows[i].style.display = employeeName.indexOf(searchInput) > -1 ? "" : "none";
            }
        }
    }

    // Call updateButtons on page load to ensure the modify button is correctly enabled/disabled
    window.onload = updateButtons;
</script>
</body>
</html>
