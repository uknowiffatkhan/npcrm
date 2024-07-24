<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/usermodel.php";

$uid = $_SESSION["UId"];
$roleid = $_SESSION["Role"];
$typeid = $_SESSION["TypeId"];

$cpdet=$userdet=$det='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST["search"];


    if ($typeid  == 0 && $roleid == 1){
       $cpdet = getGlobalSearchCp('',$search);


    }elseif($typeid  == 5 && $roleid == 2){
        $sourceid = $uid;
        $cpdet = getGlobalSearchCp($sourceid,$search);

    }

    $det = getGlobalSearch($uid,$typeid,$search);
    

    
}

?>


<div class="p-3 border-bottom d-flex align-items-center justify-content-between">
    Quick Search
    <span class="s-close">Close X</span>
</div>
<div class="search-container">
<?php
if($cpdet){
if ($cpdet->num_rows > 0) {
    while ($cp = $cpdet->fetch_assoc()) {?>

        <div class="s-lead-card cpshowdetails">
        <input type="hidden" name="leadid" value="<?php echo $cp["Cp_Id"]?>" />
        <div class="d-flex flex-nowrap align-items-center justify-content-between border-bottom pb-1">
            <div>
                <div class="s-name"><?php echo $cp["Cp_Name"]?></div>
                <small class="s-assigned"><i class="fas <?php echo count(explode(',',$cp["Assigned"])) > 1 ? "fa-users" : "fa-user"?> fa-md mr-1"></i><?php echo $cp["Assigned"]?></small>
            </div>

            <div>
             <div class="s-status status-<?php echo `Channel Partner`?>"><?php echo "Channel Partner [".$cp["Cp_Code"] ."]"?></div>
            </div>
        </div>
        <div class="d-flex flex-nowrap align-items-center justify-content-between pt-1">
            <div class="s-phone">
                <i class="fas fa-phone fa-sm"></i> <?php echo $cp["Cp_Mobile"]?>
            </div>
        </div>
    </div>
    <?php
    }
}
}
if($det){
if ($det->num_rows > 0) {
    while ($d = $det->fetch_assoc()) {
        ?>
        <div class="s-lead-card showdetails">
            <input type="hidden" name="leadid" value="<?php echo $d["Ld_Id"]?>" />
            <div class="d-flex flex-nowrap align-items-center justify-content-between border-bottom pb-1">
                <div>
                    <div class="s-name"><?php echo $d["Ld_Name"]?></div>
                    <small class="s-assigned"><i class="fas <?php echo count(explode(',',$d["Assigned"])) > 1 ? "fa-users" : "fa-user"?> fa-md mr-1"></i><?php echo $d["Assigned"]?></small>
                </div>
                <div>
                    <div class="s-status status-<?php echo str_replace(" ", "-", $d["Ls_Name"])?>"><?php echo $d["Ls_Name"]?></div>
                </div>
            </div>
            <div class="d-flex flex-nowrap align-items-center justify-content-between pt-1">
                <div class="s-phone">
                    <i class="fas fa-phone fa-sm"></i> <?php echo $d["Ld_Mobile"]?>
                </div>
                <div class="d-flex flex-nowrap align-items-center fs-sm">
                    <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($d["Ld_CreatedDate"])) ?>" data-placement="bottom"
                        class="d-flex align-items-center text-danger fw-600"><i class="far fa-clock fa-lg"></i>&nbsp;&nbsp; <?php echo timeago($d["Ld_CreatedDate"]) ?>
                    </span>
                    <span class="mx-2">|</span>
                    <span data-toggle="tooltip" title="Last Call <br/> <?php echo $d["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($d["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom"
                        class="d-flex align-items-center text-danger fw-600"><i class="fas fa-phone"></i>&nbsp;&nbsp;<?php echo $d["Ld_LastCallDate"] != "" ? timeago($d["Ld_LastCallDate"]) : "-" ?>
                    </span>
                    <span class="mx-2">|</span>
                    <!-- <span><i class="fas fa-circle fa-md text-info mr-1"></i></span> -->
                    <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i
                            class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;<?php echo $d["callcount"] ?>
                    </span>
                </div>
            </div>
        </div>
    <?php
    }
} else {
?>
<?php
}
}

if($userdet){
    if ($userdet->num_rows > 0) {
        while ($u = $userdet->fetch_assoc()) {?>

            <div class="s-lead-card">
            <input type="hidden" name="uid" value="<?php echo $u["U_Id"]?>" />
            <div class="d-flex flex-nowrap align-items-center justify-content-between border-bottom pb-1">
                <div>
                    <div class="s-name"><?php echo $u["U_Username"]?></div>
                    <small class="s-assigned"><i class="fas <?php echo count(explode(',',$u["Tm_Name"])) > 1 ? "fa-users" : "fa-user"?> fa-md mr-1"></i><?php echo $cp["Tm_Name"]?></small>
                </div>
    
                <div>
            </div>
            <div class="d-flex flex-nowrap align-items-center justify-content-between pt-1">
                <div class="s-phone">
                    <i class="fas fa-phone fa-sm"></i> <?php echo $cp["U_Username"]?>
                </div>
            </div>
        </div>
<?php        }
    }
}

?>
</div>

<!-- <div class="lead-card">
    <div class="d-flex flex-nowrap align-items-center justify-content-between border-bottom pb-1">
        <div>
            <div class="s-name">Irfan</div>
            <small class="s-assigned"><i class="fas fa-users fa-md mr-1"></i>Farhin,Shuhaib</small>
        </div>
        <div>
            <div class="s-status">Site Visit Plan</div>
        </div>
    </div>
    <div class="d-flex flex-nowrap align-items-center justify-content-between pt-1">
        <div>
            <i class="fas fa-phone"></i> 7977777777
        </div>
        <div class="d-flex flex-nowrap align-items-center fs-sm">
            <span data-toggle="tooltip" title="Lead Date <br/> 01-06-2023" data-placement="bottom"
                class="d-flex align-items-center text-danger fw-600"><i class="far fa-clock fa-lg"></i>&nbsp;&nbsp; 6D
            </span>
            <span class="mx-2">|</span>
            <span data-toggle="tooltip" title="Last Call <br/> 01-06-2023 11:50 AM" data-placement="bottom"
                class="d-flex align-items-center text-danger fw-600"><i class="fas fa-phone"></i>&nbsp;&nbsp;3D
            </span>
            <span class="mx-2">|</span>
            <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i
                    class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;2
            </span>
        </div>
    </div>
</div> -->