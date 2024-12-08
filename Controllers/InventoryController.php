<?php
// Include paths as before
$pathToUserlogin = __DIR__ . "/../Models/User.php";

$pathToInventory = __DIR__ . "/../Models/Inventory.php";
$pathToController = __DIR__ . "/Controller.php";

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
        $action = isset($_GET['action']) ? $_GET['action'] : "list";
        //session_start();


        switch ($action) {
            case "list":

                $hasRights = $this->verifyRights($_SESSION['email'], 'inventory', $action);
            
                $canDelete = $this->verifyRights($_SESSION['email'], 'inventory', 'delete');


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
                    'verifyRights' => $canDelete  
                ];
            
                // Render the view
                $this->render("Inventory", "list", $data);
                break;
            

            case "add":

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
                            $category['fields'] = ''; // No additional fields for unknown categories
                    }
                }


                // Debugging output
                //  var_dump($categories); // Check if categories data is fetched
               // var_dump($suppliers);
                // var_dump($family);
                //FAMILY DATA HAS FAMILY ID, FAMILYNAME, CATEGORYID AND CATEGORY NAME

                $data = [
                    'categories' => $categories,
                    'suppliers' => $suppliers,
                    'family' => $family,
                ];

                $this->render("Inventory", "add", $data);
                break;


            case "addSave":
                $name = $_POST['name'];
                $nameEn = $_POST['name_en'] ?? null;
                $low_stock_alert = $_POST['low_stock_alert'];
                $stock = $_POST['stock'];
                $unit = $_POST['unit'];
                $selectedSuppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
                $category = $_POST['category'];

                $additionalData = [];

                // Debugging output for primary variables
                var_dump([
                    'name' => $name,
                    'nameEn' => $nameEn,
                    'low_stock_alert' => $low_stock_alert,
                    'stock' => $stock,
                    'unit' => $unit,
                    'selectedSuppliers' => $selectedSuppliers,
                    'category' => $category,
                ]);

                //FOR ADDITIONAL DATA

                //family
                if (isset($_POST['family'])) {
                    $additionalData['family'] = trim($_POST['family']);
                    var_dump(['additionalData' => $additionalData]);
                }

                //Glue

                if (isset($_POST['cureTime'])) {
                    $additionalData['cureTime'] = trim($_POST['cureTime']);

                    echo '....CURE TIME: ' . $_POST['cureTime'] . '<br>';
                }

                if (isset($_POST['strength'])) {
                    $additionalData['strength'] = trim($_POST['strength']);

                    echo '....strength TIME: ' . $_POST['strength'] . '<br>';
                }

                //Isolant
                if (isset($_POST['isolantStrength'])) {
                    $additionalData['isolantStrength'] = trim($_POST['isolantStrength']);

                    echo '....strength ISOLANT TIME: ' . $_POST['isolantStrength'] . '<br>';
                }



                // Handle new suppliers
                $supplierIds = [];
                foreach ($selectedSuppliers as $supplier) {
                    echo 'Supplier ID: ' . $supplier . '<br>';

                    if ($supplier === 'addSupplier') {
                        $newSupplierName = isset($_POST['newSupplierName']) ? trim($_POST['newSupplierName']) : null;
                        $newSupplierContact = isset($_POST['newSupplierContact']) ? trim($_POST['newSupplierContact']) : null;
                    }
                }


                $inventoryModel = new Inventory();
                $result = $inventoryModel->insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category, $selectedSuppliers, $additionalData);

                if ($result) {
                    var_dump('result is true');
                    header("Location: " . $this->getBasePath() . "/"  . $_SESSION['language'] .  "/inventory/list");
                    exit();
                } else {
                    echo "Failed to save the product.";
                }
                break;


            case "modify":
                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                }

                $id = isset($_GET['id']) ? intval($_GET['id']) : -1;


                $userData = [
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email']
                ];
                
                $inventoryModel = new Inventory();

                $product = $inventoryModel->getProduct($id);
                $data = [
                    'user' => $userData,
                    'products' => $product,
                 //   'verifyRights' => $canDelete  
                ];
             //   $data = $product;

                $this->render("Inventory", "modify", $data);



                break;


            case "modifySave":

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Retrieve all POST data
                    $post_data = $_POST;
                
                    // Retrieve product_id specifically
                    $product_id = $post_data['product_id'] ?? null;
                
                    if ($product_id) {
                        echo "Product ID received: " . htmlspecialchars($product_id);
                    } else {
                        echo "No product ID in POST data.";
                    }
                }
                

                $id = intval($_POST['product_id']);


                var_dump($id);

                $name = $_POST['namefr'];
                $nameEn = $_POST['name_en'] ?? null;
                $low_stock_alert = $_POST['low_stock_alert'];
                $stock = $_POST['stock'];

                $inventoryModel = new Inventory();

                $product = $inventoryModel->getProduct($id);
                if (!$product) {
                    echo "Product not found." . $product;
                    break;
                }

                $result = $inventoryModel->modifyProduct($id, $name, $nameEn, $low_stock_alert, $stock);

                if ($result) {
                    // Redirect or show success message
                    header("Location: " . $this->getBasePath() . "/" . $_SESSION['language'] . "/inventory/list");
                    exit();
                } else {
                    echo "Failed to update the product.";
                }
                break;

            case "routeFunction":
                break;

                case "updateStock":
                    $inventoryModel = new Inventory();
                    $updatedStockData = $_POST['updated_stock'];
                
                    if (empty($updatedStockData)) {
                        echo "No stock data received.";
                        break;
                    }
                
                    error_log("Updated stock data: " . print_r($updatedStockData, true));
                
                    $result = $inventoryModel->updateStock($updatedStockData);
                
                    if ($result) {
                        echo "Stock updated successfully.";
                        header("Location: " . $this->getBasePath() . "/" . $_SESSION['language'] . "/inventory/list");
                    } else {
                        error_log("Stock update failed.");
                        echo "Failed to update stock.";
                    }
                    break;
                


            case 'delete':

                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                } else {

                    $inventoryModel = new Inventory();

                    $productToDelete = $_POST['selected_products'];
    
                    var_dump($productToDelete);
    
                    $result = $inventoryModel->deleteProduct($productToDelete);
    
                    if ($result) {
                        echo "Deleted successfully.";
                        header("Location: " . $this->getBasePath() . "/"  . $_SESSION['language'] . "/inventory/list");
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
