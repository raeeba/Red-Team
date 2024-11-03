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

    <title>Inventory List</title>

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
    </style>
</head>

<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    </div>
    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> MODIFY PRODUCT</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Enter employee" onkeyup="filterEmployees()">
                <button><img src="<?= $basePath ?>/images/search.png" alt="Search Icon" width="20" height="20"></button>
            </div>
        </div>

        <div class="box2-main-form-div">

            <form action="<?= $basePath ?>/Controller/Inventory/modifySave" method="POST">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($data['product_id'] ?? '') ?>">

                <div class="modify-regular-div">
                    <label for="name" class="form-label">Name</label>
                    <br>
                    <input type="text" class="form-control" id="namefr" name="namefr" value="<?= htmlspecialchars($data['namefr'] ?? '') ?>" required>
                </div>
                <div class="modify-regular-div">
                    <label for="name_en" class="form-label">Name (English)</label>
                    <br>
                    <input type="text" class="form-control" id="name_en" name="name_en" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
                </div>
                <div class="modify-regular-div">
                    <label for="low_stock_alert" class="form-label">Low Stock Alert</label>
                    <br>
                    <input type="text" class="form-control" id="low_stock_alert" name="low_stock_alert" value="<?= htmlspecialchars($data['lowstock'] ?? '') ?>" required>
                </div>
                <div class="modify-regular-div">
                    <label for="stock" class="form-label">Stock</label>
                    <br>
                    <input type="text" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($data['stock'] ?? '') ?>" required>
                </div>

                <button type="submit" class="modify-regular-div-button">Modify Product</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>AMO & LINAT - <?= ALL_RIGHTS ?></p>
    </div>



</body>

</html>