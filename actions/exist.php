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
    if ($_POST["mode"] == "leadmob"){
        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "update"){
            
            $t = checkMobById($value, $_POST["id"]);
            echo $t;
        }
        else{
            $t = checkMob($value);
            echo $t;
        }
        
    }
    else if($_POST["mode"] == "checkleave"){
        $chkdate = mysqli_real_escape_string($conn, $_POST["value"]);
        echo checkLeaveorweekoff($uid, date('Y-m-d',strtotime($chkdate)));
    }
}


?>