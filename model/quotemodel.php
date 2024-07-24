<?php 

if (!isset($_SESSION)) {
    session_start();
}


$baseurl = $_SESSION["baseurl"];

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/auth.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";

function getNewQCode()
{
    $conn = dbconnect();
    $sql = "SELECT Qt_Code FROM `tbl_quotation`
    WHERE `Qt_Status` = 'Active' AND `Qt_Del` = 0 
    ORDER BY Qt_Id DESC LIMIT 1";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
        $code = str_replace("Q", "", $result["Qt_Code"]);
    } else {
        $code = 0;
    }

    $code = sprintf('%04d', (int)$code + 1);

    return "Q" . $code;
}

function insertQuote($code, $date, $pid, $leadid, $name, $mobile, $estbook, $uid)
{

    $conn = dbconnect();


    $sql = "INSERT INTO `tbl_quotation`(`Qt_Code`, `Qt_Date`, `Qt_PId`, `Qt_LdId`, `Qt_Name`, `Qt_Mobile`, `Qt_Uid`, `Qt_BookEstDate`, `Qt_CreatedId`, `Qt_Status`, `Qt_Del`) VALUES 
            ('$code','$date',$pid,$leadid,'$name','$mobile',$uid, '$estbook',$uid,'Active',0)";

    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Inserted", "");
    return $conn->insert_id;

}


function updateQuote($qid, $date, $pid, $leadid, $name, $mobile, $estbook, $uid){
    $conn = dbconnect();


    $sql = "UPDATE `tbl_quotation` SET `Qt_Date`='$date',`Qt_PId`=$pid,`Qt_LdId`=$leadid,`Qt_Name`='$name',`Qt_Mobile`='$mobile',
            `Qt_Uid`=$uid,`Qt_BookEstDate`='$estbook' WHERE `Qt_Id`=$qid";

    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Updated", "");
    return $qid;
}



function delQuotDetail($Pid, $Qid, $uid){
    $conn = dbconnect();
    $sql = "DELETE FROM `tbl_quotprodetails` WHERE `Qpd_PId` = $Pid AND `Qpd_QId` = $Qid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Details Deleted", "");
    return true;
}


function insertQuoteDetail($Pid, $Qid, $config, $phase, $wing, $floor, $roomno, $saleable, $carpet, $agreeval, $devvalue, $govtvalue, $club, $parking, $society, $registration, 
                            $stamp, $legal, $total, $uid)
{

    $conn = dbconnect();


    $sql = "INSERT INTO `tbl_quotprodetails`(`Qpd_PId`, `Qpd_QId`, `Qpd_Config`, `Qpd_Phase`, `Qpd_Wing`, `Qpd_Floor`, `Qpd_Roomno`, `Qpd_Saleable`, `Qpd_Carpet`, `Qpd_Agreevalue`, 
            `Qpd_Development`, `Qpd_GovtTax`,`Qpd_ClubMembersip`, `Qpd_ParkingCharge`, `Qpd_SocietyOtherCharge`, `Qpd_Registration`, `Qpd_Stampduty`, `Qpd_LegalCharge`,
             `Qpd_Totalvalue`, `Qpd_CreatedId`, `Qpd_ModifiedId`, `Qpd_Status`, `Qpd_Del`) VALUES 
            ($Pid,$Qid,'$config', '$phase', '$wing','$floor','$roomno','$saleable','$carpet','$agreeval','$devvalue','$govtvalue','$club','$parking','$society','$registration',
            '$stamp','$legal','$total',$uid,$uid,'Active',0)";

    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Details Inserted", "");
    return $conn->insert_id;

}

function updateQuoteDetail($Pid, $Qid, $config, $phase, $wing, $floor, $roomno, $saleable, $carpet, $agreeval, $devvalue, $govtvalue, $club, $parking, $society, $registration, 
                            $stamp, $legal, $total, $uid){
    $conn = dbconnect();


    $sql = "UPDATE `tbl_quotprodetails` SET `Qpd_Config`='$config',`Qpd_Phase`='$phase',`Qpd_Wing`='$wing',`Qpd_Floor`='$floor',`Qpd_Roomno`='$roomno',
            `Qpd_Saleable`='$saleable',`Qpd_Carpet`='$carpet',`Qpd_Agreevalue`='$agreeval',`Qpd_Development`='$devvalue',`Qpd_GovtTax`='$govtvalue',
            `Qpd_ClubMembersip`='$club',`Qpd_ParkingCharge`='$parking',`Qpd_SocietyOtherCharge`='$society',`Qpd_Registration`='$registration',`Qpd_Stampduty`='$stamp',
            `Qpd_LegalCharge`='$legal', `Qpd_Totalvalue`='$total', `Qpd_ModifiedDate`='".date('Y-m-d H:i:s')."',`Qpd_ModifiedId`=$uid WHERE `Qpd_PId`=$Pid AND `Qpd_QId`=$Qid";

    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Details Inserted", "");
    return $Qid;
}


