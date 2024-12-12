
// Use the variables directly
console.log('Base Path:', basePath);
console.log('Language:', language);

// Counts how many checkboxes/products are currently checked and updates them accordingly
function countCheckedCheckboxes() {
    const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
    let count = 0;

    // Loop through each checkbox and check if its selected
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            count++;
        }
    });

    // Call updateButtons to update button state based on number of checkboxes selected
    updateButtons(count);
}


function updateButtons(checkedCount) {
    // Updates if action buttons are enabled/disabled
    const modifyButton = document.getElementById('modifyButton');
    const updateStockButton = document.getElementById('updateStockButton');
    const deleteButton = document.querySelector('.delete');

    // Enable Modify button if only 1 checkbox is selected
    modifyButton.disabled = checkedCount !== 1;

    // Enable Update button if at least 1 checkbox is selected
    updateStockButton.disabled = checkedCount === 0;

    // Enable Delete button if at least 1 checkbox is selected
    deleteButton.disabled = checkedCount === 0;
}

// Shows text fiels for stock when their checkbox is selected
function showUpdateStockFields() {

    // Select all checked checkboxes with the name 'selected_products[]'
    const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');

    // Iterate through each selected checkbox
    selectedProducts.forEach((checkbox) => {

        // Get the input field for stock using its id
        const stockInput = document.getElementById(`stock-input-${checkbox.value}`);

        //Get the stock display
        const stockDisplay = stockInput.previousElementSibling;

        // Show the stock input field for editing
        stockInput.style.display = 'inline-block';
        stockDisplay.style.display = 'none';
    });
}

// Function to redirect to Add product view when Add Product button is selected
function addProduct() {

    window.location.href = `${basePath}/${language}/Inventory/add`;
}

// Function 
function modifyProduct() {

    // Select all checked checkboxes with the name 'selected_products[]'
    const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');

    // If only 1 checkbox is selected, get product id and redirect to modify oage
    if (selectedProducts.length === 1) {
        const productId = selectedProducts[0].value;
        window.location.href = `${basePath}/${language}/Inventory/modify/${encodeURIComponent(productId)}`;
    } else {
        alert('Please select exactly one product to modify.');
    }
}

// Updates product stock when Update 
function updateProductStock() {
    const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
    const updateProductIdsInput = document.getElementById('updateProductIdsInput');

    if (!updateStockClicked) {
        //Sow stock input field and change button text
        if (selectedProducts.length > 0) {
            showUpdateStockFields();
            updateStockClicked = true;
            document.getElementById('updateStockButton').textContent = 'Submit Stock Updates';


            // Toggle stock input fields based on checkbox changes
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
        //Submit stock updates
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
                    // Reset stock inputs if no changes
                    const checkbox = document.querySelector(`input[name="selected_products[]"][value="${productId}"]`);
                    if (checkbox) checkbox.checked = false;

                    // Revert the stock input field to original display
                    const stockInput = document.getElementById(`stock-input-${productId}`);
                    const stockDisplay = stockInput.previousElementSibling;

                    stockInput.style.display = 'none';
                    stockDisplay.style.display = 'inline-block';
                }
            }
        });

        if (!isStockUpdated) {
            alert('No stock changes were made.');
            return;
        }

        // Add updated stock values as hidden fields to the form
        for (const [productId, newStock] of Object.entries(updatedStockData)) {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `updated_stock[${productId}]`;
            hiddenInput.value = newStock;
            document.getElementById('updateStockForm').appendChild(hiddenInput);
        }

        // Submit form after confirmation
        if (confirm('Are you sure you want to submit the stock updates?')) {
            document.getElementById('updateStockForm').submit();
        }
    }
}

// Delets sleected product after confirmation
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

window.onload = function () {
    countCheckedCheckboxes();
    updateStockClicked = false;
    document.getElementById('updateStockButton').textContent = 'Update Stock'; // Reset button text
};

// search for product(s) based  on name
function searchProducts() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase();
    const productTable = document.getElementById("product-table");
    const rows = productTable.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByClassName("product-name")[0];
        if (nameCell) {
            const productName = nameCell.textContent.toLowerCase();
            rows[i].style.display = productName.indexOf(searchInput) > -1 ? "" : "none";
        }
    }
}

// filter based on category
function filterByCategory() {

    const selectedCategory = document.getElementById("categoriesDropdown").value;
    const rows = document.querySelectorAll(".product-table tr");

    rows.forEach((row, index) => {
        const productCategory = row.getAttribute("data-category");

        if (index === 0) {
            row.style.display = "";
            return;
        }

        if (selectedCategory && productCategory !== selectedCategory) {
            row.style.display = "none";
        } else {
            row.style.display = "";
        }
    });

}

// Expands / collapses the low stock table
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
