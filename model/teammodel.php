<?php

if (!isset($_SESSION)) {
    session_start();
}



include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";


function getTeamMembers($tid){
    $conn = dbconnect();
    $sql = "WITH RECURSIVE TeamHierarchy AS (
                    SELECT 
                        t.Tm_Id AS TeamId,
    					t.Tm_Id AS Team_Count,
                        t.Tm_Name AS TeamName,
                        t.Tm_parent_team_id AS ParentTeamId,
                        m.tm_m_uid AS MemberId,
     					m.tm_m_id AS Member,
                        1 AS Level
                    FROM 
                        tbl_team t
                    LEFT JOIN 
                        tbl_teammap m ON t.Tm_Id = m.Team_Id
                    WHERE 
                        t.Tm_Id = $tid

                    UNION ALL

                    SELECT 
                        child.Tm_Id AS TeamId,
    					child.Tm_Id AS Team_Count,
                        child.Tm_Name AS TeamName,
                        child.Tm_parent_team_id AS ParentTeamId,
                        m.tm_m_uid AS MemberId,
         				m.tm_m_id AS Member,
                        th.Level + 1 AS Level
                    FROM 
                        tbl_team child
                    LEFT JOIN 
                        tbl_teammap m ON child.Tm_Id = m.Team_Id
                    INNER JOIN 
                        TeamHierarchy th ON child.Tm_parent_team_id = th.TeamId
            )

                SELECT 
                    TeamId,
                    COUNT(DISTINCT TeamId) AS Team_Count,
                    TeamName,
                    ParentTeamId,
                    GROUP_CONCAT(DISTINCT MemberId) MemberId ,
                    COUNT(DISTINCT Member) Member ,

                    Level
                FROM 
                    TeamHierarchy
                ORDER BY 
                    Level, TeamId, MemberId";

 $result = $conn->query($sql);
 $result =$result->fetch_assoc();
 return $result;

}

function lddeatails($uid,$type="",$sdate,$edate) {
    $conn = dbconnect();
    $w="";
    $j = " AND al.Al_CreatedDate >= '" . date('Y-m-d 00:00:00', strtotime($sdate)) . "' AND al.Al_CreatedDate <= '" . date('Y-m-d 23:59:59', strtotime($edate)) . "'";
    if($type == ""){
        $sql = "SELECT 'Leads' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#6c757d' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) 
            AND al.Al_Del = 0
            $j

            UNION ALL

            SELECT 'newleads' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#0d6efd' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) AND ld.Ld_LeadStatus IN (1) AND ld.Ld_LastCallDate IS NULL AND al.Al_Del = 0
            $j

            UNION ALL 

            SELECT 'Visit planned' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#198754' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) AND ld.Ld_LeadStatus IN (4,17)  AND al.Al_Del = 0
            $j


            UNION ALL 

            SELECT 'Site Visited' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#dc3545' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) AND ld.Ld_LeadStatus IN (5)  AND al.Al_Del = 0
            $j

            UNION ALL 

            SELECT 'Booked' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#ffc107' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) AND ld.Ld_LeadStatus IN (11)  AND al.Al_Del = 0
            $j

            UNION ALL 

            SELECT 'Interested' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#0dcaf0' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) AND ld.Ld_LeadStatus IN (3)  AND al.Al_Del = 0
            $j

            UNION ALL 

            SELECT 'Junk' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#0d6efd' AS Color
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) AND ld.Ld_LeadStatus IN (8,15)  AND al.Al_Del = 0
            $j
            
            UNION ALL

            SELECT 'Missed' AS LeadType, COUNT(ld.Ld_Id) AS Count, GROUP_CONCAT(ld.Ld_Id) AS LEADIDS
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            INNER JOIN tbl_assignleadtime alt ON alt.Alt_LdId = al.Al_LeadId AND alt.Alt_Uid = al.Al_CallerId AND alt.Alt_AssignTime < CURDATE() AND alt.Alt_Del = 0
            WHERE al.Al_CallerId IN ($uid) AND alt.Alt_Uid IN ($uid) AND ld.Ld_LeadStatus IN (5)";
    }else{

        if ($type == 1) {
            $w .= " UNION ALL 
                    SELECT 'New' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#664d03' AS Color, '2' AS Odr
                    FROM tbl_lead ld
                    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
                    WHERE al.Al_CallerId IN ($uid) 
                    AND ld.Ld_LeadStatus = 1 
                    AND ld.Ld_LastCallDate IS NULL 
                    AND al.Al_Del = 0 
                    $j
                    
                    
                    UNION ALL
            
                    SELECT 'Called Missed' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#ff3e1d' AS Color , '4' AS Odr
                    FROM tbl_lead ld
                    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
                    INNER JOIN tbl_assignleadtime alt ON alt.Alt_LdId = al.Al_LeadId 
                        AND alt.Alt_Uid = al.Al_CallerId 
                        AND alt.Alt_AssignTime < CURDATE() 
                        AND alt.Alt_Del = 0
                    WHERE al.Al_CallerId IN ($uid) 
                    AND alt.Alt_Uid IN ($uid) 
                    AND ld.Ld_LeadStatus IN (2, 12)
                    $j
                    ";
        } else {
        $w .= " UNION ALL 
                SELECT 'Site Visited' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#dc3545' AS Color, '3' AS Odr
                FROM tbl_lead ld
                INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
                WHERE al.Al_CallerId IN ($uid) 
                AND ld.Ld_LeadStatus = 5 
                AND al.Al_Del = 0
                $j
                ";
    }

    $sql = "SELECT 'Leads' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#0d6efd' AS Color, '1' AS Odr
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) 
            AND al.Al_Del = 0
            $j

            UNION ALL
            
            SELECT 'Visit planned' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#198754' AS Color, '3' AS Odr
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) 
            AND ld.Ld_LeadStatus IN (4, 17) 
            AND al.Al_Del = 0
            $j

            UNION ALL
            
            SELECT 'Interested' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#842029' AS Color, '6' AS Odr
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) 
            AND ld.Ld_LeadStatus = 3 
            AND al.Al_Del = 0
            $j

            UNION ALL
            
            SELECT 'Booked' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#6610f2' AS Color, '7' AS Odr
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) 
            AND ld.Ld_LeadStatus = 11 
            AND al.Al_Del = 0
            $j

            UNION ALL
            
            SELECT 'Junk' AS LeadType, COUNT(ld.Ld_Id) AS Count, '#6c757d' AS Color, '8' AS Odr
            FROM tbl_lead ld
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            WHERE al.Al_CallerId IN ($uid) 
            AND ld.Ld_LeadStatus IN (8, 15) 
            AND al.Al_Del = 0 
            $w

            ORDER BY Odr";

    }
    $result = $conn->query($sql);
    // echo $sql;
    
    return $result;
}


