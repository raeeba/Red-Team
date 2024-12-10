<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/inventoryModify.css" ?>>
    <title>Modify Product</title>
    <style>
       
    </style>
</head>

<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> <?= MODIFY_PRODUCT ?></h1>
           
        </div>

        <div class="box2-main-form-div">

    <form action="<?= $basePath ?>/Controller/Inventory/modifySave" method="POST" style="width: 100%; max-width: 900px;">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($products['product_id'] ?? '') ?>">

        <div class="modify-regular-div">
            <label for="namefr" class="form-label"><?= NAME ?></label>
            <input type="text" class="form-control" id="namefr" name="namefr" value="<?= htmlspecialchars($products['namefr'] ?? '') ?>" required>
        </div>

        <div class="modify-regular-div">
            <label for="name_en" class="form-label"><?= NAME_ENGLISH ?></label>
            <input type="text" class="form-control" id="name_en" name="name_en" value="<?= htmlspecialchars($products['name'] ?? '') ?>" required>
        </div>

        <div class="modify-regular-div">
            <label for="low_stock_alert" class="form-label"><?= LOW_STOCK_ALERT ?></label>
            <input type="text" class="form-control" id="low_stock_alert" name="low_stock_alert" value="<?= htmlspecialchars($products['lowstock'] ?? '') ?>" required>
        </div>

        <div class="modify-regular-div">
            <label for="stock" class="form-label"><?= STOCK?></label>
            <input type="text" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($products['stock'] ?? '') ?>" required>
        </div>

        <div class="modify-regular-div-buttons-container">
            <button type="submit" class="modify-regular-div-button">Save Changes</button>
            <button type="button" class="modify-regular-div-button" onclick="resetForm()">Cancel</button>
        </div>
    </form>
</div>


    </div>

    

    <script>
        function resetForm() {
            const basePath = '<?= $basePath ?>';
            const language = '<?= $language ?>';
            window.location.href = `${basePath}/${language}/Inventory/list`;
        }
    </script>
</body>

</html>