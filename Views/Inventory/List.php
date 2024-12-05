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
            <h1><img src="<?= $basePath ?>/images/employee.png" alt="Amo & Linat Logo"> LIST PRODUCT</h1>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Enter Products" onkeyup="filterEmployees()">
                <button><img src="<?= $basePath ?>/images/search.png" alt="Search Icon" width="20" height="20"></button>
            </div>
        </div>

        <div class="box2-main-form-div">


            <?php if (!empty($data['products'])) : ?>

                <form action="<?= $basePath ?>/<?= $language ?>/Inventory/updateStock" method="POST" id="updateStockForm">
                    <table border="1" class="product-table">
                        <tr>
                            <th>Select</th>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Family Name</th>
                            <th>Category Name</th>
                            <th>Supplier Name</th>
                            <th>Low Stock</th>
                            <th>Stock</th>
                        </tr>
                        <?php foreach ($data['products'] as $product) : ?>
                            <tr>
                                <td class="checkbox">
                                    <input type="checkbox" id="product-<?= htmlspecialchars($product['product_id']); ?>" name="selected_products[]" value="<?= htmlspecialchars($product['product_id']); ?>" onchange="countCheckedCheckboxes()">
                                    <label for="product-<?= htmlspecialchars($product['product_id']); ?>"></label>
                                </td>
                                <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                <td><?php echo htmlspecialchars($product['Name'] ?? ""); ?></td>
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

                <!-- Hidden forms for delete -->
                <form action="<?= $basePath ?>/<?= $language ?>/Inventory/delete" method="POST" id="deleteProductForm">
                    <input type="hidden" name="selected_products" id="deleteProductIdsInput">
                </form>

                <!-- Hidden forms for update stock actions -->
                <form action="<?= $basePath ?>/<?= $language ?>/Inventory/updateStock" method="POST" id="updateStockForm">
                    <input type="hidden" name="selected_products" id="updateProductIdsInput">
                </form>


                <div class="actions">
                    <button type="button" onclick="addProduct()">Add Product</button>
                    <button type="button" id="modifyButton" onclick="modifyProduct()" disabled>Modify Product Information</button>
                    <button type="button" id="updateStockButton" onclick="updateProductStock()" disabled>Update Stock</button>
                    <button type="button" class="delete" onclick="deleteProduct()" disabled>Delete Selected Product(s)</button>
                </div>

            <?php else : ?>
                <p>No products available in inventory.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>AMO & LINAT - <?= ALL_RIGHTS ?></p>
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

            // Add event listeners to checkboxes to hide stock fields when deselected
            document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
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

            // Store original stock values for comparison
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

        // Ensure only selected products' stock inputs are included in the submission
        document.querySelectorAll('.stock-input').forEach(input => {
            const productId = input.id.split('-')[2]; // Extract product ID from input ID
            if (!selectedIds.includes(productId)) {
                input.disabled = true; // Disable inputs not selected
            } else {
                input.disabled = false; // Ensure selected inputs are enabled for submission
            }
        });

        // Check if stock values have been updated
        let isStockUpdated = false;
        const updatedStockData = {}; // To collect updated stock values

        document.querySelectorAll('.stock-input').forEach(input => {
            const productId = input.id.split('-')[2]; // Extract product ID from input ID

            if (selectedIds.includes(productId)) {
                const originalValue = input.dataset.originalValue; // Get the stored original value
                if (input.value !== originalValue) {
                    isStockUpdated = true; // Stock has been updated
                    updatedStockData[productId] = input.value; // Store updated value
                } else {
                    // Deselect the product if no changes were made
                    const checkbox = document.querySelector(`input[name="selected_products[]"][value="${productId}"]`);
                    if (checkbox) checkbox.checked = false;

                    // Revert the stock input field to its original display
                    const stockInput = document.getElementById(`stock-input-${productId}`);
                    const stockDisplay = stockInput.previousElementSibling;

                    stockInput.style.display = 'none'; // Hide the input
                    stockDisplay.style.display = 'inline-block'; // Show the original label
                }
            }
        });

        if (!isStockUpdated) {
            alert('No stock changes were made.');
            return; // Prevent form submission
        }

        // Attach updated stock data to the form
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
    </script>

</body>

</html>