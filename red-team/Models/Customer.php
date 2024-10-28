<?php
include_once dirname(__DIR__) . "/mysqldatabase.php";
include_once "Models/Employee.php";

class Customer
{
    

public $customerNumber;
public $customerName;
public $contactLastName;
public $contactFirstName;
public $phone;
public $addressLine1;
public $addressLine2;
public $city;
public $state;
public $postalCode;
public $country;
public $salesRepEmployeeNumber;
public $creditLimit;




function __construct($id=-1){


    global $conn;

    $this->customerNumber = $id;

    if ($id < 0) {
        $this->customerName = "";
        $this->contactLastName = "";
        $this->contactFirstName = "";
        $this->city = "";
        $this->phone = "";
        $this->addressLine1 = "";
        $this->addressLine2 = "";
        $this->state = "";
        $this->postalCode = "";
        $this->country = "";
        $this->salesRepEmployeeNumber = "";
        $this->creditLimit = "";



}else{
    $sql= "SELECT * FROM `customers` WHERE `customerNumber`=" . $id;
    
    $result = $conn->query($sql);
    $data = $result->fetch_object();
    $this->customerNumber = $id;
    $this->customerName = $data->customerName;
    $this->contactLastName = $data->contactLastName;
    $this->contactFirstName = $data->contactFirstName;
    $this->city = $data->city;
    $this->phone = $data->phone;
    $this->addressLine1 = $data->addressLine1;
    $this->addressLine2 = $data->addressLine2;
    $this->state = $data->state;
    $this->postalCode = $data->postalCode;
    $this->country = $data->country;
    $this->salesRepEmployeeNumber = $data->salesRepEmployeeNumber;
    $this->creditLimit = $data->creditLimit;

}

}

public static function list()
{
    global $conn;
    $list = array();

    $sql = "SELECT * FROM `customers`";
    $result = $conn->query($sql);

    while ($row = $result->fetch_object()) {
        $off = new Customer();
        $off->customerNumber = $row->customerNumber;
        $off->customerName = $row->customerName;
        $off->contactLastName = $row->contactLastName;
        $off->contactFirstName = $row->contactFirstName;
        $off->city = $row->city;
        $off->phone = $row->phone;
        $off->addressLine1 = $row->addressLine1;
        $off->addressLine2 = $row->addressLine2;
        $off->state = $row->state;
        $off->postalCode = $row->postalCode;
        $off->country = $row->country;
        $off->salesRepEmployeeNumber = $row->salesRepEmployeeNumber;
        $off->creditLimit = $row->creditLimit;
    
        array_push($list, $off);
    }
    return $list;

}



public static function updateSave($data)
{

    global $conn;
    $sql = "UPDATE `customers` SET `customerName` = '" .
        $data['customerName'] . "', `contactLastName` = '" .
        $data['contactLastName'] . "', `contactFirstName` = '" .
        $data['contactFirstName'] . "', `phone` = '" .
        $data['phone'] . "', `addressLine1` = '" .
        $data['addressLine1'] . "', `addressLine2`= '" .
        $data['addressLine2'] . "', `city`= '" .
        $data['city'] . "', `state`='" .
        $data['state'] . "', `country`='" . 
        $data['country'] . "', `postalCode`='" . 
        $data['postalCode'] . "', `creditLimit`='" . 
        $data['creditLimit'] . "'
        
            WHERE `customers`.`customerNumber` = " . $data['customerNumber'] . ";";

    $conn->query($sql);

}

public static function delete($data)
    {
        global $conn;
        $sql = "DELETE FROM offices WHERE `offices`.`officeCode` = " . $this->officeCode;

        $conn->query($sql);

    }

    public static function getEmployee(){
        
    global $conn;
    $list=array();
    $sql="SELECT  employeeNumber, lastName, firstName FROM `employees` WHERE jobTitle like 'Sales Rep'";
    $result = $conn->query($sql);
    
    
    while ($row = $result->fetch_object()) {
        $emp=new Employee();
        $emp->employeeNumber = $row->employeeNumber;
        $emp->lastName = $row->lastName;
        $emp->firstName = $row->firstName;
        array_push($list, $emp);
    }
    return $list;
    }

    function insert($data)
    {

        global $conn;

        //echo "<pre>";
//var_dump($_POST);

$sql = "INSERT INTO customers (customerNumber, contactLastName, contactFirstName, customerName,
city, phone, addressLine1, addressLine2, state, country, postalCode, creditLimit, salesRepEmployeeNumber) 
       VALUES (
           '" . $data['customerNumber'] . "',
           '" . $data['contactLastName'] . "',
           '" . $data['contactFirstName'] . "',
           '" . $data['customerName'] . "',
           '" . $data['city'] . "',
           '" . $data['phone'] . "',
           '" . $data['addressLine1'] . "',
           '" . $data['addressLine2'] . "',
           '" . $data['state'] . "',
           '" . $data['country'] . "',
           '" . $data['postalCode'] . "',
           '" . $data['creditLimit'] . "',
           '" . $data['salesRepEmployeeNumber'] . "'
       )";

        //	echo $sql;

        $conn->query($sql);

    }









}