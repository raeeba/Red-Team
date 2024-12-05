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
    <link rel="stylesheet" href="styles.css">

    <title>Inventory List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 350px;
            padding: 30px;
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

        #lowStockToggle {
            font-weight: bold;
            text-transform: uppercase;
        }

        #lowStockContent {
            background-color: #f9f9f9;
        }

        .low-stock-table,
        .product-table {
            border: 2px solid #ccc;
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
            <h1><img src="<?= $basePath ?>/images/inventory.png" alt="Amo & Linat Logo"> <?= INVENTORY ?></h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Enter Product Name" onkeyup="searchProducts()">
                <button><img src="<?= $basePath ?>/images/search.png" alt="Search Icon" width="20" height="20"></button>
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
                                            <td class='product-name'><?php echo htmlspecialchars($product['Name'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['Unit'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['Family'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['category_name'] ?? ""); ?></td>
                                            <td><?php echo htmlspecialchars($product['Suppliers'] ?? ""); ?></td>
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
                                <th><?= SELECTED ?></th>
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
                                    <td class="checkbox">
                                        <input type="checkbox" id="product-<?= htmlspecialchars($product['product_id']); ?>" name="selected_products[]" value="<?= htmlspecialchars($product['product_id']); ?>" onchange="countCheckedCheckboxes()">
                                        <label for="product-<?= htmlspecialchars($product['product_id']); ?>"></label>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                    <td class='product-name'><?php echo htmlspecialchars($product['Name'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Unit'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Family'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name'] ?? ""); ?></td>
                                    <td><?php echo htmlspecialchars($product['Suppliers'] ?? ""); ?></td>
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

                <select id="categoriesDropdown" onchange="filterByCategory()">
                            <option value=""><?= ALL_CATEGORY ?></option>
                            <option value="Building"><?= BUILDING ?></option>
                            <option value="Glue"><?= GLUE ?></option>
                            <option value="Isolant"><?= INSULATION ?></option>
                            <option value="Miscellaneous"><?= MISCELLANEOUS ?></option>
                        </select>


            <?php else : ?>
                <p>No products available in inventory.</p>
            <?php endif; ?>
        </div>
    </div>



    <script>
        function countCheckedCheckboxes() {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            let count = 0;

            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    count++;
                }
            });

            updateButtons(count);
        }

        function updateButtons(checkedCount) {
            const modifyButton = document.getElementById('modifyButton');
            const updateStockButton = document.getElementById('updateStockButton');
            const deleteButton = document.querySelector('.delete');

            modifyButton.disabled = checkedCount !== 1;
            updateStockButton.disabled = checkedCount === 0;
            deleteButton.disabled = checkedCount === 0;
        }

        function showUpdateStockFields() {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            selectedProducts.forEach((checkbox) => {
                const stockInput = document.getElementById(`stock-input-${checkbox.value}`);
                const stockDisplay = stockInput.previousElementSibling;

                stockInput.style.display = 'inline-block';
                stockDisplay.style.display = 'none';
            });
        }

        function addProduct() {
            var basePath = '<?= $basePath ?>';
            var language = '<?= $language ?>';
            window.location.href = basePath + '/' + language + '/Inventory/add';
        }

        function modifyProduct() {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            if (selectedProducts.length === 1) {
                const productId = selectedProducts[0].value;
                console.log('Selected Product ID:', productId);
                window.location.href = `<?= $basePath ?>/${language}/Inventory/modify/${encodeURIComponent(productId)}`;
            } else {
                alert('Please select exactly one product to modify.');
            }
        }

        function updateProductStock() {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            const updateProductIdsInput = document.getElementById('updateProductIdsInput');

            if (!updateStockClicked) {
                if (selectedProducts.length > 0) {
                    showUpdateStockFields();
                    updateStockClicked = true;
                    document.getElementById('updateStockButton').textContent = 'Submit Stock Updates'; // Change button text


                    document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            const stockInput = document.getElementById(`stock-input-${this.value}`);
                            const stockDisplay = stockInput.previousElementSibling;

                            if (!this.checked) {
                                stockInput.style.display = 'none';
                                stockDisplay.style.display = 'inline-block';
                            } else {
                                stockInput.style.display = 'inline-block';
                                stockDisplay.style.display = 'none';
                            }
                        });
                    });

                    document.querySelectorAll('.stock-input').forEach(input => {
                        input.dataset.originalValue = input.value;
                    });
                } else {
                    alert('Please select at least one product to update stock.');
                    return;
                }
            } else {
                const selectedIds = Array.from(selectedProducts).map(checkbox => checkbox.value);
                updateProductIdsInput.value = JSON.stringify(selectedIds);


                document.querySelectorAll('.stock-input').forEach(input => {
                    const productId = input.id.split('-')[2];
                    if (!selectedIds.includes(productId)) {
                        input.disabled = true; // Disable inputs not selected
                    } else {
                        input.disabled = false;
                    }
                });

                // Check if stock values have been updated
                let isStockUpdated = false;
                const updatedStockData = {}; // To collect updated stock values

                document.querySelectorAll('.stock-input').forEach(input => {
                    const productId = input.id.split('-')[2];
                    if (selectedIds.includes(productId)) {
                        const originalValue = input.dataset.originalValue;
                        if (input.value !== originalValue) {
                            isStockUpdated = true;
                            updatedStockData[productId] = input.value;
                        } else {
                            const checkbox = document.querySelector(`input[name="selected_products[]"][value="${productId}"]`);
                            if (checkbox) checkbox.checked = false;

                            // Revert the stock input field to its original display
                            const stockInput = document.getElementById(`stock-input-${productId}`);
                            const stockDisplay = stockInput.previousElementSibling;

                            stockInput.style.display = 'none'; // Hide the input
                            stockDisplay.style.display = 'inline-block';
                        }
                    }
                });

                if (!isStockUpdated) {
                    alert('No stock changes were made.');
                    return;
                }

                for (const [productId, newStock] of Object.entries(updatedStockData)) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `updated_stock[${productId}]`;
                    hiddenInput.value = newStock;
                    document.getElementById('updateStockForm').appendChild(hiddenInput);
                }

                if (confirm('Are you sure you want to submit the stock updates?')) {
                    document.getElementById('updateStockForm').submit();
                }
            }
        }


        function deleteProduct() {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            const deleteProductIdsInput = document.getElementById('deleteProductIdsInput');

            if (selectedProducts.length > 0) {
                const selectedIds = Array.from(selectedProducts).map(checkbox => checkbox.value);
                deleteProductIdsInput.value = JSON.stringify(selectedIds);

                if (confirm('Are you sure you want to delete the selected products?')) {
                    document.getElementById('deleteProductForm').submit();
                }
            } else {
                alert('Please select at least one product to delete.');
            }
        }

        document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', countCheckedCheckboxes);
        });

        window.onload = function() {
            countCheckedCheckboxes();
            updateStockClicked = false;
            document.getElementById('updateStockButton').textContent = 'Update Stock'; // Reset button text
        };

        // search for product(s) based  on name
        function searchProducts() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const productTable = document.getElementById("product-table");
            const rows = productTable.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                const nameCell = rows[i].getElementsByClassName("product-name")[0];
                if (nameCell) {
                    const productName = nameCell.textContent.toLowerCase();
                    rows[i].style.display = productName.indexOf(searchInput) > -1 ? "" : "none";
                }
            }
        }

        // filter based on category
        function filterByCategory() {
            /*const category = document.getElementById('categoriesDropdown').value;
            const rows = document.querySelectorAll('#product-table tr');

            rows.forEach(row => {
                if (row.querySelector('th')) return;

                const productCategory = row.getAttribute('data-category').toLowerCase();

                if (category === '' || productCategory === category.toLowerCase()) {
                    row.style.display = '';
                    if (productCategory === 'glue') {
                        row.querySelector('.glue-strength').style.display = ''; // Show glue-specific field
                        row.querySelector('.cure-time').style.display = 'none'; // Hide insulation field
                    }
                    /*else if (productCategory === 'insulation') {
                                           row.querySelector('.extra-field-insulation').style.display = '';  // Show insulation-specific field
                                           row.querySelector('.extra-field-glue').style.display = 'none';  // Hide glue field
                                       } */
            /*else {
                        row.querySelector('.glue-strength').style.display = 'none'; // Hide glue field
                        row.querySelector('.cure-time').style.display = 'none'; // Hide insulation field
                    }
                } else {
                    row.style.display = 'none';
                }
            });*/
            const selectedCategory = document.getElementById("categoriesDropdown").value;
            const rows = document.querySelectorAll(".product-table tr");

            rows.forEach((row, index) => {
                const productCategory = row.getAttribute("data-category");

                // Always show the header row (assumes it's the first row)
                if (index === 0) {
                    row.style.display = ""; // Ensure header is always displayed
                    return;
                }

                // Hide or show rows based on the selected category
                if (selectedCategory && productCategory !== selectedCategory) {
                    row.style.display = "none";
                } else {
                    row.style.display = "";
                }
            });

        }

        function toggleLowStockContent() {
            const content = document.getElementById("lowStockContent");
            const icon = document.getElementById("lowStockIcon");

            if (content.style.maxHeight === "0px" || !content.style.maxHeight) {
                content.style.maxHeight = "300px";
                icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 -2 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>`;
            } else {
                content.style.maxHeight = "0px";
                icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 -2 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>`;
            }
        }
    </script>

</body>

</html>