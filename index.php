<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
$controller=(isset($_GET['controller']))? $_GET['controller']: "home";
$action = isset($_GET['action']) ? $_GET['action'] : '';  // Default is empty
$id = isset($_GET['id']) ? $_GET['id'] : "";


$controllerClassName=ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";


$ct = new $controllerClassName();
$ct ->route();

?>