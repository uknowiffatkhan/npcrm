<?php

if (!isset($_SESSION)) {
    session_start();
}


$baseurl="/npcrm/";   

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";


function insertActionsLog($uid, $text, $url)
{

    $conn = dbconnect();

    $sql = "INSERT INTO `tbl_actionslog`(`ALog_EmpId`, `ALog_Action`, `ALog_Url`) VALUES 
            ($uid,'$text','$url')";


    $result = $conn->query($sql);
    return $conn->insert_id;

}
function LastLogin($uid){

    $conn = dbconnect();
    $sql = "SELECT * FROM `tbl_actionslog` WHERE ALog_EmpId = $uid AND ALog_Url = '/login' ORDER BY ALog_Id DESC LIMIT 1";
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result;
}

function getProjectById($Pid){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_projects` WHERE Pr_Id = $Pid";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result;
}


function getBudgetById($budid){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_budget` WHERE Bd_Id = $budid";
//echo $sql;
    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result;
}


function getcallrule($lstatus, $cstype, $operator, $callcount)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_callslacondition` WHERE `CslaC_CallSType` = '$cstype' AND `CslaC_Operator` = '$operator' AND `CslaC_CallCount` = $callcount AND FIND_IN_SET('$lstatus', `CslaC_LeadStatus`) > 0";


    $result = $conn->query($sql);
    insertActionsLog($_SESSION["UId"], "Fetched Call rule", "");
    return $result;
}


function getUserStatus($uid)
{
    $conn = dbconnect();

    $sql = "SELECT U_Online FROM `tbl_users` WHERE `U_Id` = $uid";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    return $result["U_Online"];
}


function getUserTeam($uid)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_team` tm 
    LEFT JOIN tbl_teammap m ON m.team_id = tm.Tm_Id 
    WHERE m.tm_m_uid = $uid";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    insertActionsLog($uid, "Fetched User Team", "");
    return $result;
}
function getUserTeamLeader($tmid)
{
    $conn = dbconnect();

    $sql = "SELECT tm_m_uid AS 'TLeader' FROM tbl_teammap m
    LEFT JOIN tbl_team tm ON m.team_id = tm.Tm_Id
    WHERE m.tm_m_role = 2 AND tm.Tm_Id = $tmid";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    insertActionsLog($tmid, "Fetched User Team Leader", "");
    return $result;
}