function delQuotPlans($QPdId, $Qid, $leadid, $uid){
    $conn = dbconnect();
    $sql = "DELETE FROM `tbl_quotpayplans` WHERE `Ppp_QpdId` = $QPdId AND `Ppp_QId` = $Qid AND `Ppp_LdId` = $leadid AND `Ppp_Uid` = $uid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Details Deleted", "");
    return true;
}


function insertQuotePayPLan($QPdId, $Qid, $leadid, $part, $type, $dur, $amount, $totalamount, $uid)
{

    $conn = dbconnect();

    if($dur == ""){
        $sql = "INSERT INTO `tbl_quotpayplans`(`Ppp_QpdId`, `Ppp_QId`, `Ppp_LdId`, `Ppp_Uid`, `Ppp_Particular`, `Ppp_Type`, `Ppp_Duration`, `Ppp_Amount`, `Ppp_TotalAmount`,
        `Ppp_CreatedId`, `Ppp_ModifiedId`, `Ppp_Status`, `Ppp_Del`) VALUES 
        ($QPdId,$Qid,$leadid,$uid,'$part','$type',NULL,'$amount','$totalamount',$uid,$uid,'Active',0)";
    }
    else{
        $sql = "INSERT INTO `tbl_quotpayplans`(`Ppp_QpdId`, `Ppp_QId`, `Ppp_LdId`, `Ppp_Uid`, `Ppp_Particular`, `Ppp_Type`, `Ppp_Duration`, `Ppp_Amount`, `Ppp_TotalAmount`,
        `Ppp_CreatedId`, `Ppp_ModifiedId`, `Ppp_Status`, `Ppp_Del`) VALUES 
        ($QPdId,$Qid,$leadid,$uid,'$part','$type',$dur,'$amount','$totalamount',$uid,$uid,'Active',0)";
    }
    
    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Plan Inserted", "");
    return $conn->insert_id;

}


function getQuotesListByLid($lid, $uid){
    $conn = dbconnect();
    $sql = "SELECT q.*, qd.*, p.*, u.U_DisplayName FROM tbl_quotation q
    INNER JOIN tbl_quotprodetails qd ON qd.Qpd_QId = q.Qt_Id
    INNER JOIN tbl_projects p ON p.Pr_Id = q.Qt_PId
    INNER JOIN tbl_users u ON u.U_Id = q.Qt_Uid
    WHERE q.Qt_LdId = $lid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Fetched for Lead ". $lid, "");
    return $result;
}

function getQuoteById($qid, $uid){
    $conn = dbconnect();
    $sql = "SELECT Qt_Name as 'Ld_Name', Qt_Mobile as 'Ld_Mobile', q.*, qd.*, p.*, u.U_FullName, u.U_Mobile FROM tbl_quotation q
    INNER JOIN tbl_quotprodetails qd ON qd.Qpd_QId = q.Qt_Id
    INNER JOIN tbl_projects p ON p.Pr_Id = q.Qt_PId
    INNER JOIN tbl_users u ON u.U_Id = q.Qt_Uid
    WHERE q.Qt_Id = $qid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Fetched", "");
    return $result;
}


function getQuotePlansById($qid, $uid){
    $conn = dbconnect();
    $sql = "SELECT * FROM tbl_quotation q
    INNER JOIN tbl_quotpayplans qp ON qp.Ppp_QId = q.Qt_Id
    WHERE q.Qt_Id = $qid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Quotation Plan Fetched", "");
    return $result;
}

function getQuoteCountsByLid($lid){
    $conn = dbconnect();
    $sql = "SELECT COUNT(q.Qt_Id) as 'quotecount' FROM tbl_quotation q
    WHERE q.Qt_LdId = $lid";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result["quotecount"];
}

?>