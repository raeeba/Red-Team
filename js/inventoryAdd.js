
// Category - Additional Information
// Show/Hide additional fields based on selected category
document.getElementById('category').addEventListener('change', function() {

    // Get selected category id
    var selectedCategoryId = parseInt(this.value, 10); 
    var additionalForm = document.getElementById('additionalForm'); // additionalFrom div
    var dynamicFields = document.getElementById('dynamicFields'); // dynamicFields div
    
    // Clear previous fields
    dynamicFields.innerHTML = ''; 

    //Get specific fields to display for selected category
    var fields = this.options[this.selectedIndex].dataset.fields;

    // Check if specific fields are defind, then show additional form
    if (fields) {
        additionalForm.style.display = 'block';

        // Split fields and generate input dynamically
        fields.split(',').forEach(function(field) {

            // If field is " family", make dropdown
            if (field === 'family') {
                createFamilyDropdown(dynamicFields, selectedCategoryId);
                console.log(selectedCategoryId);
            } else {
            // Else make text input
                createTextInput(dynamicFields, field);
            }
        });
    } else {
        // Hide addtionalForm if no additional fields
        additionalForm.style.display = 'none';
    }
});


// For "Add SUpplier"
// Make new supplier div when checkbox is selected
document.getElementById('addSupplier').addEventListener('change', function() {
    var newSupplierDiv = document.getElementById('newSupplierDiv');

    // Show the "New Supplier" form if the checkbox is checked
    if (this.checked) {
        newSupplierDiv.style.display = 'block';
    } else {
        newSupplierDiv.style.display = 'none';
    }
});

// Dynamically make text field and label -- for Catgeory selection
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

//Make Family dropdown when specific category with family is selected
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
            // Use family_id as the value
            opt.value = family.family_id; 
            // Use family_name as the text
            opt.innerText = family.family_name; 
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

