<?php
include_once dirname(__DIR__) . "/mysqldatabase.php";

class Office
{

    public $officeCode;
    public $city;
    public $phone;
    public $addressLine1;
    public $addressLine2;
    public $state;
    public $country;
    public $postalCode;
    public $territory;


    function __construct($id = -1)
    {

        global $conn;

        $this->officeCode = $id;

        if ($id < 0) {
            $this->city = "";
            $this->phone = "";
            $this->addressLine1 = "";
            $this->addressLine2 = "";
            $this->state = "";
            $this->country = "";
            $this->postalCode = "";
            $this->territory = "";

        } else {
            $sql = "SELECT * FROM `offices` WHERE `officeCode`=" . $id;

            $result = $conn->query($sql);
            $data = $result->fetch_object();

            $this->officeCode = $id;
            $this->city = $data->city;
            $this->phone = $data->phone;
            $this->addressLine1 = $data->addressLine1;
            $this->addressLine2 = $data->addressLine2;
            $this->state = $data->state;
            $this->country = $data->country;
            $this->postalCode = $data->postalCode;
            $this->territory = $data->territory;


        }


    }
    public static function list()
    {
        global $conn;
        $list = array();

        $sql = "SELECT * FROM `offices`";
        $result = $conn->query($sql);

        while ($row = $result->fetch_object()) {
            $off = new Office();
            $off->officeCode = $row->officeCode;
            $off->city = $row->city;
            $off->phone = $row->phone;
            $off->addressLine1 = $row->addressLine1;
            $off->addressLine2 = $row->addressLine2;
            $off->state = $row->state;
            $off->country = $row->country;
            $off->postalCode = $row->postalCode;
            $off->territory = $row->territory;

            array_push($list, $off);
        }
        return $list;
    }


    function updateSave($data)
    {

        global $conn;

    $stmt= $conn-> prepare("UPDATE offices SET
        `city`=?,
        `phone`=?,
        `addressLine1`=?,
        `addressLine2`=?,
        `state`=?,
        `country`=?,
        `postalCode`=?,
        `territory`=?
        WHERE `offices`.`officeCode`= ? ");

$stmt-> bind_param("ssssssssi",$data['city'], $data['phone'],$data['addressLine1'], $data['addressLine2'],
$data['state'],$data['country'], $data['postalCode'],$data['territory'],$data['officeCode'] );

$stmt->execute();


        // $sql = "UPDATE `offices` SET `city` = '" .
        //     $data['city'] . "', `phone` = '" .
        //     $data['phone'] . "', `addressLine1` = '" .
        //     $data['addressLine1'] . "', `addressLine2` = '" .
        //     $data['addressLine2'] . "', `state` = '" .
        //     $data['state'] . "', `country`= '" .
        //     $data['country'] . "', `postalCode`= '" .
        //     $data['postalCode'] . "', `territory`='" .
        //     $data['territory'] . "'
        // 		WHERE `offices`.`officeCode` = " . $data['officeCode'] . ";";

        // $conn->query($sql);

    }
    function delete($data)
    {
        global $conn;
        $sql = "DELETE FROM offices WHERE `offices`.`officeCode` = " . $this->officeCode;

        $conn->query($sql);

    }
    function insert($data)
    {

        global $conn;


        $stmt= $conn-> prepare("INSERT INTO offices(officeCode, city, phone, addressLine1, addressLine2, state, country, postalCode, territory)
        VALUES (?,?,?,?,?,?,?,?,?)");
        
        $stmt-> bind_param("sssssssss",$data['officeCode'], $data['city'], $data['phone'],$data['addressLine1'], $data['addressLine2'],
        $data['state'],$data['country'], $data['postalCode'],$data['territory']);
        //echo "<pre>";
//var_dump($_POST);

$stmt->execute();

$stmt->close();

        // $sql = "INSERT INTO offices (city, phone, addressLine1, addressLine2, state, country, postalCode, territory) 
        //         VALUES (
        //             '" . $data['city'] . "',
        //             '" . $data['phone'] . "',
        //             '" . $data['addressLine1'] . "',
        //             '" . $data['addressLine2'] . "',
        //             '" . $data['state'] . "',
        //             '" . $data['country'] . "',
        //             '" . $data['postalCode'] . "',
        //             '" . $data['territory'] . "'
        //         )";

        // //	echo $sql;

        // $conn->query($sql);

    }


}


?>