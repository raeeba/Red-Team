<?php

// Other PHP logic for defining the base path and the user's language preference
$basePath = dirname($_SERVER['PHP_SELF']);  
$language = $_SESSION['language'];  // Get the user's language preference from the session

?>

<!DOCTYPE html>
<html lang="<?= $language ?>">  <!-- Set the page language from session -->

<head>
    <meta charset="UTF-8">  <!-- character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Make the page responsive -->
    <link rel="stylesheet" href=<?= $basePath . "/css/calculatorView.css" ?>>  <!-- calculator view CSS -->

    <title>Inventory List</title> 

</head>

<body>
    <div class="logo">
        <!-- Include the navigation bar (nav.php) at the top of the page -->
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>
    </div>

    <div class="main-content">
        <div class="header">
            <!-- Display the page header with an image and the title -->
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> <?= CALCULATOR ?> </h1>
        </div>

        <div class="box-container">
            <div class="row">
                <div class="box">
                    <!-- Calculator form where the user can input values for calculation -->
                    <form method="post" action="<?= $basePath ?>/<?= $language ?>/calculator/calculate">
                        <!-- Form fields for entering length, height, thickness, spacing, and load bearing -->
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
                        <!-- Submit button to trigger the calculation -->
                        <button type="submit"><?= GENERATE ?></button>
                    </form>
                </div>

                <div class="box">
                    <!-- Display the results of the calculation -->
                    <h2><?= RESULTS ?></h2>
                    <div style="background-color: #fdf8e2; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); margin-top: 40px;">
                        <div class="form-group" style=" padding: 20px">
                            <label for="wool_needed" style="display: block; font-weight: bold; margin-bottom: 5px;"><?= AMOUNT_OF_WOOL ?></label>
                            <input type="text" id="wool_needed" name="wool_needed" value="<?= isset($results['wool_needed']) ? htmlspecialchars($results['wool_needed']) : '' ?>" readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff;">
                        </div>
                        <div class="form-group" style="margin-top: 15px;  padding: 20px">
                            <label for="planks_needed" style="display: block; font-weight: bold; margin-bottom: 5px;"><?= AMOUNT_OF_PLANKS ?></label>
                            <input type="text" id="planks_needed" name="planks_needed" value="<?= isset($results['planks_needed']) ? htmlspecialchars($results['planks_needed']) : '' ?>" readonly style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table to display inventory products and allow updates to stock -->
            <div class="row">
                <div class="box" style="width: 100%;">
                    <h2 style=" padding: 20px"><?= BUILDING ?> & <?= GLUE ?> </h2>
                    <!-- Form to submit stock updates for inventory -->
                    <form action="<?= $basePath ?>/<?= $language ?>/Inventory/updateStock" method="POST" id="updateStockForm">
                        <!-- Table displaying the inventory list -->
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
                                <!-- Iterate through each product and display it in a table row -->
                                <tr data-category="<?= htmlspecialchars($product['category_name'] ?? '') ?>">
                                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                    <td class='product-name'><?php echo htmlspecialchars($product['Name'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Unit'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Family'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Supplier Names'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['lowstock'] ?? ""); ?></td>
                                    <td>
                                        <!-- Display current stock, and provide an input to update it -->
                                        <span class="stock-display"><?= htmlspecialchars($product['stock'] ?? ""); ?></span>
                                        <input type="number" class="stock-input" id="stock-input-<?= htmlspecialchars($product['product_id']); ?>" name="updated_stock[<?= htmlspecialchars($product['product_id']); ?>]" value="<?= htmlspecialchars($product['stock'] ?? ''); ?>" style="display: none;">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>
