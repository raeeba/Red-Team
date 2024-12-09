<?php
$basePath = dirname($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Red-Team/css/styles.css">
    <title>Modify Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 320px;
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
    display: flex;
    flex-direction: column; /* Stack rows vertically */
    justify-content: center; /* Center the form vertically within the div */
    align-items: center; /* Center the form horizontally */
    padding: 20px;
    padding-top: 25px;
    border-radius: 5px;
    border: 1px solid #0000002d;
    background-color: white;
    margin-top: 20px;
    width: 1000px;
    max-width: 1200px;
    margin: 0 auto; /* Horizontally center the box itself */
}

.modify-regular-div {
    display: flex;
    align-items: center; /* Vertically align label and input */
    justify-content: space-between; /* Space label and input evenly */
    margin-bottom: 30px;
    width: 100%; /* Ensure rows span the container width */
    max-width: 900px; /* Set a maximum width for each row */
}

.modify-regular-div label {
    width: 20%; /* Fixed width for labels */
    text-align: left;
    font-size: medium;
}

.form-control {
    width: 100%;
    max-width: 700px; /* Ensure input doesn't exceed this width */
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #0000002d;
}

.modify-regular-div-button {
    width: 200px;
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

.modify-regular-div-buttons-container {
    display: flex;
    justify-content: center; /* Center the buttons */
    gap: 20px; /* Add spacing between the buttons */
    width: 100%;
    max-width: 900px;
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
            <label for="stock" class="form-label"><?= STOCK_2 ?></label>
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