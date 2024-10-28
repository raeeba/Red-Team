<?php

include_once dirname(__DIR__) . "/mysqldatabase.php";

class Orderdetails{

public $orderNumber;
public $productCode;
public $quantityOrdered;
public $priceEach;
public $orderLineNumber;
public $product;



function __construct($id=-1)
{


    global $conn;

    $this->orderNumber = $id;

    if ($id < 0) {
        $this->orderNumber = "";
        $this->productCode = "";
        $this->quantityOrdered = "";
        $this->priceEach = "";
        $this->orderLineNumber = "";
      

    } else {
        $sql = "SELECT * FROM `orderdetails` WHERE `orderNumber`=" . $id;

        $result = $conn->query($sql);
        $data = $result->fetch_object();

        $this->orderNumber = $id;
        $this->productCode = $data->productCode;
        $this->quantityOrdered = $data->quantityOrdered;
        $this->priceEach = $data->priceEach;
        $this->orderLineNumber = $data->orderLineNumber;
       

    }



}


public static function list(){

    global $conn;
    $list=array();
    $sql = "SELECT * FROM `orderdetails`";

    $result = $conn->query($sql);
    
    
    while ($row = $result->fetch_object()) {
    
        $ord= new Order();
        $ord->orderNumber= $row->orderNumber;
        $ord->productCode = $row->productCode;
        $ord->quantityOrdered = $row->quantityOrdered;
        $ord->priceEach = $row->priceEach;
        $ord->orderLineNumber = $row->orderLineNumber;
       
        array_push($list, $ord);
    }
    return $list;
    
    }
} 