<?php 
session_start();
$baseurl="/npcrm/";   
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";

$conn = dbconnect();

if (isset($_SESSION['AId'])) {
    setcookie("npcrm", $_COOKIE['Adminnpcrm'], time() + (86400 * 1), "/");
    setcookie("Adminnpcrm", "", time() - 3600, "/");
    header('Location:' . $baseurl . 'dashboard.php');
    unset($_SESSION['AId']);   
    exit();
}
   
?>