function getCallersList()
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_users` u
    INNER JOIN tbl_team tm ON FIND_IN_SET(u.U_Id, tm.Tm_MemId) > 0
    WHERE U_TypeId = 1";

    $result = $conn->query($sql);
    return $result;
}


function getActiveCallersList()
{
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_users u
    INNER JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId
    INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
    LEFT JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
    LEFT JOIN tbl_team tm ON tm.Tm_Id = m.team_id
    WHERE u.U_Status = 'Active' AND u.U_Id <> 1 AND u.U_TypeId = 1";

    $result = $conn->query($sql);
    return $result;
}
function getActiveSaleList($search="")
{
    $conn = dbconnect();
    $w='';
    if($search != ""){
        $w = " AND (U_DisplayName LIKE '$search%' OR U_Mobile LIKE '$search%'
        OR U_EmpCode LIKE '$search%')
        ";

    }
    $sql = "SELECT * FROM tbl_users u
    INNER JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId
    INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
    LEFT JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
    LEFT JOIN tbl_team tm ON tm.Tm_Id = m.team_id
    WHERE u.U_Status = 'Active'  AND u.U_TypeId = 2  $w";

    $result = $conn->query($sql);
    return $result;
}
function getSalesVisitPlanCount($uid){
    $conn = dbconnect();
    
    $sql = "SELECT SUM(leadcount) AS 'leadcount', actiondate from ( SELECT CASE WHEN (cl2.Cl_LeadStatus = 4 OR cl2.Cl_LeadStatus = 17 ) THEN 1 ELSE 0 END as 'leadcount', DATE(cl2.Cl_ActionDate) as 'actiondate' FROM tbl_lead ld LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id LEFT JOIN tbl_calllog cl2 ON cl2.Cl_LeadId = ld.Ld_Id AND (cl2.Cl_CallStatus = 1 OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13 ) AND cl2.Cl_Status = 'Active' 
    
    WHERE al.Al_CallerId = $uid AND al.Al_Del = 0 
    
    AND cl2.Cl_ActionDate BETWEEN '" . date('Y-m-d') . " 00:00:00' AND '" . date('Y-m-d') . " 23:59:59' GROUP BY cl2.Cl_ActionDate ORDER BY cl2.Cl_Id DESC) as a WHERE a.leadcount <> 0 GROUP BY actiondate ORDER BY actiondate ASC";

    $result = $conn->query($sql);
    // echo $sql;
    $result = $result->fetch_assoc();

    return $result;
    
}
function getSalesVisitCount($uid){
    $conn = dbconnect();
    
    $sql = "SELECT SUM(leadcount) AS 'leadcount', actiondate from ( SELECT CASE WHEN (cl2.Cl_LeadStatus = 5 ) THEN 1 ELSE 0 END as 'leadcount', DATE(cl2.Cl_CreatedDate) as 'actiondate' FROM tbl_lead ld LEFT JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id LEFT JOIN tbl_calllog cl2 ON cl2.Cl_LeadId = ld.Ld_Id AND (cl2.Cl_CallStatus = 1 OR cl2.Cl_CallStatus = 12 OR cl2.Cl_CallStatus = 13 ) AND   cl2.Cl_Status = 'Active' WHERE al.Al_CallerId = $uid AND al.Al_Del = 0 AND DATE(cl2.Cl_CreatedDate) = '".date('Y-m-d')."' GROUP BY cl2.Cl_CreatedDate ORDER BY cl2.Cl_Id DESC) as a WHERE a.leadcount <> 0 GROUP BY actiondate ORDER BY actiondate ASC";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();
    // echo $sql;
    return $result;
    
}
function getAllUsers($search = "", $type = "",$role="",$page = 1, $limit = 50){
    $conn = dbconnect();
    $w = "";
    $offset = ($page - 1) * $limit;

    if ($search != "") {
        $w .= " AND (`U_EmpCode` LIKE '%$search%' OR  `U_Username` LIKE '%$search%' OR  `U_Mobile` LIKE '%$search%'  OR `Cp_Code` LIKE '%$search%' OR `Tm_Name` LIKE '%$search%' )";
    }

    if ($type != "") {
        $w .= " AND `UType_Id` = $type";
    }
    if ($role != "") {
       
        $w .= " AND `U_RoleId` = $role";
    }


    $sql = "SELECT * FROM tbl_users u
            LEFT JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId
            LEFT JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
            LEFT JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
            LEFT JOIN tbl_team tm ON tm.Tm_Id = m.team_id
            LEFT JOIN tbl_channelpartner c ON u.U_RefrenceIdCp = c.Cp_Id 
            WHERE U_Id <> 1 $w ORDER BY `U_Id` DESC, `U_Status` ASC LIMIT $limit OFFSET $offset";

    $result = $conn->query($sql);
    // echo $sql;
    return $result;
}



function getMemberByTeam($tmid)
{
    $conn = dbconnect();

    $sql = "WITH RECURSIVE TeamHierarchy AS (
            SELECT 
                t.Tm_Id AS TeamId,
                t.Tm_Id AS Team_Count,
                t.Tm_Name AS TeamName,
                t.Tm_parent_team_id AS ParentTeamId,
                u.U_Id AS MemberId,
                u.U_TypeId AS MemberType,
                u.U_Status AS Mem_Status
            FROM 
                tbl_team t
            LEFT JOIN 
                tbl_teammap m ON t.Tm_Id = m.Team_Id
            INNER JOIN 
                tbl_users u ON u.U_Id = m.tm_m_uid
            WHERE 
                t.Tm_Id = $tmid 

            UNION ALL

            SELECT 
                child.Tm_Id AS TeamId,
                child.Tm_Id AS Team_Count,
                child.Tm_Name AS TeamName,
                child.Tm_parent_team_id AS ParentTeamId,
                u.U_Id AS MemberId,
                u.U_TypeId AS MemberType,
                u.U_Status AS Mem_Status

            FROM 
                tbl_team child
            LEFT JOIN 
                tbl_teammap m ON child.Tm_Id = m.Team_Id
            INNER JOIN 
                tbl_users u ON u.U_Id = m.tm_m_uid 
            INNER JOIN 
                TeamHierarchy th ON child.Tm_parent_team_id = th.TeamId
        )

            SELECT 
                TeamId,
                TeamId AS Team_Count,
                TeamName,
                ParentTeamId,
                MemberId,
                MemberType,
                Mem_Status

            FROM
                TeamHierarchy
            WHERE MemberType = 1 AND Mem_Status = 'Active'
            ORDER BY 
            TeamId, MemberId";

    $result = $conn->query($sql);
    return $result;
}


function getMemberByProject($pid)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM tbl_assignprojmem apm
    INNER JOIN tbl_users u ON u.U_Id = apm.Apm_AssignTo AND apm.Apm_AssignType = 'user'
    LEFT JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
    LEFT JOIN tbl_team tm ON tm.Tm_Id = m.team_id
    WHERE apm.Apm_ProjectId = $pid AND u.U_TypeId = 1  AND u.U_Status = 'Active'";

    $result = $conn->query($sql);
    return $result;
}

function getWeekOff($uid)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_holiday`
    WHERE H_Type = 'weekoff' AND H_Uid = $uid AND H_Status = 'Active'";

    $result = $conn->query($sql);
    return $result;
}

