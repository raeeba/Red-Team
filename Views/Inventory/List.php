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
    <link rel="stylesheet" href=<?= $basePath . "/css/inventoryView.css" ?>>

    <title><?=INVENTORY?></title>


</head>

<body>
    <div class="logo">
        <?php include_once dirname(__DIR__) . "/nav.php"; ?>

    </div>
    <div class="main-content">
        <div class="header">
            <h1><img src="<?= $basePath ?>/images/inventory.png" alt="Amo & Linat Logo"> <?= INVENTORY ?></h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Enter Product Name" onkeyup="searchProducts()">
                <button><img src="<?= $basePath ?>/images/search.png" alt="Search Icon" width="20" height="20"></button>
            </div>


            <div class="dropdown-container">
                <label for="categoriesDropdown" class="dropdown-label"><?= SELECT_CATEGORY ?>:</label>
                <select id="categoriesDropdown" class="styled-dropdown" onchange="filterByCategory()">
                    <option value=""><?= ALL_CATEGORY ?></option>
                    <option value="Building"><?= BUILDING ?></option>
                    <option value="Glue"><?= GLUE ?></option>
                    <option value="Isolant"><?= INSULATION ?></option>
                    <option value="Miscellaneous"><?= MISCELLANEOUS ?></option>
                </select>
            </div>

        </div>

        <div class="box2-main-form-div">


            <?php if (!empty($data['products'])) : ?>

                <div style="margin: 20px 0;">
                    <button id="lowStockToggle" style="background-color: #71797E; border: none; padding: 11px 30px; border-radius: 40px; cursor: pointer; color: white; font-size: 1.1em; display: flex; align-items: center; justify-content: space-between; width: 100%;" onclick="toggleLowStockContent()">
                        <?= LOW_STOCK ?>
                        <span id="lowStockIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 -2 16 16">
                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                            </svg>
                        </span>
                    </button>

                    <div id="lowStockContent" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; border-top: none; background-color: #f5f5f5;">
                        <div style="max-height: 300px; max-width: 97%; overflow-y: auto; margin: 0 auto; border-right: solid 1px #ccc; border-bottom: solid 1px #ccc;">
                            <?php
                            $lowStockProducts = array_filter($data['products'], function ($product) {
                                return isset($product['stock']) && $product['stock'] <= $product['lowstock'];
                            });
                            ?>

                            <!-- Table for Low Stock Inventory -->
                            <?php if (!empty($lowStockProducts)) : ?>
                                <table border="1" class="low-stock-table" id="low-stock-table" style="width: 100%;">
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
                                    <?php foreach ($lowStockProducts as $product) : ?>
                                        <tr data-category="<?= htmlspecialchars($product['category_name'] ?? '') ?>" class="low-stock-row">
                                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                            <!-- To change the language of product name -->
                                            <td><?php
                                                if ($language === 'fr') {

                                                    // If a nameFr is empty, use the english name
                                                    $name = trim($product['NameFr']);
                                                    if (empty($name) || $name === '') {
                                                        echo htmlspecialchars($product['Name']);
                                                    } else {
                                                        echo htmlspecialchars($name);
                                                    }
                                                } elseif ($language === 'en') {
                                                    // If a name is empty, use the french name
                                                    $name = trim($product['Name']);
                                                    if (empty($name) || $name === '') {
                                                        echo htmlspecialchars($product['NameFr']);
                                                    } else {
                                                        echo htmlspecialchars($name);
                                                    }
                                                } else {
                                                    // Default to French name
                                                    echo htmlspecialchars($product['NameFr']);
                                                }
                                                ?></td>
                                            <td><?php echo htmlspecialchars($product['Unit'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['Family'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['category_name'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['Supplier Names'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['lowstock'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>



                <div id="lowStockToggle" style=" border: 1px solid #ccc; border-radius: 40px;  padding: 11px 30px; background-color: #71797E;  color: white; font-size: 1.1em; margin: 0">
                    <?= ALL_PRODUCTS ?>


                </div>
                <div style=" max-width: 97%; overflow-x: auto;  margin: 0 auto; ">
                    <form action="<?= $basePath ?>/<?= $language ?>/Inventory/updateStock" method="POST" id="updateStockForm">
                        <table border="1" class="product-table" id="product-table" style="width: 100%; border-collapse: collapse; margin: 0">
                            <tr>
                                <?php if ($data['verifyRights']) : ?>
                                    <th><?= SELECTED ?></th>
                                <?php endif; ?>

                                <?php if ($data['verifyRights']) : ?>
                                    <th>ID</th>
                                <?php endif; ?>

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
                                    <?php if ($data['verifyRights']) : ?> <td class="checkbox">
                                            <input type="checkbox" id="product-<?= htmlspecialchars($product['product_id']); ?>" name="selected_products[]" value="<?= htmlspecialchars($product['product_id']); ?>" onchange="countCheckedCheckboxes()">
                                            <label for="product-<?= htmlspecialchars($product['product_id']); ?>"></label>
                                        </td> <?php endif; ?>
                                    <?php if ($data['verifyRights']) : ?> <td><?php echo htmlspecialchars($product['product_id']); ?></td> <?php endif; ?>
                                    <!-- To change the language of product name -->
                                    <td><?php
                                        if ($language === 'fr') {

                                            // If a nameFr is empty, use the english name
                                            $name = trim($product['NameFr']);
                                            if (empty($name) || $name === '') {
                                                echo htmlspecialchars($product['Name']);
                                            } else {
                                                echo htmlspecialchars($name);
                                            }
                                        } elseif ($language === 'en') {
                                            // If a name is empty, use the french name
                                            $name = trim($product['Name']);
                                            if (empty($name) || $name === '') {
                                                echo htmlspecialchars($product['NameFr']);
                                            } else {
                                                echo htmlspecialchars($name);
                                            }
                                        } else {
                                            // Default to French name
                                            echo htmlspecialchars($product['NameFr']);
                                        }
                                        ?></td>

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


                <!-- Hidden forms for delete -->
                <form action="<?= $basePath ?>/<?= $language ?>/Inventory/delete" method="POST" id="deleteProductForm">
                    <input type="hidden" name="selected_products" id="deleteProductIdsInput">
                </form>

                <!-- Hidden forms for update stock actions -->
                <form action="<?= $basePath ?>/<?= $language ?>/Inventory/updateStock" method="POST" id="updateStockForm">
                    <input type="hidden" name="selected_products" id="updateProductIdsInput">
                </form>

                <?php if ($verifyRights): ?>
                    <div class="actions">
                        <button type="button" onclick="addProduct()"><?= ADD_PRODUCT ?></button>
                        <button type="button" id="modifyButton" onclick="modifyProduct()" disabled><?= MODIFY_PRODUCT ?></button>
                        <button type="button" id="updateStockButton" onclick="updateProductStock()" disabled><?= UPDATE_STOCK ?></button>
                        <button type="button" class="delete" onclick="deleteProduct()" disabled><?= DELETE_PRODUCT ?></button>

                    </div>
                <?php endif; ?>




            <?php else : ?>
                <p>No products available in inventory.</p>
            <?php endif; ?>
        </div>
    </div>




    <script src="<?= htmlspecialchars($basePath . '/js/inventoryList.js') ?>"></script>

</body>

</html>