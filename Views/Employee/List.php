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



<script src="<?= htmlspecialchars($basePath . '/js/employeeList.js') ?>"></script>

   
</body>
</html>
