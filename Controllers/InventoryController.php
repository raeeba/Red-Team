<?php
// Include paths as before
$pathToInventory = __DIR__ . "/../Models/Inventory.php";
$pathToController = __DIR__ . "/Controller.php";
//$pathToInventory = __DIR__ . "/../../Models/Inventory.php";

//$pathToInventory = __DIR__ . "/../../Models/Inventory.php";


//<?php
// Fetch categories
//require_once __DIR__ . "/../../Models/Inventory.php"; // Include Inventory model
//$inventoryModel = new Inventory(); 
//$categories = $inventoryModel->getCategories(); 
// Log fetched categories to the error log for debugging
//error_log(print_r($categories, true)); 
//

// Fix: Remove reference to undefined $pathToUserlogin
if (file_exists($pathToInventory) && file_exists($pathToController)) {
    include_once $pathToInventory;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToInventory), file_exists($pathToController));
    exit;
}

class InventoryController extends Controller
{
    function route()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {
            case "list":
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

                $data = [
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email']
                ];
                $this->render("Inventory", "list", $data);
                break;


            case "add":

                $inventoryModel = new Inventory();

                // Fetch categories
                $categories = $inventoryModel->getCategories();
                // Fetch suppliers
                $suppliers = $inventoryModel->getSuppliers();
                // Fetch family
                $family = $inventoryModel->getFamily();


                $data = [
                    // Pass categories to the view
                    'categories' => $categories,
                    // Pass suppliers to the view
                    'suppliers' => $suppliers,
                    // Pass family to the view
                    'family' => $family,
                ];

                $this->render("Inventory", "add", $data);
                break;

                //inserts to the db
            case "addSave":
                // Assuming you have a method to get POST data safely
                $name = $_POST['name'];
                $nameEn = $_POST['name_en'] ?? null; // This can be null
                $low_stock_alert = $_POST['low_stock_alert'];
                $stock = $_POST['stock'];
                $unit = $_POST['unit'];
                $suppliers = $_POST['suppliers'] ?? null; // This can also be null
                $category = $_POST['category'];


                // Additional fields based on selected category
                $additionalData = [];
                if (isset($_POST['family'])) {
                    $additionalData['family'] = trim($_POST['family']);
                }
                if (isset($_POST['glueType'])) {
                    $additionalData['glueType'] = trim($_POST['glueType']);
                }
                if (isset($_POST['cureTime'])) {
                    $additionalData['cureTime'] = trim($_POST['cureTime']);
                }
                if (isset($_POST['strength'])) {
                    $additionalData['strength'] = trim($_POST['strength']);
                }

                // Insert the product into the database using your Inventory model
                $inventoryModel = new Inventory();
                $result = $inventoryModel->insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category, $suppliers, $additionalData);

                if ($result) {
                    // Redirect or show success message
              var_dump('result is true');
                   // header("Location: " . $this->getBasePath() . "/en/inventory/list");
                    exit();
                } else {
                    echo "Failed to save the product."; // Handle failure case
                }
                break;





            case "modify":

                $inventoryModel = new Inventory();
                // Fetch categories
                $categories = $inventoryModel->getCategories();
                $data = [
                    // Pass categories to the view
                    'categories' => $categories
                ];

                $this->render("Inventory", "modify", $data);
                break;

            default:
                echo "Unsupported action.";
                break;
        }
    }
}
