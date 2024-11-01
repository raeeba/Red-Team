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

        if ($action == "list") {
            session_start();
            if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                echo "Permission denied.";
                return false;
            }
            if (!isset($_SESSION['name'])) {
                echo "Debug: 'name' not set in session.";
            } else {
                echo "Debug: 'name' in session is " . htmlspecialchars($_SESSION['name']);
            }
            $data=[
                'name'=>$_SESSION['name'],
                'email'=>$_SESSION['email']
            ];
            $this->render("Inventory", "list",$data);
        } else {
            echo "Unsupported action.";
        }
    }
}
