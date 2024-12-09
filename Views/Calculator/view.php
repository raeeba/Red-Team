<?php


// Other PHP logic
$basePath = dirname($_SERVER['PHP_SELF']);
$language = isset($_GET['language']) ? $_GET['language'] : 'en';
?>


<!DOCTYPE html>
<html lang="<?= $language ?>">


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





        .box2-main-form-div {
            margin-top: 20px;
        }


        h2 {
            text-align: center;
            margin-bottom: 20px;
        }


        .form-group {
            margin-bottom: 15px;
        }


        label {
            display: block;
            margin-bottom: 5px;
        }


        input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }


        button {
            background-color: #ffc107;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }


        button:hover {
            background-color: #e0a800;
        }


        .results,
        .error {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
        }


        .error {
            color: red;
            background-color: #ffe6e6;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.8em;
            color: #888;
        }

        .box-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            /* Adds space between rows */
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .box {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            padding: 20px;
        }

        .box h2 {
            text-align: center;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
            .product-table,
        .low-stock-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th,
        .low-stock-table th,
        .product-table td,
        .low-stock-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .product-table th,
        .low-stock-table th {
            background-color: #f2f2f2;
        }

        }
    </style>
</head>


<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>


    </div>
    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> <?= CALCULATOR ?> </h1>
        </div>


        <div class="box-container">
            <div class="row">
                <div class="box">
                    <form method="post" action="<?= $basePath ?>/<?= $language ?>/calculator/calculate">
                        <!-- //<h2>Form 1</h2> -->
                        <div class="form-group">
                            <label for="length"><?= LENGTH ?>:</label>
                            <input type="text" id="length" name="length" value="<?= isset($length) ? htmlspecialchars($length) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="height"><?= HEIGHT ?>:</label>
                            <input type="text" id="height" name="height" value="<?= isset($height) ? htmlspecialchars($height) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="thickness"><?= THICKNESS_OF_WALL ?>:</label>
                            <input type="text" id="thickness" name="thickness" value="<?= isset($thickness) ? htmlspecialchars($thickness) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="spacing"><?= SPACING_BETWEEN_WALL ?>:</label>
                            <input type="text" id="spacing" name="spacing" value="<?= isset($spacing) ? htmlspecialchars($spacing) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="load_bearing"><?= LOAD_BEARING ?>:</label>
                            <input type="text" id="load_bearing" name="load_bearing" value="<?= isset($load_bearing) ? htmlspecialchars($load_bearing) : '' ?>" required>
                        </div>
                        <button type="submit"><?= GENERATE ?></button>
                    </form>
                </div>

                <div class="box">
                    <h2><?= RESULTS ?></h2>
                    <div style="background-color: #fdf8e2; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); margin-top: 40px;">
                        <div class="form-group" style=" padding: 20px">
                            <label for="wool_needed" style="display: block; font-weight: bold; margin-bottom: 5px;"><?= AMOUNT_OF_WOOL ?></label>
                            <input type="text" id="wool_needed" name="wool_needed" value="<?= isset($results['wool_needed']) ? htmlspecialchars($results['wool_needed']) : '' ?>" readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff;">
                        </div>
                        <div class="form-group" style="margin-top: 15px;  padding: 20px">
                            <label for="planks_needed" style="display: block; font-weight: bold; margin-bottom: 5px;"><?= AMOUNT_OF_PLANKS   ?></label>
                            <input type="text" id="planks_needed" name="planks_needed" value="<?= isset($results['planks_needed']) ? htmlspecialchars($results['planks_needed']) : '' ?>" readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="box" style="width: 100%;">

                    <h2 style=" padding: 20px">Low Stock Inventory</h2>
                    <form action="<?= $basePath ?>/<?= $language ?>/Inventory/updateStock" method="POST" id="updateStockForm">
                        <table border="1" class="product-table" id="product-table" style="width: 100%; border-collapse: collapse; margin: 0">
                            <tr>
                           
                                <th>ID</th>
                                <th><?= NAME ?></th>
                                <th><?= UNITS ?></th>
                                <th><?= FAMILY ?></th>
                                <th><?= CATEGORY ?></th>
                                <th><?= SUPPLIERS ?></th>
                                <th><?= LOW_STOCK ?></th>
                                <th><?= STOCK ?></th>
                            </tr>
                            <?php foreach ($data['products'] as $product) : ?>
                                <tr data-category="<?= htmlspecialchars($product['category_name'] ?? '') ?>">
                                 
                                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                    <td class='product-name'><?php echo htmlspecialchars($product['Name'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Unit'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Family'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Supplier Names'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['lowstock'] ?? ""); ?></td>
                                    <td>
                                        <span class="stock-display"><?= htmlspecialchars($product['stock'] ?? ""); ?></span>
                                        <input type="number" class="stock-input" id="stock-input-<?= htmlspecialchars($product['product_id']); ?>" name="updated_stock[<?= htmlspecialchars($product['product_id']); ?>]" value="<?= htmlspecialchars($product['stock'] ?? ''); ?>" style="display: none;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </form>

    
                </div>
            </div>








            <!-- Footer -->
            <div class="footer">
                <p>AMO & LINAT - <?= ALL_RIGHTS ?></p>
            </div>






</body>


</html>