function getLeaveDate($uid, $date)
{
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_holiday`
    WHERE H_Type = 'leave' AND H_Uid = $uid AND H_Date = '$date' AND H_Status = 'Active'";

    $result = $conn->query($sql);
    return $result->num_rows;
}


function getNonWeekOffLeaveDate($uid, $date = "")
{


    if ($date != "") {
        $d = date("Y-m-d", strtotime($date));

        $wk = getWeekOff($uid);
        $weekoff = 0;
        if ($wk->num_rows > 0) {
            while ($w = $wk->fetch_assoc()) {
                $weekoff = (strval(date('Y-m-d', strtotime("next " . $w["H_Date"]))) == strval($d) ? 1 : 0);
                //echo $d."<br/>";
                if ($weekoff > 0) {
                    break;
                }
            }
        }


        $leave = getLeaveDate($uid, date("Y-m-d", strtotime($d)));

        if ($weekoff == 0 && $leave == 0) {
            return $d;
        } else {
            $i = 0;
            $d = date("Y-m-d", strtotime($date));
            while (++$i) {
                $wk = getWeekOff($uid);
                $d = date("Y-m-d", strtotime("+1 days", strtotime($d)));
                $weekoff = 0;
                if ($wk->num_rows > 0) {
                    while ($w = $wk->fetch_assoc()) {
                        $weekoff = (strval(date('Y-m-d', strtotime("next " . $w["H_Date"]))) == strval($d) ? 1 : 0);
                        if ($weekoff > 0) {
                            break;
                        }
                    }
                }

                //$weekoff = (date('Y-m-d', strtotime("next " . getWeekOff($uid))) == $d ? 1 : 0);
                $leave = getLeaveDate($uid, date("Y-m-d", strtotime($d)));

                if ($weekoff == 0 && $leave == 0) {
                    return $d;
                }
            }
        }
    } else {
        $i = 0;
        while (++$i) {
            $d = date("Y-m-d", strtotime("+" . $i . " days"));
            $wk = getWeekOff($uid);
            $weekoff = 0;
            if ($wk->num_rows > 0) {
                while ($w = $wk->fetch_assoc()) {
                    $weekoff = (strval(date('Y-m-d', strtotime("next " . $w["H_Date"]))) == strval($d) ? 1 : 0);
                    if ($weekoff > 0) {
                        break;
                    }
                }
            }
            //$weekoff = (date('Y-m-d', strtotime("next " . getWeekOff($uid))) == $d ? 1 : 0);
            $leave = getLeaveDate($uid, date("Y-m-d", strtotime($d)));

            if ($weekoff == 0 && $leave == 0) {
                return $d;
            }
        }
    }



}


function checkLeaveorweekoff($uid, $date)
{
    $d = date("Y-m-d", strtotime($date));

    $wk = getWeekOff($uid);
    $weekoff = 0;
    if ($wk->num_rows > 0) {
        while ($w = $wk->fetch_assoc()) {
            $weekoff = (strtolower(date('l', strtotime($d))) == strtolower($w["H_Date"]) ? 1 : 0);
            //echo $d."<br/>";
            if ($weekoff > 0) {
                break;
            }
        }
    }


    $leave = getLeaveDate($uid, date("Y-m-d", strtotime($d)));

    if ($weekoff == 0 && $leave == 0) {
        return "true";
    }
    else{
        return "false";
    }
}


?>