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
            // Delete from products table -- cascades appropeiately
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




    ///////////////////////// UPDATE STOCK ////////////////////////
    public function updateStock($updatedStockData)
    {
        foreach ($updatedStockData as $productId => $newStock) {
            $sql = "UPDATE `products` SET `stock` = ? WHERE `product_id` = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                error_log("Failed to prepare UPDATE statement: " . $this->conn->error);
                return false;
            }

            $stmt->bind_param("ii", $newStock, $productId);
            if (!$stmt->execute()) {
                error_log("Failed to execute UPDATE for product_id $productId: " . $stmt->error);
                return false;
            }

            error_log("Stock updated successfully for product_id $productId (new stock: $newStock)");
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
        try {
            // Single SQL statement for both updates
            $sql = "
                UPDATE `products` p
                LEFT JOIN `building` b ON p.product_id = b.product_id AND p.category_id = 1
                LEFT JOIN `glue` g ON p.product_id = g.product_id AND p.category_id = 2
                LEFT JOIN `isolant` i ON p.product_id = i.product_id AND p.category_id = 3
                LEFT JOIN `miscellaneous` m ON p.product_id = m.product_id AND p.category_id = 4
                SET 
                    p.lowstock = COALESCE(?, p.lowstock), 
                    p.stock = COALESCE(?, p.stock),
                    b.namefr = COALESCE(?, b.namefr),
                    b.name = COALESCE(?, b.name),
                    g.namefr = COALESCE(?, g.namefr),
                    g.name = COALESCE(?, g.name),
                    i.namefr = COALESCE(?, i.namefr),
                    i.name = COALESCE(?, i.name),
                    m.namefr = COALESCE(?, m.namefr),
                    m.name = COALESCE(?, m.name)
                WHERE p.product_id = ?
            ";

            // Prepare the statement
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare combined update statement: " . $this->conn->error);
            }

            // Bind parameters
            $stmt->bind_param(
                "iissssssssi",
                $lowstock,
                $stock,
                $namefr,
                $nameen,
                $namefr,
                $nameen,
                $namefr,
                $nameen,
                $namefr,
                $nameen,
                $id
            );

            // Execute the statement
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute combined update statement: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
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

    ////////////////////////////////////     INSERT     /////////////////////
    public function insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category_id, $suppliers, $additionalData)
    {
        try {
            // Start transaction
            $this->beginTransaction();

            // Extract additional data
            $family_id = $additionalData['family'] ?? null;
            $cureTime = $additionalData['cureTime'] ?? null;
            $strength = $additionalData['strength'] ?? null;
            $isolant_strength = $additionalData['isolantStrength'] ?? null;

            // Insert product into products
            $stmt = $this->conn->prepare("INSERT INTO products (category_id, family_id, lowstock, stock) VALUES (?, ?, ?, ?)");
            $stmt->execute([$category_id, $family_id, $low_stock_alert, $stock]);
            $product_id = $this->conn->insert_id; // last id inserted


            foreach ($suppliers as $supplier) {
                $supplier_id = null;

                // Add new supplier if "addSupplier" is selected
                if ($supplier === 'addSupplier') {
                    $newSupplierName = $_POST['newSupplierName'] ?? null;
                    $newSupplierContact = $_POST['newSupplierContact'] ?? null;

                    if ($newSupplierName && $newSupplierContact) {
                        $stmt = $this->conn->prepare("INSERT INTO suppliers (supplier_name, contact_info) VALUES (?, ?)");
                        $stmt->execute([$newSupplierName, $newSupplierContact]);
                        $supplier_id = $this->conn->insert_id; // Get the new supplier ID
                    } else {
                        throw new Exception("Missing details: Failed to insert supplier: $newSupplierName.");
                    }
                } else {
                    $supplier_id = intval($supplier); // Use existing supplier ID/s
                }

                // Link product to supplier in product_supplier table
                $stmt = $this->conn->prepare("INSERT INTO product_supplier (product_id, supplier_id) VALUES (?, ?)");
                $stmt->execute([$product_id, $supplier_id]);
            }

            //get Family name
            $family_name = $this->getFamilyName($family_id);
            if (!$family_name) {
                throw new Exception("Invalid family ID: $family_id");
            }

            //Insert product to respective category
            switch ($category_id) {
                case 1:
                    // Insert into building
                    $stmt = $this->conn->prepare(
                        "INSERT INTO building (product_id, name, namefr, family, unit) VALUES (?, ?, ?, ?, ?)"
                    );
                    $stmt->execute([$product_id,  $nameEn, $name, $family_name, $unit]);
                    break;

                case 2:
                    // Insert into glue
                    $stmt = $this->conn->prepare(
                        "INSERT INTO glue (product_id, name, namefr, cure_time, strength, unit, family) VALUES (?, ?, ?, ?, ?, ?, ?)"
                    );
                    $stmt->execute([$product_id, $nameEn, $name, $cureTime, $strength, $unit,  $family_name]);
                    break;

                case 3:
                    // Insert into isolant
                    $stmt = $this->conn->prepare(
                        "INSERT INTO isolant (product_id, name, namefr, isolant_strength, unit, family) VALUES (?, ?, ?, ?, ? , ?)"
                    );
                    $stmt->execute([$product_id, $nameEn, $name, $isolant_strength, $unit, $family_name]);
                    break;

                case 4:
                    // Insert into misc
                    $stmt = $this->conn->prepare(
                        "INSERT INTO miscellaneous (product_id, name, namefr, unit, family) VALUES (?, ?, ?, ?, ?)"
                    );
                    $stmt->execute([$product_id,  $nameEn, $name, $unit, $family_name]);
                    break;

                default:
                    throw new Exception("Invalid category ID: $category_id");
            }

            // Commit transaction
            $this->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on failure
            $this->rollBack();
            throw new Exception(message: "Transaction failed: " . $e->getMessage());
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


    ////////////////////// Calculator  
    public function listInventoryForCalculator(){
          // Changed this to View - for query optimization
          $sql = "SELECT * FROM product_list_view WHERE `category_name` IN ('Building', 'Isolant')";


          $stmt = $this->conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->get_result();
  
          $list = [];
          while ($row = $result->fetch_assoc()) {
              $list[] = $row;
          }
  
          return !empty($list) ? $list : null;


}

}