<?php 

if (!isset($_SESSION)) {
    session_start();
}

include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/leadmodel.php";
include_once "../model/usermodel.php";


$conn = dbconnect();
$uid = $_SESSION["UId"];


if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if ($_POST["mode"] == "leadmob"){
        $value = mysqli_real_escape_string($conn, $_POST["value"]);
        
        if($_POST["type"] == "insertsourcinglead"){
            
            $t1 = checkMob($value);
            $t2 = checkMobCp($value);
            $t3 = checkMobByUId($value);


            $t = ($t1 == "true") && ($t2 == "true") && ($t3 == "true");
            echo $t ? "true" : "false";

            // $t = checkMobById($value, $_POST["id"]);
            // echo $t;

        }elseif($_POST["type"] == "insertconfirmcp"){

            $t1 = checkMobCp($value);
            $t2 = checkMob($value);
            $t3 = checkMobByUId($value);

            $t = ($t1 == "true") && ($t2 == "true") && ($t3 == "true");
            echo $t ? "true" : "false";

        }elseif($_POST["type"] == "updateconfirmcp"){
            
            $t = checkMobByIdCp($value, $_POST["id"]);
            echo $t;

        }else{
            $t = checkMob($value);
            echo $t;
        }
        
    }else if ($_POST["mode"] == "leademail"){

        $value = mysqli_real_escape_string($conn, $_POST["value"]);

        if($_POST["type"] == "updatesourcinglead"){

            $t = checkEmailByIdCp($value, $_POST["id"]);

            echo $t;

        }elseif($_POST["type"] == "insertconfirmcp"){

            $t1 = checkEmailCp($value);
            $t2 = checkEmail($value);
            $t3 = checkEmailByUId($value);

            $t = ($t1 == "true") && ($t2 == "true") && ($t3 == "true");
            echo $t ? "true" : "false";

            // $t = (checkEmailCp($value, $_POST["id"]))||(checkEmail($value))||(checkEmailByUId($value));

            // echo($t == 0 ? "true" : "false");


        }elseif($_POST["type"] == "updateconfirmcp"){

            $t = checkEmailByIdCp($value, $_POST["id"]);
            echo $t;

        }else{
            $t = checkEmail($value);
            echo $t;
        }


    }else if($_POST["mode"] == "checkleave"){
        $chkdate = mysqli_real_escape_string($conn, $_POST["value"]);
        echo checkLeaveorweekoff($uid, date('Y-m-d',strtotime($chkdate)));
    }
}


?>