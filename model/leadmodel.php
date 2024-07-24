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
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/usermodel.php";



require $_SERVER['DOCUMENT_ROOT'] . $baseurl . "mailer/PHPMailer.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl . "mailer/SMTP.php";
require $_SERVER['DOCUMENT_ROOT'] . $baseurl . "mailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function insertLead($name,$rno, $mob, $altmob, $email, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus, $ldate, $assigned, $budget, $remark,$leadtype, $uid)
{

    $conn = dbconnect();
    $rno = ($rno == "" ? NULL : $rno);
    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "INSERT INTO `tbl_lead`(`Ld_Name`,`Ld_RNo`, `Ld_Mobile`, `Ld_AltMobile`, `Ld_Email`, `Ld_Location`, `Ld_Address`, `Ld_City`, `Ld_Pincode`, `Ld_ProjectId`, `Ld_InterestedIn`, `Ld_Source`, 
            `Ld_LeadStatus`, `Ld_Reference`, `Ld_LeadDate`, `Ld_Assigned`, `Ld_Budget`, `Ld_Remark`,`Ld_LeadType`, `Ld_CreatedId`, `Ld_ModifiedId`, `Ld_Status`, `Ld_Del`) VALUES 
            ('$name','$rno','$mob','$altmob','$email','$loc','$add','$city','$pin', '$project',$intin,$source,$lstatus,'$ref','$ldate',$assigned,$budget,'$remark','$leadtype',$uid,$uid,'Active',0)";
    } else {
        $sql = "INSERT INTO `tbl_lead`(`Ld_Name`,`Ld_RNo`, `Ld_Mobile`, `Ld_AltMobile`,`Ld_Email`, `Ld_Location`, `Ld_Address`, `Ld_City`, `Ld_Pincode`, `Ld_InterestedIn`, `Ld_Source`, 
            `Ld_LeadStatus`, `Ld_Reference`, `Ld_LeadDate`, `Ld_Assigned`, `Ld_Budget`, `Ld_Remark`,`Ld_LeadType`, `Ld_CreatedId`, `Ld_ModifiedId`, `Ld_Status`, `Ld_Del`) VALUES 
            ('$name','$rno','$mob','$altmob','$email','$loc','$add','$city','$pin', $intin,$source,$lstatus,'$ref','$ldate',$assigned,$budget,'$remark','$leadtype',$uid,$uid,'Active',0)";
    }
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Inserted", "");
    return $conn->insert_id;

}

function insertSouringcLead($name, $mob,$altmob,$email, $ref, $add,$lpadd, $city, $pin, $loc,$project,$source,$lstatus,$lrno, $lgst,$ldate,$rmk,$leadtype,$assigned,$uid)
{

    $conn = dbconnect();
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $lrno = ($lstatus == "" ? 'NULL' : $lrno);

   
    if ($project != "") {
        $sql = "INSERT INTO `tbl_lead`(`Ld_Name`, `Ld_Mobile`, `Ld_AltMobile`, `Ld_Email`, `Ld_Location`,`Ld_Source`, `Ld_LeadStatus`,`Ld_Address`,`Ld_Permanent_add`, `Ld_City`, `Ld_Pincode`, `Ld_ProjectId`, 
                `Ld_Reference`, `Ld_Rera_Number`, `Ld_Gst_No`,`Ld_LeadDate`,`Ld_Remark`,`Ld_LeadType`,`Ld_Assigned`,`Ld_CreatedId`, `Ld_ModifiedId`, `Ld_Status`, `Ld_Del`) VALUES 
            ('$name','$mob','$altmob','$email','$loc',$source,$lstatus,'$add','$lpadd','$city','$pin', '$project','$ref','$lrno','$lgst','$ldate','$rmk','$leadtype','$assigned',$uid,$uid,'Active',0)";
    } else{
        $sql = "INSERT INTO `tbl_lead`(`Ld_Name`, `Ld_Mobile`, `Ld_AltMobile`, `Ld_Email`, `Ld_Location`,`Ld_Source`, `Ld_LeadStatus`,`Ld_Address`,`Ld_Permanent_add`, `Ld_City`, `Ld_Pincode`,`Ld_Reference`, `Ld_Rera_Number`, `Ld_Gst_No`,`Ld_LeadDate`,`Ld_Remark`,`Ld_LeadType`,`Ld_Assigned`,`Ld_CreatedId`, `Ld_ModifiedId`, `Ld_Status`, `Ld_Del`) VALUES 
    ('$name','$mob','$altmob','$email','$loc',$source,$lstatus,'$add','$lpadd','$city','$pin','$ref','$lrno','$lgst','$ldate','$rmk','$leadtype','$assigned',$uid,$uid,'Active',0)";
    }

    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Inserted", "");
    return $conn->insert_id;

}

function insertCpLead($name, $mob, $altmob, $email, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus, $ldate, $assigned, $budget, $remark,$leadtype, $uid)
{

    $conn = dbconnect();

    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "INSERT INTO `tbl_lead`(`Ld_Name`, `Ld_Mobile`, `Ld_AltMobile`, `Ld_Email`, `Ld_Location`, `Ld_Address`, `Ld_City`, `Ld_Pincode`, `Ld_ProjectId`, `Ld_InterestedIn`, `Ld_Source`, 
            `Ld_LeadStatus`, `Ld_Reference`, `Ld_LeadDate`, `Ld_Assigned`, `Ld_Budget`, `Ld_Remark`,`Ld_LeadType`, `Ld_CreatedId`, `Ld_ModifiedId`, `Ld_Status`, `Ld_Del`) VALUES 
            ('$name','$mob','$altmob','$email','$loc','$add','$city','$pin', '$project',$intin,$source,$lstatus,'$ref','$ldate',$assigned,$budget,'$remark','$leadtype',$uid,$uid,'Active',0)";
    } else {
        $sql = "INSERT INTO `tbl_lead`(`Ld_Name`, `Ld_Mobile`, `Ld_AltMobile`,`Ld_Email`, `Ld_Location`, `Ld_Address`, `Ld_City`, `Ld_Pincode`, `Ld_InterestedIn`, `Ld_Source`, 
            `Ld_LeadStatus`, `Ld_Reference`, `Ld_LeadDate`, `Ld_Assigned`, `Ld_Budget`, `Ld_Remark`,`Ld_LeadType`, `Ld_CreatedId`, `Ld_ModifiedId`, `Ld_Status`, `Ld_Del`) VALUES 
            ('$name','$mob','$altmob','$email','$loc','$add','$city','$pin', $intin,$source,$lstatus,'$ref','$ldate',$assigned,$budget,'$remark','$leadtype',$uid,$uid,'Active',0)";
    }

    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Inserted", "");
    return $conn->insert_id;

}

function insertConfirmCpLead($name,$mob,$altmob,$mail,$add,$pin,$loc,$rerano,$gst,$accno,$panno,$ifsc,$bankno,$branch,$code,$date,$uid)
{

    $conn = dbconnect();
    $lastCpCode = getLastCpCode($conn);
    $lastCpNumber = $lastCpCode ? intval(substr($lastCpCode, 3)) : 2024000;
    $code = 'GC-' . str_pad($lastCpNumber + 1, 8, '0', STR_PAD_LEFT);


     $sql = "INSERT INTO `tbl_channelpartner`(`Cp_Code`,`Cp_Name`, `Cp_Mobile`, `Cp_AltMobile`,`Cp_Email`,`Cp_Address`, `Cp_ReraNo`,`Cp_gst`, `Cp_Pin`, `Cp_Location`, `Cp_JoiningDate`, `Cp_AccNo`, `Cp_PanNo`, `Cp_IFSC`, 
            `Cp_BankNo`, `Cp_Branch`, `Cp_CreatedId`, `Cp_ModifiedId`, `Cp_Status`, `Cp_Del`) VALUES 
            ('$code','$name','$mob','$altmob','$mail','$add','$rerano','$gst','$pin','$loc','$date','$accno','$panno','$ifsc','$bankno','$branch',$uid,$uid,'Active',0)";
    
    // echo $sql;
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Inserted", "");
    return $conn->insert_id;

}

function AssignLead($lid, $uid, $teamid, $new)
{
    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_assignlead`(`Al_CallerId`, `Al_TeamId`, `Al_LeadId`, `Al_New`, `Al_CreatedId`, `Al_ModifiedId`, `Al_Del`) VALUES 
                        ($uid,$teamid,$lid,$new,$uid,$uid,0)";

    $sql = $conn->query($sql);

    return $conn->insert_id;
}

function AssignSourceLead($cpid, $uid, $teamid)
{
    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_assigncpsource`(`AC_CpId`,`AC_UId`,`AC_TeamId`, `AC_CreatedId`,`AC_ModifiedId`, `AC_Del`) VALUES 
                        ($cpid,$uid,$teamid,$uid,$uid,0)";
    $sql = $conn->query($sql);
    return $conn->insert_id;
}


