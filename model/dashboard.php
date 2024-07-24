<?php 

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "layouts/auth.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";


function getStatusWiseCounts($uid)
{

    $conn = dbconnect();

    $sql = "SELECT DISTINCT ls.Ls_Name,
    COALESCE(ls_parent.Ls_Name,'') AS Parent_Name,
    COUNT(ls.Ls_Id) as 'totals' FROM tbl_leadstatus ls
    LEFT JOIN tbl_leadstatus ls_parent ON ls.Ls_parent = ls_parent.Ls_Id
    INNER JOIN tbl_lead ld ON ld.Ld_LeadStatus = ls.Ls_Id
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0
    GROUP BY ls.Ls_Id, ls.Ls_Name";

    // echo $sql;
    $result = $conn->query($sql);
    insertActionsLog($uid, "Status Wise Counts Fetched", "");
    return $result;

}
function getOverview($uid)
{

    $conn = dbconnect();

    $sql = "SELECT DISTINCT ls.Ls_Name, COUNT(ls.Ls_Id) as 'totals' FROM tbl_leadstatus ls INNER JOIN tbl_lead ld ON ld.Ld_LeadStatus = ls.Ls_Id INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id WHERE al.Al_Del = 0 AND ls.Ls_Id IN (4,5,17,11) GROUP BY ls.Ls_Id, ls.Ls_Name";

    // echo $sql;
    $result = $conn->query($sql);
    insertActionsLog($uid, "Overview Wise Counts Fetched", "");
    return $result;

}

function getConfirmCp($uid)
{
    $conn = dbconnect();

    $sql ="SELECT DISTINCT COUNT(cp.Cp_Id) as 'totals' FROM tbl_channelpartner cp
    INNER JOIN tbl_assigncpsource ACS ON ACS.AC_CpId = cp.Cp_Id
    WHERE ACS.AC_UId = $uid AND ACS.AC_Del = 0";
    $result = $conn->query($sql);
    insertActionsLog($uid,"Status Wise Counts Fetched", "");
    return $result;

}

function getcpleads($uid)
{
    $conn = dbconnect();

    $sql = "SELECT DISTINCT COUNT(ld.Ld_Id) as 'totals' FROM tbl_lead ld
    LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    LEFT JOIN tbl_users u ON u.U_Id = al.Al_CallerId
    LEFT JOIN tbl_channelpartner cp ON cp.Cp_Id = u.U_RefrenceIdCp
    LEFT JOIN tbl_assigncpsource acp ON acp.AC_CpId = cp.Cp_Id
    WHERE acp.AC_UId = $uid";
    $result = $conn->query($sql);
    insertActionsLog($uid,"Status Wise Counts Fetched", "");
    return $result;
}
 
    
function getNewCp($uid)
{
    $conn = dbconnect();

    $w='';

    if($uid !=""){
            $w .= " OR acp.AC_UId = $uid";
        }

            $sql="SELECT 
            cp.Cp_Id,
            cp.Cp_Code,
            cp.Cp_Name,
            cp.Cp_CreatedDate,
            COUNT(ld.Ld_Id) AS 'leads_count',
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
                acp.AC_UId IS NULL $w
            GROUP BY 
            cp.Cp_Id, cp.Cp_CreatedDate
            ORDER BY 
            cp.Cp_CreatedDate DESC
            LIMIT 10;";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Channel Partner Lead Fetched", "");
    return $result;
}




function getInterestWiseCounts($uid)
{

    $conn = dbconnect();

    $sql = "SELECT DISTINCT rt.Rt_Name, COUNT(rt.Rt_Id) as 'totals' FROM tbl_assignlead al
    INNER JOIN tbl_lead ld ON ld.Ld_Id = al.Al_LeadId
    INNER JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0
    GROUP BY rt.Rt_Id, rt.Rt_Name";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Interest Wise Counts Fetched", "");
    return $result;

}


function getSourceWiseCounts($uid)
{

    $conn = dbconnect();

    $sql = "SELECT DISTINCT sc.Sc_Name, COUNT(sc.Sc_Id) as 'totals' FROM tbl_source sc
    INNER JOIN tbl_lead ld ON ld.Ld_Source = sc.Sc_Id
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0
    GROUP BY sc.Sc_Id, sc.Sc_Name";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Status Wise Counts Fetched", "");
    return $result;

}



