<?php  

if(!isset($_SESSION)){
    session_start();
}
$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'].$baseurl ."config/encrypter.php";
include_once $_SERVER['DOCUMENT_ROOT'].$baseurl ."config/db.php";
include_once $_SERVER['DOCUMENT_ROOT'].$baseurl ."layouts/auth.php";


function getSource(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_source` WHERE Sc_Del = 0";
    $result = $conn->query($sql);
    return $result;

}
#cp_list source wise
function getSourcebyData($stats, $src, $int, $uid, $dateby, $sdate, $edate, $search, $leadtype,$misc=''){
    $conn = dbconnect();

    $w = $j=$g= "";
    if ($stats != "") {
        if($misc == "missed" && $stats == 4){
            $w = $w . " AND (ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $stats == 1){
            $w = $w . " AND Ls_Id IN ($stats) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stats)";
        }
        
    }

    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }

  
  	if($src != ""){
        $w = $w . " AND Sc_Id in ($src)";
    }

    if($int != ""){
        $w = $w . " AND Rt_Id in ($int)";
    }
  
  	if($dateby == "lead"){
        $w = $w . " AND Ld_LeadDate between '".$sdate."' AND '".$edate."'";
    }
    else if($dateby == "lastcall"){
        $w = $w . " AND Ld_LastCallDate between '".$sdate."' AND '".$edate."'";
    }else if ($dateby == "visitplan") {
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
  
  	if($search != ""){
        $w = $w . " AND (Ld_Name LIKE '%".$search."%' OR Ld_Mobile LIKE '%".$search."%' OR Ld_Email LIKE '%".$search."%' OR Ld_Pincode LIKE '%".$search."%')";
    }

    if ($leadtype != "") {
        $w .= " AND Ld_leadtype = $leadtype"; 
    }else{
        $w .= " AND Ld_LeadType = 1"; 
    }

    $sql = "SELECT DISTINCT tbl_source.*,al.Al_Del FROM tbl_source 
    INNER JOIN tbl_lead ld ON ld.Ld_Source = Sc_Id 
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    $j
    WHERE al.Al_CallerId = $uid AND Sc_Del = 0 AND al.Al_Del = 0 $w 
    ORDER BY Sc_Id ASC";

    $result = $conn->query($sql);
    return $result; 

}


function getLeadStatus(){

    $conn = dbconnect();
    $w = "";


    if($_SESSION["Role"] == 3){
        $w .= " AND Ls_Id <> 9";
    }

    $sql = "SELECT * FROM `tbl_leadstatus` WHERE Ls_Del = 0 AND Ls_parent IS NULL  $w";
    // echo $sql;
    $result = $conn->query($sql);
    return $result;

}
function getLeadStatusById($pid){

    $conn = dbconnect();
    $w = "";
    if($_SESSION["Role"] == 3){
        $w = " AND Ls_Id <> 9";
    }

    $sql = "SELECT * FROM `tbl_leadstatus` WHERE Ls_Del = 0 AND Ls_parent = $pid $w";
    $result = $conn->query($sql);
    return $result;

}

function getLeadStatusbyData($stats, $src, $int, $uid, $dateby, $sdate, $edate, $search, $leadtype,$misc=""){

    $conn = dbconnect();
    $w =$j=$g= "";
    #
    if ($stats != "") {
        if($misc == "missed" && ($stats == 4 || $stats == 17 )){
            $w = $w . " AND (ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 17 )";
        }
        else if($misc == "nocall" && $stats == 1){
            $w = $w . " AND Ls_Id IN ($stats) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stats)";
        }
        
    }

    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }


    if($_SESSION["Role"] != 2){
        $w = $w . " AND Ls_Id <> 8";
    }
  
  	if($src != ""){
        $w = $w . " AND Sc_Id in ($src)";
    }

    if($int != ""){
        $w = $w . " AND Rt_Id in ($int)";
    }

    if($dateby == "lead"){
        $w = $w . " AND Ld_LeadDate between '".$sdate."' AND '".$edate."'";
    }
    else if($dateby == "lastcall"){
        $w = $w . " AND Ld_LastCallDate between '".$sdate."' AND '".$edate."'";
    }else if ($dateby == "visitplan") {
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
  
  	if($search != ""){
        $w = $w . " AND (Ld_Name LIKE '%".$search."%' OR Ld_Mobile LIKE '%".$search."%' OR Ld_Email LIKE '%".$search."%' OR Ld_Pincode LIKE '%".$search."%')";
    }

    if ($leadtype != "") {
        $w .= " AND Ld_LeadType = $leadtype"; 
    }else{
        $w .= " AND Ld_LeadType = 1"; 
    }
    
    $sql = "SELECT DISTINCT ls.*,al.Al_Del,
    (SELECT s.Ls_Name 
     FROM tbl_leadstatus s 
     WHERE ls.Ls_parent = s.Ls_Id) AS ParentLabel
    FROM `tbl_leadstatus` ls 
    INNER JOIN tbl_lead ld ON ld.Ld_LeadStatus = ls.Ls_Id 
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
    LEFT JOIN tbl_leadtype lt ON lt.Lt_TypeId = ld.Ld_LeadType
    $j
    WHERE al.Al_CallerId = $uid AND ls.Ls_Del = 0 AND al.Al_Del = 0
    $w ORDER BY ls.Ls_Id ASC";

    $result = $conn->query($sql);
    // echo $sql;
    return $result;

}


function getProjects(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_projects` WHERE Pr_Del = 0";
    $result = $conn->query($sql);
    return $result;

}