function AssignLeadFromAdmin($lid, $uid, $teamid)
{
    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_assignlead`(`Al_CallerId`, `Al_TeamId`, `Al_LeadId`, `Al_New`, `Al_CreatedId`, `Al_ModifiedId`, `Al_Del`) VALUES 
                        ($uid,$teamid,$lid,1,1,1,0)";
    $sql = $conn->query($sql);
    return $conn->insert_id;
}

function AssignToSales($lid, $uid, $project, $assdate)
{
    $conn = dbconnect();

    $ret = "";



    
    $sql = "";
    if ($project != "") {
        $sql = "SELECT u.U_Id, 
        COUNT(al.Al_Id) as 'cnt',t.Tm_Id
        FROM tbl_users u
        INNER JOIN tbl_assignprojmem ap ON u.U_Id = ap.Apm_AssignTo AND ap.Apm_ProjectId = $project AND ap.Apm_AssignType = 'user'
        LEFT JOIN tbl_team t ON FIND_IN_SET(u.U_Id, t.Tm_MemId) > 0
        LEFT JOIN tbl_assignlead al ON al.Al_CallerId = u.U_Id
        INNER JOIN (select MAX(cl.Cl_Id), cl.Cl_LeadId FROM tbl_calllog cl WHERE cl.Cl_ActionDate BETWEEN '" . date('Y-m-d', strtotime($assdate)) . " 00:00:00' AND '" . date('Y-m-d', strtotime($assdate)) . " 23:59:59' 
        AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17) GROUP BY cl.Cl_LeadId) as c ON c.Cl_LeadId = al.Al_LeadId
        WHERE t.Tm_Id IS NOT NULL AND u.U_TypeId = 2
        GROUP BY u.U_Id 
        ORDER BY cnt ASC 
        LIMIT 1";

        $res = $conn->query($sql);
        // echo $sql."<br/>";

        if ($res->num_rows > 0) {
            $ut = $res->fetch_assoc();

            $tm = getUserTeam($ut["U_Id"]);

            $sql = "INSERT INTO `tbl_assignlead`(`Al_CallerId`, `Al_TeamId`, `Al_LeadId`, `Al_New`, `Al_CreatedId`, `Al_ModifiedId`, `Al_Del`) VALUES 
            (" . $ut["U_Id"] . "," . $tm["Tm_Id"] . ",$lid,1," . $ut["U_Id"] . "," . $ut["U_Id"] . ",0)";
            // echo $sql."<br/>";
            $res = $conn->query($sql);
            $ret = $conn->insert_id;
        } else {
            ///get user assign to project by team
            $sql = "SELECT u.U_Id, 
                COUNT(al.Al_Id) as 'cnt',t.Tm_Id
                FROM tbl_users u
                LEFT JOIN tbl_assignprojmem ap ON u.U_Id = ap.Apm_AssignTo AND ap.Apm_ProjectId = $project AND ap.Apm_AssignType = 'team'
                LEFT JOIN tbl_team t ON FIND_IN_SET(u.U_Id, t.Tm_MemId) > 0
                LEFT JOIN tbl_assignlead al ON al.Al_CallerId = u.U_Id
                INNER JOIN (select MAX(cl.Cl_Id), cl.Cl_LeadId FROM tbl_calllog cl WHERE cl.Cl_ActionDate BETWEEN '" . date('Y-m-d', strtotime($assdate)) . " 00:00:00' AND '" . date('Y-m-d', strtotime($assdate)) . " 23:59:59' 
                AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17 ) GROUP BY cl.Cl_LeadId) as c ON c.Cl_LeadId = al.Al_LeadId
                WHERE t.Tm_Id IS NOT NULL AND u.U_TypeId = 2
                GROUP BY u.U_Id 
                ORDER BY cnt ASC 
                LIMIT 1";
            //echo $sql . "<br/>";
            $res = $conn->query($sql);

            if ($res->num_rows > 0) {
                $ut = $res->fetch_assoc();
    
                $tm = getUserTeam($ut["U_Id"]);
    
                $sql = "INSERT INTO `tbl_assignlead`(`Al_CallerId`, `Al_TeamId`, `Al_LeadId`, `Al_New`, `Al_CreatedId`, `Al_ModifiedId`, `Al_Del`) VALUES 
                (" . $ut["U_Id"] . "," . $tm["Tm_Id"] . ",$lid,1," . $ut["U_Id"] . "," . $ut["U_Id"] . ",0)";
                // echo $sql."<br/>";
                $res = $conn->query($sql);
                $ret = $conn->insert_id;
            }

        } 
    




    } else {
        ///get any user with min assigned lead
        $sql = "SELECT u.U_Id ,COUNT(al.Al_Id) as 'cnt',t.Tm_Id
            FROM tbl_users u
            LEFT JOIN tbl_assignprojmem ap ON u.U_Id = ap.Apm_AssignTo
            LEFT JOIN tbl_team t ON FIND_IN_SET(u.U_Id, t.Tm_MemId) > 0
            LEFT JOIN tbl_assignlead al ON al.Al_CallerId = u.U_Id
            LEFT JOIN (SELECT max(c.Cl_Id) as 'cid', c.Cl_LeadId, c.Cl_ActionDate as 'date' FROM tbl_calllog c 
            WHERE c.Cl_ActionDate BETWEEN '" . date('Y-m-d', strtotime($assdate)) . " 00:00:00' AND '" . date('Y-m-d', strtotime($assdate)) . " 23:59:59' AND (c.Cl_LeadStatus = 4 OR c.Cl_LeadStatus = 17) GROUP BY c.Cl_LeadId) cl ON al.Al_LeadId = cl.Cl_LeadId
            WHERE u.U_TypeId = 2
            GROUP BY u.U_Id 
            ORDER BY cnt ASC 
            LIMIT 1";
        //echo $sql . "<br/>";
        $res = $conn->query($sql);

        if ($res->num_rows > 0) {
            $ut = $res->fetch_assoc();

            $tm = getUserTeam($ut["U_Id"]);

            $sql = "INSERT INTO `tbl_assignlead`(`Al_CallerId`, `Al_TeamId`, `Al_LeadId`, `Al_New`, `Al_CreatedId`, `Al_ModifiedId`, `Al_Del`) VALUES 
            (" . $ut["U_Id"] . "," . $tm["Tm_Id"] . ",$lid,1," . $ut["U_Id"] . "," . $ut["U_Id"] . ",0)";
            // echo $sql."<br/>";
            $res = $conn->query($sql);
            $ret = $conn->insert_id;
        }
    }


    return $ret;
}



function DelAssignedCP($lid,$cpid,$uid){
    $conn = dbconnect();

    $sql = "UPDATE `tbl_assignleadcp` SET `Alcp_Del`= 1 WHERE `Alcp_LdId`=$lid AND `Alcp_CreatedId` = $uid";
    //echo $sql;
    $sql = $conn->query($sql);
    return $conn->insert_id;
}


function AssignCP($lid,$cpid,$uid){
    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_assignleadcp`(`Alcp_LdId`, `Alcp_CpId`, `Alcp_CreatedId`, `Alcp_Del`) VALUES 
            ($lid,$cpid,$uid,0)";
    $sql = $conn->query($sql);
    return $conn->insert_id;
}

function updateLead($lid, $name, $mob, $altmob, $email, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus,$budget, $remark, $uid)
{

    $conn = dbconnect();
    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',`Ld_Mobile`='$mob', `Ld_AltMobile`='$altmob', `Ld_ProjectId`='$project',`Ld_Email`='$email',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref', `Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    } else {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',`Ld_Mobile`='$mob', `Ld_AltMobile`='$altmob', `Ld_Email`='$email',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref',`Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    }
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;

}

function updatebyReception($lid,$rno,$name, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus,$budget, $uid){
    $conn = dbconnect();
    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',
        `Ld_RNo`='$rno',`Ld_ProjectId`='$project',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref',`Ld_Assigned` = 1 ,`Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    } else {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name' ,
        `Ld_RNo`='$rno',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref',`Ld_Assigned` = 1,`Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    }
    $result = $conn->query($sql);
    //echo $sql;
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;
}
function updatebySales($lid,$name, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus,$budget, $uid){
    $conn = dbconnect();
    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name', `Ld_ProjectId`='$project',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref', `Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    } else {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name', `Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref',`Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    }
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;
}

function updateCpLead($lid, $name, $mob, $altmob, $email, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus,$budget, $remark, $uid)
{

    $conn = dbconnect();
    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',`Ld_Mobile`='$mob', `Ld_AltMobile`='$altmob', `Ld_ProjectId`='$project',`Ld_Email`='$email',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref', `Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    } else {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',`Ld_Mobile`='$mob', `Ld_AltMobile`='$altmob', `Ld_Email`='$email',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref',`Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    }
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;

}

function updatebyCpSales($lid,$name, $ref, $add, $city, $pin, $loc, $project, $intin, $source, $lstatus,$budget, $uid){
    $conn = dbconnect();
    
    $intin = ($intin == "" ? 'NULL' : $intin);
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    $budget = ($budget == "" ? 'NULL' : $budget);

    if ($project != "") {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name', `Ld_ProjectId`='$project',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref', `Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    } else {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name', `Ld_Location`='$loc',`Ld_Address`='$add',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_InterestedIn`=$intin,`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Reference`='$ref',`Ld_Budget` = $budget,`Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    }
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;
}

function updateSourcingLead($lid, $name, $mob, $altmob, $email, $ref, $add,$padd, $city, $pin, $loc, $project,$source, $lstatus,$rerano,$gst,$remark, $uid)
{

    $conn = dbconnect();
   
    $source = ($source == "" ? 'NULL' : $source);
    $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
    

    if ($project != "") {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',`Ld_Mobile`='$mob', `Ld_AltMobile`='$altmob', `Ld_ProjectId`='$project',`Ld_Email`='$email',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_Permanent_add`='$padd',`Ld_City`='$city',
            `Ld_Pincode`='$pin',`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Rera_Number` = '$rerano',`Ld_Gst_No`='$gst',`Ld_Remark`='$remark',`Ld_Reference`='$ref',`Ld_ModifiedDate`= CURDATE(),
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    } else {
        $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name',`Ld_Mobile`='$mob', `Ld_AltMobile`='$altmob', `Ld_Email`='$email',`Ld_Reference`='$ref',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_Permanent_add`='$padd',`Ld_City`='$city',`Ld_Pincode`='$pin',`Ld_Source`='$source',`Ld_LeadStatus`='$lstatus',`Ld_Rera_Number` = '$rerano',`Ld_Gst_No`='$gst',`Ld_Remark`='$remark',`Ld_ModifiedDate`= CURDATE(),
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    }
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;

}


// function updatebySourcingSales($lid,$name, $ref, $add,$padd, $city, $pin, $loc, $project,$source,$lstatus,$rerano,$gst,$uid){
//     $conn = dbconnect();
    
//     $source = ($source == "" ? 'NULL' : $source);
//     $lstatus = ($lstatus == "" ? 'NULL' : $lstatus);
  
