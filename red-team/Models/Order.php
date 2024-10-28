<?php

include_once dirname(__DIR__) . "/mysqldatabase.php";
include_once "Models/OrderDetails.php";
include_once "Models/Product.php";


class Order{

public $orderNumber;
public $orderDate;
public $requiredDate;
public $shippedDate;
public $status;
public $comments;
public $customerNumber;
public $product;


function __construct($id=-1)
{


    global $conn;

    $this->orderNumber = $id;

    if ($id < 0) {
        $this->orderNumber = "";
        $this->orderDate = "";
        $this->requiredDate = "";
        $this->shippedDate = "";
        $this->status = "";
        $this->comments = "";
        $this->customerNumber = "";

    } else {
        $sql = "SELECT * FROM `orders` WHERE `orderNumber`=" . $id;

        $result = $conn->query($sql);
        $data = $result->fetch_object();

        $this->orderNumber = $id;
        $this->orderDate = $data->orderDate;
        $this->requiredDate = $data->requiredDate;
        $this->shippedDate = $data->shippedDate;
        $this->status = $data->status;
        $this->comments = $data->comments;
        $this->customerNumber = $data->customerNumber;

    }



}


public static function list(){

    global $conn;
    $list=array();
    $sql = "SELECT * FROM `orders`";

    $result = $conn->query($sql);
    
    
    while ($row = $result->fetch_object()) {
    
        $ord= new Order();
        $ord->orderNumber= $row->orderNumber;
        $ord->orderDate = $row->orderDate;
        $ord->requiredDate = $row->requiredDate;
        $ord->shippedDate = $row->shippedDate;
        $ord->status = $row->status;
        $ord->comments = $row->comments;
        $ord->customerNumber = $row->customerNumber;

        array_push($list, $ord);
    }
    return $list;
    
    }
    function delete($data)
    {
        global $conn;
        $sql = "DELETE FROM orders WHERE `orders`.`orderNumber` = " . $this->orderNumber;
        $sql2 = "DELETE FROM orderdetails WHERE `orderdetails`.`orderNumber` = " . $this->orderNumber;

        $conn->query($sql);
        $conn->query($sql2);


    }
    public static function getDetails($id){
        global $conn;
    $list = array();

    $sql = "SELECT od.productCode, od.quantityOrdered, od.priceEach, p.productName 
            FROM orderdetails od
            JOIN products p ON od.productCode = p.productCode
            WHERE od.orderNumber = " . $id;

    $result = $conn->query($sql);

    while ($row = $result->fetch_object()) {
        $ord = new Orderdetails();
        $ord->quantityOrdered = $row->quantityOrdered;
        $ord->priceEach = $row->priceEach;

        $product = new Product();
        $product->productCode = $row->productCode;
        $product->productName = $row->productName;

        $ord->product = $product;

        array_push($list, $ord);
    }
    return $list;
    }

    public static function updateSave($data){
        global $conn;
        $sql = "UPDATE `orders` SET `orderDate` = '" .
            $data['orderDate'] . "', `requiredDate` = '" .
            $data['requiredDate'] . "', `shippedDate` = '" .
            $data['shippedDate'] . "', `status` = '" .
            $data['status'] . "', `comments` = '" .
            $data['comments'] . "'
        		WHERE `orders`.`orderNumber` = " . $data['orderNumber'] . ";";

        $conn->query($sql);
    }


}






?>