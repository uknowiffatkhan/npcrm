<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/leadmodel.php";

$conn = dbconnect();
$uid = $_SESSION["UId"];


if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if ($_POST["mode"] == "checkrno"){
        $value = mysqli_real_escape_string($conn, $_POST["rno"]);
        $lid = isset($_POST["id"]) ? mysqli_real_escape_string($conn, $_POST["id"]) : "";

        if ($_POST["type"] == "insert"){
            $t = checkRegistraionNo($value, $lid);
            echo $t;
        }else{
            $t = checkRegistraionNo($value,$lid);
            echo $t;
        }


           
       
        
        
    }
}


?>