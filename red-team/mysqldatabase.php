<?php
$servername="localhost";
$username="root";
$password="";
$database="classicmodels";

$conn = new mysqli($servername,$username,$password,$database);

if($conn->connect_error){
    die("Connection error, Good luck, babe");
}


?>