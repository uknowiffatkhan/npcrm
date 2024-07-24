<?php 

$baseurl="/npcrm/";   
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
$log = decrypt($_COOKIE["npcrm"]);
setcookie("npcrm","",time()-3600, "/");
$log = json_decode($log, false);

$conn = dbconnect();
$sql = "UPDATE `tbl_users` SET `U_Online`=0 WHERE `U_Id`= ". $log->uid;
$result = $conn->query($sql);
header('Location: ./login.php ');

?>