function getBudget(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_budget` WHERE Bd_Del = 0";
    $result = $conn->query($sql);
    return $result;

}


function getUsers($tmid = 0){
    $conn = dbconnect();
    if($tmid != 0){
        $sql = "SELECT * FROM `tbl_users` u 
        INNER JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId 
        INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
        INNER JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
        INNER JOIN tbl_team tm ON tm.Tm_Id = m.team_id   
        WHERE U_TypeId <> 0 AND tm.Tm_Id = $tmid";
    }
    else{
        $sql = "SELECT * FROM `tbl_users` u 
        INNER JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId 
        INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
        INNER JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
        INNER JOIN tbl_team tm ON tm.Tm_Id = m.team_id   
        WHERE U_TypeId <> 0";
    }
    $result = $conn->query($sql);
    return $result;
}
function getUsertype($uid){
    $conn = dbconnect();
    $sql = "SELECT u.U_TypeId FROM `tbl_users` u 
            INNER JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId 
            INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
            WHERE u.U_Id = $uid";

    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function getUType(){
    $conn = dbconnect();

    $sql ="SELECT * FROM `tbl_usertype`WHERE UType_Del = 0 AND UType_Id <> 0";
    $result = $conn->query($sql);
    return $result;


}

function getUserBytype($typeid){
    $conn = dbconnect();
    if($typeid != 0){
        $sql = "SELECT * FROM `tbl_users` u 
        INNER JOIN tbl_usertype ut ON ut.UType_Id = u.U_TypeId 
        INNER JOIN tbl_roles r ON r.Rl_Id = u.U_RoleId
        INNER JOIN tbl_teammap m ON m.tm_m_uid = u.U_Id
        INNER JOIN tbl_team tm ON tm.Tm_Id = m.team_id  
        WHERE U_TypeId <> 0 AND u.U_TypeId = $typeid";
    }
    
    $result = $conn->query($sql);
    return $result;
}

function getRole(){
    $conn = dbconnect();

    $sql ="SELECT * FROM `tbl_roles`WHERE Rl_Del = 0 AND Rl_Id <> 1";
    $result = $conn->query($sql);
    return $result;


}
function AllTeams($type="",$role=""){
    $conn = dbconnect();
    $w = "";

    if($role !=""){
        $w .= "AND ";
    }

          $sql = "SELECT * FROM tbl_team tm WHERE tm.Tm_Del =0";
    
          $result = $conn->query($sql);
    return $result;
}

function getTeams($tid=""){
    $conn = dbconnect();
    $w = '';
    if($tid  != ''){

       $sql ="WITH RECURSIVE Team AS (
                SELECT 
                    t.Tm_Id, 
                    t.Tm_Name, 
                    t.Tm_parent_team_id, 
                    t.Tm_Code, 
                    t.Tm_Del, 
                    0 AS level
                FROM tbl_team t
                WHERE t.Tm_Del = 0 AND t.Tm_Id = $tid

                UNION ALL

                SELECT 
                    t.Tm_Id, 
                    t.Tm_Name, 
                    t.Tm_parent_team_id, 
                    t.Tm_Code, 
                    t.Tm_Del, 
                    c.level + 1
                FROM tbl_team t
                INNER JOIN Team c ON t.Tm_parent_team_id = c.Tm_Id
                INNER JOIN tbl_teammap mm ON mm.team_id = t.Tm_Id
                WHERE t.Tm_Del = 0
            )
            SELECT DISTINCT * FROM Team;";
        
    }else{
          $sql = "SELECT * FROM tbl_team tm 
                    INNER JOIN tbl_teammap m ON tm.Tm_Id = m.team_id
                    WHERE tm.Tm_Del = 0
                    GROUP BY Tm_Id";
    }
    $result = $conn->query($sql);
    return $result;
}








function getProjectsbyLid($ld){

    $conn = dbconnect();

    $sql = "SELECT pr.Pr_Id, pr.Pr_Name FROM tbl_projects pr
    INNER JOIN tbl_lead ld ON pr.Pr_Id IN(ld.Ld_ProjectId)
    WHERE ld.Ld_Id = $ld
    GROUP BY pr.Pr_Id, pr.Pr_Name";
    $result = $conn->query($sql);
    return $result;

}


function getRoomType(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_roomtype` WHERE Rt_Del = 0";
    $result = $conn->query($sql);
    return $result;

}


