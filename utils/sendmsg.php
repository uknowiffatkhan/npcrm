<?php


if (!isset($_SESSION)) {
    session_start();
}
include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/callmodel.php";
include_once "../model/usermodel.php";
include_once "../model/leadmodel.php";
include_once "../model/commonmodel.php";
include_once "../utils/helper.php";



function sendSiteVisitMsgtoCust($lid)
{

    $sid = checksalesassign($lid);
    $sid = $sid->fetch_assoc();
    $sid = $sid["Al_CallerId"];

    $to = getClientMobileNo($lid);
    
    $d = "";
    $svdata = getSiteVisitPlanDetail($lid, $sid);
    if ($svdata->num_rows > 0) {
        while($svd = $svdata->fetch_assoc()){
            $d = (strval($svd["Pr_Id"]) != "" ? $svd["Pr_Name"] : "Neral") . "," . date('l d F Y',strtotime($svd["Cl_ActionDate"])) . "," . date('h:i A',strtotime($svd["Cl_ActionDate"])) . " - " . date('h:i A',strtotime('+1 hours',strtotime($svd["Cl_ActionDate"]))) . "," . $svd["U_FullName"] . "," . $svd["U_Mobile"] . "," . $svd["U_FullName"];
        }
    }

    $to = explode('/',$to);
    //sendWhatsapp($to[0],1,$d);
    if(isset($to[1]) && $to[1] != ""){
        //sendWhatsapp($to[1],1,$d);
    }


}

function sendSiteVisitMsgtoAgent($lid)
{

    $sid = checksalesassign($lid);
    $sid = $sid->fetch_assoc();
    $sid = $sid["Al_CallerId"];

    $to = getUserMobileNo($sid);
    $d = "";
    $svdata = getSiteVisitPlanDetail($lid, $sid);
    if ($svdata->num_rows > 0) {
        while($svd = $svdata->fetch_assoc()){
            $d = $svd["U_FullName"] . "," . (strval($svd["Pr_Id"]) != "" ? $svd["Pr_Name"] : "Neral") . "," . date('l d F Y',strtotime($svd["Cl_ActionDate"])) . "," . date('h:i A',strtotime($svd["Cl_ActionDate"])) . " - " . date('h:i A',strtotime('+1 hours',strtotime($svd["Cl_ActionDate"]))) . "," . $svd["Ld_Name"] . "," . $svd["Ld_Mobile"] . ($svd["Ld_AltMobile"] != "" ? " or " . $svd["Ld_AltMobile"] : "");
        }
    }

    //sendWhatsapp($to,2,$d);


}


function sendDisconnectedSMS($lid,$uid){
    $to = getLeadDataById($lid);
    $user = getUserDetails($uid);

    $d = $to["Ld_Name"] . "," . $user["U_Mobile"] . " - " . $user["U_FullName"];

    //sendSms($to["Ld_Mobile"],$d,3);
    //sendWhatsapp($to["Ld_Mobile"],3,$d);
}



?>