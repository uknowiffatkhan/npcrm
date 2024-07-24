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
    if ($_POST["mode"] == "changestatus") {
        $id = mysqli_real_escape_string($conn, $_POST["uid"]);
        $sts = mysqli_real_escape_string($conn, $_POST["status"]);


        $rid = changestatus($id,$uid,$sts);

        echo "true";

    }
    if ($_POST["mode"] == "insertuser") {
            $name = mysqli_real_escape_string($conn, $_POST["fullname"]);
            $uname = mysqli_real_escape_string($conn, $_POST["username"]);
            $udname = mysqli_real_escape_string($conn, $_POST["dname"]);
            $code = mysqli_real_escape_string($conn, $_POST["Emp_code"]);

            $umob = mysqli_real_escape_string($conn, $_POST["mobno"]);
            $umail = mysqli_real_escape_string($conn, $_POST["email"]);
            $utype = mysqli_real_escape_string($conn, $_POST["userType"]);
            $urole = mysqli_real_escape_string($conn, $_POST["userRole"]);
            $uteam = mysqli_real_escape_string($conn, $_POST["userTeam"]);

            $uadd = mysqli_real_escape_string($conn, $_POST["add"]);
            $uloc = mysqli_real_escape_string($conn, $_POST["location"]);
            $uadhno = mysqli_real_escape_string($conn, $_POST["adharno"]);
            $upanno = mysqli_real_escape_string($conn, $_POST["panno"]);
            $user_id = insertUser($name,$uname,$udname,$code, $umob, $umail,$utype, $urole,$uadd, $uloc, $uadhno, $upanno,$uid);
            Assignteam($user_id,$uteam,$urole,$uid);
            // Assignteam($uteam,$user_id);
          
            $_SESSION["openuser"] = $user_id;
            echo "insert/" . $user_id;
    
    } else if ($_POST["mode"] == "updateuser") {
            $uname = mysqli_real_escape_string($conn, $_POST["fullname"]);
            if(isset($_POST["mobno"])){
                $umob = mysqli_real_escape_string($conn, $_POST["mobno"]);
            }
            else{
                $umob = "";
            }
          
            if(isset($_POST["email"])){
                $umail = mysqli_real_escape_string($conn, $_POST["email"]);
            }
            else{
                $umail = "";
            }

            $user_id = mysqli_real_escape_string($conn, $_POST["uid"]);
            $name = mysqli_real_escape_string($conn, $_POST["fullname"]);
            $uname = mysqli_real_escape_string($conn, $_POST["username"]);
            $udname = mysqli_real_escape_string($conn, $_POST["dname"]);

            $umob = mysqli_real_escape_string($conn, $_POST["mobno"]);
            $umail = mysqli_real_escape_string($conn, $_POST["email"]);
            $utype = mysqli_real_escape_string($conn, $_POST["userType"]);
            $urole = mysqli_real_escape_string($conn, $_POST["userRole"]);
            $uteam = mysqli_real_escape_string($conn, $_POST["userTeam"]);

            $uadd = mysqli_real_escape_string($conn, $_POST["add"]);
            $uloc = mysqli_real_escape_string($conn, $_POST["location"]);
            $uadhno = mysqli_real_escape_string($conn, $_POST["adharno"]);
            $upanno = mysqli_real_escape_string($conn, $_POST["panno"]);

            
            $oldname = mysqli_real_escape_string($conn, $_POST["oldname"]);
            $olduname = mysqli_real_escape_string($conn, $_POST["oldusername"]);
            $olddname = mysqli_real_escape_string($conn, $_POST["olddname"]);
            $oldmobno = mysqli_real_escape_string($conn, $_POST["oldmobno"]);
            $oldemail = mysqli_real_escape_string($conn, $_POST["oldemail"]);

            $oldutype = mysqli_real_escape_string($conn, $_POST["olduserType"]);
            $oldurole = mysqli_real_escape_string($conn, $_POST["olduserRole"]);
            $olduteam = mysqli_real_escape_string($conn, $_POST["olduserTeam"]);


            $oldladd = mysqli_real_escape_string($conn, $_POST["oldadd"]);
            $oldlloc = mysqli_real_escape_string($conn, $_POST["oldlocation"]);
            $oldadharno = mysqli_real_escape_string($conn, $_POST["oldadharno"]);
            $oldpanno = mysqli_real_escape_string($conn, $_POST["oldpanno"]);

            updatetUser($user_id,$name,$uname,$udname,$umob,$umail,$utype,$urole,$uadd,$uloc,$uadhno,$upanno,$uid);

            if($uteam != $olduteam || $urole != $oldurole ){
                UpdateAssignteam($user_id,$uteam,$urole,$uid);
            }
         
            $logremark = "";


            if($name != $oldname){
                $logremark = $logremark . ", " . "Changed  Name from $oldname => $name of $user_id";
            }
            if($uname != $olduname){
                $logremark = $logremark . ", " . "Changed User Name from $olduname => $uname of $user_id";
            }
            if($udname != $olddname){
                $logremark = $logremark . ", " . "Changed Display Name from $olddname => $udname of $user_id";
            }
            if( $umob != $oldmobno){
                $logremark = $logremark . ", " . "Changed Contact Number from $oldmobno => $umob of $user_id";
            }
            if( $umail != $oldemail){
                $logremark = $logremark . ", " . "Changed Email from $oldemail => $umail of $user_id";
            }
            if($utype != $oldutype){
                $logremark = $logremark . ", " . "Changed Type from $oldutype => $utype of $user_id";
            }
            if($urole != $oldurole){
                $logremark = $logremark . ", " . "Changed Role from $oldurole => $urole of $user_id";
            }
            if($uteam != $olduteam){
                $logremark = $logremark . ", " . "Changed Team from $olduteam => $uteam of $user_id";
            }
            if($uadd != $oldladd){
                $logremark = $logremark . ", " . "Changed Address from $oldladd => $uadd of $user_id";
            }
            if($uloc != $oldlloc){
                $logremark = $logremark . ", " . "Changed Location from $oldlloc => $uloc of $user_id";
            }
            if($uadhno != $oldadharno){
                $logremark = $logremark . ", " . "Changed Aadhaar Number from $oldadharno => $uadhno of $user_id";
            }
            if($upanno != $oldpanno){
                $logremark = $logremark . ", " . "Changed Pan Number from $oldpanno => $upanno of $user_id";
            }

            if($logremark != ""){
                insertActionsLog($uid, trim($logremark, ','), "");
            }
    
    
            $_SESSION["openuser"] = $user_id;
            echo "update/" . $user_id;
           
        }
        
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $url_components = parse_url($_SERVER["REQUEST_URI"]);

    parse_str($url_components['query'], $params);

    // if ($params['mode'] == "checknotifications") {

    //     $res = checkNotifications($uid);

    //     $res = $res->fetch_assoc();
        

    //     echo json_encode($res["notifycount"]);

    // }

}




?>