function getChannelPartner(){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_channelpartner` WHERE Cp_Del = 0";

    $result = $conn->query($sql);
    return $result;
}

function getVideoCallType(){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_vc` WHERE Vc_Del = 0";

    $result = $conn->query($sql);
    return $result;
}
function getInPersonType(){
    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_inperson` WHERE Ip_Del = 0";

    $result = $conn->query($sql);
    return $result;
}

function getRoomTypebyData($stats, $src, $int, $uid, $dateby, $sdate, $edate, $search, $leadtype,$misc=''){

    $conn = dbconnect();

    $w = $j = $g ="";
    if ($stats != "") {
        if($misc == "missed" && $stats == 4){
            $w = $w . " AND (ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $stats == 1){
            $w = $w . " AND Ls_Id IN ($stats) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stats)";
        }
        
    }
    
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }
    
  	if($src != ""){
        $w = $w . " AND Sc_Id in ($src)";
    }

    if($int != ""){
        $w = $w . " AND Rt_Id in ($int)";
    }
  
  	if($dateby == "lead"){
        $w = $w . " AND Ld_LeadDate between '".$sdate."' AND '".$edate."'";
    }
    else if($dateby == "lastcall"){
        $w = $w . " AND Ld_LastCallDate between '".$sdate."' AND '".$edate."'";
    }else if ($dateby == "visitplan") {
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
  
  	if($search != ""){
        $w = $w . " AND (Ld_Name LIKE '%".$search."%' OR Ld_Mobile LIKE '%".$search."%' OR Ld_Email LIKE '%".$search."%' OR Ld_Pincode LIKE '%".$search."%')";
    }

    $w .= " AND Ld_LeadType = 1"; 

    $sql = "SELECT DISTINCT tbl_roomtype.* FROM `tbl_roomtype` 
    INNER JOIN tbl_lead ld ON ld.Ld_InterestedIn = Rt_Id 
    INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id 
    INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
    INNER JOIN tbl_leadstatus ls ON ls.Ls_Id = ld.Ld_LeadStatus
    $j
    WHERE al.Al_CallerId = $uid AND Rt_Del = 0 $w 
    ORDER BY Rt_Id ASC";
    $result = $conn->query($sql);
    return $result;

}


function getCallStatus(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_callstatus` WHERE Cs_Del = 0 AND Cs_Type = 'Connected' OR Cs_Type = 'Disconnected'";
    $result = $conn->query($sql);
    return $result;

}

function getMessageStatus(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_callstatus` WHERE Cs_Del = 0 AND Cs_Type = 'Message'";
    $result = $conn->query($sql);
    return $result;

}
function getMeetingStatus(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_callstatus` WHERE Cs_Del = 0 AND Cs_Type = 'Meeting'";
    $result = $conn->query($sql);
    return $result;

}


function getLabels(){

    $conn = dbconnect();

    $sql = "SELECT * FROM `tbl_labels` WHERE Lb_Del = 0";
    $result = $conn->query($sql);
    return $result;

}
function getlabelbyData($stats, $src, $int,$lb,$dateby, $sdate, $edate, $search){

    $conn = dbconnect();
    $w = "";
    if ($stats != "") {
        if($misc == "missed" && $stats == 4){
            $w = $w . " AND (ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $lstatus == 1){
            $w = $w . " AND Ls_Id IN ($stats) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stats)";
        }
        
    }

    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }
  	// if($src != ""){
    //     $w = $w . " AND Sc_Id in ($src)";
    // }

    if($int != ""){
        $w = $w . " AND Rt_Id in ($int)";
    }

    if($lb !=""){
        $w = $w."AND Lb_Id in ($lb)";
    }

    if($dateby == "lead"){
        $w = $w . " AND Ld_LeadDate between '".$sdate."' AND '".$edate."'";
    }
    else if($dateby == "lastcall"){
        $w = $w . " AND Ld_LastCallDate between '".$sdate."' AND '".$edate."'";
    }
  
  	if($search != ""){
        $w = $w . " AND (Ld_Name LIKE '%".$search."%' OR Ld_Mobile LIKE '%".$search."%' OR Ld_Email LIKE '%".$search."%' OR Ld_Pincode LIKE '%".$search."%')";
    }

    $sql = "SELECT l.* , la.La_LabelId,la.La_EmpId,lb.*,u.*
            FROM tbl_lead l 
            LEFT JOIN tbl_labelassign la ON l.Ld_Id  = la.La_Id 
            LEFT JOIN tbl_labels ON la.La_LabelId = lb.Lb_Id 
            LEFT JOIN tbl_users ON lb.La_EmpId = u.U_Id";
    // echo $sql;
    $result = $conn->query($sql);
    return $result;

}



