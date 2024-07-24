<?php

if (!isset($_SESSION)) {
    session_start();
}


$baseurl=$_SESSION["baseurl"];   

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";


function changestatus($id,$uid,$status)
{

    $conn = dbconnect();

    $sql = "UPDATE `tbl_users` SET `U_Status`= '$status' WHERE `U_Id`=$id";

    $result = $conn->query($sql);
    insertActionsLog($uid, "User ".$status." ".$id, "");
    return true;

}

function getUserDetails($id){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_users u 
            LEFT JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
            LEFT JOIN tbl_team tm ON tm.Tm_Id = m.team_id
           -- LEFT JOIN tbl_team tm ON FIND_IN_SET(u.U_Id, tm.Tm_MemId) > 0
            WHERE u.U_Id =$id";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result;
}
function checkMobByUId($mob, $id="")
{
    $conn = dbconnect();
    $w="";

    if(strlen($mob) > 10){
        $mob = substr($mob, -10);
    }

    if($id !=''){
        $w= " AND `U_Id` <> $id";
    }
    
    $sql = "SELECT * FROM `tbl_users` WHERE (`U_Mobile` LIKE '%$mob%') $w";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}

function checkEmailByUId($email, $id="")
{
    $conn = dbconnect();
    $w="";

    if($id !=''){
        $w= " AND `U_Id` <> $id";
    }

    $sql = "SELECT * FROM `tbl_users` WHERE (`U_Email` LIKE '%$email%' ) $w";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}
function checkUserNameByUId($username, $id="")
{
    $conn = dbconnect();
    $w="";

    if($id !=''){
        $w= " AND `U_Id` <> $id";
    }

    $sql = "SELECT * FROM `tbl_users` WHERE (`U_Username` LIKE '%$username%' ) $w";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}
function getUserMobileNo($id){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_users u WHERE u.U_Id =$id";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result["U_Mobile"];
}


function getClientMobileNo($id){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_lead ld WHERE ld.ld_Id =$id";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result["Ld_Mobile"]."/".$result["Ld_AltMobile"];
}

function getEmpCode(){

    $conn = dbconnect();

    $sql  = "SELECT U_EmpCode FROM tbl_users ORDER BY U_EmpCode  DESC LIMIT 1";
    
    $result = $conn->query($sql);

    return $result;
}
function insertUser($name,$uname,$dname,$code, $mob, $email,$type,$role, $add, $loc,$adno,$panno,$uid)
{

    $conn = dbconnect();

    // $intin = ($intin == "" ? 'NULL' : $intin);


        $sql = "INSERT INTO `tbl_users`(`U_RoleId`, `U_TypeId`, `U_Username`,`U_Password`, `U_FullName`, `U_DisplayName`, `U_EmpCode`, `U_Mobile`, `U_Email`, `U_Address`, `U_Location`, 
            `U_AdhaarNo`, `U_PanNo`,`U_CreatedId`, `U_ModifiedId`, `U_Status`, `U_Del`) VALUES 
            ('$role','$type','$uname','1234','$name','$dname','$code','$mob','$email','$add','$loc','$adno','$panno',$uid,$uid,'Active',0)";
    
    $result = $conn->query($sql);
    insertActionsLog($uid, "User Created", "");
    return $conn->insert_id;

}
function updatetUser($user_id,$name,$uname,$dname,$mob,$email,$type,$role,$add,$loc,$adno,$panno,$uid)
{

    $conn = dbconnect();
        $sql="UPDATE `tbl_users` SET `U_FullName`='$name',`U_Username`='$uname',`U_DisplayName`='$dname',`U_Mobile`='$mob', `U_Email`='$email',`U_TypeId`='$type',`U_RoleId`='$role',`U_Address`='$add',`U_Location`='$loc',`U_AdhaarNo`='$adno',
        `U_PanNo`='$panno',`U_ModifiedDate`='" . date("Y-m-d") . "',
        `U_ModifiedId`=$uid WHERE `U_Id`= $user_id";

    $result = $conn->query($sql);
    insertActionsLog($uid, "User Details Updated Of ".$user_id, "");
    return $conn->insert_id;

}
function Assignteam($id,$tmid,$role,$uid) {
    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_teammap` (`tm_m_role`,`tm_m_uid`,`team_id`,`tm_m_CreatedDate`,`tm_m_CreatedId`,`tm_m_Status`,`tm_m_Del`) VALUES ($role,$id,$tmid,NOW(),$uid,'Active',0)";

    $result = $conn->query($sql);
    insertActionsLog($uid, "User Inserted In Team-".$tmid, "");
}
function UpdateAssignteam($id,$tmid,$role,$uid) {
    $conn = dbconnect();

    $sql = "UPDATE `tbl_teammap` SET `tm_m_role` = '$role', `tm_m_uid` = '$id', `team_id` = '$tmid'
            WHERE `tm_m_uid` = '$id'";

    $result = $conn->query($sql);
    insertActionsLog($uid, "User Updated In Team-".$tmid, "");
}
function CreateTeam($uid,$name,$code,$pid='') {
    $conn = dbconnect();
    $tm_parent_id = ($pid == "" ? NULL : $pid);
    $sql ="INSERT INTO `tbl_team` (`Tm_Name`,`Tm_Code`,`Tm_parent_team_id`,`Tm_CreatedDate`,`Tm_CreatedId`,`Tm_Status`,`Tm_Del`) VALUES ('$name','$code',$tm_parent_id,NOW(),$uid,'Active',0)";
    $result = $conn->query($sql);
    //echo $sql;
    return $result;
}
function getLastTmCode($conn)
{
    $query = "SELECT Tm_Code FROM tbl_team ORDER BY Tm_Id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['Tm_Code'];
    }
    return '';
}
?>

