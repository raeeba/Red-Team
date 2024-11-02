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

    public function getCategories()
    {
        $sql = "SELECT category_name FROM categories";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row['category_name'];
        }

        // Return the list of categories or null if none found
        return !empty($categories) ? $categories : null;
    }

    public function getFamily()
    {
        $sql = "SELECT family_name FROM families";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $family = [];
        while ($row = $result->fetch_assoc()) {
            $family[] = $row['family_name'];
        }

        // Return the list of categories or null if none found
        return !empty($family) ? $family : null;
    }

    public function getSuppliers()
    {
        $sql = "SELECT supplier_name FROM suppliers";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row['supplier_name'];
        }

        // Return the list of categories or null if none found
        return !empty($suppliers) ? $suppliers : null;
    }

    public function insertProduct($name, $nameEn, $low_stock_alert, $stock, $unit, $category, $supplier, $additionalData)
    {

        $family = isset($additionalData['family']) ? $additionalData['family'] : null;
        $glueType = isset($additionalData['glueType']) ? $additionalData['glueType'] : null;
        $cureTime = isset($additionalData['cureTime']) ? $additionalData['cureTime'] : null;
        $strength = isset($additionalData['strength']) ? $additionalData['strength'] : null;


        // 1 - GET CATEGORy ID
        if ($this->getCategoryId($category) != null) {
            $category_id = $this->getCategoryId($category);
            var_dump('insertProduct() --- true');


            // 2 - Find Family Id based on category Id
            if ($this->getFamilyId($category_id, $family) != null) {

                $family_id = $this->getFamilyId($category_id, $family);

                var_dump('insertProduct(), getFamilyId --- true' . $family);

                // 3 - get supplier id
                if ($supplier == "" or $supplier == null) {
                    $supplier_id = null;
                }
                // if ($this->getSupplerId($supplier) != null) {
                //     $this->getSupplerId($supplier);
                //     var_dump(value: 'getsypplierid()--- true');
                // } else {

                // }

                //4 INSERT PRODUCT
                if ($this->insertToProductTable($category_id, $family_id, $supplier_id, $low_stock_alert, $stock,) != false) {

                    var_dump('INSERTED');

                    // 5 - Insert to Addiotional Table
                    //table 
                    // if($category_id == 1){

                    // }

                }



                return true;
            }

            //
        }
    }

    public function insertToBuilding($product_id, $name, $nameEn, $family_id, $unit)
    {
        // Insert to Building Table
        $sql = "INSERT INTO building (product_id, name, namefr, family, unit) VALUES (?, ?, ?, ?, ?)";

        $stmt = Database::getConnection()->prepare($sql);

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        //get the familyid
        $sql_ = "SELECT family_name FROM families WHERE family_id = ?";

        // Bind the parameters
  //      $stmt->bind_param('iiiii', $product_id, $name, $nameEn, $family, $unit);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the last inserted product_id
            $product_id = $stmt->insert_id; // Use insert_id to get the last inserted ID
            var_dump('product_id ---- product_id FOUND: ' . $product_id);
            return $product_id; // Return the product_id
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }



    public function insertToGlue() {}

    public function insertToIsolant() {}

    public function getCategoryName($category_id)
    {
        //return the category_id
        // Insert to Categories Table
        $sql_category = "SELECT category_name FROM categories WHERE category_id = ?";

        $stmt = Database::getConnection()->prepare($sql_category);

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        // Bind the parameter
        $stmt->bind_param('i', $category_id); // 's' specifies the variable type => string

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch the category_id
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];
                var_dump('getCategoryName ---- CATEGORY_Name FOUND: ' . $category_name);

                return lcfirst($category_name); // Return the category_name with the first letter in lowercase
                // Return the category_id
            } else {
                var_dump('No category found');
                return false; // No matching category
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }
    public function getCategoryName($category_id)
    {
        //return the category_id
        // Insert to Categories Table
        $sql_category = "SELECT category_name FROM categories WHERE category_id = ?";

        $stmt = Database::getConnection()->prepare($sql_category);

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        // Bind the parameter
        $stmt->bind_param('i', $category_id); // 's' specifies the variable type => string

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch the category_id
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];
                var_dump('getCategoryName ---- CATEGORY_Name FOUND: ' . $category_name);

                return lcfirst($category_name); // Return the category_name with the first letter in lowercase
                // Return the category_id
            } else {
                var_dump('No category found');
                return false; // No matching category
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function insertToProductTable($category_id, $family_id, $supplier_id, $lowstock, $stock)
    {
        // Insert to Products Table
        $sql = "INSERT INTO products (category_id, family_id, supplier_id, lowstock, stock) VALUES (?, ?, ?, ?, ?)";

        $stmt = Database::getConnection()->prepare($sql);

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        // Bind the parameters
        $stmt->bind_param('iiiii', $category_id, $family_id, $supplier_id, $lowstock, $stock);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the last inserted product_id
            $product_id = $stmt->insert_id; // Use insert_id to get the last inserted ID
            var_dump('product_id ---- product_id FOUND: ' . $product_id);
            return $product_id; // Return the product_id
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }


    public function getSupplerId($supplier)
    {
        if ($supplier != null || $supplier != "") {
            //return the category_id
            $sql = "SELECT supplier_id FROM suppliers WHERE supplier_name = ?";

            $stmt = Database::getConnection()->prepare($sql);

            // Check if the statement was prepared correctly
            if (!$stmt) {
                echo "Error preparing statement: " . Database::getConnection()->error;
                return false;
            }

            // Bind the parameter
            $stmt->bind_param('s', $supplier); // 's' specifies the variable type => string

            // Execute the statement
            if ($stmt->execute()) {
                // Get the result
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Fetch the category_id
                    $row = $result->fetch_assoc();
                    $supplier_id = $row['supplier_id'];
                    var_dump('supplier_id ---- supplier_id FOUND: ' . $supplier_id);
                    return $supplier_id; // Return the category_id
                } else {
                    var_dump('No supplier found');
                    return false; // No matching category
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
        //return the category_id
        // Insert to Categories Table
        $sql = "SELECT family_id FROM families WHERE category_id = ? && family_name = ?";

        $stmt = Database::getConnection()->prepare($sql);

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        // Bind the parameter
        $stmt->bind_param('is', $category_id, $family); // 's' specifies the variable type => string

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch the category_id
                $row = $result->fetch_assoc();
                $family_id = $row['family_id'];
                var_dump('family_id ---- FAMILY_ID FOUND: ' . $family_id);
                return $family_id; // Return the category_id
            } else {
                var_dump('No family found');
                return false; // No matching category
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }

    public function getCategoryId($category)
    {
        //return the category_id
        // Insert to Categories Table
        $sql_category = "SELECT category_id FROM categories WHERE category_name = ?";

        $stmt = Database::getConnection()->prepare($sql_category);

        // Check if the statement was prepared correctly
        if (!$stmt) {
            echo "Error preparing statement: " . Database::getConnection()->error;
            return false;
        }

        // Bind the parameter
        $stmt->bind_param('s', $category); // 's' specifies the variable type => string

        // Execute the statement
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch the category_id
                $row = $result->fetch_assoc();
                $category_id = $row['category_id'];
                var_dump('getCategoryid ---- CATEGORY_ID FOUND: ' . $category_id);
                return $category_id; // Return the category_id
            } else {
                var_dump('No category found');
                return false; // No matching category
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
            return false;
        }
    }



    //     // Prepare your SQL statement
    //     $sql = "INSERT INTO products (name, low_stock_alert, stock, unit, category";



    //     // Append additional fields to the SQL statement
    //     foreach ($additionalData as $key => $value) {
    //         $sql .= ", $key"; // Adding fields for additional data
    //     }

    //     $sql .= ") VALUES (:name, :low_stock_alert, :stock, :unit, :category";

    //     // Add placeholders for additional data values
    //     foreach ($additionalData as $key => $value) {
    //         $sql .= ", :$key"; // Adding placeholders for additional data
    //     }

    //     $sql .= ")";

    //     // Prepare the statement
    //     $stmt = $this->conn->prepare($sql);

    //     // Bind parameters
    //     $stmt->bindParam(':name', $name);
    //     $stmt->bindParam(':low_stock_alert', $low_stock_alert);
    //     $stmt->bindParam(':stock', $stock);
    //     $stmt->bindParam(':unit', $unit);
    //     $stmt->bindParam(':category', $category);

    //     // Bind additional data parameters
    //     foreach ($additionalData as $key => $value) {
    //         $stmt->bindParam(":$key", $additionalData[$key]);
    //     }

    //     // Execute the statement and return the result
    //     return $stmt->execute();
    // }
}
