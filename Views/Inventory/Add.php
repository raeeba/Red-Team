<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set $name and $email with session fallbacks if they aren't provided
$name = isset($name) ? $name : (isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest');
$email = isset($email) ? $email : (isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A');
?>


<?php

// Other PHP logic
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Red-Team/css/styles.css">

    <title>Add Product</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 320px;
            /* This can be adjusted to fit your sidebar width */
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2em;
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
        }

        .search-bar input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
            margin-right: 10px;
        }

        .search-bar button {
            background-color: #ffb84d;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            display: flex;
            align-items: center;
        }

        .box2-main-form-div {
            margin-top: 20px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-table th,
        .product-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .actions button {
            background-color: #ffb84d;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .actions button:hover {
            background-color: #e69d3c;
        }

        .actions button.delete {
            background-color: red;
        }

        .actions button.delete:hover {
            background-color: darkred;
        }

        .actions button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .checkbox {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.8em;
            color: #888;
        }

        .box2-main-form-div {
            padding: 20px;
            padding-top: 25px;
            border-radius: 5px;
            border: 1px solid #0000002d;
        }


        .modify-regular-div {
            margin-bottom: 30px;
        }

        .modify-regular-div label {
            font-size: medium;
        }

        .form-control {
            width: 700px;
            padding: 5px;
            justify-content: center;
            border-radius: 5px;
            margin-top: 5px;
            border: 1px solid #0000002d;

        }

        .modify-regular-div-button {
            width: 700px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid;
            margin-top: 10px;

        }

        .modify-regular-div-button:hover {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        select.form-control {
            font-family: 'YourFontFamily', sans-serif;
            font-size: 16px;
            color: #333;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    </div>
    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> ADD PRODUCT</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Enter employee" onkeyup="filterEmployees()">
                <button><img src="<?= $basePath ?>/images/search.png" alt="Search Icon" width="20" height="20"></button>
            </div>
        </div>

        <div class="box2-main-form-div">


            <form action="<?= $basePath ?>/Controller/Inventory/addSave" method="POST">
                <div class="modify-regular-div">
                    <label for="name" class="form-label"><?= NAME ?></label>
                    <br>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="modify-regular-div">
                    <label for="name_en" class="form-label"><?= NAME_ENGLISH ?></label>
                    <br>
                    <input type="text" class="form-control" id="name_en" name="name_en">
                </div>


                <div class="modify-regular-div">
                    <label for="low_stock_alert" class="form-label"><?= LOW_STOCK_ALERT ?></label> <!-- Using constant -->
                    <br>
                    <input type="text" class="form-control" id="low_stock_alert" name="low_stock_alert" required>
                </div>

                <div class="modify-regular-div">
                    <label for="stock" class="form-label"><?= STOCK ?></label> <!-- Using constant -->
                    <br>
                    <input type="text" class="form-control" id="stock" name="stock" required>
                </div>

                <div class="modify-regular-div">
                    <label for="unit" class="form-label"><?= UNIT ?></label> <!-- Using constant -->
                    <br>
                    <input type="text" class="form-control" id="unit" name="unit" required>
                </div>

                <div class="modify-regular-div">
                    <label for="unit" class="form-label"><?= SUPPLIERS ?></label> <!-- Using constant -->
                    <br> LEAVE THIS EMPTY FOR NOW
                    <input type="text" class="form-control" id="unit" name="unit">
                </div>

                <label for="category" class="form-label"><?= CATEGORY ?></label> <!-- Using constant -->
                <br>
                <select class="form-control" id="category" name="category" required>
                    <option value=""><?= SELECT_CATEGORY ?></option> <!-- Assuming you have defined SELECT_CATEGORY -->
                    <?php if ($categories): ?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category) ?>" data-fields="<?= htmlspecialchars($category) === 'Building' ? 'family' : (htmlspecialchars($category) === 'Glue' ? 'glueType,cureTime,strength' : '') ?>">
                                <?= htmlspecialchars($category) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value=""><?= NO_CATEGORIES_AVAILABLE ?></option> <!-- Assuming you have defined NO_CATEGORIES_AVAILABLE -->
                    <?php endif; ?>
                </select>

                <!-- Additional Form to be shown/hidden -->
                <div id="additionalForm" class="additional-form">
                    <h2><?= ADDITIONAL_INFORMATION ?></h2> <!-- Assuming you have defined ADDITIONAL_INFORMATION -->
                    <div id="dynamicFields" class="additional-form-forms"></div>
                </div>

                <button type="submit" class="modify-regular-div-button"><?= ADD_PRODUCT ?></button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>AMO & LINAT - <?= ALL_RIGHTS ?></p>
    </div>

    <script>
        var familyOptions = <?= json_encode($family) ?>;

        document.getElementById('category').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var additionalForm = document.getElementById('additionalForm');
            var dynamicFields = document.getElementById('dynamicFields');
            dynamicFields.innerHTML = ''; 

            var fields = selectedOption.dataset.fields;
            if (fields) {
                additionalForm.style.display = 'block'; 
                fields.split(',').forEach(function(field) {
                    if (field === 'family') {
                        createFamilyDropdown(dynamicFields);
                    } else {
                        createTextInput(dynamicFields, field);
                    }
                });
            } else {
                additionalForm.style.display = 'none'; 
            }
        });

        function createTextInput(container, field) {
            var containerDiv = document.createElement('div'); 
            containerDiv.className = 'modify-regular-div';

            var label = document.createElement('label');
            label.className = 'form-label';
            label.htmlFor = field;
            label.innerText = field.charAt(0).toUpperCase() + field.slice(1).replace(/([A-Z])/g, ' $1').trim(); // Capitalize and space out field names

            var input = document.createElement('input');
            input.type = 'text';
            input.id = field;
            input.name = field;
            input.className = 'form-control';
            input.placeholder = 'Enter ' + field.charAt(0).toUpperCase() + field.slice(1);

            containerDiv.appendChild(label);
            containerDiv.appendChild(input);
            container.appendChild(containerDiv);
        }

        function createFamilyDropdown(container) {
            var containerDiv = document.createElement('div'); 
            containerDiv.className = 'modify-regular-div';

            var label = document.createElement('label');
            label.className = 'form-label';
            label.htmlFor = 'family';
            label.innerText = 'Family';

            var select = document.createElement('select');
            select.id = 'family';
            select.name = 'family';
            select.className = 'form-control';
            select.required = true;

            familyOptions.forEach(function(option) {
                var opt = document.createElement('option');
                opt.value = option;
                opt.innerText = option; 
                select.appendChild(opt);
            });

            containerDiv.appendChild(label);
            containerDiv.appendChild(select);
            container.appendChild(containerDiv);
        }
    </script>

</body>

</html>