function MemberTypeCount($uid){
    $conn = dbconnect();
    $sql="SELECT 'Caller' AS Type, COUNT(*) AS Count 
	FROM tbl_users
	WHERE U_Id IN ($uid)
    AND U_TypeId = 1 
    AND U_Del = 0
  
    UNION ALL 

    SELECT 'Sales' AS Type, COUNT(*) AS Count 
        FROM tbl_users
        WHERE U_Id IN ($uid)
        AND U_TypeId = 2 
        AND U_Del = 0

    UNION ALL 

    SELECT 'Sourcing' AS Type, COUNT(*) AS Count 
        FROM tbl_users
        WHERE U_Id IN ($uid)
        AND U_TypeId = 5 
    
    UNION ALL

    SELECT 'Channel Partner' AS Type, COUNT(*) AS Count 
        FROM tbl_users
        WHERE U_Id IN ($uid)
        AND U_TypeId = 4";

    $result = $conn->query($sql);
    return $result;

}

function getTeamDetail($tid="",$ptid=""){

    $conn = dbconnect();
    $w="";
    if (strpos($tid, "-") !== false) {
        $t = explode("-", $tid);
        $tid = $t[0];
        $ptid = $t[1];
    }
    if (strpos($ptid, "-") !== false) {
        $t = explode("-", $ptid);
        $tid = $t[0];
        $ptid = $t[1];
    }
    if (!empty($tid)) {
        $w .= " AND Tm_Id = '$tid' ";
    }

    if (!empty($ptid)) {
        $w .= " AND Tm_parent_team_id = '$ptid' ";
    } else {
        $w .= " AND Tm_parent_team_id IS NULL ";
    }

    $sql = "SELECT * FROM `tbl_team` WHERE Tm_Status = 'Active' $w ";
    $result = $conn->query($sql);
    //echo $sql;
    return $result;
}

function getSubTeamDetail($tid){

    $conn = dbconnect();
    $sql = "SELECT t.* FROM `tbl_team` t 
    INNER JOIN tbl_teammap m ON t.Tm_Id = m.team_id  
    WHERE t.Tm_parent_team_id = $tid GROUP BY t.Tm_Id";
    $result = $conn->query($sql);
    
    return $result;
}

function getTeamMembersDetail($tid){

    $conn = dbconnect();

    $sql = " SELECT * FROM `tbl_teammap` tm INNER JOIN tbl_users u ON tm.tm_m_uid = u.U_Id LEFT JOIN tbl_roles r ON tm.tm_m_role = r.Rl_Id LEFT JOIN tbl_usertype ut ON u.U_TypeId = ut.UType_Id WHERE team_id = $tid ORDER BY tm.tm_m_role ";
    // echo $sql;
    $result = $conn->query($sql);
    return $result;
}


?>