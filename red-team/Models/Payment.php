<?php
include_once dirname(__DIR__) . "/mysqldatabase.php";

class Payment{

public $customerNumber;
public $checkNumber;
public $paymentDate;
public $amount;


function __construct($id=""){

global $conn;
$this -> checkNumber= $id;


if($id ==""){

$this->checkNumber=$id;
$this->customerNumber="";
$this->paymentDate="";
$this->amount="";

}else{

    $sql = "SELECT * FROM `payments` WHERE `checkNumber` = '". $id . "'";
            $result = $conn->query($sql);
                $data = $result->fetch_object();

                $this->checkNumber=$data->checkNumber;
                $this->customerNumber=$data->customerNumber;
                $this->paymentDate=$data->paymentDate;
                $this->amount=$data->amount;

}
}
public static function list(){

    global $conn;
    $list = array();

    $sql = "SELECT * FROM `payments`";
    $result=$conn->query($sql);

    while($row = $result->fetch_object()){

        $pay = new Payment();
        $pay-> checkNumber= $row->checkNumber;
        $pay-> customerNumber= $row->customerNumber;
        $pay-> paymentDate= $row->paymentDate;
        $pay-> amount= $row->amount;
       
        array_push($list, $pay);



    }

    return $list;


}

public static function save($data){

    global $conn;
    $sql = "UPDATE `payments` SET `customerNumber` = '" .
        $data['customerNumber'] . "', `checkNumber` = '" .
        $data['checkNumber'] . "', `paymentDate` = '" .
        $data['paymentDate'] . "', `amount` = '" .
        $data['amount'] . "'
            WHERE `payments`.`checkNumber` = '" . $data['checkNumber'] . "';";

    $conn->query($sql);


} 
public static function delete($id)
{

global $conn;
$sql = "DELETE FROM payments WHERE `payments`.`checkNumber` =  '". $id . "'";
$conn->query($sql);


}


}



















?>