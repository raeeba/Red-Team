<?php
// Include paths as before
$pathToInventory = __DIR__ . "/../Models/Inventory.php";
$pathToController = __DIR__ . "/Controller.php";

// Fix: Remove reference to undefined $pathToUserlogin
if (file_exists($pathToInventory) && file_exists($pathToController)) {
    include_once $pathToInventory;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToInventory), file_exists($pathToController));
    exit;
}

class InventoryController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        // Ensure the user is authenticated
        $this->checkSession();
        echo "<pre>Debug: Action is '$action'</pre>";

        if ($action == "list") {
            $this->render("Inventory", "list");
        } else {
            echo "Unsupported action.";
        }
    }
}
