
    document.querySelector("form").addEventListener("submit", function (event) {
        const roleSelect = document.getElementById("role");
        const selectedRole = roleSelect.value;

        if (selectedRole === "super admin") {
            console.log("Granting Super Admin with Admin access...");
        }
    });



    const today = new Date();
    const minAgeDate = new Date(today.getFullYear() - 80, today.getMonth(), today.getDate());
    const maxAgeDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

    // Format dates as YYYY-MM-DD
    const maxDateStr = maxAgeDate.toISOString().split('T')[0];
    const minDateStr = minAgeDate.toISOString().split('T')[0];

    const birthdayInput = document.getElementById('birthday');
    birthdayInput.max = maxDateStr;
    birthdayInput.min = minDateStr;
