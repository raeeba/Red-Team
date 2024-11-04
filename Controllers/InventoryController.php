<?php
// Include paths as before
$pathToUserlogin = __DIR__ . "/../Models/Userlogin.php";

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


        switch ($action) {
            case "list":
                session_start();
                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                }

         

                $userData = [
                    'name' => $_SESSION['name'],
                    'email' => $_SESSION['email']
                ];

                $inventoryModel = new Inventory();

                $productList = $inventoryModel->list();

                $data = [
                    'user' => $userData,
                    'products' => $productList
                ];

                $this->render("Inventory", "list", $data);
                break;

            case "add":
                session_start();
                
            if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                echo "Permission denied.";
                return false;
            }

                $inventoryModel = new Inventory();

                $categories = $inventoryModel->getCategories();
                $suppliers = $inventoryModel->getSuppliers();
                $family = $inventoryModel->getFamily();


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
                $suppliers = $_POST['suppliers'] ?? null; 
                $category = $_POST['category'];


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

                $inventoryModel = new Inventory();
                $result = $inventoryModel->insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category, $suppliers, $additionalData);

                if ($result) {
                    var_dump('result is true');
                    header("Location: " . $this->getBasePath() . "/en/inventory/list");
                    exit();
                } else {
                    echo "Failed to save the product.";
                }
                break;





            case "modify":
                session_start();
            if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                echo "Permission denied.";
                return false;
            }

                $id = isset($_GET['id']) ? intval($_GET['id']) : -1;


                $inventoryModel = new Inventory();
               
                $product = $inventoryModel->getProduct($id);
                $data = $product;

                $this->render("Inventory", "modify", $data);



                break;


            case "modifySave":

                $id = intval($_POST['product_id']);


                var_dump($id);

                $name = $_POST['namefr'];
                $nameEn = $_POST['name_en'] ?? null; 
                $low_stock_alert = $_POST['low_stock_alert'];
                $stock = $_POST['stock'];

                $inventoryModel = new Inventory();

                $product = $inventoryModel->getProduct($id);
                if (!$product) {
                    echo "Product not found.";
                    break;
                }

                $result = $inventoryModel->modifyProduct($id, $name, $nameEn, $low_stock_alert, $stock);

                if ($result) {
                    // Redirect or show success message
                    header("Location: " . $this->getBasePath() . "/en/inventory/list");
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
                    
                    var_dump($updatedStockData); 
                
                    $result = $inventoryModel->updateStock($updatedStockData);
                
                    if ($result) {
                        echo "Stock updated successfully.";
                        header("Location: " . $this->getBasePath() . "/en/inventory/list");

                    } else {
                        echo "Failed to update stock.";
                    }
                    break;
                

            case 'delete':

                session_start();
                if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                    echo "Permission denied.";
                    return false;
                }

                $inventoryModel = new Inventory();
                
                $productToDelete = $_POST['selected_products'];
                
                var_dump($productToDelete); 
            
                $result = $inventoryModel->deleteProduct($productToDelete);
            
                if ($result) {
                    echo "Deleted successfully.";
                    header("Location: " . $this->getBasePath() . "/en/inventory/list");

                } else {
                    echo "Failed to delete stock.";
                }               
                 break;

            default:
                echo "Unsupported action.";
                break;
        }
    }
}