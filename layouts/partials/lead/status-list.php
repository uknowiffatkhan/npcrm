    <?php

include('../../../config/db.php');

include('../../../config/encrypter.php');

include("../../../utils/helper.php");

include("../../../model/leadmodel.php");
include("../../../model/quotemodel.php");
include("../../../model/dropdownmodel.php");


// Check and print $_SESSION variables
// var_dump($_SESSION);

// Access specific session variables
$typeId = $_SESSION["TypeId"] ?? null;
$role = $_SESSION["Role"] ?? null;

// Print specific session variables
// echo "Type Id: " . $typeId . "<br>";
// echo "Role: " . $role . "<br>";

$uid = $_SESSION["UId"];
// echo $uid;  
$leadtype='';
//echo getNonWeekOffLeaveDate($uid, "2023-06-01");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//print_r($_POST);
    $type = $_POST["type"];
    $stat = $_POST["status"];
    $src = $_POST["source"];
    $int = $_POST["interest"];
    $lbl = $_POST["label"];
    $sdate = $_POST["sdate"];
    $edate = $_POST["edate"];
    $dateby = $_POST["dateby"];
    $leadsearch = $_POST["leadsearch"];
    $cid = $_POST["cid"];
    $typeres = "";
    if(isset($_POST["misc"])){
        $misc = $_POST["misc"];
    }

    if($cid != ""){
        $uid = $cid;
        $typeId = "4";
        $leadtype = 1;
    }
    else{
        if(($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1")){
            $uid = $_POST["uid"];
            $ut = getUsertype($_POST["uid"]);
            if ($ut['U_TypeId'] == 5 ){
                $leadtype = 2;
            }else{
                $leadtype = 1;
  
            }
        }elseif(($_SESSION["TypeId"] == "5" && $_SESSION["Role"] == "2")  )
        {
            $leadtype = 2;
        }
        else{
            $leadtype = 1;
        }
    }

    if ($type == "leadstatus") {
            $typeres = getLeadStatusbyData($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch,$leadtype,$misc);
            if ($typeres->num_rows == 0) {
                echo '<div>
                        <div class="lead-card">
                            No Records Found
                        </div>
                      </div>';
                exit; // Stop further execution if no records are found        
             }
    } else if ($type == "source") {
        $typeres = getSourcebyData($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch, $leadtype,$misc);
        if ($typeres->num_rows == 0) {
            echo '<div>
                    <div class="lead-card">
                        No Records Found
                    </div>
                  </div>';
            exit; // Stop further execution if no records are found
        }
    } else if ($type == "interest") {
        $typeres = getRoomTypebyData($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch, $leadtype,$misc);
        if ($typeres->num_rows == 0) {
            echo '<div>
                    <div class="lead-card">
                        No Records Found
                    </div>
                  </div>';
            exit; // Stop further execution if no records are found
        }
    } else if ($type == "time") {
        $typeres = getTimeWisebyData($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch, $leadtype,$misc);
        if ($typeres->num_rows == 0) {
            echo '<div>
                    <div class="lead-card">
                        No Records Found
                    </div>
                  </div>';
            exit; // Stop further execution if no records are found
        }
    }else if($type ="label"){
        $typeres = getlabelbyData($stats, $src, $int,$lb,$dateby, $sdate, $edate, $search);
    }



}

?>



