<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/usermodel.php";

$conn = dbconnect();
$uid = $_SESSION["UId"];

// echo $uid;

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if ($_POST["mode"] == "usermob"){
        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "updateuser"){
            
            $t = checkMobByUId($value, $_POST["id"]);
            echo $t;
        }
        else{
            $t = checkMobByUId($value);
            echo $t;
        }
        
    }else if ($_POST["mode"] == "useremail"){

        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "updateuser"){
            
            $t = checkEmailByUId($value, $_POST["id"]);
            echo $t;
        }
        else{
            $t = checkEmailByUId($value);
            echo $t;
        }


    }else if($_POST["mode"] == "username"){
        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "updateuser"){
            
            $t = checkUserNameByUId($value, $_POST["id"]);
            echo $t;
        }
        else{
            $t = checkUserNameByUId($value);
            echo $t;
        }
    }
}


?>