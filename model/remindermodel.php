<?php

if (!isset($_SESSION)) {
    session_start();
}


$baseurl = $_SESSION["baseurl"];

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/auth.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";


function insertReminder($lid, $calid, $date, $remark, $uid)
{

    $conn = dbconnect();

    if ($calid == NULL) {
        $sql = "INSERT INTO `tbl_reminder`(`Rm_LeadId`, `Rm_Uid`, `Rm_DateTime`, `Rm_Remark`, `Rm_Read`, `Rm_Status`, `Rm_Del`) VALUES 
        ($lid,$uid,'$date','$remark',0,'Active',0)";
    } else {
        $sql = "INSERT INTO `tbl_reminder`(`Rm_LeadId`, `Rm_CallId`, `Rm_Uid`, `Rm_DateTime`, `Rm_Remark`, `Rm_Read`, `Rm_Status`, `Rm_Del`) VALUES 
        ($lid,$calid,$uid,'$date','$remark',0,'Active',0)";
    }


    $result = $conn->query($sql);
    insertActionsLog($uid, "Reminder Inserted", "");
    // echo $sql;
    return $conn->insert_id;

}


function markReminderRead($lid, $uid)
{

    $conn = dbconnect();

    $sql = "UPDATE `tbl_reminder` SET `Rm_Read`= 1 WHERE `Rm_Id`=$lid";


    $result = $conn->query($sql);
    insertActionsLog($uid, "Reminder Marked Read", "");
    return true;

}


function getReminderbydate($uid,$date){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_reminder` WHERE Rm_Uid = $uid AND Rm_Del = 0 AND Rm_DateTime BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
    // echo $sql;

    $result = $conn->query($sql);
    return $result;
}


function checkNotifications($uid)
{
    $conn = dbconnect();

    $sql = "SELECT COUNT(Rm_Id) as 'notifycount' FROM `tbl_reminder` rm
    INNER JOIN tbl_assignlead la ON la.Al_LeadId = rm.Rm_LeadId
            WHERE la.Al_CallerId = $uid AND rm.Rm_Read = 0 AND rm.Rm_Uid = $uid  AND la.Al_Del = 0 AND `Rm_DateTime` BETWEEN '".date("Y-m-d")."' AND '".date("Y-m-d",strtotime(date("Y-m-d"). ' + 1 days'))."'";
    $result = $conn->query($sql);
    // echo $sql;
    return $result;

}


function checkLiveReminders($uid)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_reminder` rm 
            INNER JOIN tbl_assignlead la ON la.Al_LeadId = rm.Rm_LeadId 
            INNER JOIN tbl_Lead ld ON ld.Ld_Id = rm.Rm_LeadId
            WHERE la.Al_CallerId = $uid AND rm.Rm_Read = 0 AND la.Al_Del = 0 AND `Rm_DateTime` between (now() - interval 1 minute) and now()";
    
    $result = $conn->query($sql);
    
    return $result;

}


function getNotifications($uid, $dt = "")
{
    $conn = dbconnect();

    if($dt == ""){
        $dt = "`Rm_DateTime` < '".date("Y-m-d",strtotime(date("Y-m-d"). ' + 1 days'))."' AND rm.Rm_Read = 0";
    }
    else{
        $dt = "`Rm_DateTime` like '$dt%'";
    }

    $sql = "SELECT * FROM `tbl_reminder` rm
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = rm.Rm_LeadId
    INNER JOIN tbl_lead ld ON ld.Ld_Id = rm.Rm_LeadId
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
            WHERE al.Al_CallerId = $uid AND rm.Rm_Uid = $uid AND al.Al_Del = 0 AND $dt
            order by Rm_DateTime desc";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Reminder Fetched", "");
    // echo $sql;
    return $result;

}


?>