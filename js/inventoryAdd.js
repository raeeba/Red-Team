

// Show/Hide additional fields based on selected category
document.getElementById('category').addEventListener('change', function() {
    var selectedCategoryId = parseInt(this.value, 10); // Ensure it's a number
    var additionalForm = document.getElementById('additionalForm');
    var dynamicFields = document.getElementById('dynamicFields');

    dynamicFields.innerHTML = ''; // Clear previous fields

    var fields = this.options[this.selectedIndex].dataset.fields;
    if (fields) {
        additionalForm.style.display = 'block';
        fields.split(',').forEach(function(field) {
            if (field === 'family') {
                createFamilyDropdown(dynamicFields, selectedCategoryId);
                console.log(selectedCategoryId);
            } else {
                createTextInput(dynamicFields, field);
            }
        });
    } else {
        additionalForm.style.display = 'none';
    }
});

// Toggle new supplier div when checkbox is checked
document.getElementById('addSupplier').addEventListener('change', function() {
    var newSupplierDiv = document.getElementById('newSupplierDiv');

    // Show the "New Supplier" form if the checkbox is checked
    if (this.checked) {
        newSupplierDiv.style.display = 'block';
    } else {
        newSupplierDiv.style.display = 'none';
    }
});

function createTextInput(container, field) {
    var containerDiv = document.createElement('div');
    containerDiv.className = 'modify-regular-div';

    var label = document.createElement('label');
    label.className = 'form-label';
    label.htmlFor = field;
    label.innerText = field.charAt(0).toUpperCase() + field.slice(1).replace(/([A-Z])/g, ' $1').trim();

    var lineBreak = document.createElement('br');

    var input = document.createElement('input');
    input.type = 'text';
    input.id = field;
    input.name = field;
    input.className = 'form-control';

    containerDiv.appendChild(label);
    containerDiv.appendChild(lineBreak);
    containerDiv.appendChild(input);
    container.appendChild(containerDiv);
}

function createFamilyDropdown(container, categoryId) {
    var containerDiv = document.createElement('div');
    containerDiv.className = 'modify-regular-div';

    var label = document.createElement('label');
    label.className = 'form-label';
    label.htmlFor = 'family';
    label.innerText = 'Family';

    var lineBreak = document.createElement('br');

    var select = document.createElement('select');
    select.id = 'family';
    select.name = 'family';
    select.className = 'form-control';
    select.required = true;

    // Add the placeholder option
    var placeholderOption = document.createElement('option');
    placeholderOption.value = '';
    placeholderOption.innerText = 'Select a family';
    placeholderOption.disabled = true;
    placeholderOption.selected = true;
    select.appendChild(placeholderOption);

    // Filter family options based on the selected category ID
    var filteredFamilies = familyOptions.filter(function(family) {
        return family.category_id === categoryId; // Match the category ID
    });

    // Populate the dropdown
    if (filteredFamilies.length > 0) {
        filteredFamilies.forEach(function(family) {
            var opt = document.createElement('option');
            opt.value = family.family_id; // Use family_id as the value
            opt.innerText = family.family_name; // Use family_name as the text
            select.appendChild(opt);
        });
    } else {
        var opt = document.createElement('option');
        opt.value = '';
        opt.innerText = 'No families available for this category';
        select.appendChild(opt);
    }

    containerDiv.appendChild(label);
    containerDiv.appendChild(lineBreak);
    containerDiv.appendChild(select);
    container.appendChild(containerDiv);
}

