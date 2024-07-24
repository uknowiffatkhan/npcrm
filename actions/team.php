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


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST["mode"] == "insertteam" || $_POST["mode"] == "updateteam") {

        $lastTmCode = getLastTmCode($conn);
        $lastTmNumber = $lastTmCode ? intval($lastTmCode) : 1011;
        $newTmCode = $lastTmNumber + 1;

        // echo $newTmCode;

        
        $name = mysqli_real_escape_string($conn, $_POST["tname"]);
            $team_parent_id = mysqli_real_escape_string($conn, ($_POST["teamParent"] ? $_POST["teamParent"] : 'NULL' ));
            $t_id = CreateTeam($uid,$name,$newTmCode,$team_parent_id);
    
            echo "Team/" . $t_id;
    }
  
}  
    
?>