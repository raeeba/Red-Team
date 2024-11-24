<?php

require_once __DIR__ . '/../Models/Model.php';

class Inventory extends Model
{
    public $productId;
    public $productName;
    public $stock;
    public $lowStock;
    public $unitOfMeasurement;
    public $supplier;
    public $family;

    public function __construct($id = -1)
    {
        parent::__construct();

        $this->productId = $id;

        if ($id < 0) {
            $this->productName = "";
            $this->stock = 0;
            $this->lowStock = 0;
            $this->unitOfMeasurement = "";
            $this->supplier = "";
            $this->family = "";
        } else {
            $sql = "SELECT * FROM `products` WHERE `product_id` = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($data = $result->fetch_assoc()) {
                $this->productId = $data['product_id'];
                $this->productName = $data['product_name'];
                $this->stock = $data['stock'];
                $this->lowStock = $data['lowstock'];
                $this->unitOfMeasurement = $data['unit_of_measurement'];
                $this->supplier = $data['supplier_id'];
                $this->family = $data['family_id'];
            }
        }
    }

    ////////////////////////// DELETE PRODUCT //////////////////////
    public function deleteProduct($productIds)
    {
        if (is_string($productIds)) {
            $productIds = json_decode($productIds, true);
        }

        if (!is_array($productIds) || empty($productIds)) {
            error_log("No product IDs provided for deletion.");
            return false;
        }

        $success = true;

        foreach ($productIds as $productId) {
            // Delete from the `products` table.
            $sql = "DELETE FROM `products` WHERE `product_id` = ?";
            $stmt = $this->conn->prepare($sql);

            if (!$stmt) {
                error_log("Failed to prepare statement for deleting from products: " . $this->conn->error);
                $success = false;
                continue;
            }

            $stmt->bind_param("i", $productId);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                error_log("No rows deleted from products table for product_id: $productId");
                $success = false;
            }
        }

        return $success;
    }
    // public function deleteProduct($productIds)
    // {

    //     if (is_string($productIds)) {
    //         $productIds = json_decode($productIds, true);
    //     }

    //     if (!is_array($productIds) || empty($productIds)) {
    //         error_log("No product IDs provided for deletion.");
    //         return false;
    //     }

    //     $success = true;

    //     foreach ($productIds as $productId) {
    //         $category_id = $this->getCategoryIdForModify($productId);

    //         var_dump($category_id);
    //         var_dump($productIds);

    //         if ($category_id == 1) {
    //             var_dump('DELTE FROM BUILDING');
    //             $sql = "DELETE FROM `building` WHERE `product_id` = ?";
    //         } elseif ($category_id == 2) {
    //             $sql = "DELETE FROM `glue` WHERE `product_id` = ?";
    //         } elseif ($category_id == 3) {
    //             $sql = "DELETE FROM `isolant` WHERE `product_id` = ?";
    //         } elseif ($category_id == 4) {
    //             $sql = "DELETE FROM `miscellaneous` WHERE `product_id` = ?";
    //         }  
    //         else {
    //             error_log("Unknown category ID for product_id: $productId");
    //             continue;
    //         }

    //         $stmt = $this->conn->prepare($sql);
    //         if (!$stmt) {
    //             error_log("Failed to prepare statement for category deletion: " . $this->conn->error);
    //             $success = false;
    //             continue;
    //         }

    //         $stmt->bind_param("i", $productId);
    //         $stmt->execute();

    //         if ($stmt->affected_rows === 0) {
    //             error_log("No rows deleted from category table for product_id: $productId");
    //             $success = false;
    //             continue;
    //         }

    //         $sql = "DELETE FROM `products` WHERE `product_id` = ?";
    //         $stmt = $this->conn->prepare($sql);
    //         if (!$stmt) {
    //             error_log("Failed to prepare statement for deleting from products: " . $this->conn->error);
    //             $success = false;
    //             continue;
    //         }

    //         $stmt->bind_param("i", $productId);
    //         $stmt->execute();

    //         if ($stmt->affected_rows === 0) {
    //             error_log("No rows deleted from products table for product_id: $productId");
    //             $success = false;
    //         }
    //     }

    //     return $success;
    // }




    ///////////////////////// UPDATE STOCK ////////////////////////
    public function updateStock($updatedStockData)
    {
        foreach ($updatedStockData as $productId => $newStock) {
            $sql = "UPDATE `products` SET `stock` = ? WHERE `product_id` = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $newStock, $productId);
            $stmt->execute();

            if ($stmt->affected_rows === 0) {
                error_log("No rows updated for product_id: $productId");
                return false;
            }
            var_dump('UPDATE_STOCK MORE SLAY');
        }
        return true;
    }

    ///////////////// MODIFY PRODUCT ////////////////////////////
    public function getProduct($id)
    {
        $sql =
            "SELECT
            p.product_id, 
        COALESCE(b.name, g.name, i.name, m.name) AS name,
        COALESCE(b.namefr, g.namefr, i.namefr, m.namefr) AS namefr,
        p.lowstock,
        p.stock
    FROM `products` p 
    LEFT JOIN `building` b ON b.product_id = p.product_id 
    LEFT JOIN `glue` g ON g.product_id = p.product_id 
    LEFT JOIN `isolant` i ON i.product_id = p.product_id 
    LEFT JOIN `miscellaneous` m ON m.product_id = p.product_id
    WHERE p.product_id = ?";


        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        return !empty($product) ? $product : null;
    }

    public function modifyProduct($id, $namefr, $nameen, $lowstock, $stock)
    {
        $category_id = $this->getCategoryIdForModify($id);

        var_dump($category_id);
        if ($category_id > 0) {
            $result = false;


            // modify the product in its category table based on category id 
            $result = $this->modifyProductInCategory($category_id, $id, $namefr, $nameen);


            if ($result) {
                $sql = "UPDATE `products` 
                SET `lowstock` = ?, `stock` = ?
                WHERE `product_id` = ?";

                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("iii", $lowstock, $stock, $id);

                if ($stmt->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    public function modifyProductInCategory($category_id, $id, $namefr, $nameen)
    {
        // Map category_id to table name
        $categories = [
            1 => 'building',
            2 => 'glue',
            3 => 'isolant',
            4 => 'miscellaneous',

        ];

        // Validate the category_id
        if (!isset($categories[$category_id])) {
            throw new Exception("Invalid category_id: $category_id");
        }

        $category = $categories[$category_id]; // Get the table name

        // Prepare the SQL query
        $sql = "UPDATE `$category` 
                SET `namefr` = ?, `name` = ?
                WHERE `product_id` = ?";

        // Execute the query
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        // Bind the parameters
        $stmt->bind_param("ssi", $namefr, $nameen, $id);

        // Execute and return success or failure
        if (!$stmt->execute()) {
            throw new Exception("Failed to execute query: " . $stmt->error);
        }

        return true; // If no errors, the update was successful
    }



    public function getCategoryIdForModify($product_id)
    {
        // GET THE CATEGORY ID IN PRODUCT
        $sql = "SELECT category_id FROM `products` WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];

                return $category_id;
            } else {
                var_dump('No category found');
                return false;
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }



    ////////////////////// LIST //////////////////////////

    public function list()
    {

        // Changed this to View - for query optimization
        $sql = "SELECT * FROM product_list_view";


        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $list = [];
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }

        return !empty($list) ? $list : null;
    }


    ////////////////////// ADD /////////////////////////////

    public function getCategories()
    {
        $sql = "SELECT category_id, category_name FROM categories"; // Adjust field names as per your table structure

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = [
                'category_id' => $row['category_id'], // Assuming 'id' is the primary key
                'category_name' => $row['category_name'], // Name of the category
            ];
        }

        return !empty($categories) ? $categories : null;
    }



    public function getFamily()
    {
        $sql = "
        SELECT 
            f.family_name , 
            f.family_id , 
            c.category_id, 
            c.category_name
        FROM families f
        JOIN categories c ON f.category_id = c.category_id
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $families = [];
        while ($row = $result->fetch_assoc()) {
            $families[] = [
                'family_id' => $row['family_id'],
                'family_name' => $row['family_name'],
                'category_id' => $row['category_id'],
                'category_name' => $row['category_name']
            ];
        }

        return !empty($families) ? $families : null;
    }



    public function getSuppliers()
    {

        $sql = "SELECT supplier_id, supplier_name FROM suppliers";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = [
                'supplier_id' => $row['supplier_id'],
                'supplier_name' => $row['supplier_name'],
            ];
        }

        return !empty($suppliers) ? $suppliers : null;
    }

    public function insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category_id, $suppliers, $additionalData)
    {
        // ADD A CONDITION WHERE YOU CAN ONLY ADD ONE PRODUCT AND NOT MULTIPLE OF THE SAME

        $family_id = isset($additionalData['family']) ? $additionalData['family'] : null;

        // Glue-specific data
        //  $glueType = isset($additionalData['glueType']) ? $additionalData['glueType'] : null;
        $cureTime = isset($additionalData['cureTime']) ? $additionalData['cureTime'] : null;
        $strength = isset($additionalData['strength']) ? $additionalData['strength'] : null;

        //isolant
        $isolantStrength = isset($additionalData['isolantStrength']) ? $additionalData['isolantStrength'] : null;

        echo '....Supplier ID: ' . $cureTime . '<br>';

        // Get category ID
        //$category_id = $this->getCategoryId($category);

        var_dump('mmmmmmm' . $family_id . ' ' . $category_id);
        //$category_id = $category_id;


        // // Check for duplicate product
        // if ($this->checkDuplicateProduct($name, $category_id, $family, $glueType)) {
        //     throw new Exception("A product with the same name and details already exists.");
        // }

        // Suppliers
        $supplierIds = [];
        foreach ($suppliers as $supplier) {
            echo '....Supplier ID: ' . $supplier . '<br>';

            if ($supplier == 'addSupplier') {

                $supplierIds[] = $this->processSupplier($supplier);
                $supplier = $supplierIds[0];
                echo '....Supplier ID if add supplier: ' . $supplierIds[0] . '<br>';
            }

            // INSERTING TO SPECIFIC CATEGORY
            if ($category_id == 1) {
                // Find Family Id based on category Id
                //   $family_id = $this->getFamilyId($category_id, $family);

                // Insert Product
                $product_id = $this->insertToProductTable($category_id, $family_id, $supplier, $low_stock_alert, $stock);

                // Insert to Building
                $this->insertToBuilding($product_id, $name, $nameEn, $family_id, $unit);

                return true;
            } else if ($category_id == 2) {
                // Insert to Glue

                var_dump($family_id);
                $product_id = $this->insertToProductTable($category_id, $family_id, $supplier, $low_stock_alert, $stock);

                $this->insertToGlue($product_id, $name, $nameEn, $cureTime,  $strength, $unit, $family_id);

                return true;
            } else if ($category_id == 3) {

                // Insert to Isolant
                $product_id = $this->insertToProductTable($category_id, $family_id, $supplier, $low_stock_alert, $stock);

                $this->insertToIsolant($product_id, $name, $nameEn, $isolantStrength, $unit, $family_id);

                return true;
            } else if ($category_id == 4) {

                // Insert to Isolant
                $product_id = $this->insertToProductTable($category_id, $family_id, $supplier, $low_stock_alert, $stock);

                $this->insertToMisc($product_id, $name, $nameEn, $unit, $family_id);

                return true;
            }
        }
    }





    public function insertToBuilding($product_id, $name, $nameEn, $family_id, $unit)
    {

        $family_name = $this->getFamilyName($family_id);

        $sql = "INSERT INTO building (product_id, name, namefr, family, unit) VALUES (?, ?, ?, ?, ?)";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('issss', $product_id,  $nameEn, $name, $family_name, $unit);

        if ($stmt->execute()) {
            $building_id = $stmt->insert_id;
            var_dump('building_id ---- building_id FOUND: ' . $building_id);
            return $building_id;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }

    public function insertToGlue($product_id, $nameFr, $nameEn, $cureTime, $strength, $unit,  $family_id,)
    {

        $family_name = $this->getFamilyName($family_id);

        // Insert to Glue Table
        $sql = "INSERT INTO glue (product_id, name, namefr, cure_time, strength, unit, family) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('issssss', $product_id, $nameEn, $nameFr, $cureTime, $strength, $unit,  $family_name);

        if ($stmt->execute()) {
            $glue_id = $stmt->insert_id;
            return $glue_id;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }



    public function insertToIsolant($product_id, $name, $nameEn, $isolant_strength, $unit, $family_id)
    {

        $family_name = $this->getFamilyName($family_id);


        $sql = "INSERT INTO isolant (product_id, name, namefr, isolant_strength, unit, family) VALUES (?, ?, ?, ?, ? , ?)";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('isssss', $product_id,  $nameEn, $name, $isolant_strength, $unit, $family_name);

        if ($stmt->execute()) {
            $isolant_id = $stmt->insert_id;
            var_dump('isolant_id ---- isolant_id FOUND: ' . $isolant_id);
            return $isolant_id;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function insertToMisc($product_id, $name, $nameEn, $unit, $family_id)
    {

        $family_name = $this->getFamilyName($family_id);


        $sql = "INSERT INTO miscellaneous (product_id, name, namefr, unit, family) VALUES (?, ?, ?, ?, ?)";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('issss', $product_id,  $nameEn, $name, $unit, $family_name);

        if ($stmt->execute()) {
            $misc_id = $stmt->insert_id;
            var_dump('misc_id ---- misct_id FOUND: ' . $misc_id);
            return $misc_id;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function getFamilyName($family_id)
    {
        $sql = "SELECT family_name FROM families WHERE family_id = ?";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('i', $family_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $family_name = $row['family_name'];
                var_dump('getFamilyName ---- FAMILY_NAME FOUND: ' . $family_name);

                return $family_name;
            } else {
                var_dump('No Family Name found');
                return false;
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }

    public function getCategoryName($category_id)
    {

        $category_name = "SELECT category_name FROM categories WHERE category_id = ?";

        $stmt = Database::getConnection()->prepare($category_name);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('i', $category_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];
                var_dump('getCategoryName ---- CATEGORY_Name FOUND: ' . $category_name);

                return lcfirst($category_name);
            } else {
                var_dump('No category found');
                return false;
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function insertToProductTable($category_id, $family_id, $supplier_id, $lowstock, $stock)
    {

        //BYULDING WORKS
        $sql = "INSERT INTO products (category_id, family_id, supplier_id, lowstock, stock) VALUES (?, ?, ?, ?, ?)";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('iiiii', $category_id, $family_id, $supplier_id, $lowstock, $stock);

        if ($stmt->execute()) {
            $product_id = $stmt->insert_id;
            var_dump('product_id ---- product_id FOUND: ' . $product_id);
            return $product_id;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function getSupplerId($supplier)
    {
        if ($supplier != null || $supplier != "") {
            $sql = "SELECT supplier_id FROM suppliers WHERE supplier_name = ?";

            $stmt = Database::getConnection()->prepare($sql);

            if (!$stmt) {
                echo "Error preparing statement: " . Database::getConnection()->error;
                return false;
            }

            $stmt->bind_param('s', $supplier); // 's' specifies the variable type => string

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $supplier_id = $row['supplier_id'];
                    var_dump('supplier_id ---- supplier_id FOUND: ' . $supplier_id);
                    return $supplier_id;
                } else {
                    var_dump('No supplier found');
                    return false;
                }
            } else {
                echo "Error executing statement: " . $stmt->error;
                return false;
            }
        } else {
            var_dump($supplier);
            return false;
        }
    }

    public function getFamilyId($category_id, $family)
    {

        $sql = "SELECT family_id FROM families WHERE category_id = ? && family_name = ?";

        $stmt = Database::getConnection()->prepare($sql);

        var_dump('FAMILY--NAME: ' . $family . 'CATEGIRY--ID: ' . $category_id);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('is', $category_id, $family);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $family_id = $row['family_id'];
                var_dump('family_id ---- FAMILY_ID FOUND: ' . $family_id);
                return $family_id;
                var_dump('No family found');
                return false;
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }

    public function getCategoryId($category)
    {

        $sql_category = "SELECT category_id FROM categories WHERE category_name = ?";

        $stmt = Database::getConnection()->prepare($sql_category);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('s', $category);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];
                var_dump('getCategoryid ---- CATEGORY_ID FOUND: ' . $category_id);
                return $category_id;
                var_dump('No category found');
                return false;
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function processSupplier($supplier)
    {
        if ($supplier === 'addSupplier') {
            // Add new supplier
            $newSupplierName = $_POST['newSupplierName'] ?? null;
            $newSupplierContact = $_POST['newSupplierContact'] ?? null;

            if ($newSupplierName && $newSupplierContact) {
                return $this->insertSupplier($newSupplierName, $newSupplierContact);
            }
        }

        // Existing supplier
        return intval($supplier);
    }

    public function insertSupplier($newSupplierName, $newSupplierContact)
    {

        //Change this
        $sql = "INSERT INTO suppliers (supplier_name, contact_info) VALUES (?,?)";

        $stmt = Database::getConnection()->prepare($sql);

        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        $stmt->bind_param('ss', $newSupplierName, $newSupplierContact);

        if ($stmt->execute()) {
            $supplier_id = $stmt->insert_id;
            var_dump('supplier_id ---- supplier_id FOUND: ' . $supplier_id);
            return $supplier_id;
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }
}
