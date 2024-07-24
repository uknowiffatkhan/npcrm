<style>
   .badge-green {
   background-color: #f3f4f6;
   color: #1f2937;
   }
</style>
<?php
   if (!isset($_SESSION)) {
       session_start();
   }
   
   $baseurl = $_SESSION["baseurl"];
   
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/usermodel.php";
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/teammodel.php";
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/remindermodel.php";
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dashboard.php";
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dropdownmodel.php";
   include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/commonmodel.php";
   
   
   $uid = $_SESSION["UId"];
   $sdate = $_POST["sdate"];
   $edate = $_POST["edate"];
   
   ?>
<?php 
   function Teams($tid="",$ptid=""){
       $result= getTeamDetail($tid,$ptid);   
       if ($result->num_rows > 0) {
           $teams = [];
           while ($row = $result->fetch_assoc()) {
               $team = [
                   'Tm_Id' => $row['Tm_Id'],
                   'Tm_Code' => $row['Tm_Code'],
                   'Tm_Name' => $row['Tm_Name'],
                   'Tm_Status' => $row['Tm_Status'],
   
                   'members' => [] 
               ];
               
               $team['members'] = TeamMembers($team['Tm_Id']);
               
               $team['children'] = SubTeams($team['Tm_Id']);
               
               $teams[] = $team;
           }
           return $teams;
       } else {
           return [];
       }
   }
   
   function SubTeams($tid){
       $result = getSubTeamDetail($tid);
       
       if ($result->num_rows > 0) {
           $subTeams = [];
           while ($row = $result->fetch_assoc()) {
               $subTeam = [
                   'Tm_Id' => $row['Tm_Id'],
                   'Tm_Code' => $row['Tm_Code'],
                   'Tm_Name' => $row['Tm_Name'],
                   'Tm_Status' => $row['Tm_Status'],
   
                   'members' => []  
               ];
               
               $subTeam['members'] = TeamMembers($subTeam['Tm_Id']);
               
               $subTeam['children'] = SubTeams($subTeam['Tm_Id']);
               
               $subTeams[] = $subTeam;
           }
           return $subTeams;
       } else {
           return [];
       }
   }
   
   function TeamMembers($tid) {
       $result = getTeamMembersDetail($tid);
       if ($result->num_rows > 0) {
           $members = [];
           while ($row = $result->fetch_assoc()) {
            $login = LastLogin($row['U_Id']);
               $member = [
                   'tm_m_id' => $row['tm_m_id'],
                   'tm_m_role' => $row['tm_m_role'],
                   'tm_m_uid' => $row['tm_m_uid'],
                   'tm_m_CreatedDate' => $row['tm_m_CreatedDate'],
                   'tm_m_CreatedId' => $row['tm_m_CreatedId'],
                   'tm_m_Status' => $row['tm_m_Status'],
                   'tm_m_Del' => $row['tm_m_Del'],
                   'U_Id'=>$row['U_Id'],
                   'U_DisplayName'=>$row['U_DisplayName'],
                   'U_Mobile'=>$row['U_Mobile'],
                   'U_Online'=>$row['U_Online'],
                   'Rl_Id'=>$row['Rl_Id'],
                   'Rl_Name'=>$row['Rl_Name'],
                   'U_Id'=>$row['U_Id'],
                   'UType_Name'=>$row['UType_Name'],
                   'UType_Id'=>$row['UType_Id'],
                   'login'=>$login ? $login['ALog_CreatedDate'] : '----',
   
               ];
               $members[] = $member;
           }
           return $members;
       } else {
           return [];
       }
   }
   
    function leadlabel($uid,$sdate,$edate){
        $leads = lddeatails($uid,"",$sdate,$edate);
        if ($leads->num_rows > 0) {
            while ($lead = $leads->fetch_assoc()) {
                echo '<span class="fw-semibold border rounded pill badge-green px-2 py-1 text-capitalize  text-wrap fs-6"><i class="fa-solid fa-circle fa-2xs me-2" style="color:'.$lead['Color'].'"></i>'.$lead['LeadType'].  ' : '.$lead['Count'].'</span>';
            }
        }
    }
   
   
    function Memberleadlabel($uid,$type="",$sdate,$edate){
        $leads = lddeatails($uid,$type,$sdate,$edate);
        if ($leads->num_rows > 0) {
            while ($lead = $leads->fetch_assoc()) {
                echo '<span class=" fw-semibold fs-6  text-wrap text-capitalize" style="color:'.$lead['Color'].'" >'.$lead['LeadType'].  ' : '.$lead['Count'].'</span>  | ';
            }
        }
    }
   
    function Typecount($uid){
     $types = MemberTypeCount($uid);
     if ($types->num_rows > 0) {
        while ($type = $types->fetch_assoc()) {
            echo '| <span class=" fs-7 mb-0 mx-1">'.$type['Type'].' : <span class="fw-semibold text-decoration-underline"> '.$type['Count'].'</span></span>';
        }
     }
    }
   
   
   