function getTimeWisebyData($stats, $src, $int, $uid, $dateby, $sdate, $edate, $search, $leadtype,$misc=''){

    $conn = dbconnect();
    $w = "";
    if ($stats != "") {
        if($misc == "missed" && $stats == 4){
            $w = $w . " AND (ld.Ld_LeadStatus = 17 OR ld.Ld_LeadStatus = 12 OR ld.Ld_LeadStatus = 4 OR ld.Ld_LeadStatus = 3 OR ld.Ld_LeadStatus = 2 OR ld.Ld_LeadStatus = 1)";
        }
        else if($misc == "nocall" && $stats == 1){
            $w = $w . " AND Ls_Id IN ($stats) AND ld.Ld_LastCallDate IS NULL";
        }
        else{
            $w = $w . " AND Ls_Id IN ($stats)";
        }
        
    }
    
    if($misc == "newupdate"){
        $w = $w . " AND ld.Ld_NewUpdate = 1";
    }
  
  	if($src != ""){
        $w = $w . " AND Sc_Id in ($src)";
    }

    if($int != ""){
        $w = $w . " AND Rt_Id in ($int)";
    }

    // if($dateby == "lead"){
    //     $w = $w . " AND Ld_LeadDate between '".$sdate."' AND '".$edate."'";
    // }
    // else if($dateby == "lastcall"){
    //     $w = $w . " AND Ld_LastCallDate between '".$sdate."' AND '".$edate."'";
    // }
  
  	if($search != ""){
        $w = $w . " AND (Ld_Name LIKE '%".$search."%' OR Ld_Mobile LIKE '%".$search."%' OR Ld_Email LIKE '%".$search."%' OR Ld_Pincode LIKE '%".$search."%')";
    }

    if ($leadtype != "") {
        $w .= " AND Ld_leadtype = $leadtype"; 
    }else{
        $w .= " AND Ld_LeadType = 1"; 
    }

    $sql = "SELECT COUNT(ld.Ld_Id) as 'leadcount', 'First Half' as 'label' FROM tbl_lead ld
    INNER JOIN tbl_leadstatus ls ON ld.Ld_LeadStatus = ls.Ls_Id 
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
            LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
            INNER JOIN tbl_assignleadtime alt ON alt.Alt_LdId = ld.Ld_Id AND alt.Alt_Uid = $uid
    WHERE alt.Alt_AssignTime BETWEEN '".$sdate." 10:00:00' AND '".$edate." 13:59:59' AND alt.Alt_Del = 0 $w
    UNION ALL
    SELECT COUNT(ld.Ld_Id) as 'leadcount', 'Second Half' as 'label' FROM tbl_lead ld
    INNER JOIN tbl_leadstatus ls ON ld.Ld_LeadStatus = ls.Ls_Id 
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
            LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
            INNER JOIN tbl_assignleadtime alt ON alt.Alt_LdId = ld.Ld_Id AND alt.Alt_Uid = $uid
    WHERE alt.Alt_AssignTime BETWEEN '".$sdate." 13:59:59' AND '".$edate." 23:59:59' AND alt.Alt_Del = 0 $w
    UNION ALL
    SELECT COUNT(ld.Ld_Id) as 'leadcount', 'Missed' as 'label' FROM tbl_lead ld
    INNER JOIN tbl_leadstatus ls ON ld.Ld_LeadStatus = ls.Ls_Id 
            INNER JOIN tbl_assignlead al ON al.Al_LeadId = ld.Ld_Id
            INNER JOIN tbl_source sc ON sc.Sc_Id = ld.Ld_Source
            LEFT JOIN tbl_roomtype rt ON rt.Rt_Id = ld.Ld_InterestedIn
            INNER JOIN tbl_assignleadtime alt ON alt.Alt_LdId = ld.Ld_Id AND alt.Alt_Uid = $uid
    WHERE alt.Alt_AssignTime < '".$sdate."' AND alt.Alt_Del = 0 $w";
    $result = $conn->query($sql);
    return $result;

}

    function getPin()
    {
        $conn = dbconnect();
        
       $sql = "SELECT DISTINCT Cp_Pin FROM tbl_channelpartner";
       $result = $conn->query($sql);
       return $result;

    }

    function getLoc()
    {
        $conn = dbconnect();
        
       $sql = "SELECT DISTINCT Cp_Location FROM tbl_channelpartner";
       $result = $conn->query($sql);
       return $result;

    }
?>