//     if ($project != "") {
//         $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name', `Ld_ProjectId`='$project',`Ld_Location`='$loc',`Ld_Address`='$add',`Ld_Permanent_add`='$padd',`Ld_City`='$city',
//             `Ld_Pincode`='$pin',`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Rera_Number` = '$rerano',`Ld_Gst_No`='$gst',`Ld_Reference`='$ref',`Ld_ModifiedDate`='" . date("Y-m-d") . "',
//             `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
//     } else {
//         $sql = "UPDATE `tbl_lead` SET `Ld_Name`='$name', `Ld_Location`='$loc',`Ld_Address`='$add',`Ld_Permanent_add`='$padd',`Ld_City`='$city',
//             `Ld_Pincode`='$pin',`Ld_Source`=$source,`Ld_LeadStatus`=$lstatus,`Ld_Rera_Number` = '$rerano',`Ld_Gst_No`='$gst',`Ld_Reference`='$ref',`Ld_ModifiedDate`='" . date("Y-m-d") . "',
//             `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
//     }
//     $result = $conn->query($sql);
//     insertActionsLog($uid, "Lead Updated", "");
//     return $conn->insert_id;
// }

function updatebyConfirmCpSales($lid,$name,$add,$pin,$rerano,$gst,$accno,$panno,$ifsc,$bankno,$branch,$loc,$uid){
    $conn = dbconnect();
    

        $sql = "UPDATE `tbl_channelpartner` SET `Cp_Name`='$name', `Cp_Address`='$add',`Cp_ReraNo`='$rerano',`Cp_gst`='$gst',`Cp_Pin`='$pin',`Cp_Location`='$loc',
            `Cp_AccNo`='$accno',`Cp_PanNo`='$panno',`Cp_IFSC`='$ifsc',`Cp_BankNo`='$bankno',`Cp_Branch` = '$branch' WHERE `Cp_Id` = $lid";
    
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Updated", "");
    return $conn->insert_id;
}

function updateConfirmCpLead($lid,$name,$mob,$altmob,$mail,$add,$pin,$loc,$rerano,$gst,$accno,$panno,$ifsc,$bankno,$branch,$uid){
    $conn = dbconnect();
    

        $sql = "UPDATE `tbl_channelpartner` SET `Cp_Name`='$name',`Cp_Mobile`='$mob',`Cp_AltMobile`='$altmob',`Cp_Email`='$mail',`Cp_Address`='$add',`Cp_ReraNo`='$rerano',`Cp_gst`='$gst',`Cp_Pin`='$pin',`Cp_Location`='$loc',
            `Cp_AccNo`='$accno',`Cp_PanNo`='$panno',`Cp_IFSC`= '$ifsc',`Cp_BankNo`='$bankno',`Cp_Branch` = '$branch'WHERE `Cp_Id` = $lid";
    
    
    $result = $conn->query($sql);
    
    insertActionsLog($uid, "Lead Updated", "");
    
    return $conn->insert_id;
}



function updateLeadRemark($remark, $lid, $uid){
    $conn = dbconnect();
    $sql = "UPDATE `tbl_lead` SET `Ld_Remark`='$remark',`Ld_ModifiedDate`='" . date("Y-m-d") . "',`Ld_ModifiedId`=$uid, Ld_NewUpdate = 1 WHERE `Ld_Id`=$lid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Remark Updated", "");
    return $conn->insert_id;
}


function updateStatus($lid, $status, $uid)
{

    $conn = dbconnect();

    $sql = "UPDATE `tbl_lead` SET `Ld_LeadStatus`=$status,`Ld_ModifiedDate`='" . date("Y-m-d") . "', `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Status Updated", "");
    return $conn->insert_id;

}


function deleteLabel($lid, $uid)
{

    $conn = dbconnect();

    $sql = "DELETE FROM `tbl_labelassign` WHERE `La_LeadId` = $lid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Label Deleted", "");
    return $conn->insert_id;

}


