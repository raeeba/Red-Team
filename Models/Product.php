<?php

include_once dirname(__DIR__) . "/mysqldatabase.php";

class Product {
    public $productCode;
    public $productName;
    public $productLine;
    public $productScale;
    public $productVendor;
    public $productDescription;
    public $quantityInStock;
    public $buyPrice;
    public $MSRP;

    // Constructor
    function __construct($id = "") {
        global $conn;
        $this->productCode = $id;

        if ($id=="") {
            $this->productCode = $id;
            $this->productName = "";
            $this->productLine = "";
            $this->productScale = "";
            $this->productVendor = "";
            $this->productDescription = "";
            $this->quantityInStock = "";
            $this->buyPrice = "";
            $this->MSRP = "";
        } else {
            $sql = "SELECT * FROM `products` WHERE `productCode` = '". $id . "'";
            $result = $conn->query($sql);

           
                $data = $result->fetch_object();
                
                $this->productCode = $data->productCode;
                $this->productName = $data->productName;
                $this->productLine = $data->productLine;
                $this->productScale = $data->productScale;
                $this->productVendor = $data->productVendor;
                $this->productDescription = $data->productDescription;
                $this->quantityInStock = $data->quantityInStock;
                $this->buyPrice = $data->buyPrice;
                $this->MSRP = $data->MSRP;
           
        }
    }

    public static function list(){

        global $conn;
        $list = array();

        $sql = "SELECT * FROM `products`";
        $result=$conn->query($sql);

        while($row = $result->fetch_object()){

            $pro = new Product();
            $pro-> productCode= $row->productCode;
            $pro-> productName= $row->productName;
            $pro-> productLine= $row->productLine;
            $pro-> productScale= $row->productScale;
            $pro-> productVendor= $row->productVendor;
            $pro-> productDescription= $row->productDescription;
            $pro-> quantityInStock= $row->quantityInStock;
            $pro-> buyPrice= $row->buyPrice;
            $pro-> MSRP= $row->MSRP;

            array_push($list, $pro);



        }

        return $list;


    }

    public static function updateSave($data){
        global $conn;
        $sql = "UPDATE `products` SET `productName` = '" .
            $data['productName'] . "', `productLine` = '" .
            $data['productLine'] . "', `productDescription` = '" .
            $data['productDescription'] . "', `quantityInStock` = '" .
            $data['quantityInStock'] . "', `buyPrice` = '" .
            $data['buyPrice'] . "'
        		WHERE `products`.`productCode` = '" . $data['productCode'] . "';";

        $conn->query($sql);
    }

    public static function listProductLine(){


        global $conn;
        $list=array();
        $sql="SELECT DISTINCT productLine FROM `products`";
        $result = $conn->query($sql);
        
        
        while ($row = $result->fetch_object()) {
            $pro=new Product();
            $pro->productLine = $row->productLine;
            array_push($list, $pro);
        }
        return $list;
    
    
    }

    function insert($data)
    {

        global $conn;

        //echo "<pre>";
//var_dump($_POST);

        $sql = "INSERT INTO products (productCode, productLine, productDescription , quantityInStock, buyPrice) 
                VALUES (
                    '" . $data['productCode'] . "',
                    '" . $data['productLine'] . "',
                    '" . $data['productDescription'] . "',
                    '" . $data['quantityInStock'] . "',
                    '" . $data['buyPrice'] . "'
                   
                )";

        //	echo $sql;

        $conn->query($sql);

    }
    public static function delete($id)
{

global $conn;
$sql = "DELETE FROM products WHERE `products`.`productCode` =  '". $id . "'";
$conn->query($sql);


}


}
