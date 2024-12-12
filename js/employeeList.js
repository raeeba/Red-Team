
// Navigates to the "Add Employee" page
function addEmployee() {
    window.location.href = `${basePath}/${language}/user/add`;
}

function modifyEmployee() {
        // Select all checked checkboxes with the name "selected_employees[]"
    const selectedEmployees = document.querySelectorAll('input[name="selected_employees[]"]:checked');
        // Check if exactly one employee is selected
    if (selectedEmployees.length === 1) {
            // Check if exactly one employee is selected

        const email = selectedEmployees[0].value;
        const modifyEmailInput = document.getElementById('modifyEmailInput');
        if (!modifyEmailInput) {
            console.error("Modify email input field is missing.");
            return;
        }
         // Find the hidden input field where the selected email will be stored
        modifyEmailInput.value = email; // Set the email in the hidden input
        document.getElementById('modifyForm').submit(); // Submit the form
    } else if (selectedEmployees.length === 0) {
        alert('Please select an employee to modify.');
    } else {
        alert('Please select exactly one employee to modify.');
    }
}
// Updates the state of the Modify and Delete buttons based on selected employees

function updateButtons() {
    const selectedEmployees = document.querySelectorAll('input[name="selected_employees[]"]:checked');
    const modifyButton = document.getElementById('modifyButton');
    modifyButton.disabled = selectedEmployees.length !== 1;
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.disabled = selectedEmployees.length === 0;

}
// Filters the employee table based on the search input and the class "employee-name"

function filterEmployees() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase();
    const employeeTable = document.getElementById("employeeTable");
    const rows = employeeTable.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
        const nameCell = rows[i].getElementsByClassName("employee-name")[0];
        if (nameCell) {
            const employeeName = nameCell.textContent.toLowerCase();
            rows[i].style.display = employeeName.indexOf(searchInput) > -1 ? "" : "none";
        }
    }
}

// Call updateButtons on page load to ensure the modify button is correctly enabled/disabled
window.onload = updateButtons;