<div class="d-grid d-lg-flex overflow-auto  ">
    <?php if (isset($typeres)) {
        if ($typeres->num_rows > 0) {
            while ($row = $typeres->fetch_assoc()) {
                if(($type == "time" && $row["leadcount"] > 0) || $type != "time"){
                   
                ?>
                <div class="status-divider border-<?php echo (isset($row["Ls_Name"]) ? str_replace(" ", "-", $row["Ls_Name"]) : "") . "" . (isset($row["Sc_Name"]) ? str_replace(" ", "-", $row["Sc_Name"]) . " pt-4" : "") . "" . (isset($row["Rt_Name"]) ? str_replace(" ", "-", $row["Rt_Name"]) . " pt-4" : "") ?>">
                    <?php if ($type == "leadstatus") {
                        
                        echo "<h4 class='divider-title'>" . ($row["ParentLabel"] != "" ? $row["ParentLabel"].' - ' : ""). $row["Ls_Name"] . "</h4>";
                        if ( $typeId == "5" ) {  
                            $dres = getCpLeadListStatusWise($row["Ls_Id"],$src, $lbl, $int,$uid, $dateby, $sdate, $edate, $leadsearch,$misc);
                        } else{
                      
                            $dres = getLeadListStatusWise($row["Ls_Id"], $src, $int, $lbl, $uid, $dateby, $sdate, $edate, $leadsearch,$leadtype,$misc);
                        }
                        if (isset($dres)) {
                            if ($dres->num_rows > 0) {
                                ?>
                                <div>
                                    <?php
                                    while ($r = $dres->fetch_assoc()) { ?>
                                        <div class="lead-card">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <div class="leaddetails d-flex align-items-center">
                                                        <label class="mr-1">
                                                            <input type="checkbox" />
                                                        </label>

                                                    <?php if ($typeId == "4") { ?>
                                                        <div class="d-grid cpleadshowdetails">
                                                            <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>" />
                                                            <!-- <span class="status-badge badge badge-success">New</span> -->
                                                            <?php 
                                                            $qcount = getQuoteCountsByLid($r["Ld_Id"]);
                                                            if($qcount != "" && $qcount > 0){
                                                                ?>
                                                                <span class="status-badge badge badge-success right-20">Q(<?php echo $qcount; ?>)</span>
                                                                <?php
                                                            } ?>
                                                            
                                                            <span class="leadtitle">
                                                                <?php echo $r["Ld_Name"] ?>
                                                            </span>
                                                            <p>
                                                                <?php echo $r["Rt_Name"] . " | " . $r["Sc_Name"] ?>
                                                            </p>
                                                            <span>
                                                                <?php echo $r["Ld_Mobile"] ?>
                                                            </span>
                                                            <div class="labels-list">
                                                                <?php

                                                                $lbs = getLabelsByLeadId($r["Ld_Id"]);

                                                                if (isset($lbs)) {
                                                                    if ($lbs->num_rows > 0) {
                                                                        while ($lb = $lbs->fetch_assoc()) {
                                                                            ?>

                                                                            <span class="label-tag" style="color:<?php echo $lb["Lb_ColorCode"] ?>">
                                                                                <i class="fas fa-circle"></i>
                                                                                <?php echo $lb["Lb_Name"] ?>
                                                                            </span>

                                                                        <?php }
                                                                    }
                                                                } ?>
                                                            </div>
                                                            <div class="d-flex mt-1">
                                                            <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($r["Ld_CreatedDate"])) ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                                    <?php echo timeago($r["Ld_CreatedDate"]) ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <span data-toggle="tooltip" title="Last Call <br/> <?php echo $r["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($r["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="fas fa-phone"></i>&nbsp;&nbsp;
                                                                    <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?>
                                                                        </span>
                                                                <span class="mx-2">|</span>
                                                                <!-- <span class="text-info mr-1"><i class="fas fa-circle fa-md "></i></span> -->
                                                                <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;
                                                                    <?php echo $r["callcount"] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                            <div class="d-grid showdetails">
                                                            <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>" />
                                                            <!-- <span class="status-badge badge badge-success">New</span> -->
                                                            <?php 
                                                            $qcount = getQuoteCountsByLid($r["Ld_Id"]);
                                                            if($qcount != "" && $qcount > 0){
                                                                ?>
                                                                <span class="status-badge badge badge-success right-20">Q(<?php echo $qcount; ?>)</span>
                                                                <?php
                                                            } ?>
                                                            
                                                            <span class="leadtitle">
                                                                <?php echo $r["Ld_Name"] ?>
                                                            </span>
                                                            <p>
                                                                <?php echo $r["Rt_Name"] . " | " . $r["Sc_Name"] ?>
                                                            </p>
                                                            <span>
                                                                <?php echo $r["Ld_Mobile"] ?>
                                                            </span>
                                                            <div class="labels-list">
                                                                <?php

                                                                $lbs = getLabelsByLeadId($r["Ld_Id"]);

                                                                if (isset($lbs)) {
                                                                    if ($lbs->num_rows > 0) {
                                                                        while ($lb = $lbs->fetch_assoc()) {
                                                                            ?>

                                                                            <span class="label-tag" style="color:<?php echo $lb["Lb_ColorCode"] ?>">
                                                                                <i class="fas fa-circle"></i>
                                                                                <?php echo $lb["Lb_Name"] ?>
                                                                            </span>

                                                                        <?php }
                                                                    }
                                                                } ?>
                                                            </div>
                                                            <div class="d-flex mt-1">
                                                            <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($r["Ld_CreatedDate"])) ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                                    <?php echo timeago($r["Ld_CreatedDate"]) ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <span data-toggle="tooltip" title="Last Call <br/> <?php echo $r["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($r["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="fas fa-phone"></i>&nbsp;&nbsp;
                                                                    <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?>
                                                                        </span>
                                                                <span class="mx-2">|</span>
                                                                <!-- <span class="text-info mr-1"><i class="fas fa-circle fa-md "></i></span> -->
                                                                <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;
                                                                    <?php echo $r["callcount"] ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                            <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="statusactions">
                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php

                            } else {
                                ?>
                                <div>
                                    <div class="lead-card">
                                        No Records Found
                                    </div>
                                </div>

                                <?php
                            }
                        }
                    } else if ($type == "source") {
                        echo "<h4 class='divider-title'>" . $row["Sc_Name"] . "</h4>";

                        if ( $typeId == "5"){
                            $dres = getCpLeadListSourceWise($stat, $row["Sc_Id"],$uid,$lbl,$dateby, $sdate, $edate, $leadsearch,$misc);
                        } else {
                                $dres = getLeadListSourceWise($stat, $row["Sc_Id"], $int,$uid,$lbl,$dateby, $sdate, $edate, $leadsearch,$leadtype,$misc);
                            }
                       
                        if (isset($dres)) {
                            if ($dres->num_rows > 0) {
                                ?>
                                    <div>
                                        <?php
                                        while ($r = $dres->fetch_assoc()) { ?>

                                            <div class="lead-card">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="leaddetails d-flex align-items-center">
                                                            <label class="mr-1">
                                                                <input type="checkbox" />
                                                            </label>
                                                            <div class="d-grid showdetails">
                                                            <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>" />
                                                                <span
                                                                    class="status-badge badge badge-<?php echo str_replace(" ", "-", $r["Ls_Name"]) ?>"><?php
                                                                         echo $r["Ls_Name"] ?></span>
                                                                <span class="leadtitle mt-1">
                                                                <?php echo $r["Ld_Name"] ?>
                                                                </span>
                                                                <p>
                                                                <?php echo $r["Rt_Name"] . " | " . $r["Sc_Name"] ?>
                                                                </p>
                                                                <span>
                                                                <?php echo $r["Ld_Mobile"] ?>
                                                                </span>
                                                                <div class="labels-list">
                                                                    <?php

                                                                    $lbs = getLabelsByLeadId($r["Ld_Id"]);

                                                                    if (isset($lbs)) {
                                                                        if ($lbs->num_rows > 0) {
                                                                            while ($lb = $lbs->fetch_assoc()) {
                                                                                ?>

                                                                                <span class="label-tag" style="color:<?php echo $lb["Lb_ColorCode"] ?>">
                                                                                    <i class="fas fa-circle"></i>
                                                                                <?php echo $lb["Lb_Name"] ?>
                                                                                </span>

                                                                        <?php }
                                                                        }
                                                                    } ?>
                                                                </div>
                                                                <div class="d-flex mt-1">
                                                                <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($r["Ld_CreatedDate"])) ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                                    <?php echo timeago($r["Ld_CreatedDate"]) ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <span data-toggle="tooltip" title="Last Call <br/> <?php echo $r["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($r["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="fas fa-phone"></i>&nbsp;&nbsp;
                                                                    <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?>
                                                                        </span>
                                                                    <span class="mx-2">|</span>
                                                                    <!-- <span><i class="fas fa-circle fa-md text-info mr-1"></i></span> -->
                                                                    <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i class="fas fa-headset fa-lg"></i>&nbsp;&nbsp;
                                                                    <?php echo $r["callcount"] ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="statusactions">
                                                        <!-- <span class="action-badge text-success"><i class="fas fa-flag fa-xs"></i></span> -->                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                            } else {
                                ?>
                                    <div>
                                        <div class="lead-card">
                                            No Records Found
                                        </div>
                                    </div>
                                <?php
                            }
                        }
                 
                    } else if ($type == "interest") {
                        echo "<h4 class='divider-title'>" . $row["Rt_Name"] . "</h4>";

                        $dres = getLeadListInterestWise($stat, $src, $row["Rt_Id"], $uid,$lbl,$dateby, $sdate, $edate, $leadsearch,$misc);
                        if (isset($dres)) {
                            if ($dres->num_rows > 0) {
                                ?>
                                        <div>
                                        <?php
                                        while ($r = $dres->fetch_assoc()) { ?>

                                                <div class="lead-card">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="leaddetails d-flex align-items-center">
                                                                <label class="mr-1">
                                                                    <input type="checkbox" />
                                                                </label>
                                                                <div class="d-grid showdetails">
                                                            <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>" />
                                                                    <span
                                                                        class="status-badge badge badge-<?php echo str_replace(" ", "-", $r["Ls_Name"]) ?>"><?php
                                                                             echo $r["Ls_Name"] ?></span>
                                                                    <span class="leadtitle mt-1">
                                                                <?php echo $r["Ld_Name"] ?>
                                                                    </span>
                                                                    <p>
                                                                <?php echo $r["Rt_Name"] . " | " . $r["Sc_Name"] ?>
                                                                    </p>
                                                                    <span>
                                                                <?php echo $r["Ld_Mobile"] ?>
                                                                    </span>
                                                                    <div class="labels-list">
                                                                    <?php

                                                                    $lbs = getLabelsByLeadId($r["Ld_Id"]);

                                                                    if (isset($lbs)) {
                                                                        if ($lbs->num_rows > 0) {
                                                                            while ($lb = $lbs->fetch_assoc()) {
                                                                                ?>

                                                                                    <span class="label-tag" style="color:<?php echo $lb["Lb_ColorCode"] ?>">
                                                                                        <i class="fas fa-circle"></i>
                                                                                <?php echo $lb["Lb_Name"] ?>
                                                                                    </span>

                                                                        <?php }
                                                                        }
                                                                    } ?>
                                                                    </div>
                                                                    <div class="d-flex mt-1">
                                                                    <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($r["Ld_CreatedDate"])) ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                                    <?php echo timeago($r["Ld_CreatedDate"]) ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <span data-toggle="tooltip" title="Last Call <br/> <?php echo $r["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($r["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="fas fa-phone"></i>&nbsp;&nbsp;
                                                                    <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <!-- <span><i class="fas fa-circle fa-md text-info mr-1"></i></span> -->
                                                                        <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;
                                                                    <?php echo $r["callcount"] ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="statusactions">
                                                            <!-- <span class="action-badge text-success"><i class="fas fa-flag fa-xs"></i></span> -->                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php
                                        }
                                        ?>
                                        </div>
                                <?php
                            } else {
                                ?>
                                        <div>
                                            <div class="lead-card">
                                                No Records Found
                                            </div>
                                        </div>
                                <?php
                            }
                        }
                    } else if ($type == "time" && $row["leadcount"] > 0) {
                        echo "<h4 class='divider-title'>" . $row["label"] . "</h4>";
                        $dres = getLeadListTimeWise($stat, $src, $int, $uid,$lbl,$type, $sdate,$edate, $leadsearch, $row["label"]);
                        if (isset($dres)) {
                            if ($dres->num_rows > 0) {
                                ?>
                                        <div>
                                        <?php
                                        while ($r = $dres->fetch_assoc()) { ?>

                                                <div class="lead-card">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="leaddetails d-flex align-items-center">
                                                                <label class="mr-1">
                                                                    <input type="checkbox" />
                                                                </label>
                                                                <div class="d-grid showdetails">
                                                            <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>" />
                                                                    <span
                                                                        class="status-badge badge badge-<?php echo str_replace(" ", "-", $r["Ls_Name"]) ?>"><?php
                                                                             echo $r["Ls_Name"] ?></span>
                                                                    <span class="leadtitle mt-1">
                                                                <?php echo $r["Ld_Name"] ?>
                                                                    </span>
                                                                    <p>
                                                                <?php echo $r["Rt_Name"] . " | " . $r["Sc_Name"] ?>
                                                                    </p>
                                                                    <span>
                                                                <?php echo $r["Ld_Mobile"] ?>
                                                                    </span>
                                                                    <div class="labels-list">
                                                                    <?php
                                                                  

                                                                    $lbs = getLabelsByLeadId($r["Ld_Id"]);

                                                                    if (isset($lbs)) {
                                                                        if ($lbs->num_rows > 0) {
                                                                            while ($lb = $lbs->fetch_assoc()) {
                                                                                ?>

                                                                                    <span class="label-tag" style="color:<?php echo $lb["Lb_ColorCode"] ?>">
                                                                                        <i class="fas fa-circle"></i>
                                                                                <?php echo $lb["Lb_Name"] ?>
                                                                                    </span>

                                                                        <?php }
                                                                        }
                                                                    } ?>
                                                                    </div>
                                                                    <div class="d-flex mt-1">
                                                                        <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($r["Ld_CreatedDate"])) ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                                    <?php echo timeago($r["Ld_CreatedDate"]) ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <span data-toggle="tooltip" title="Last Call <br/> <?php echo $r["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($r["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                                                class="fas fa-phone"></i>&nbsp;&nbsp;
                                                                    <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?>
                                                                        </span>
                                                                        <span class="mx-2">|</span>
                                                                        <!-- <span><i class="fas fa-circle fa-md text-info mr-1"></i></span> -->
                                                                        <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;
                                                                    <?php echo $r["callcount"] ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="statusactions">
                                                            <!-- <span class="action-badge text-success"><i class="fas fa-flag fa-xs"></i></span> -->                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php
                                        }
                                        ?>
                                        </div>
                                <?php
                            } else {
                                ?>
                                        <div>
                                            <div class="lead-card">
                                                No Records Found
                                            </div>
                                        </div>
                                <?php
                            }
                        }
                    }?>



                </div>
            <?php }}
        }
    } ?>
</div>