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

// echo $uid;

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if ($_POST["mode"] == "leadmob"){
        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "updatecplead"){
            
            $t = checkMobByIdCp($value, $_POST["id"]);
            echo $t;
        }
        else{
            $t = checkMobCp($value);
            echo $t;
        }
        
    }else if ($_POST["mode"] == "leademail"){

        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "updatecplead"){
            
            $t = checkEmailByIdCp($value, $_POST["id"]);
            echo $t;
        }
        else{
            $t = checkEmailCp($value);
            echo $t;
        }


    }
    else if($_POST["mode"] == "checkleave"){
        $chkdate = mysqli_real_escape_string($conn, $_POST["value"]);
        echo checkLeaveorweekoff($uid, date('Y-m-d',strtotime($chkdate)));
    }
}


?>