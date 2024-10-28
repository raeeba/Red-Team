<?php

include_once dirname(__DIR__) . "/mysqldatabase.php";

class Employee
{

    public $employeeNumber;
    public $lastName;
    public $firstName;
    public $extension;
    public $email;
    public $officeCode;
    public $reportsTo;
    public $jobTitle;

    function __construct($id = -1)
    {

        global $conn;

        $this->employeeNumber = $id;

        if ($id < 0) {
            $this->lastName = "";
            $this->firstName = "";
            $this->extension = "";
            $this->email = "";
            $this->officeCode = "";
            $this->reportsTo = "";
            $this->jobTitle = "";

        } else {
            $sql = "SELECT * FROM `employees` WHERE `employeeNumber`=" . $id;

            $result = $conn->query($sql);
            $data = $result->fetch_object();

            $this->employeeNumber = $id;
            $this->lastName = $data->lastName;
            $this->firstName = $data->firstName;
            $this->extension = $data->extension;
            $this->email = $data->email;
            $this->officeCode = $data->officeCode;
            $this->reportsTo = $data->reportsTo;
            $this->jobTitle = $data->jobTitle;

        }

    }

public static function list(){

global $conn;
$list=array();
$sql = "SELECT e1.`employeeNumber`, e1.`lastName`, e1.`firstName`, e1.`extension`, e1.`email`, e1.`officeCode`,e1.`jobTitle`, e2.`jobTitle` as reportsTo FROM `employees` e1 LEFT join employees e2 ON e1.reportsTo=e2.employeeNumber";
$result = $conn->query($sql);


while ($row = $result->fetch_object()) {

    $emp= new Employee();
    $emp->employeeNumber= $row->employeeNumber;
    $emp->lastName=$row->lastName;
    $emp->firstName = $row->firstName;
    $emp->extension = $row->extension;
    $emp->email = $row->email;
    $emp->officeCode = $row->officeCode;
    $emp->reportsTo = $row->reportsTo;
    $emp->jobTitle = $row->jobTitle;
    array_push($list, $emp);
}
return $list;

}
public static function save($data){

    global $conn;
    $sql = "UPDATE `employees` SET `lastName` = '" .
        $data['lastName'] . "', `firstName` = '" .
        $data['firstName'] . "', `extension` = '" .
        $data['extension'] . "', `email` = '" .
        $data['email'] . "', `jobTitle` = '" .
        $data['jobTitle'] . "', `reportsTo`= '" .
        $data['reportsTo']. "'
            WHERE `employees`.`employeeNumber` = " . $data['employeeNumber'] . ";";

    $conn->query($sql);


}
public static function listJobs(){


    global $conn;
    $list=array();
    $sql="SELECT DISTINCT jobTitle FROM `employees`";
    $result = $conn->query($sql);
    
    
    while ($row = $result->fetch_object()) {
        $emp=new Employee();
        $emp->jobTitle = $row->jobTitle;
        array_push($list, $emp);
    }
    return $list;


}
public static function listReports(){


    global $conn;
    $list=array();
    $sql="SELECT  employeeNumber, lastName, firstName FROM `employees`";
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
public static function delete($id)
{

global $conn;
$sql = "DELETE FROM employees WHERE `employees`.`employeeNumber` = " . $id;
$conn->query($sql);


}
function insert($data)
    {

        global $conn;

        //echo "<pre>";
//var_dump($_POST);

        $sql = "INSERT INTO employees (employeeNumber, lastName, firstName, extension, email, officeCode, jobTitle, reportsTo) 
                VALUES (
                    '" . $data['employeeNumber'] . "',
                    '" . $data['lastName'] . "',
                    '" . $data['firstName'] . "',
                    '" . $data['extension'] . "',
                    '" . $data['email'] . "',
                    '" . $data['officeCode'] . "',
                    '" . $data['jobTitle'] . "',
                    '" . $data['reportsTo'] . "'
                )";

        //	echo $sql;

        $conn->query($sql);

    }
}
?>