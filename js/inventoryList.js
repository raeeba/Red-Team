
// Use the variables directly
console.log('Base Path:', basePath);
console.log('Language:', language);
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
  
    window.location.href = `${basePath}/${language}/Inventory/add`;
}

function modifyProduct() {
    const selectedProducts = document.querySelectorAll('input[name="selected_products[]"]:checked');
    if (selectedProducts.length === 1) {
        const productId = selectedProducts[0].value;
        window.location.href = `${basePath}/${language}/Inventory/modify/${encodeURIComponent(productId)}`;
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
            document.getElementById('updateStockButton').textContent = 'Submit Stock Updates';


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
