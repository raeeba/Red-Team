<?php


// Other PHP logic
$basePath = dirname($_SERVER['PHP_SELF']);
$language = $_SESSION['language'];
?>


<!DOCTYPE html>
<html lang="<?= $language ?>">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= $basePath . "/css/calculatorView.css" ?>>


    <title>Inventory List</title>



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

                    <h2 style=" padding: 20px">     <?= LOW_STOCK_2 ?></h2>
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