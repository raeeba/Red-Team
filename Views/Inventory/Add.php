<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ADD_PRODUCT ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=YourFontFamily&display=swap">
    <link rel="stylesheet" href="/Red-Team/css/style.css">
    <style>
        select.form-control {
            font-family: 'YourFontFamily', sans-serif;
            font-size: 16px;
            color: #333;
            padding: 10px;
        }

        .additional-form {
            display: none;
            /* Hide by default */
            margin-top: 20px;
            /* Add some spacing */

        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="<?= $basePath ?>/logo.png" alt="Amo & Linat Logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>
        <h1>AMO & LINAT</h1>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="box2-back">
            <div class="box2-back-icon">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                    BACK TO INVENTORY
                </a>
            </div>
        </div>
        <div class="box2-heading">
            <div class="box2-heading-icon">
                <svg class="box2-heading-icon-svg" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                    <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z" />
                </svg>
                <?= ADD_PRODUCT ?>
            </div>
        </div>

        <div class="box2-main">
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
                        <input type="text" class="form-control" id="unit" name="unit" >
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
    </div>

    <script>
    // Embed PHP data into JavaScript
    var familyOptions = <?= json_encode($family) ?>;

    // JavaScript to handle showing the additional form and dynamic fields
    document.getElementById('category').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var additionalForm = document.getElementById('additionalForm');
        var dynamicFields = document.getElementById('dynamicFields');
        dynamicFields.innerHTML = ''; // Clear previous fields

        // Check if fields are specified for the selected category
        var fields = selectedOption.dataset.fields;
        if (fields) {
            additionalForm.style.display = 'block'; // Show the additional form
            fields.split(',').forEach(function(field) {
                if (field === 'family') {
                    // Create a dropdown for family
                    createFamilyDropdown(dynamicFields);
                } else {
                    createTextInput(dynamicFields, field);
                }
            });
        } else {
            additionalForm.style.display = 'none'; // Hide the additional form
        }
    });

    function createTextInput(container, field) {
        var containerDiv = document.createElement('div'); // Create the outer div
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
        var containerDiv = document.createElement('div'); // Create the outer div
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

        // Populate dropdown with family options from PHP
        familyOptions.forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option;  // Assuming the family array has value as the option
            opt.innerText = option; // Display name in dropdown
            select.appendChild(opt);
        });

        containerDiv.appendChild(label);
        containerDiv.appendChild(select);
        container.appendChild(containerDiv);
    }
</script>

</body>

</html>