function getLeads10($uid)
{

    $conn = dbconnect();

    $sql = "SELECT DISTINCT ld.*, sc.*, ls.*, rt.*, (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id) as 'callcount' FROM tbl_lead ld
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    INNER JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_calllog cl ON cl.Cl_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0
    ORDER BY ld.Ld_ModifiedDate DESC
    LIMIT 10";
    $result = $conn->query($sql);
    insertActionsLog($uid, "Status Wise Counts Fetched", "");
    return $result;

}



function getCallsCounts($uid, $sdate, $edate)
{

    $conn = dbconnect();
    
    $sql = "SELECT DISTINCT cs.Cs_Type as 'label', COUNT(Cl_Id) as 'totals', (SELECT DISTINCT COUNT(Cl_Id) as 'totals' FROM tbl_calllog cl
    WHERE cl.Cl_CreatedId = $uid AND cl.Cl_CallStatus <> 0 AND cl.Cl_CreatedDate between '".$sdate." 00:00:00' AND '".$edate." 23:59:00') as 'all' FROM tbl_calllog cl
    INNER JOIN tbl_callstatus cs ON cs.Cs_Id = cl.Cl_CallStatus
    WHERE cl.Cl_CreatedId = $uid AND cl.Cl_CallStatus <> 0 AND cl.Cl_CreatedDate between '".$sdate." 00:00:00' AND '".$edate." 23:59:00'
    GROUP BY cs.Cs_Type
    ORDER BY cs.Cs_Type";
    $result = $conn->query($sql);
    //echo $sql;
    insertActionsLog($uid, "Call Logs Counts Fetched", "");
    return $result;

}



function getTodaysScope($uid, $date){
    $conn = dbconnect();

    //Total Call
    $sql = "SELECT COUNT(ld.Ld_Id) as 'leadcount', 'Total Calls' as 'label', GROUP_CONCAT(ld.Ld_Id) AS 'LEADIDS' FROM tbl_lead ld
    INNER JOIN 
        tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    INNER JOIN 
        tbl_assignleadtime alt on alt.Alt_LdId = al.Al_LeadId 
        AND DATE(alt.Alt_AssignTime) = '$date' 
        AND al.Al_Del = 0
    WHERE al.Al_CallerId = $uid 
        AND alt.Alt_Uid = $uid 
        AND alt.Alt_Del = 0
    UNION ALL

    SELECT COUNT(ld.Ld_Id) as 'leadcount', 'First Half' as 'label', GROUP_CONCAT(ld.Ld_Id) AS 'LEADIDS' FROM tbl_lead ld
    INNER JOIN 
        tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    INNER JOIN 
        tbl_assignleadtime alt ON alt.Alt_LdId = al.Al_LeadId 
        AND al.Al_Del = 0
        AND alt.Alt_AssignTime BETWEEN '$date 10:00:00' AND '$date 13:59:59' 
    WHERE 
        al.Al_CallerId = $uid 
        AND alt.Alt_Uid = $uid
        AND alt.Alt_Del = 0
 
    UNION ALL

    SELECT COUNT(ld.Ld_Id) AS 'leadcount', 'Second Half' AS 'label', GROUP_CONCAT(ld.Ld_Id) AS 'LEADIDS' FROM tbl_lead ld
    INNER JOIN 
        tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    INNER JOIN 
        tbl_assignleadtime alt ON alt.Alt_LdId = al.Al_LeadId 
        AND alt.Alt_AssignTime BETWEEN '$date 13:59:59' AND '$date 23:59:59' 
        AND al.Al_Del = 0
    WHERE  
        al.Al_CallerId = $uid 
        AND alt.Alt_Uid = $uid 
        AND alt.Alt_Del = 0

    UNION ALL

    SELECT COUNT(ld.Ld_Id) as 'leadcount', 'Missed' as 'label', GROUP_CONCAT(ld.Ld_Id) AS 'LEADIDS' FROM tbl_lead ld
    INNER JOIN 
        tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 
    INNER JOIN 
        tbl_assignleadtime alt ON alt.Alt_LdId = al.Al_LeadId 
        AND alt.Alt_Uid = al.Al_CallerId 
        AND alt.Alt_AssignTime < '".date('Y-m-d')."' 
        AND alt.Alt_Del = 0 
    WHERE 
        al.Al_CallerId = $uid 
        AND alt.Alt_Uid = $uid  
        AND (ld.Ld_LeadStatus IN (1, 2, 3, 4, 5,12,17));";
        
    $result = $conn->query($sql);
    // echo $sql;
    insertActionsLog($uid, "Todays Scope Counts Fetched", "");
    return $result;
}

