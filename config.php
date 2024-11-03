<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', '1');

$language = isset($_GET['language']) ? $_GET['language'] : (isset($_SESSION['language']) ? $_SESSION['language'] : 'en');
$_SESSION['language'] = $language;

$languageFile = __DIR__ . "/languages/{$language}.php";
if (file_exists($languageFile)) {
    include_once $languageFile;
} else {
    include_once __DIR__ . "/languages/en.php";
}

$basePath = dirname($_SERVER['PHP_SELF']);
?>