function insertLabel($lid, $label, $uid)
{

    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_labelassign`(`La_LeadId`, `La_LabelId`, `La_EmpId`) VALUES ($lid,$label,$uid)";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Label Inserted", "");
    return $conn->insert_id;

}


function updateLastCallDateLead($lid, $uid)
{

    $conn = dbconnect();

    $sql = "UPDATE `tbl_lead` SET `Ld_LastCallDate`='" . date("Y-m-d H:i:s") . "', `Ld_ModifiedDate`='" . date("Y-m-d") . "',
            `Ld_ModifiedId`=$uid WHERE `Ld_Id`=$lid";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Update Lead Last Call Date", "");
    return $conn->insert_id;

}

function getAssignLeadzeroCount()
{

    $conn = dbconnect();

    $sql = "SELECT COUNT(Ld_Id) as 'ldcount' FROM tbl_lead WHERE Ld_Assigned = 0";

    $res = $conn->query($sql);
    $res = $res->fetch_assoc();
    return $res["ldcount"];
}

function DelAssignDateLead($lid, $uid)
{
    $conn = dbconnect();

    $sql = "UPDATE `tbl_assignleadtime` SET `Alt_Del`= 1 WHERE `Alt_LdId`=$lid and `Alt_Uid`=$uid";

    $res = $conn->query($sql);
    return $res;
}

function checksalesassign($lid)
{

    $conn = dbconnect();

    $sql = "SELECT al.* FROM `tbl_assignlead` al
	INNER JOIN tbl_users u on u.U_Id = al.Al_CallerId
	WHERE u.U_TypeId = 2 AND al.Al_LeadId = $lid ";

    $res = $conn->query($sql);
    return $res;
}
function checksalesassignsourcelead($lid)
{

    $conn = dbconnect();

    $sql = "SELECT al.* FROM `tbl_assignlead` al
	INNER JOIN tbl_users u on u.U_Id = al.Al_CallerId
	WHERE u.U_TypeId = 5 AND al.Al_LeadId = $lid ";

    $res = $conn->query($sql);
    return $res;
}

function updateAssignDateTimeLead($lid, $dt, $uid)
{

    $conn = dbconnect();

    $sql = "UPDATE `tbl_assignleadtime` SET `Alt_Del`= 1 WHERE `Alt_LdId`=$lid and `Alt_Uid`=$uid";

    $conn->query($sql);

    $sql = "INSERT INTO `tbl_assignleadtime`(`Alt_LdId`, `Alt_Uid`, `Alt_AssignTime`, `Alt_CreatedId`, `Alt_Del`) VALUES 
            ($lid,$uid,'$dt',$uid,0)";
    $conn->query($sql);



    insertActionsLog($uid, "Update Lead Next Call Date", "");
    return $conn->insert_id;

}


function ReadNewUpdateLead($lid, $uid){
    $conn = dbconnect();

    $sql = "UPDATE `tbl_lead` SET Ld_NewUpdate = 0 WHERE `Ld_Id`= $lid";

    $update = $conn->query($sql);
    insertActionsLog($uid, "Lead new update read", "");
    return $update;
}


function MarkNewUpdateLead($lid, $uid){
    $conn = dbconnect();

    $sql = "UPDATE `tbl_lead` SET Ld_NewUpdate = 1 WHERE `Ld_Id`= $lid";

    $update = $conn->query($sql);
    insertActionsLog($uid, "Lead new update marked", "");
    return $update;
}


function getLeadById($lid, $uid)
{

    $conn = dbconnect();

    $sql = "UPDATE `tbl_lead` SET `Ld_Assigned`= 0 WHERE `Ld_Id`= $lid";

    $update = $conn->query($sql);

    $sql2 = "SELECT *, (SELECT GROUP_CONCAT(La_LabelId) FROM tbl_labelassign WHERE La_LeadId = ld.Ld_Id) as 'labelids' FROM `tbl_lead` ld
            LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
            INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
            INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
            LEFT JOIN tbl_budget bd ON bd.Bd_Id = Ld_Budget
            LEFT JOIN tbl_assignleadcp acp ON acp.Alcp_LdId = ld.Ld_Id AND acp.Alcp_Del = 0
            LEFT JOIN tbl_users u ON u.U_Id = acp.Alcp_CpId
            LEFT JOIN tbl_channelpartner cp ON cp.Cp_Id = u.U_RefrenceIdCp
            LEFT JOIN tbl_projects pr ON pr.Pr_Id = ld.Ld_ProjectId
            WHERE `Ld_Id` = $lid AND `Ld_Del` = 0 ";

    $result = $conn->query($sql2);
    // echo $sql;
    insertActionsLog($uid, "Lead Detail Fetched", "");
    return $result;

}


function getCpLeadById($lid, $uid)
   
{
    $conn = dbconnect();

    $sql = "UPDATE `tbl_channelpartner` SET `Cp_Assigned`= 1 WHERE `Cp_Id`= $lid";
    // echo $sql;

    $update = $conn->query($sql);

    $sql2 = "SELECT *
    FROM tbl_channelpartner cp 
    LEFT JOIN tbl_users u ON cp.Cp_Id = u.U_RefrenceIdCp
    LEFT JOIN tbl_teammap tm ON u.U_Id = tm.tm_m_uid
    WHERE `Cp_Id` = $lid AND cp.Cp_Del = 0";

    // echo $sql2;
    $result = $conn->query($sql2);
    insertActionsLog($uid, "Lead Detail Fetched", "");
    return $result;


}

 
function getcurrentCallerAssigned($lid)
{
    $conn = dbconnect();
    $sql2 = "SELECT al.*, u.U_Id, u.U_TypeId FROM tbl_assignlead al
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    WHERE al.Al_LeadId = $lid  AND u.U_TypeId = 1";

    $result = $conn->query($sql2);
    return $result;
}
function getcurrentSalesAssigned($lid)
{
    $conn = dbconnect();
    $sql = "SELECT al.*, u.U_Id, u.U_TypeId FROM tbl_assignlead al
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    WHERE al.Al_LeadId = $lid  AND u.U_TypeId = 2 
    AND al.Al_Del = 0  ORDER BY al.Al_Id DESC";

    $result = $conn->query($sql);
    // echo $sql;
    return $result;
}


function getcurrentCpCallerAssigned($lid)
{
    $conn = dbconnect();
    $sql2 = "SELECT ac.*, u.U_Id, u.U_TypeId FROM tbl_assigncpsource ac
    INNER JOIN tbl_users u ON u.U_Id = ac.AC_UId 
    WHERE ac.AC_CpId = $lid AND ac.AC_Del = 0 AND u.U_TypeId = 5";

    $result = $conn->query($sql2);
    return $result;
}

function getAllListByFilter($lstatus, $src, $int, $uid, $dateby, $sdate, $edate, $search,$leadtype,$misc = "")
{

    $conn = dbconnect();



    $w = "";
    $j = "";
    $g = "";

    if ($leadtype != "") {
    $w .= " AND Ld_LeadType = $leadtype" ;

    }else{
    $w .= " AND Ld_LeadType = 1 " ;

    }

    if($_SESSION['TypeId'] != 7){

    }

    if ($lstatus != "") {
        if($misc == "missed" && ($lstatus == 4 || $lstatus == 17 )){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $lstatus == 1){
            $w = $w . " AND Ls_Id IN ($lstatus) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($lstatus)";
        }
        
    }

    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

    if ($src != "") {
        $w = $w . " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w = $w . " AND Rt_Id IN ($int)";
    }

    if ($dateby == "lead") {
        $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "visitplan") {
        if($misc == "missed"){
            $j .= " LEFT JOIN (
                SELECT
            (
            SELECT CASE WHEN (cl2.Cl_LeadStatus = 4 OR  cl2.Cl_LeadStatus = 17 ) AND cl2.Cl_ActionDate < '" . $edate . " 00:00:00' THEN cl2.Cl_LeadId ELSE 0 END FROM tbl_calllog cl2 
                WHERE cl2.Cl_LeadId = ld.Ld_Id AND (cl2.Cl_CallStatus = 1  OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13 ) ORDER BY cl2.Cl_Id DESC LIMIT 1) as 'leads', 
                ld.Ld_Name,
                 ld.Ld_Mobile,
                cl.Cl_Id,
                cl.Cl_CallStatus,
                cl.Cl_LeadStatus,
                cl.Cl_Status,
               ld.Ld_LeadStatus, '0' as 'actiondate' FROM tbl_lead ld
            LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13 )
            WHERE al.Al_CallerId = $uid 
            AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)
            AND cl.Cl_Status = 'Active'
            GROUP BY ld.Ld_Id
            ORDER BY leads DESC
            ) cl ON cl.leads = ld.Ld_Id";
            $w = $w . " AND (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13)";
            $g .= " GROUP BY ld.Ld_Id";    
        }
        else{
            $j .= " LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17)";
            $w = $w . " AND cl.Cl_ActionDate between '" . $sdate . " 00:00:00' AND '" . $edate . " 23:59:59' AND cl.Cl_Status = 'Active'";
            $g .= " GROUP BY ld.Ld_Id";
        }
        
    }

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    $sql = "SELECT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, al.Al_Del, (SELECT s.Ls_Name 
     FROM tbl_leadstatus s 
     WHERE ls.Ls_parent = s.Ls_Id) AS ParentLabel,
      (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    LEFT JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source 
    LEFT JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus 
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn 
    LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 

    $j
    WHERE al.Al_CallerId = $uid AND `Ld_Del` = 0 AND al.Al_Del = 0  $w 
    $g ORDER BY Ld_LastCallDate,Ld_LeadDate";
    $result = $conn->query($sql);
    insertActionsLog($uid, "All Lead Fetched", "");
    return $result;
}
function getAllRecepListByFilter($lstatus, $src, $int, $uid, $dateby, $sdate, $edate, $search,$leadtype,$misc = "")
{

    $conn = dbconnect();



    $w = "";
    $j = "";
    $g = "";

    if ($leadtype != "") {
    $w .= " AND Ld_LeadType = $leadtype" ;

    }else{
    $w .= " AND Ld_LeadType = 1 " ;

    }

    if($_SESSION['TypeId'] != 7){

    }

    if ($lstatus != "") {
        if($misc == "missed" && ($lstatus == 4 || $lstatus == 17 )){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 4)";
        }
    }else{
        $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 4)";
    }

    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

    if ($src != "") {
        $w = $w . " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w = $w . " AND Rt_Id IN ($int)";
    }

    if ($dateby == "lead") {
        $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "visitplan") {
        if($misc == "missed"){
            $j .= " LEFT JOIN (
                SELECT
            (
            SELECT CASE WHEN (cl2.Cl_LeadStatus = 4 OR  cl2.Cl_LeadStatus = 17 ) AND cl2.Cl_ActionDate < '" . $edate . " 00:00:00' THEN cl2.Cl_LeadId ELSE 0 END FROM tbl_calllog cl2 
                WHERE cl2.Cl_LeadId = ld.Ld_Id AND (cl2.Cl_CallStatus = 1  OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13 ) ORDER BY cl2.Cl_Id DESC LIMIT 1) as 'leads', 
                ld.Ld_Name,
                 ld.Ld_Mobile,
                cl.Cl_Id,
                cl.Cl_CallStatus,
                cl.Cl_LeadStatus,
                cl.Cl_Status,
               ld.Ld_LeadStatus, '0' as 'actiondate' FROM tbl_lead ld
            LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13 )
            WHERE al.Al_CallerId = $uid 
            AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 4 )
            AND cl.Cl_Status = 'Active'
            GROUP BY ld.Ld_Id
            ORDER BY leads DESC
            ) cl ON cl.leads = ld.Ld_Id";
            $w = $w . " AND (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13) AND cl.Cl_CreatedId = $uid  AND cl.Cl_Status = 'Active'";
            $g .= " GROUP BY ld.Ld_Id";    
        }
        else{
            $j .= " LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17)";
            $w = $w . " AND cl.Cl_ActionDate between '" . $sdate . " 00:00:00' AND '" . $edate . " 23:59:59' AND cl.Cl_Status = 'Active' AND cl.Cl_CreatedId = $uid";
            $g .= " GROUP BY ld.Ld_Id";
        }
        
    }

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    $sql = "SELECT DISTINCT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, al.Al_Del, (SELECT s.Ls_Name 
     FROM tbl_leadstatus s 
     WHERE ls.Ls_parent = s.Ls_Id) AS ParentLabel,
      (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    LEFT JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source 
    LEFT JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus 
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn 
    LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 

    $j
    WHERE `Ld_Del` = 0 AND al.Al_Del = 0  $w 
    ORDER BY Ld_LastCallDate,Ld_LeadDate";
    // echo $sql;
    $result = $conn->query($sql);
    insertActionsLog($uid, "Reception All Lead Fetched", "");
    return $result;
}

function getAllCpListByFilter($lstatus, $src, $int, $uid, $dateby, $sdate, $edate, $search, $misc = "")
{
    $conn = dbconnect();

    $w = "";
    $j = "";
    $g = "";


    $w .= " AND Ld_LeadType = 2";

    if ($lstatus != "") {
        if($misc == "missed" && ($lstatus == 4 || $lstatus == 17 )){
            $w .= " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $lstatus == 1){
            $w .= " AND Ls_Id IN ($lstatus) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w .= " AND Ls_Id IN ($lstatus)";
        }
    }

    if($misc == "newupdate"){
        $w .= " AND ld.Ld_NewUpdate = 1";
    }

    if ($src != "") {
        $w .= " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w .= " AND Rt_Id IN ($int)";
    }

    if ($dateby == "lead") {
        $w .= " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w .= " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "visitplan") {
        if($misc == "missed"){
            $j .= " LEFT JOIN (
                SELECT
                (
                    SELECT CASE WHEN (cl2.Cl_LeadStatus = 4 OR OR cl2.Cl_LeadStatus = 17) AND cl2.Cl_ActionDate < '" . $edate . " 00:00:00' THEN cl2.Cl_LeadId ELSE 0 END FROM tbl_calllog cl2 
                    WHERE cl2.Cl_LeadId = ld.Ld_Id AND ( cl2.Cl_CallStatus = 1 OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13 ) ORDER BY cl2.Cl_Id DESC LIMIT 1) as 'leads', 
                    ld.Ld_Name, ld.Ld_Mobile,
                    cl.Cl_Id, cl.Cl_CallStatus, cl.Cl_LeadStatus,
                    cl.Cl_Status,
                    ld.Ld_LeadStatus, '0' as 'actiondate' FROM tbl_lead ld
                LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
                LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13)
                WHERE al.Al_CallerId = $uid AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1) 
                AND cl.Cl_Status = 'Active'
                GROUP BY ld.Ld_Id
                ORDER BY leads DESC
            ) cl ON cl.leads = ld.Ld_Id";
            $w .= " AND ( cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13 )";
            $g .= " GROUP BY ld.Ld_Id";    
        }
        else{
            $j .= " LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17)";
            $w .= " AND cl.Cl_ActionDate between '" . $sdate . " 00:00:00' AND '" . $edate . " 23:59:59'";
            $g .= " GROUP BY ld.Ld_Id";
        }
    }

    if ($search != "") {
        $w .= " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    $sql = "SELECT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount', (SELECT s.Ls_Name 
     FROM tbl_leadstatus s 
     WHERE ls.Ls_parent = s.Ls_Id) AS ParentLabel FROM `tbl_lead` ld
    LEFT JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source 
    LEFT JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus 
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn 
    LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 

    $j
    WHERE al.Al_CallerId = $uid AND `Ld_Del` = 0 AND al.Al_Del = 0   $w 
    $g ORDER BY Ld_LastCallDate,Ld_LeadDate";
    // echo $sql;
        $result = $conn->query($sql);

    insertActionsLog($uid, "All Lead Fetched", "");
    return $result;
}



function getLeadListStatusWise($lstatus, $src,$int,$lbl, $uid, $dateby, $sdate, $edate, $search,$leadtype, $misc = "")
{
    $conn = dbconnect();

    $w = $j = $g =  "";

    if ($src != "") {
        $w = $w . " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w = $w . " AND Rt_Id IN ($int)";
    }

    if ($lbl != "") {
        $w = $w . " AND La_LabelId IN ($lbl)";
    }

    // if ($dateby == "lead") {
    //     $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    // } else if ($dateby == "lastcall") {
    //     $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    // }
        

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }
    if ($leadtype != "") {
        $w = $w . " AND Ld_LeadType = $leadtype";
    }else{
        $w = $w . " AND Ld_LeadType = 1";
    }

    if ($lstatus != "") {
        if($misc == "missed" && ($lstatus == 4 || $lstatus == 17 )){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $lstatus == 1){
            $w = $w . " AND Ls_Id IN ($lstatus) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($lstatus)";
        }
        
    }
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

    if ($src != "") {
        $w = $w . " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w = $w . " AND Rt_Id IN ($int)";
    }

    $sql = "SELECT DISTINCT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, cl.cid, c.Cl_Status , c.Cl_CreatedDate, al.Al_Del, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_labelassign la ON la.La_LeadId = ld.Ld_Id
    LEFT JOIN (SELECT max(c.Cl_Id) as 'cid', c.Cl_LeadId FROM tbl_calllog c   GROUP BY c.Cl_LeadId) cl ON ld.Ld_Id = cl.Cl_LeadId
    LEFT JOIN tbl_calllog c ON c.Cl_Id = cl.cid
    $j

    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0   $w ORDER BY Ld_LastCallDate,Ld_LeadDate";
    $result = $conn->query($sql);
    // echo $sql;
    insertActionsLog($uid, "Lead Fetched Status Wise", "");
    return $result;

}
function getCpLeadListStatusWise($stat, $src,$lbl,$int, $uid, $dateby, $sdate, $edate, $search,$misc="")
{
    $conn = dbconnect();

    $w = "";

    
    if ($src != "") {
        $w = $w . " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w = $w . " AND Rt_Id IN ($int)";
    }

    if ($lbl != "") {
        $w = $w . " AND La_LabelId IN ($lbl)";
    }

    if ($dateby == "lead") {
        $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    }

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }
    if ($stat != "") {
        if($misc == "missed" && ($stat == 4 || $stat == 17 )){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $stat == 1){
            $w = $w . " AND Ls_Id IN ($stat) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stat)";
        }
        
    }
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

     $w = $w . " AND Ld_LeadType = 2";

    $sql = "SELECT DISTINCT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, cl.cid, c.Cl_CreatedDate, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_labelassign la ON la.La_LeadId = ld.Ld_Id
    LEFT JOIN (SELECT max(c.Cl_Id) as 'cid', c.Cl_LeadId FROM tbl_calllog c GROUP BY c.Cl_LeadId) cl ON ld.Ld_Id = cl.Cl_LeadId
    LEFT JOIN tbl_calllog c ON c.Cl_Id = cl.cid
    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0 $w ORDER BY Ld_LastCallDate,Ld_LeadDate";
    // echo $sql;
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Fetched Status Wise", "");
    return $result;
}

function getLeadListSourceWise($lstatus, $stat, $int, $uid,$lbl, $dateby, $sdate, $edate, $search,$leadtype,$misc = "")
{
    $conn = dbconnect();

    $w = "";
    if ($lstatus != "") {
        $w = $w . " AND Ls_Id IN ($lstatus)";
    }

    if ($int != "") {
        $w = $w . " AND Rt_Id IN ($int)";
    }

    if ($lbl != "") {
        $w = $w . " AND La_LabelId IN ($lbl)";
    }

    if ($dateby == "lead") {
        $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    }

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    if ($leadtype != "") {
        $w = $w . " AND Ld_LeadType = $leadtype";
    }else{
        $w = $w . " AND Ld_LeadType = 1";
    }

    if ($lstatus != "") {
        if($misc == "missed" && ($lstatus == 4 || $lstatus == 17 )){
            $w = $w . " AND ( ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $lstatus == 1){
            $w = $w . " AND Ls_Id IN ($lstatus) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($lstatus)";
        }
        
    }
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

    $sql = "SELECT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_labelassign la ON la.La_LeadId = ld.Ld_Id
    WHERE EXISTS (
                SELECT 1 
                FROM tbl_assignlead asl 
                WHERE asl.Al_LeadId = ld.Ld_Id AND asl.Al_Del = 0 
                )
        AND al.Al_CallerId = $uid AND `Ld_Source` IN ($stat)  $w ORDER BY Ld_LastCallDate,Ld_LeadDate";
    $result = $conn->query($sql);
    //echo $sql;
    insertActionsLog($uid, "Lead Fetched Source Wise", "");
    return $result;
}
function getCpLeadListSourceWise($lstatus, $stat, $uid,$lbl, $dateby, $sdate, $edate, $search,$misc='')
{
    $conn = dbconnect();

    $w = "";
    if ($lstatus != "") {
        $w = $w . " AND Ls_Id IN ($lstatus)";
    }

   
    if ($lbl != "") {
        $w = $w . " AND La_LabelId IN ($lbl)";
    }

    if ($dateby == "lead") {
        $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    }
    if ($stat != "") {
        if($misc == "missed" && ($stat == 4 || $stat == 17)){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $stat == 1){
            $w = $w . " AND Ls_Id IN ($stat) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stat)";
        }
        
    }
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    $w = $w . " AND Ld_LeadType  = 2"; // Modify this according to your table structure

    $sql = "SELECT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_labelassign la ON la.La_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND `Ld_Source` IN ($stat) AND al.Al_Del = 0   $w ORDER BY Ld_LastCallDate,Ld_LeadDate ";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Fetched Source Wise", "");
    // echo $sql;

    return $result;
}

function getAllConfirmCpListByFilter($uid, $dateby, $sdate, $edate, $pin, $loc, $search) {
    $conn = dbconnect();
    $w = "";

    if ($dateby == "lead") {
        $w .= " AND Cp_CreatedDate BETWEEN '" . $sdate . "' AND '" . $edate . "'";
    }

    if ($search != "") {
        $w .= " AND (Cp_Name LIKE '%" . $search . "%' OR Cp_Mobile LIKE '%" . $search . "%' OR Cp_Email LIKE '%" . $search . "%' OR Cp_Pin LIKE '%" . $search . "%')";
    }

    if ($pin != "") {
        $w .= " AND Cp_Pin = '" . $pin . "'";
    }

    if ($loc != "") {
        $w .= " AND Cp_Location = '" . $loc . "'";
    }

    $sql = "SELECT cp.Cp_Id,cp.Cp_Code, cp.Cp_Name, cp.Cp_Email, cp.Cp_Mobile, cp.Cp_CreatedDate, Cp_JoiningDate, Cp_Location, Cp_Pin
            FROM tbl_channelpartner cp
            LEFT JOIN tbl_assigncpsource acs ON cp.Cp_Id = acs.AC_CpId 
            WHERE acs.AC_Uid = $uid";

            

    $result = $conn->query($sql);
    insertActionsLog($uid, "All Lead Fetched", "");
    return $result; 
}



function getLeadListInterestWise($lstatus, $src, $stat, $uid,$lbl, $dateby, $sdate, $edate, $search,$misc = "")
{
    $conn = dbconnect();

    $w = "";
    if ($src != "") {
        $w = $w . " AND Sc_Id IN ($src)";
    }

    if ($lstatus != "") {
        $w = $w . " AND Ls_Id IN ($lstatus)";
    }

    if ($lbl != "") {
        $w = $w . " AND La_LabelId IN ($lbl)";
    }

    if ($dateby == "lead") {
        $w = $w . " AND Ld_LeadDate between '" . $sdate . "' AND '" . $edate . "'";
    } else if ($dateby == "lastcall") {
        $w = $w . " AND Ld_LastCallDate between '" . $sdate . "' AND '" . $edate . "'";
    }

    if ($search != "") {
        $w = $w . " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    if ($lstatus != "") {
        if($misc == "missed" && ($lstatus == 4 || $lstatus == 17)){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $lstatus == 1){
            $w = $w . " AND Ls_Id IN ($lstatus) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($lstatus)";
        }
        
    }
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

    $sql = "SELECT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' FROM `tbl_lead` ld
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_labelassign la ON la.La_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND `Ld_InterestedIn` IN ($stat)  $w ORDER BY Ld_LastCallDate,Ld_LeadDate";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Lead Fetched Interest Wise", "");
    return $result;
}
function getLeadListTimeWise($lstatus, $src, $int, $uid, $lbl, $dateby, $sdate, $edate, $search, $time, $misc = '')
{
    $conn = dbconnect();
    $w = "";
    $j = "";

    if ($src != "") {
        $w .= " AND Sc_Id IN ($src)";
    }

    if ($int != "") {
        $w .= " AND Rt_Id IN ($int)";
    }

    if ($lbl != "") {
        $w .= " AND La_LabelId IN ($lbl)";
    }

    if ($dateby == "time") {
        $j .= " LEFT JOIN tbl_assignleadtime alt ON alt.Alt_LdId = ld.Ld_Id AND alt.Alt_Uid = $uid";
        if ($time == "First Half") {
            $w .= " AND alt.Alt_AssignTime BETWEEN '" . date('Y-m-d', strtotime($sdate)) . " 00:00:00' AND '" . date('Y-m-d', strtotime($edate)) . " 13:59:59'";
        }
        if ($time == "Second Half") {
            $w .= " AND alt.Alt_AssignTime BETWEEN '" . date('Y-m-d', strtotime($sdate)) . " 14:00:00' AND '" . date('Y-m-d', strtotime($edate)) . " 23:59:59'";
        }
        if ($time == "Missed") {
            $w .= " AND alt.Alt_AssignTime < '" . date('Y-m-d', strtotime($sdate)) . "' AND (ld.Ld_LeadStatus IN (1, 2, 3, 4, 5,12,17))";
        }
    } else if ($dateby == "lastcall") {
        $w .= " AND Ld_LastCallDate BETWEEN '" . $sdate . "' AND '" . $edate . "'";
    }

    if ($search != "") {
        $w .= " AND (Ld_Name LIKE '%" . $search . "%' OR Ld_Mobile LIKE '%" . $search . "%' OR Ld_Email LIKE '%" . $search . "%' OR Ld_Pincode LIKE '%" . $search . "%')";
    }

    $sql = "SELECT DISTINCT ld.*, sc.Sc_Name, ls.Ls_Name, rt.Rt_Name, cl.cid, c.Cl_CreatedDate, 
            (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_Del <> 0) AS 'callcount' 
            FROM `tbl_lead` ld
            INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
            INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
            LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            LEFT JOIN tbl_labelassign la ON la.La_LeadId = ld.Ld_Id
            LEFT JOIN (SELECT MAX(c.Cl_Id) AS 'cid', c.Cl_LeadId FROM tbl_calllog c GROUP BY c.Cl_LeadId) cl ON ld.Ld_Id = cl.Cl_LeadId
            LEFT JOIN tbl_calllog c ON c.Cl_Id = cl.cid
            $j
            WHERE  (DATE(c.Cl_CreatedDate) >= '" . date('Y-m-d') . "' OR c.Cl_CreatedDate is null) AND al.Al_CallerId = $uid AND al.Al_Del = 0 $w ORDER BY Ld_LastCallDate,Ld_LeadDate";

    $result = $conn->query($sql);
    // echo $sql;
    insertActionsLog($uid, "Lead Fetched Time Wise", "");
    return $result;
}





function getLabelsByLeadId($lid)
{
    $conn = dbconnect();

    $sql = "SELECT lb.Lb_Name, lb.Lb_ColorCode FROM tbl_labelassign la
    INNER JOIN tbl_lead ld ON ld.Ld_Id = la.La_LeadId
    INNER JOIN tbl_labels lb ON lb.Lb_Id = la.La_LabelId
    WHERE ld.Ld_Id = $lid";
    $result = $conn->query($sql);
    return $result;
}

function checkMobBulkInsert($mob)
{
    $conn = dbconnect();
    $sql = "SELECT * FROM `tbl_lead` WHERE `Ld_Mobile` = '$mob' OR `Ld_AltMobile` = '$mob'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}


function checkMob($mob)
{
    $conn = dbconnect();
    if(strlen($mob) > 10){
        $mob = substr($mob, -10);
    }
    $sql = "SELECT * FROM `tbl_lead` WHERE `Ld_Mobile` LIKE '%$mob%' OR `Ld_AltMobile` LIKE '%$mob%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}
function checkEmail($email)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_lead` WHERE `Ld_Email` LIKE '%$email%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}
function checkMobCp($mob)
{
    $conn = dbconnect();
    if(strlen($mob) > 10){
        $mob = substr($mob, -10);
    }
    $sql = "SELECT * FROM `tbl_channelpartner` WHERE `Cp_Mobile` LIKE '%$mob%' OR `Cp_AltMobile` LIKE '%$mob%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}
function checkEmailCp($email)
{
    $conn = dbconnect();
    $sql = "SELECT * FROM `tbl_channelpartner` WHERE `Cp_Email` LIKE '%$email%' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}
function checkRegistraionNo($value,$id="")
{
    $conn = dbconnect();
    $w = "";
    if($id !=""){
        $w = " AND `Ld_Id` <> $id";
    }
    $sql = "SELECT * FROM `tbl_lead` WHERE `Ld_RNo` = '$value' $w";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}


function checkMobById($mob, $id)
{
    $conn = dbconnect();
    if(strlen($mob) > 10){
        $mob = substr($mob, -10);
    }
    $sql = "SELECT * FROM `tbl_lead` WHERE (`Ld_Mobile` LIKE '%$mob%' OR `Ld_AltMobile` LIKE '%$mob%') AND `Ld_Id` <> $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}

function checkMobByIdCp($mob, $id)
{
    $conn = dbconnect();
    if(strlen($mob) > 10){
        $mob = substr($mob, -10);
    }
    $sql = "SELECT * FROM `tbl_channelpartner` WHERE (`Cp_Mobile` LIKE '%$mob%' OR `Cp_AltMobile` LIKE '%$mob%') AND `Cp_Id` <> $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}

function checkEmailByIdCp($email, $id)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_channelpartner` WHERE (`Cp_Email` LIKE '%$email%' ) AND `Cp_Id` <> $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return "false";
    } else {
        return "true";
    }
}


function getleadbyMobNo($mob,$altmob){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_lead` WHERE `Ld_Mobile` = '$mob' OR `Ld_AltMobile` = '$mob'";
    $result = $conn->query($sql);
    return $result;
}

function getLeadDataById($lid){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_lead` WHERE `Ld_Id` = '$lid'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function getProjectDetails($lid)
{
    $conn = dbconnect();

    $sql = "SELECT pr.* FROM `tbl_projects` pr
    INNER JOIN tbl_lead ld ON ld.Ld_ProjectId = pr.Pr_Id
    WHERE ld.Ld_Id = $lid";
    $result = $conn->query($sql);
    return $result;
}


function updateLeadAssigned($lid)
{
    $conn = dbconnect();

    $sql = "UPDATE `tbl_lead` SET `Ld_Assigned` = 1 WHERE `Ld_Id`=$lid";

    $res = $conn->query($sql);
    return $res;
}
function getVisitedCounts($lid){
    $conn = dbconnect();

    $sql = "SELECT cl.*,u.U_Id,u.U_TypeId,u.U_RoleId,u.U_DisplayName FROM tbl_calllog cl
    INNER JOIN tbl_users u ON u.U_Id = cl.Cl_CreatedId
    WHERE cl.Cl_LeadStatus = 5 AND cl.Cl_LeadId = $lid";
    $result = $conn->query($sql);
    return $result->num_rows;
}
function getAssignedSalesList($lid)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_assignlead al
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    WHERE al.Al_LeadId = $lid AND u.U_TypeId = 2 ";
    $result = $conn->query($sql);
    return $result;
}


function getAssignedUsersLead($lid){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_assignlead al
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    INNER JOIN tbl_usertype ut on ut.UType_Id = u.U_TypeId
    WHERE al.Al_LeadId = $lid AND al.Al_Del = 0 ";
    $result = $conn->query($sql);
    return $result;
}
function getAssignedCpLead($lid){
    $conn = dbconnect();

    $sql = "SELECT * FROM  tbl_assigncpsource ac
    INNER JOIN tbl_users u ON u.U_Id = ac.AC_UId 
    INNER JOIN tbl_usertype ut on ut.UType_Id = u.U_TypeId
    WHERE ac.AC_CpId  = $lid AND ac.AC_Del = 0";
    $result = $conn->query($sql);
    return $result;
}


function getSiteVisitPlanDetail($lid, $userid){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_lead ld
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17) AND cl.Cl_Status = 'Active'
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    LEFT JOIN tbl_projects pr ON pr.Pr_Id = ld.Ld_ProjectId
    WHERE ld.Ld_Id = $lid AND (ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 17) AND al.Al_CallerId = $userid 
    ORDER BY ld.Ld_Id DESC";
    $result = $conn->query($sql);
    return $result;
}


function getGlobalSearch($uid,$typeid,$search){
    $conn = dbconnect();
    $w=$y='';
    if(($typeid == 1 ||$typeid == 2 || $typeid == 4 ) && $uid != ''){
        $w .= "AND asl.Al_CallerId = $uid";
    }
   
    $sql = "SELECT DISTINCT ld.*, sc.Sc_Name, ls.Ls_Name,
    (SELECT GROUP_CONCAT(us.U_DisplayName) FROM tbl_assignlead asl INNER JOIN tbl_users us ON us.U_Id = asl.Al_CallerId WHERE asl.Al_LeadId = ld.Ld_Id AND asl.Al_Del = 0) as 'Assigned', 
    (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as 'callcount' 
        FROM `tbl_lead` ld
        INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
        INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
        LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 
        LEFT JOIN tbl_users u ON u.U_Id = al.Al_CallerId
        WHERE EXISTS (
                SELECT 1 
                FROM tbl_assignlead asl 
                WHERE asl.Al_LeadId = ld.Ld_Id AND asl.Al_Del = 0 $w 
                )
        AND (ld.Ld_Mobile LIKE '%$search%' OR ld.Ld_Name LIKE '%$search%' OR ld.Ld_AltMobile LIKE '%$search%' OR ld.Ld_Email LIKE '%$search%' OR 
            (SELECT GROUP_CONCAT(us.U_DisplayName) FROM tbl_assignlead asl INNER JOIN tbl_users us ON us.U_Id = asl.Al_CallerId WHERE asl.Al_LeadId = ld.Ld_Id AND asl.Al_Del = 0) LIKE '%$search%')
        ";


          
     $result = $conn->query($sql);
     return $result;

     }



function getGlobalSearchCp($uid="",$search){
        $conn = dbconnect();
        $w = "";
        if($uid != "" ){
           $w = " AND acs.AC_UId = $uid";
        }
        $sql="SELECT 
        cp.Cp_Id,
        cp.Cp_Code,
        cp.Cp_Name,
        cp.Cp_Mobile,
         (SELECT GROUP_CONCAT(us.U_DisplayName) FROM  tbl_assigncpsource cps INNER JOIN tbl_users us ON us.U_Id = cps.AC_UId WHERE cp.Cp_Id =cps.AC_CpId) AS 'Assigned' 
        FROM 
            tbl_channelpartner cp
        INNER JOIN 
            tbl_users u ON u.U_RefrenceIdCp = cp.Cp_Id
        LEFT JOIN tbl_assigncpsource acs ON acs.AC_CpId = cp.Cp_Id
        
        WHERE 
        (cp.Cp_Name LIKE '%$search%' OR cp.Cp_Mobile = '" . $search . "' OR cp.Cp_Email = '" . $search . "' OR cp.Cp_Pin = '" . $search . "') $w
        ORDER BY 
            cp.Cp_Id DESC";
       
           
         $result = $conn->query($sql);
         return $result;
    
}

    
function reassignLeadtoSales($lid,$uid, $teamid,$lstatus){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_assignlead al
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    WHERE al.Al_LeadId = $lid AND u.U_TypeId = 2 ";
    $result = $conn->query($sql);
  	if($result->num_rows > 0){
    $sales = $result->fetch_assoc();
	
    $sql = "UPDATE tbl_assignlead al SET al.Al_Del = 1 WHERE al.Al_CallerId = ".$sales["Al_CallerId"]." AND al.Al_LeadId = $lid";
    $result = $conn->query($sql);  
    }
    $res = AssignLead($lid, $uid, $teamid, $lstatus);
    //echo $sql;
    return $res;
}
function claimLead($lid,$uid, $teamid){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_assignlead al
    INNER JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    WHERE al.Al_LeadId = $lid AND u.U_TypeId = 2 ";
    $result = $conn->query($sql);
  	if($result->num_rows > 0){
    $sales = $result->fetch_assoc();
	
    $sql = "UPDATE tbl_assignlead al SET al.Al_Del = 1 WHERE al.Al_Id = ".$sales["Al_Id"]."";
    $result = $conn->query($sql);  
    }
    

    $res = AssignLead($lid, $uid, $teamid, 1);

    return $res;
}


function getFirstVisitPlanOverview($sdate, $edate, $uid){
    $conn = dbconnect();

    $sql = "SELECT COUNT(a.visitplan) AS 'counts', GROUP_CONCAT(DISTINCT Lead) AS 'LeadsId' 
    FROM (
        SELECT 
            CASE 
                WHEN cl1.Cl_CreatedDate = cl.Cl_CreatedDate THEN cl1.Cl_LeadId 
                ELSE '0' 
            END AS 'visitplan',
            cl.Cl_LeadId AS 'Lead'

        FROM tbl_calllog cl
        LEFT JOIN tbl_calllog cl1 ON cl1.Cl_LeadId = cl.Cl_LeadId 
            AND cl1.Cl_CallStatus IN (1, 12, 13) 
            AND cl1.Cl_LeadStatus IN (4, 17)
        WHERE 
            cl.Cl_CallStatus IN (1, 12, 13) 
            AND cl.Cl_LeadStatus IN (4, 17) 
            AND DATE(cl.Cl_CreatedDate) BETWEEN '$sdate' AND '$edate' 
            AND cl.Cl_CreatedId = $uid
        GROUP BY visitplan, cl.Cl_CreatedDate
        ORDER BY visitplan DESC
    ) AS a
    WHERE a.visitplan <> '0'";
    // echo $sql;
    $result = $conn->query($sql);
    return $result->fetch_assoc();

}
function getVisitPlanCount($uid,$sdate,$edate){
    $conn = dbconnect();

    //$sql = "SELECT GROUP_CONCAT(a.visitplan) AS LeadID ,COUNT(a.visitplan) as 'counts' FROM
    // (SELECT 
    //     (SELECT CASE WHEN cl1.Cl_CreatedDate = cl.Cl_CreatedDate THEN cl1.Cl_LeadId ELSE '0' END FROM tbl_calllog cl1 WHERE cl1.Cl_LeadId = cl.Cl_LeadId AND (cl1.Cl_CallStatus = 1 OR  cl1.Cl_CallStatus = 12 OR cl1.Cl_CallStatus = 13 ) AND (cl1.Cl_LeadStatus = 4 OR  cl1.Cl_LeadStatus = 17)  ORDER BY cl1.Cl_Id ASC LIMIT 1) as 'visitplan',
    //     cl.Cl_CreatedDate
    //     FROM tbl_calllog cl
    //     WHERE ( cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13 ) AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17 ) AND cl.Cl_CreatedDate >=".date('Y-m-d')." AND cl.Cl_CreatedId IN ($uid)
    //     GROUP BY visitplan
    //     ORDER BY visitplan DESC) as a
    //     WHERE a.visitplan <> 0";

    $sql = "SELECT COUNT(a.visitplan) AS 'counts'
    FROM (
        SELECT 
            CASE 
                WHEN cl1.Cl_CreatedDate = cl.Cl_CreatedDate THEN cl1.Cl_LeadId 
                ELSE '0' 
            END AS 'visitplan'

        FROM tbl_calllog cl
        LEFT JOIN tbl_calllog cl1 ON cl1.Cl_LeadId = cl.Cl_LeadId 
            AND cl1.Cl_CallStatus IN (1, 12, 13) 
            AND cl1.Cl_LeadStatus IN (5)
        WHERE 
            cl.Cl_CallStatus IN (1, 12, 13) 
            AND cl.Cl_LeadStatus IN (5) 
            AND DATE(cl.Cl_CreatedDate) BETWEEN '$sdate' AND '$edate' 
            AND cl.Cl_CreatedId = $uid
        GROUP BY visitplan, cl.Cl_CreatedDate
        ORDER BY visitplan DESC
    ) AS a
    WHERE a.visitplan <> '0'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();

}
function getVisitedCount($uid){
    $conn = dbconnect();

    $sql = "SELECT GROUP_CONCAT(visited) AS LeadID , COUNT(visited) AS counts FROM
    (SELECT 
        (SELECT CASE WHEN cl1.Cl_CreatedDate = cl.Cl_CreatedDate THEN cl1.Cl_LeadId ELSE '0' END FROM tbl_calllog cl1 
         WHERE cl1.Cl_LeadId = cl.Cl_LeadId AND cl1.Cl_LeadStatus = 5 ORDER BY cl1.Cl_Id ASC LIMIT 1) as 'visited',
        cl.Cl_CreatedDate
        FROM tbl_calllog cl
        LEFT JOIN tbl_lead ld ON ld.Ld_Id = cl.Cl_LeadId
        LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
        WHERE cl.Cl_LeadStatus = 5  AND al.Al_CallerId = $uid
        GROUP BY visited
        ORDER BY visited DESC) as a
        WHERE visited <> 0";
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}
function getBookedCount($uid,$sdate,$edate){
    $conn = dbconnect();
    $sql = "SELECT COUNT(a.booked) AS 'counts',GROUP_CONCAT(DISTINCT Lead) AS 'LeadID'
    FROM (
        SELECT 
            CASE 
                WHEN cl1.Cl_CreatedDate = cl.Cl_CreatedDate THEN cl1.Cl_LeadId 
                ELSE '0' 
            END AS 'booked',
           cl1.Cl_LeadId AS 'Lead'


        FROM tbl_calllog cl
        LEFT JOIN tbl_calllog cl1 ON cl1.Cl_LeadId = cl.Cl_LeadId 
            AND cl1.Cl_CallStatus IN (1, 12, 13) 
            AND cl1.Cl_LeadStatus IN (11)
        WHERE 
            cl.Cl_CallStatus IN (1, 12, 13) 
            AND cl.Cl_LeadStatus IN (11) 
            AND DATE(cl.Cl_CreatedDate) BETWEEN '$sdate' AND '$edate' 
            AND cl.Cl_CreatedId = $uid
        GROUP BY booked, cl.Cl_CreatedDate
        ORDER BY booked DESC
    ) AS a
    WHERE a.booked <> '0'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}
function getAllReceptionSiteVisitPlan(){
    $conn = dbconnect();

    $sql = "SELECT COALESCE(COUNT(ld.Ld_Id), 0) AS 'count' FROM `tbl_calllog` cl 
            INNER JOIN tbl_lead ld ON ld.Ld_Id = cl.Cl_LeadId
            WHERE  cl.Cl_Status = 'Active'
            AND cl.Cl_CallStatus IN (1,12,13) AND cl.Cl_LeadStatus IN (4,17)
            AND DATE(cl.Cl_ActionDate) >= '".date('Y-m-d')."'";

        $result = $conn->query($sql);
        return $result;
}

function getAllSalesSiteVisitCount(){
    $conn = dbconnect();

    $sql = "SELECT 
            CASE 
                WHEN EXISTS (
                    SELECT 1 
                    FROM tbl_calllog cl2
                    WHERE cl2.Cl_LeadId = al.Al_LeadId 
                    AND DATE(cl.Cl_CreatedDate) = '".date('Y-m-d')."' 
                    AND cl2.Cl_LeadStatus = 5
                ) THEN 
                COUNT(ld.Ld_Id)
                ELSE '0'
            END AS count
        FROM 
            tbl_assignlead al
        INNER JOIN 
            tbl_users u ON u.U_Id = al.Al_CallerId
        INNER JOIN 
            tbl_lead ld ON ld.Ld_Id = al.Al_LeadId
        INNER JOIN 
            tbl_calllog cl ON cl.Cl_LeadId = al.Al_LeadId
        WHERE 
            u.U_TypeId = 2 
            AND ld.Ld_LeadStatus = 5 
            AND cl.Cl_LeadStatus = 5
            AND cl.Cl_Status = 'Active'";

        $result = $conn->query($sql);
        // echo $sql;
        return $result;
}
function getSiteVisitPlanLead($uid,$search=""){
    $conn = dbconnect();
    $w="";
    if($search != ""){
        $w = " AND (Ld_Name LIKE '$search%' OR Ld_Mobile LIKE '$search%'
        OR Ld_AltMobile LIKE '$search%')";

    }
 
    $sql="SELECT 
    ld.*, 
    cl.*, 
    GROUP_CONCAT(DISTINCT u.U_DisplayName) AS assignedto
    FROM 
        tbl_calllog cl 
    INNER JOIN 
        tbl_lead ld ON ld.Ld_Id = cl.Cl_LeadId
    INNER JOIN 
        tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id AND al.Al_Del= 0
    INNER JOIN 
        tbl_users u ON al.Al_CallerId = u.U_Id
    WHERE  cl.Cl_Status = 'Active'
        AND cl.Cl_CallStatus IN (1,12,13) AND cl.Cl_LeadStatus IN (4,17)
        AND DATE(cl.Cl_ActionDate) >= '".date('Y-m-d')."'
        $w
    GROUP BY cl.Cl_Id 
    ORDER BY DATE(cl.Cl_ActionDate) = '".date('Y-m-d')."' DESC, cl.Cl_ActionDate ASC";
    $result = $conn->query($sql);
   echo $sql;
    return $result;
}

function getLatestVisitPlan($lid){
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_calllog cl
    WHERE (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13 ) AND (cl.Cl_LeadStatus = 4 OR cl.Cl_LeadStatus = 17 )AND cl.Cl_LeadId = $lid
    ORDER BY cl.Cl_Id DESC
    LIMIT 1";
    $result = $conn->query($sql);

    return $result;
}


function getFirstVisited($sdate, $edate, $uid){
    $conn = dbconnect();

    $sql = "SELECT GROUP_CONCAT(visited) AS LeadID , COUNT(visited) AS counts FROM
    (SELECT 
        (SELECT CASE WHEN cl1.Cl_CreatedDate = cl.Cl_CreatedDate THEN cl1.Cl_LeadId ELSE '0' END FROM tbl_calllog cl1 
         WHERE cl1.Cl_LeadId = cl.Cl_LeadId AND cl1.Cl_LeadStatus = 5  AND cl1.Cl_Status = 'Active' ORDER BY cl1.Cl_Id ASC LIMIT 1) as 'visited',
        cl.Cl_CreatedDate
        FROM tbl_calllog cl
        LEFT JOIN tbl_lead ld ON ld.Ld_Id = cl.Cl_LeadId
        LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
        WHERE cl.Cl_LeadStatus = 5 AND cl.Cl_CreatedDate BETWEEN '".date('Y-m-d',strtotime($sdate))."' AND '".date('Y-m-d',strtotime($edate))."' 
        AND al.Al_CallerId = $uid 
        GROUP BY visited
        ORDER BY visited DESC) as a
        WHERE visited <> 0";
    // echo $sql;
    $result = $conn->query($sql);

    return $result->fetch_assoc();
}




function getSiteVisitPlanByDate($uid,$date){
    $conn = dbconnect();

    $sql = "SELECT SUM(leadcount) as 'ldc', actiondate from (
        SELECT CASE WHEN (cl2.Cl_LeadStatus = 4 OR cl2.Cl_LeadStatus = 17) THEN 1 ELSE 0 END as 'leadcount', DATE(cl2.Cl_ActionDate) AS 'actiondate' FROM tbl_lead ld 
                  LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 
                  LEFT JOIN tbl_calllog cl2 ON cl2.Cl_LeadId = ld.Ld_Id AND (cl2.Cl_CallStatus = 1 OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13 )
                  WHERE al.Al_CallerId = $uid  AND cl2.Cl_ActionDate LIKE '$date%' AND cl2.Cl_Status = 'Active'
        GROUP BY cl2.Cl_ActionDate
        ORDER BY cl2.Cl_Id DESC) as a
        WHERE a.leadcount <> 0
        GROUP BY actiondate
        ORDER BY actiondate ASC";
    
    $result = $conn->query($sql);
    // echo $sql;
    return $result;
}
function getReceptionSiteVisitPlanByDate($uid,$date){
    $conn = dbconnect();
    $sql="SELECT 
            COUNT(leadcount) AS ldc, 
             assignto, 
            actiondate 
        FROM (
            SELECT 
                CASE WHEN (cl2.Cl_LeadStatus = 4 OR cl2.Cl_LeadStatus = 17) THEN 1 ELSE 0 END AS 'leadcount', 
                DATE(cl2.Cl_ActionDate) AS 'actiondate',
                al.Al_CallerId AS 'assignto'
            FROM 
                `tbl_calllog` cl2
            LEFT JOIN (
                SELECT Al_LeadId, Al_CallerId
                FROM tbl_assignlead al1
                WHERE Al_CreatedDate = (
                    SELECT MAX(Al_CreatedDate)
                    FROM tbl_assignlead al2
                    WHERE al1.Al_LeadId = al2.Al_LeadId
                )
            ) al ON al.Al_LeadId = cl2.Cl_LeadId
            WHERE 
                 DATE(cl2.Cl_ActionDate) LIKE '$date%' 
                 AND DATE(cl2.Cl_ActionDate) >= CURDATE()
                AND cl2.Cl_CreatedId = $uid  
                AND cl2.Cl_Status = 'Active' 
            ORDER BY 
                cl2.Cl_Id DESC
        ) subquery 
        GROUP BY 
        actiondate";
   $result = $conn->query($sql);
//    echo $sql;
    return $result;
}

function getCpCode($code){

    $conn = dbconnect();

    $sql  = "SELECT Cp_Code FROM tbl_channelpartner ORDER BY Cp_Id  DESC LIMIT 1";
    
    $result = $conn->query($sql);

    return $result;
}


function getCpDetails($id){

    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_channelpartner 
            INNER JOIN tbl_users  ON tbl_channelpartner.Cp_Id = tbl_users.U_RefrenceIdCp 
            WHERE tbl_users.U_Id  = $id";

    $result = $conn->query($sql);
     return $result;
}

function getCpDetailsById($id){

    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_channelpartner where Cp_Id = $id";
    
    $result = $conn->query($sql);
    return $result;
}

function convertCpToUser($lastInsertId,$name,$password,$mobile,$email,$roleid,$typeid,$createdId,$modifyId,$status,$del){
    $conn = dbconnect();

   

    $sql = "INSERT INTO tbl_users (U_RefrenceIdCp, U_Username, U_Password,U_FullName,U_DisplayName,U_Mobile,U_Email,U_RoleId,U_TypeId,U_CreatedId,U_ModifiedId,U_Status,U_Del) 
    VALUES ('$lastInsertId','$name', '$password','$name','$name','$mobile','$email','$roleid','$typeid','$createdId','$modifyId','$status','$del')";

    $result = $conn->query($sql);
    $lastInsertedId = $conn->insert_id;
    return $lastInsertedId;
    
}

function getLastCpCode($conn)
{
    $query = "SELECT Cp_Code FROM tbl_channelpartner ORDER BY Cp_Id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['Cp_Code'];
    }
    return '';
}
function getCpCodeById($conn,$cpid)
{
    $conn = dbconnect();
    $query = "SELECT Cp_Code FROM tbl_channelpartner WHERE Cp_Id = $cpid ";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        $cpc =  $row['Cp_Code'];
        return $cpc;
    }

    // Default to an empty string if no record is found
    return '';
}
function sendRegistrationEmail($name, $email, $mobile, $password) {
    ini_set("SMTP", "smtp.gmail.com");
    ini_set("smtp_port", "587");
    ini_set("sendmail_from", "khaniffat230920@gmail.com");

    $mail = new PHPMailer(true);

    try {
        // PHPMailer configuration - SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->isHTML(true);
        $mail->Username = 'khaniffat230920@gmail.com';
        $mail->Password = 'vitz mygp fbht mnlt';

        $mail->setFrom('khaniffat230920@gmail.com', 'Iffat');
        $mail->addReplyTo('khaniffat230920@gmail.com', 'Iffat');

        $mail->addAddress($email, $name);

        $mail->Subject = 'CP Login From Pehlaghar';
        // $mail->Body = "Hello $name,\n\n"
        //     . "Thank you for registering!\n"
        //     . "Your username: $name\n"
        //     . "Your password: $password\n"
        //     . "Please keep your login credentials secure.\n\n";
    
        $mail->Body = '<!doctype html>
        <html lang="en-US">
        
        <head>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
            <title>New Account Email Template</title>
            <meta name="description" content="New Account Email Template.">
            <style type="text/css">
                a:hover {text-decoration: underline !important;}
            </style>
        </head>
        
        <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
            <!-- 100% body table -->
            <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
                style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: \'Open Sans\', sans-serif;">
                <tr>
                    <td>
                        <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
                            align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="height:80px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;background:#af0609;padding:20px;">
                                    <a href="https://neralproperty.com/" title="logo" target="_blank">
                                        <img width="120" src="https://neralproperty.com/assets/images/logo-w.png" title="logo" alt="logo">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                        style="max-width:670px; background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                        <tr>
                                            <td style="height:40px;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 35px;">
                                                <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Get started
                                                </h1>
                                                <p style="font-size:15px; color:#455056; margin:8px 0 0; line-height:24px;">
                                                    Your account has been created on the https://neralproperty.com/. Below are your system generated credentials, <br><strong>Please change
                                                        the password immediately after login</strong>.</p>
                                                <span
                                                    style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                                <p
                                                    style="color:#455056; font-size:18px;line-height:20px; margin:0; font-weight: 500;">
                                                    <strong
                                                        style="display: block;font-size: 13px; margin: 0 0 4px; color:rgba(0,0,0,.64); font-weight:normal;">Username</strong>'.$name.'
                                                    <strong
                                                        style="display: block; font-size: 13px; margin: 24px 0 4px 0; font-weight:normal; color:rgba(0,0,0,.64);">Password</strong>'.$password.'
                                                </p>
        
                                                <a href="https://neralproperty.com/"
                                                    style="background:#20e277;text-decoration:none !important; display:inline-block; font-weight:500; margin-top:24px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Login
                                                    to your Account</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px;">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">
                                    <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>neralproperty.com</strong> </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!--/100% body table-->
        </body>
        
        </html>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Error sending email: " . $mail->ErrorInfo;
        return false;
    }
}
function generateRandomPassword($length = 6)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    
    // Loop to generate 6 random characters
    for ($i = 0; $i < $length; $i++) {
        // Append a randomly selected character from the character set
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $password;
}

function makeTeam($uid,$name,$code,$pid=''){
    $conn = dbconnect();
    $tm_parent_id = ($pid == '' ? 'NULL' : $pid);

    $sql = "INSERT INTO `tbl_team` (`Tm_Name`, `Tm_Code`, `Tm_parent_team_id`, `Tm_CreatedDate`, `Tm_CreatedId`, `Tm_Status`, `Tm_Del`) 
            VALUES ('$name', '$code', $tm_parent_id, NOW(), $uid, 'Active', 0)";

    // echo $sql;
    $result = $conn->query($sql);
    insertActionsLog($uid, "Team Created", "");
    return $conn->insert_id;
}

function getLeadCountByCpid($id){
    $conn = dbconnect();

            $sql="SELECT 
            cp.Cp_Id,
            COUNT(ld.Ld_Id) AS 'ldcount',
            MAX(ld.Ld_CreatedDate) AS 'latest_lead',
            u.U_Id
            FROM 
            tbl_channelpartner cp
            INNER JOIN 
            tbl_users u ON cp.Cp_Id = u.U_RefrenceIdCp
            LEFT JOIN 
            tbl_assignlead al ON al.Al_CallerId = u.U_Id
            LEFT JOIN 
            tbl_lead ld ON ld.Ld_Id = al.Al_LeadId
            LEFT JOIN 
            tbl_assigncpsource acp ON acp.AC_CpId = cp.Cp_Id
            WHERE 
               cp.Cp_Id = $id
            GROUP BY 
            cp.Cp_Id, cp.Cp_CreatedDate
            ORDER BY 
            cp.Cp_CreatedDate DESC";
    
    $result = $conn->query($sql);
    return $result;
}
?>