function getLeadDetails($lid){
    $conn = dbconnect();
    $sql = "SELECT ld.*,ls.*, sc.*,rt.*,
    (SELECT COUNT(Cl_Id) FROM tbl_calllog WHERE Cl_LeadId = ld.Ld_Id AND Cl_CallStatus <> 0) as callcount
FROM tbl_lead ld
INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
WHERE ld.Ld_Id IN ($lid)
";
    $result = $conn->query($sql);
    return $result;

}
function getNewLeads($uid){
    $conn = dbconnect();
    $sql = "SELECT COUNT(ld.Ld_Id) as 'newleads' FROM tbl_lead ld
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND ld.Ld_LeadStatus = 1 AND ld.Ld_LastCallDate IS NULL AND al.Al_Del = 0";
    $result = $conn->query($sql);
    return $result;
}

function getNewUpdateLeads($uid){
    $conn = dbconnect();
    $sql = "SELECT COUNT(ld.Ld_Id) as 'newupdateleads' FROM tbl_lead ld
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    WHERE al.Al_CallerId = $uid AND `Ld_Del` = 0 AND al.Al_Del = 0 AND ld.Ld_NewUpdate = 1";
    $result = $conn->query($sql);
    return $result;
}


function getTodaysReportforAdmin($sdate, $edate){
    $conn = dbconnect();

    $sql = "SELECT COUNT(s.total) as 'totallead', SUM(s.total) as 'totalcalls',GROUP_CONCAT(s.Ld_Id) AS 'LeadIDs', s.* FROM (
        SELECT COUNT(cl.Cl_Id) 'total',
        (SELECT COUNT(cl.Cl_Id) FROM tbl_calllog cl
        LEFT JOIN tbl_callstatus cs ON cs.Cs_Id = cl.Cl_CallStatus
        WHERE cs.Cs_Type = 'Connected' AND cl.Cl_CreatedId = u.U_Id AND cl.Cl_CreatedDate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59') as 'Connected', 
        (SELECT COUNT(cl.Cl_Id) FROM tbl_calllog cl
        LEFT JOIN tbl_callstatus cs ON cs.Cs_Id = cl.Cl_CallStatus
        WHERE cs.Cs_Type = 'Disconnected' AND cl.Cl_CreatedId = u.U_Id AND cl.Cl_CreatedDate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59') as 'Disconnected',
        u.U_Id, u.U_Online, u.U_DisplayName,ld.Ld_Id FROM tbl_calllog cl
        INNER JOIN tbl_users u ON u.U_Id = cl.Cl_CreatedId
        LEFT JOIN tbl_callstatus cs ON cs.Cs_Id = cl.Cl_CallStatus
        LEFT JOIN tbl_lead ld ON ld.Ld_Id = cl.Cl_LeadId
        WHERE cl.Cl_CreatedDate BETWEEN '$sdate 00:00:00' AND '$edate 23:59:59' AND u.U_Id <> 1
        GROUP BY u.U_Id, cl.Cl_LeadId
        ) as s
        GROUP BY s.U_Id";
    $result = $conn->query($sql);
    return $result;
}


function getLeadOverviewAdminBySource($sdate, $edate, $uid = 0){
    $conn = dbconnect();

    $sql = "SELECT *, 
    (SELECT COUNT(ld.Ld_Id) FROM tbl_lead ld WHERE ld.Ld_Source = sc.Sc_Id AND ld.Ld_LeadDate BETWEEN '$sdate' AND '$edate') as 'leads',
    (SELECT GROUP_CONCAT(ld.Ld_Id) FROM tbl_lead ld WHERE ld.Ld_Source = sc.Sc_Id AND ld.Ld_LeadDate BETWEEN '$sdate' AND '$edate') as 'leadsid',
    
    (SELECT COUNT(ld1.Ld_Id) FROM tbl_lead ld1 WHERE ld1.Ld_LeadStatus = 1 AND ld1.Ld_Source = sc.Sc_Id AND ld1.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld1.Ld_LeadStatus) as 'new',
    (SELECT GROUP_CONCAT(ld1.Ld_Id) FROM tbl_lead ld1 WHERE ld1.Ld_LeadStatus = 1 AND ld1.Ld_Source = sc.Sc_Id AND ld1.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld1.Ld_LeadStatus) as 'newleadsid',
   

    (SELECT COUNT(ld2.Ld_Id) FROM tbl_lead ld2 WHERE ld2.Ld_LeadStatus = 2 AND ld2.Ld_Source = sc.Sc_Id AND ld2.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld2.Ld_LeadStatus) as 'followup',
    (SELECT GROUP_CONCAT(ld2.Ld_Id) FROM tbl_lead ld2 WHERE ld2.Ld_LeadStatus = 2 AND ld2.Ld_Source = sc.Sc_Id AND ld2.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld2.Ld_LeadStatus) as 'followupleadsid',



    (SELECT COUNT(ld3.Ld_Id) FROM tbl_lead ld3 WHERE ld3.Ld_LeadStatus = 3 AND ld3.Ld_Source = sc.Sc_Id AND ld3.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld3.Ld_LeadStatus) as 'interested',
    (SELECT GROUP_CONCAT(ld3.Ld_Id) FROM tbl_lead ld3 WHERE ld3.Ld_LeadStatus = 3 AND ld3.Ld_Source = sc.Sc_Id AND ld3.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld3.Ld_LeadStatus) as 'interestedleadsid',

    (SELECT COUNT(ld4.Ld_Id) FROM tbl_lead ld4 WHERE ld4.Ld_LeadStatus = 4 AND ld4.Ld_Source = sc.Sc_Id AND ld4.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld4.Ld_LeadStatus) as 'visitplan',
    (SELECT GROUP_CONCAT(ld4.Ld_Id) FROM tbl_lead ld4 WHERE ld4.Ld_LeadStatus = 4 AND ld4.Ld_Source = sc.Sc_Id AND ld4.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld4.Ld_LeadStatus) as 'visitplanleadsid',

    (SELECT COUNT(ld5.Ld_Id) FROM tbl_lead ld5 WHERE ld5.Ld_LeadStatus = 5 AND ld5.Ld_Source = sc.Sc_Id AND ld5.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld5.Ld_LeadStatus) as 'visited',
    (SELECT GROUP_CONCAT(ld5.Ld_Id) FROM tbl_lead ld5 WHERE ld5.Ld_LeadStatus = 5 AND ld5.Ld_Source = sc.Sc_Id AND ld5.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld5.Ld_LeadStatus) as 'visitedleadsid',



    (SELECT COUNT(ld6.Ld_Id) FROM tbl_lead ld6 LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld6.Ld_Id WHERE ld6.Ld_Source = sc.Sc_Id AND cl.Cl_Id IS NULL AND ld6.Ld_LeadDate BETWEEN '$sdate' AND '$edate') as 'nocall',
    (SELECT GROUP_CONCAT(ld6.Ld_Id) FROM tbl_lead ld6 LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld6.Ld_Id WHERE ld6.Ld_Source = sc.Sc_Id AND cl.Cl_Id IS NULL AND ld6.Ld_LeadDate BETWEEN '$sdate' AND '$edate') as 'nocallleadsid',

    (SELECT COUNT(ld7.Ld_Id) FROM tbl_lead ld7 WHERE ld7.Ld_LeadStatus = 6 AND ld7.Ld_Source = sc.Sc_Id AND ld7.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld7.Ld_LeadStatus) as 'notinterested',
    (SELECT GROUP_CONCAT(ld7.Ld_Id) FROM tbl_lead ld7 WHERE ld7.Ld_LeadStatus = 6 AND ld7.Ld_Source = sc.Sc_Id AND ld7.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld7.Ld_LeadStatus) as 'notinterestedleadsid',

    (SELECT COUNT(ld8.Ld_Id) FROM tbl_lead ld8 WHERE ld8.Ld_LeadStatus = 7 AND ld8.Ld_Source = sc.Sc_Id AND ld8.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld8.Ld_LeadStatus) as 'hold',
    (SELECT GROUP_CONCAT(ld8.Ld_Id) FROM tbl_lead ld8 WHERE ld8.Ld_LeadStatus = 7 AND ld8.Ld_Source = sc.Sc_Id AND ld8.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld8.Ld_LeadStatus) as 'holdleadsid',

    (SELECT COUNT(ld9.Ld_Id) FROM tbl_lead ld9 WHERE ld9.Ld_LeadStatus = 8 AND ld9.Ld_Source = sc.Sc_Id AND ld9.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld9.Ld_LeadStatus) as 'junk',
    (SELECT GROUP_CONCAT(ld9.Ld_Id) FROM tbl_lead ld9 WHERE ld9.Ld_LeadStatus = 8 AND ld9.Ld_Source = sc.Sc_Id AND ld9.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld9.Ld_LeadStatus) as 'junkleadsid'

    FROM tbl_source sc
    GROUP BY sc.Sc_Id
    ORDER BY leads DESC";
    $result = $conn->query($sql);
    return $result;
}


function getLeadOverviewAdminByStatus($sdate, $edate,$uid){
    $conn = dbconnect();

    $sql = "SELECT *, 
    (SELECT COUNT(ld.Ld_Id) FROM tbl_lead ld WHERE ld.Ld_Source = sc.Sc_Id AND ld.Ld_LeadDate BETWEEN '$sdate' AND '$edate') as 'leads',
    (SELECT COUNT(ld1.Ld_Id) FROM tbl_lead ld1 WHERE ld1.Ld_LeadStatus = 1 AND ld1.Ld_Source = sc.Sc_Id AND ld1.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld1.Ld_LeadStatus) as 'new',
    (SELECT COUNT(ld2.Ld_Id) FROM tbl_lead ld2 WHERE ld2.Ld_LeadStatus = 2 AND ld2.Ld_Source = sc.Sc_Id AND ld2.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld2.Ld_LeadStatus) as 'followup',
    (SELECT COUNT(ld3.Ld_Id) FROM tbl_lead ld3 WHERE ld3.Ld_LeadStatus = 3 AND ld3.Ld_Source = sc.Sc_Id AND ld3.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld3.Ld_LeadStatus) as 'interested',
    (SELECT COUNT(ld4.Ld_Id) FROM tbl_lead ld4 WHERE ld4.Ld_LeadStatus = 4 AND ld4.Ld_Source = sc.Sc_Id AND ld4.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld4.Ld_LeadStatus) as 'visitplan',
    (SELECT COUNT(ld5.Ld_Id) FROM tbl_lead ld5 WHERE ld5.Ld_LeadStatus = 5 AND ld5.Ld_Source = sc.Sc_Id AND ld5.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld5.Ld_LeadStatus) as 'visited',
    (SELECT COUNT(ld6.Ld_Id) FROM tbl_lead ld6 LEFT JOIN tbl_calllog cl ON cl.Cl_LeadId = ld6.Ld_Id WHERE ld6.Ld_Source = sc.Sc_Id AND cl.Cl_Id IS NULL AND ld6.Ld_LeadDate BETWEEN '$sdate' AND '$edate') as 'nocall',
    (SELECT COUNT(ld7.Ld_Id) FROM tbl_lead ld7 WHERE ld7.Ld_LeadStatus = 6 AND ld7.Ld_Source = sc.Sc_Id AND ld7.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld7.Ld_LeadStatus) as 'notinterested',
    (SELECT COUNT(ld8.Ld_Id) FROM tbl_lead ld8 WHERE ld8.Ld_LeadStatus = 7 AND ld8.Ld_Source = sc.Sc_Id AND ld8.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld8.Ld_LeadStatus) as 'hold',
    (SELECT COUNT(ld9.Ld_Id) FROM tbl_lead ld9 WHERE ld9.Ld_LeadStatus = 8 AND ld9.Ld_Source = sc.Sc_Id AND ld9.Ld_LeadDate BETWEEN '$sdate' AND '$edate' GROUP BY ld9.Ld_LeadStatus) as 'junk'
    FROM tbl_source sc
    GROUP BY sc.Sc_Id
    ORDER BY leads DESC";
    $result = $conn->query($sql);
    return $result;
}


function getCallLogsDetByUID($sdate, $edate,$uid){
    $conn = dbconnect();

    $sql = "SELECT COUNT(cl.Cl_Id) as 'counts',
    (SELECT COUNT(cl.Cl_Id)
    FROM tbl_calllog cl
    WHERE cl.Cl_CreatedDate BETWEEN '$sdate' AND '$edate' AND cl.Cl_CreatedId = $uid AND cl.Cl_CallStatus = 1 AND cl.Cl_LeadStatus = ls.Ls_Id
    GROUP BY cl.Cl_LeadStatus) as 'Connected',
    (SELECT COUNT(cl.Cl_Id)
    FROM tbl_calllog cl
    WHERE cl.Cl_CreatedDate BETWEEN '$sdate' AND '$edate' AND cl.Cl_CreatedId = $uid AND cl.Cl_CallStatus <> 1 AND cl.Cl_LeadStatus = ls.Ls_Id
    GROUP BY cl.Cl_LeadStatus) as 'Disconnected'
    , cl.Cl_LeadStatus, ls.Ls_Name
    FROM tbl_calllog cl
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = cl.Cl_LeadStatus
    WHERE cl.Cl_CreatedDate BETWEEN '$sdate' AND '$edate' AND cl.Cl_CreatedId = $uid
    GROUP BY cl.Cl_LeadStatus";

    $result = $conn->query($sql);
    return $result;
}



?>