<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
$language=(isset($_GET['language']))? $_GET['language']:"en";
$controller=(isset($_GET['controller']))? $_GET['controller']: "user";
$action = isset($_GET['action']) ? $_GET['action'] : 'login';  // Default is empty
$id = isset($_GET['id']) ? $_GET['id'] : ""; //default is empty

$languageFile = __DIR__ . "/languages/{$language}.php";
if (file_exists($languageFile)) {
    include_once $languageFile; // Use include_once to avoid including multiple times
} else {
    // Fallback to English if the language file does not exist
    include_once __DIR__ . "/languages/en.php";
}
$controllerClassName=ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";


$ct = new $controllerClassName();
$ct ->route();

?>