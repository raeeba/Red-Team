document.addEventListener("DOMContentLoaded", function () {
    // Add click listeners to all menu items
    const menuItems = document.querySelectorAll(".menu-item");
    menuItems.forEach(item => {
        item.addEventListener("click", function (event) {
            const itemId = this.id; // The ID of the clicked menu item
            selectMenuItem(itemId); // Call the selectMenuItem function with the ID
        });
    });

    // Call this on page load to highlight the active menu item
    setActiveMenuItem();
});
        

        // Function to select and store the active menu item in localStorage
        function selectMenuItem(itemId) {
    localStorage.setItem("activeMenuItem", itemId); // Store the active menu item in localStorage
    setActiveMenuItem(); // Update the active state visually
    navigateToView(itemId); // Navigate to the appropriate view
}
        // Function to set the active menu item based on localStorage
        function setActiveMenuItem() {
    const activeItem = localStorage.getItem("activeMenuItem");
    const menuItems = document.querySelectorAll(".menu-item");
    menuItems.forEach(item => {
        item.classList.remove("active");
        if (item.id === activeItem) {
            item.classList.add("active");
        }
    });
}

        // Function to navigate to the correct view based on the selected menu item
        function navigateToView(itemId) {
            let viewUrl = '';
            switch (itemId) {
                case 'inventory':
                    viewUrl = `${basePath}/${language}/inventory/list`;
                    break;
                case 'calculator':
                    viewUrl = `${basePath}/${language}/calculator/view`;
                    break;
                case 'employees':
                    viewUrl = `${basePath}/${language}/user/list`;
                    break;
                case 'signout':
                    if (confirm('Are you sure you want to log out?')) {
                        viewUrl = `${basePath}/${language}/user/logout`;
                        window.location.href = viewUrl;
                    }
                    return; // Exit the function if "Cancel" is selected
                default:
                    viewUrl = `${basePath}/${language}/inventory/list`;
            }
            window.location.href = viewUrl;
        }

        // Call setActiveMenuItem on page load to maintain the state
        window.onload = function() {
            setActiveMenuItem();
            setLanguage();
        }

        // Function to switch language and store the selection in localStorage
        function switchLanguage(selectedLang) {
    // Get the current URL and split it by `/` to get parts
    let currentUrlParts = window.location.pathname.split('/');

    // Assuming the language part is always the third element in the URL, e.g., `/Red-Team/fr/...`
    if (currentUrlParts.length > 2) {
        currentUrlParts[2] = selectedLang; // Replace the language part with the selected language
    }

    // Rebuild the new URL path with the selected language
    let newPath = currentUrlParts.join('/');

    // Reload the page with the updated URL (keeping the current base path and adding the new path)
    window.location.href = window.location.origin + newPath;
}

        // Function to set the selected language button based on localStorage
        function setLanguage() {
            const selectedLanguage = localStorage.getItem('selectedLanguage') || language;
            const languageButtons = document.querySelectorAll('.language-switch button');
            languageButtons.forEach(button => {
                button.classList.remove('selected');
                if (button.textContent.toLowerCase() === selectedLanguage) {
                    button.classList.add('selected');
                }
            });
        }