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
}
