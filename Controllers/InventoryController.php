<?php
// Include paths as before
$pathToUserlogin = __DIR__ . "/../Models/User.php";
$pathToInventory = __DIR__ . "/../Models/Inventory.php";
$pathToController = __DIR__ . "/Controller.php";

// Include once
if (file_exists($pathToUserlogin) && file_exists($pathToController)) {
    include_once $pathToUserlogin;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToUserlogin), file_exists($pathToController));
    exit;
}

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
        // Determine action based on GET ''action'
        $action = isset($_GET['action']) ? $_GET['action'] : "list";


        switch ($action) {
            case "list":

                // check session
                $this->checkSession();

                // verify user rights to view
                $hasRights = $this->verifyRights($_SESSION['email'], 'inventory', $action);
                // verify if user has right to modify
                $canModify = $this->verifyRights($_SESSION['email'], 'inventory', 'modify');


                if (!$hasRights) {
                    echo "Permission denied.";
                    return false;
                }

                $userData = [
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email']
                ];

                // Fetch product list
                $inventoryModel = new Inventory();
                $productList = $inventoryModel->list();

                $data = [
                    'user' => $userData,
                    'products' => $productList,
                    'verifyRights' => $canModify
                ];

                // Render the list view
                $this->render("Inventory", "list", $data);
                break;


            case "add":

                // check session
                $this->checkSession();

                // verify user's rights to add inventory
                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                }

                $inventoryModel = new Inventory();

                // Fetch categories, suppliers, and families
                $categories = $inventoryModel->getCategories();
                $suppliers = $inventoryModel->getSuppliers();
                $family = $inventoryModel->getFamily();

                // Add fields mapping to categories dynamically
                foreach ($categories as &$category) {

                    // Add fields based on category_id or category_name
                    switch ($category['category_name']) {
                        case 'Building':
                            $category['fields'] = 'family';
                            break;
                        case 'Glue':
                            $category['fields'] = 'family,cureTime,strength';
                            break;
                        case 'Isolant':
                            $category['fields'] = 'family,isolantStrength';
                            break;
                        case 'Miscellaneous':
                            $category['fields'] = 'family';
                            break;
                        default:
                            $category['fields'] = '';
                    }
                }

                $data = [
                    'categories' => $categories,
                    'suppliers' => $suppliers,
                    'family' => $family,
                ];

                // Render the add view
                $this->render("Inventory", "add", $data);
                break;


            case "addSave":
                // check session
                $this->checkSession();

                //Retrieve form data
                $name = $_POST['name'];
                $nameEn = $_POST['name_en'] ?? null;
                $low_stock_alert = $_POST['low_stock_alert'];
                $stock = $_POST['stock'];
                $unit = $_POST['unit'];
                $selectedSuppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
                $category = $_POST['category'];

                //Get additional data based on category
                $additionalData = [];

                // Debugging output for primary variables
                // var_dump([
                //     'name' => $name,
                //     'nameEn' => $nameEn,
                //     'low_stock_alert' => $low_stock_alert,
                //     'stock' => $stock,
                //     'unit' => $unit,
                //     'selectedSuppliers' => $selectedSuppliers,
                //     'category' => $category,
                // ]);

                //Adding fields to additionalData

                // Family
                if (isset($_POST['family'])) {
                    $additionalData['family'] = trim($_POST['family']);                }

                // Glue Category
                if (isset($_POST['cureTime'])) {
                    $additionalData['cureTime'] = trim($_POST['cureTime']);
                }

                if (isset($_POST['strength'])) {
                    $additionalData['strength'] = trim($_POST['strength']);
                }

                // Isolant Category
                if (isset($_POST['isolantStrength'])) {
                    $additionalData['isolantStrength'] = trim($_POST['isolantStrength']);
                }


                $inventoryModel = new Inventory();

                // Insert product to databse
                $result = $inventoryModel->insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category, $selectedSuppliers, $additionalData);

                if ($result) {
                    // var_dump('result is true');
                    header("Location: " . $this->getBasePath() . "/"  . $_SESSION['language'] .  "/inventory/list");
                    exit();
                } else {
                    echo "Failed to save the product.";
                }
                break;


            case "modify":

                // check session
                $this->checkSession();

                // Verify user rights for modify inventory
                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                }

                // Get product id from GET 
                $id = isset($_GET['id']) ? intval($_GET['id']) : -1;


                $userData = [
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email']
                ];

                $inventoryModel = new Inventory();

                //Fetch product details from Inventory model
                $product = $inventoryModel->getProduct($id);

                $data = [
                    'user' => $userData,
                    'products' => $product,
                ];

                // Render modify view 
                $this->render("Inventory", "modify", $data);

                break;


            case "modifySave":
                // check session
                $this->checkSession();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    // Retrieve updated product data from POST request
                    $product_id =  $_POST['product_id'];
                    $id = intval($_POST['product_id']);
                    $name = $_POST['namefr'];
                    $nameEn = $_POST['name_en'] ?? null;
                    $low_stock_alert = $_POST['low_stock_alert'];
                    $stock = $_POST['stock'];

                    $inventoryModel = new Inventory();

                    // Check if product exists
                    $product = $inventoryModel->getProduct($id);
                    if (!$product) {
                        echo "Product not found." . $product;
                        break;
                    }

                    //Update product in database
                    $result = $inventoryModel->modifyProduct($id, $name, $nameEn, $low_stock_alert, $stock);

                    if ($result) {
                        // Redirect to list if successful
                        header("Location: " . $this->getBasePath() . "/en/inventory/list");
                        exit();
                    } else {
                        echo "Failed to update the product.";
                    }
                }
                break;

            case "updateStock":

                // check session
                $this->checkSession();

                $inventoryModel = new Inventory();

                // Get updated stock data from POST
                $updatedStockData = $_POST['updated_stock'];

                if (empty($updatedStockData)) {
                    echo "No stock data received.";
                    break;
                }

                error_log("Updated stock data: " . print_r($updatedStockData, true));

                // Update stock in the database
                $result = $inventoryModel->updateStock($updatedStockData);

                if ($result) {
                    echo "Stock updated successfully.";

                    // Redirect to list inventory
                    header("Location: " . $this->getBasePath() . "/en/inventory/list");
                } else {
                    error_log("Stock update failed.");
                    echo "Failed to update stock.";
                }
                break;


            case 'delete':

                // check session
                $this->checkSession();

                // Verify user's rights to delete
                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                } else {

                    $inventoryModel = new Inventory();

                    // Get selected products to be deleted
                    $productToDelete = $_POST['selected_products'];

                    // Delete the selected products
                    $result = $inventoryModel->deleteProduct($productToDelete);

                    if ($result) {
                        // Redirect to list inventory
                        echo "Deleted successfully.";
                        header("Location: " . $this->getBasePath() . "/en/inventory/list");
                    } else {
                        echo "Failed to delete stock.";
                    }
                }

                break;

            default:
                echo "Unsupported action.";
                break;
        }
    }
}
