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
                <input type="text" id="searchInput" placeholder="Enter employee" onkeyup="filterEmployees()">
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
                                <td><?php echo htmlspecialchars($product['name'] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($product['unit'] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($product['family_name'] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name'] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($product['supplier_name'] ?? ""); ?></td>
                                <td><?php echo htmlspecialchars($product['lowstock'] ?? ""); ?></td>
                                <td>
                                    <span class="stock-display"><?= htmlspecialchars($product['stock'] ?? ""); ?></span>
                                    <input type="number" class="stock-input" id="stock-input-<?= htmlspecialchars($product['product_id']); ?>" name="updated_stock[<?= htmlspecialchars($product['product_id']); ?>]" value="<?= htmlspecialchars($product['stock'] ?? ''); ?>" style="display: none;">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </form>

                <!-- Hidden forms for delete and update stock actions -->
                <form action="<?= $basePath ?>/<?= $language ?>/Inventory/delete" method="POST" id="deleteProductForm">
                    <input type="hidden" name="selected_products" id="deleteProductIdsInput">
                </form>


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

            modifyButton.disabled = checkedCount !== 1; // Enable if exactly one checkbox is checked
            updateStockButton.disabled = checkedCount === 0; // Enable if at least one checkbox is checked
            deleteButton.disabled = checkedCount === 0; // Enable if at least one checkbox is checked
        }

        function showUpdateStockFields() {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            selectedProducts.forEach((checkbox) => {
                const stockInput = document.getElementById(`stock-input-${checkbox.value}`);
                const stockDisplay = stockInput.previousElementSibling; // The span element showing the stock

                stockInput.style.display = 'inline-block'; // Show the input field
                stockDisplay.style.display = 'none'; // Hide the span display
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
                console.log('Selected Product ID:', productId); // Debug output
                window.location.href = `<?= $basePath ?>/${language}/Inventory/modify/${encodeURIComponent(productId)}`;
            } else {
                alert('Please select exactly one product to modify.');
            }
        }

        let updateStockClicked = false;

        function updateProductStock() {
            const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
            const updateProductIdsInput = document.getElementById('updateProductIdsInput');

            if (!updateStockClicked) {
                if (selectedProducts.length > 0) {
                    showUpdateStockFields(); // Show input fields for checked products
                    updateStockClicked = true;
                    document.getElementById('updateStockButton').textContent = 'Submit Stock Updates'; // Change button text
                } else {
                    alert('Please select at least one product to update stock.');
                    return;
                }
            } else {
                // Create an array of selected product IDs
                const selectedIds = Array.from(selectedProducts).map(checkbox => checkbox.value);
                updateProductIdsInput.value = JSON.stringify(selectedIds);

                // Enable only stock input fields for the selected products
                document.querySelectorAll('.stock-input').forEach(input => {
                    if (selectedIds.includes(input.id.split('-')[2])) {
                        input.removeAttribute('disabled'); // Enable inputs for checked products
                    } else {
                        input.setAttribute('disabled', 'true'); // Disable inputs for unchecked products
                    }
                });

                // Confirm and submit the form
                if (confirm('Are you sure you want to submit the stock updates?')) {
                    document.getElementById('updateStockForm').submit(); // Submit the form
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
                    document.getElementById('deleteProductForm').submit(); // Submit the form
                }
            } else {
                alert('Please select at least one product to delete.');
            }
        }

        // Add event listeners to checkboxes
        document.querySelectorAll('input[name="selected_products[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', countCheckedCheckboxes);
        });

        // Reset the flag when the form is submitted or when the page is reloaded
        window.onload = function() {
            countCheckedCheckboxes();
            updateStockClicked = false; // Reset the flag on page load
            document.getElementById('updateStockButton').textContent = 'Update Stock'; // Reset button text
        };
    </script>

</body>

</html>