function displayTeams($tid,$ptid,$sdate,$edate) {
       
        $teams = Teams($tid,$ptid);

        function printTeams($teams,$sdate,$edate) {
            foreach ($teams as $team):
            $g = getTeamMembers($team['Tm_Id']);
        ?>

        <ul class="list-group" >
        <li class="list-group-item my-2 mx-2 p-0 border-2 border-secondary border-top-0 border-bottom-0 border-end-0 ">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex flex-wrap justify-content-between align-items-center "  data-bs-toggle="collapse" href="#team-<?= $team['Tm_Id'] ?>" role="button" aria-expanded="false" aria-controls="team-<?= $team['Tm_Id'] ?>">
                    <div class="card-title align-items-start mb-0 ms-2">
                        <p class="mb-1">
                            <span>
                            <?php $team['Tm_Status'] == 'Active' ? $c= '#71dd37;' :  $c = '#ff0000ba' ?>
                            <i class="fa-solid fa-circle fa-2xs me-1" style="color: <?= $c ?>"></i></span>
                            <span class="card-label fw-bold text-dark mb-0 fs-4"><span class=" text-dark"></span><?= $team['Tm_Name'] ?>.</span><span class="badge text-bg-secondary px-2 py-1 ms-1  small">Team</span>
                        </p>
                        <p class="mb-0 d-flex flex-wrap ms-3">
                            <span class=" fs-6 mb-0">Tm_Code : <span class="fw-semibold text-decoration-underline me-2"> <?= $team['Tm_Code'] ?> </span>  |  </span>
                            <span class=" fs-7 mb-0 mx-1"> Members : <span class="fw-semibold text-decoration-underline"><?= $g['Member']?></span> </span> |
                            <span class=" fs-7 mb-0 mx-1"> Teams : <span class="fw-semibold text-decoration-underline"><?= $g['Team_Count'] ?></span> </span>
                            <?= $g['MemberId'] ? Typecount($g['MemberId']) : "" ?> 
                            </span>
                        </p>
                    </div>
                    <div>
                        <i class="fa-solid fa-caret-down fa-lg me-2"></i>
                    </div>
                    <div class="d-flex flex-wrap justify-content-start align-items-center mb-2 ms-3  mt-2 w-100 gap-2">
                        <?= $g['MemberId'] ? leadlabel($g['MemberId'],$sdate,$edate) : "" ?>     
                    </div>
                    </div>
                    <div class="collapse " id="team-<?= $team['Tm_Id'] ?>">
                    <?php if (!empty($team['members'])): ?>
                    <ul class="list-group g-2">
                        <?php foreach ($team['members'] as $member): ?>
                        <?php
                            $bg = 'white';
                            if($member['Rl_Id'] == 2 ){
                                $bg = '#6ea8fe26';
                                $badge="#4d96ff !important";
                            
                            }elseif($member['Rl_Id'] == 3){
                                $bg = '#d2e4ff36';
                                $badge="#3b7670 !important";
                            
                            
                            }
                            ?>
                        <li class="list-group-item mx-4  text-dark" style="background-color : <?= $bg?> ">
                            <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center mx-0 px-0 member " data-bs-toggle="collapse" href="#member-<?= $member['tm_m_uid'] ?>" role="button" aria-expanded="false" aria-controls="member-<?= $member['tm_m_uid'] ?>">
                                <input type="hidden" name="memberid" value="<?= $member['tm_m_uid'] ?>">
                                <span class="card-label fw-semibold text-gray-800 mb-0" style="font-size:20px"><?= $member['U_DisplayName'] ?> 
                                <span class="badge text-capitalize" style="
                                background: <?= $badge?>;
                                font-size: 12px;
                                "><?= $member['Rl_Name'] ?> </span>
                                <?php if ($member['U_Online']) : ?>
                                <span class="badge text-bg-success text-capitalize" style="font-size: 10px;">Online</span>
                                <?php else : ?>
                                <span class="badge text-bg-danger text-capitalize" style="font-size: 10px;">Offline</span>
                                <?php endif; ?>
                                </span>
                                <div>
                                <i class="fa-solid fa-caret-down me-2"></i>
                                </div>
                            </div>
                            <div class="mx-1">
                                <p class="mb-1">
                                <span> <i class="fa-solid fa-phone fa-xs "></i> <span style="font-size:13px;"><?= $member['U_Mobile'] ?></span> |
                                <span class="" style="font-size:12px;">Login  :  <?= $member['login'] ?></span>
                                </p>
                                <?= $member['U_Id'] ? Memberleadlabel($member['U_Id'],$member['UType_Id'],$sdate,$edate) : "" ?>     
                            </div>
                        </li>
                        <div class="collapse  p-2 mt-1 mx-3" id="member-<?= $member['tm_m_uid'] ?>">
                            <input type="hidden" name="member_type" value="<?= $member['UType_Id'] ?>">
                            <div class="accordion-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="col-lg-6">
                                    <div class="overview" id="overview<?= $member['tm_m_uid'] ?>">
                                        <div class="card-body skeleton-body">
                                            <div class="skeleton-label"></div>
                                            <div class="skeleton-label skeleton-md"></div>
                                        </div>
                                    </div>
                                    <div class="lead overview" >
                                        <p class="fw-semibold mt-1 border-top ps-3">Status Wise lead</p>
                                        <div class="d-flex flex-wrap" id="lead_overview<?= $member['tm_m_uid'] ?>">
                                            <div class="card-body skeleton-body">
                                            <div class="skeleton-label"></div>
                                            <div class="skeleton-label skeleton-md"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($member['UType_Id'] == 2 || $member['UType_Id'] == 4  ): ?>
                                <div class="col-lg-6 d-flex justify-content-end pe-5">
                                    <div class="h-100" id="calendar<?= $member['tm_m_uid'] ?>">
                                        <div class="card-body skeleton-body">
                                            <div class="skeleton-label"></div>
                                            <div class="skeleton-label skeleton-md"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p class="badge bg-danger text-white ms-3">No members found.</p>
                    <?php endif; ?>
                    <?php if (!empty($team['children'])): ?>
                    <?php printTeams($team['children'],$sdate,$edate); ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </li>
        </ul>
        <?php
        endforeach;
        }
        printTeams($teams,$sdate,$edate);
}

    if($_SESSION["Role"] == "1"){
        $tid = "";
        if(isset($_POST["team"])){
            $tid = $_POST["team"];
        }
        displayTeams($tid,"",$sdate,$edate);    
    }else{
        $tid="";
        $ptid ="";
        if(isset($_POST["team"])){
            $tid = $_POST["team"];
        }else{
            $tid = $_SESSION["Team"][0]->Tm_Id;
            $ptid = isset($_SESSION["Team"][0]->Tm_parent_team_id) ? $_SESSION["Team"][0]->Tm_parent_team_id : '';
        }
        displayTeams($tid,$ptid,$sdate,$edate);

     }   
   ?>