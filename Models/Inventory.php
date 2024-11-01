<?php

require_once __DIR__ . '/../Models/Model.php';


class Inventory extends Model {

    public $productName;

    public $stock;

    public $lowStock;

    public $unitOfMeasurement;

    public $supplier;

    public $family;

}


?>