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
$language = $_SESSION['language'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/inventoryAdd.css" ?>>

    <title>Add Product</title>

    <style>
        
    </style>
</head>

<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    </div>
    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> <?= ADD_PRODUCT ?></h1>
          
        </div>

        <div class="box2-main-form-div">


            <form action="<?= $basePath ?>/<?= $language ?>/Inventory/addSave" method="POST">
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
                    <label for="supplier" class="form-label"><?= SUPPLIERS ?></label>
                    <br>                     <br>

                    <div id="supplierOptions">
                        <?php foreach ($suppliers as $supplier): ?>
                            <label>
                                <input type="checkbox" name="suppliers[]" value="<?= htmlspecialchars($supplier['supplier_id']) ?>">
                                <?= htmlspecialchars($supplier['supplier_name']) ?>
                            </label>
                            <br>                            <br>

                        <?php endforeach; ?>
                    </div>


                    <label>
                        <input type="checkbox" id="addSupplier" name="suppliers[]" value="addSupplier">
                        Add Supplier
                    </label>
                </div>

                <!-- New Supplier Form -->
                <div id="newSupplierDiv" class="modify-regular-div" style="display: none; margin-left: 30px;">
                    <h2>Add New Supplier</h2>

                    <label for="newSupplierName" class="form-label">Supplier Name</label>
                    <br>
                    <input type="text" class="form-control" id="newSupplierName" name="newSupplierName" >
                    <br><br>

                    <label for="newSupplierContact" class="form-label">Contact Info</label>
                    <br>
                    <input type="text" class="form-control" id="newSupplierContact" name="newSupplierContact" >
                </div>


                <label for="category" class="form-label"><?= CATEGORY ?></label>
                <br>

                <select class="form-control" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['category_id']) ?>"
                            data-fields="<?= htmlspecialchars($category['fields']) ?>">
                            <?= htmlspecialchars($category['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>




                <!-- Additional Form to be shown/hidden -->
                <div id="additionalForm" class="additional-form" style="display: none; margin-left: 30px;">
                    <h2><?= ADDITIONAL_INFORMATION ?></h2> <!-- Assuming you have defined ADDITIONAL_INFORMATION -->
                    <div id="dynamicFields" class="additional-form-forms"></div>
                </div>


                <button type="submit" class="modify-regular-div-button"><?= ADD_PRODUCT ?></button>
            </form>
        </div>
    </div>
<script>
    var familyOptions = <?= json_encode($family) ?>;
    console.log(familyOptions);

</script>
    <script src="<?= htmlspecialchars($basePath . '/js/inventoryAdd.js') ?>"></script>

   



</body>

</html>