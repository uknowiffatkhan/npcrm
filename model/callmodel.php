<?php

if (!isset($_SESSION)) {
    session_start();
}


$baseurl = $_SESSION["baseurl"];

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/auth.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";


function insertCall($lid, $calst, $cltype, $ldst, $dat, $remark, $uid)
{

    $conn = dbconnect();
    $dl = "";
    $dd = "";
    if ($dat != "") {
        $dl = "`Cl_ActionDate`,";
        $dd = "'$dat',";
    }

    $sql = "INSERT INTO `tbl_calllog`(`Cl_LeadId`, `Cl_CallStatus`, `Cl_CallType`, `Cl_LeadStatus`, $dl `Cl_Remark`, `Cl_CreatedId`, `Cl_Status`, `Cl_Del`) VALUES 
           ($lid,$calst,'$cltype',$ldst, $dd '$remark', $uid, 'Active',0)";
    $result = $conn->query($sql);
    
    insertActionsLog($uid, "Call Log Inserted", "");
    // echo $sql;
    return $conn->insert_id;

}


function insertAdminCall($lid, $remark, $uid)
{

    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_calllog`(`Cl_LeadId`, `Cl_CallStatus`, `Cl_LeadStatus`, `Cl_Remark`, `Cl_CreatedId`, `Cl_Status`, `Cl_Del`) VALUES 
           ($lid,0,1, '$remark', $uid, 'Inactive',1)";
    $result = $conn->query($sql);

    insertActionsLog($uid, "Call Log Inserted", "");

    return $conn->insert_id;

}



function InactiveAllCallLogs($lid, $uid)
{
    $conn = dbconnect();
    $sql = "UPDATE `tbl_calllog` SET `Cl_Status`='Inactive' WHERE Cl_LeadId = $lid AND Cl_CreatedId = $uid";
    $result = $conn->query($sql);

    insertActionsLog($uid, "Call Log Update Inactive", "");

    return true;
}


function InactiveAllVivistCall($lid, $uid)
{
    $conn = dbconnect();
    $sql = "UPDATE `tbl_calllog` SET `Cl_Status`='Inactive' WHERE Cl_LeadId = $lid AND `Cl_LeadStatus`= 4 OR `Cl_LeadStatus`= 17";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Call Log Update Inactive Last visit plan", "");

    return true;
}


function getCallLogById($lid, $uid)
{

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_calllog`
            LEFT JOIN tbl_callstatus on Cs_Id = Cl_CallStatus
            INNER JOIN tbl_leadstatus on Ls_Id = Cl_LeadStatus
            LEFT JOIN tbl_reminder ON Rm_CallId = Cl_Id
            LEFT JOIN tbl_users u ON u.U_Id = Cl_CreatedId
            LEFT JOIN 
            (
                SELECT Ls_Id as Parentid, Ls_Name as Parentname
                FROM tbl_leadstatus
            ) parent_ls ON tbl_leadstatus.Ls_parent = parent_ls.Parentid
            WHERE `Cl_LeadId` = $lid
            GROUP BY Cl_Id
            ORDER BY Cl_Id DESC";
    $result = $conn->query($sql);

    insertActionsLog($uid, "Fetched Log by Lead Id " . $lid, "");
    return $result;

}


function getCallCountByLId($lid, $uid, $date, $callstatus, $callstatustype)
{

    $conn = dbconnect();
    $w = "";
    if ($date != "") {
        $w .= " AND DATE(cl.Cl_CreatedDate) = '$date'";
    }
    if ($callstatus != "") {
        $w .= " AND cl.Cl_CallStatus = $callstatus";
    }
    if ($callstatustype != "") {
        $w .= " AND cs.Cs_Type = '$callstatustype'";
    }

    $sql = "SELECT DATE(cl.Cl_CreatedDate) as d, COUNT(cl.Cl_Id) as 'count', cl.Cl_LeadId, CONCAT(cs.Cs_Type) as 'ctype' FROM `tbl_calllog` cl
    INNER JOIN tbl_callstatus cs ON cs.Cs_Id = cl.Cl_CallStatus
    WHERE `Cl_LeadId` = $lid $w GROUP BY d, `Cl_LeadId` ORDER BY d DESC";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Fetched Call Count by Lead Id " . $lid, "");

    return $result;

}


function getCallStatusById($cid)
{

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_callstatus` WHERE `Cs_Id` = $cid";
    $result = $conn->query($sql);


    return $result;

}


function getSitevistPlan($uid)
{
    $conn = dbconnect();

    $sql = "SELECT SUM(leads) as 'leadcount', actiondate 
FROM (
    SELECT 
        (
            SELECT CASE 
                WHEN (cl2.Cl_LeadStatus = 4 OR cl2.Cl_LeadStatus = 17) 
                     AND cl2.Cl_ActionDate < '".date('Y-m-d')." 00:00:00' 
                THEN 1 ELSE 0 END 
            FROM tbl_calllog cl2 
            WHERE cl2.Cl_LeadId = ld.Ld_Id 
                  AND (cl2.Cl_CallStatus = 1 OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13) 
            ORDER BY cl2.Cl_Id DESC LIMIT 1
        ) as 'leads', 
        ld.Ld_Name, 
        ld.Ld_Mobile,
        cl.Cl_Id, 
        cl.Cl_CallStatus, 
        cl.Cl_LeadStatus, 
        cl.Cl_Status,
        ld.Ld_LeadStatus, 
        '0' as 'actiondate' 
    FROM tbl_lead ld
    LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id 
         AND (cl.Cl_CallStatus = 1 OR cl.Cl_CallStatus = 12 OR cl.Cl_CallStatus = 13)
    WHERE al.Al_CallerId = $uid 
          AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)
          AND cl.Cl_Status = 'Active'
    GROUP BY ld.Ld_Id
    ORDER BY leads DESC
) as a
WHERE actiondate < '".date('Y-m-d')." 00:00:00' 
      AND leads <> 0

UNION ALL

SELECT SUM(leadcount), actiondate 
FROM (
    SELECT 
        CASE 
            WHEN (cl2.Cl_LeadStatus = 4 OR cl2.Cl_LeadStatus = 17) 
            THEN 1 ELSE 0 END as 'leadcount', 
            DATE(cl2.Cl_ActionDate) as 'actiondate' 
    FROM tbl_lead ld 
    LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 
    LEFT JOIN tbl_calllog cl2 ON cl2.Cl_LeadId = ld.Ld_Id 
         AND (cl2.Cl_CallStatus = 1 OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13)
    WHERE al.Al_CallerId = $uid 
          AND al.Al_Del = 0 
          AND cl2.Cl_ActionDate > '".date('Y-m-d')." 00:00:00'
          AND cl2.Cl_Status = 'Active'
    GROUP BY cl2.Cl_ActionDate
    ORDER BY cl2.Cl_Id DESC
) as a
WHERE a.leadcount <> 0
GROUP BY actiondate
ORDER BY actiondate ASC
";

    $result = $conn->query($sql);
    // echo $sql;
    return $result;
}



function getLastConnectedCall($lid)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_calllog cl
    WHERE cl.Cl_CallStatus IN (1,12,13) AND cl.Cl_LeadId = $lid
    ORDER BY cl.Cl_Id DESC
    LIMIT 1";

    $result = $conn->query($sql);


    return $result;
}


?>