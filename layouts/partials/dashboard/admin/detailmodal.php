<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../../model/dashboard.php");
include("../../../../model/leadmodel.php");

$uid = $_SESSION["UId"];
$lid = $_POST["lid"];
$sw = getLeadDetails($lid);
?>


<!-- Modal-->

<div class="row">
    <?php
    if ($sw->num_rows > 0) {
        while ($r = $sw->fetch_assoc()) {?>
            <div class=" col-md-4 col-lg-3">
                <div class="card mb-3" style="
    box-shadow: none !important;
">
                    <div class="lead-card card-body">
                        <div class="leaddetails ">
                            <div class="d-grid showdetails">
                            <input type="hidden" name="uid" value="<?php echo $r["Ld_Id"] ?>">
                                <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>">
                                <span class="status-badge badge badge-<?php echo str_replace(" ", "-", $r["Ls_Name"]) ?>"><?php echo $r["Ls_Name"] ?></span>
                                <span class="leadtitle"><?php echo $r["Ld_Name"] ?></span>
                                <p class="m-0"><?php echo $r["Rt_Name"]."|" ?>  <?php echo $r["Sc_Name"] ?></p>
                                <span><?php echo $r["Ld_Mobile"] ?></span>
                                <div class="labels-list"></div>
                                <div class="d-flex mt-1">
                                    <span class="d-flex align-items-center text-danger fw-600"><i class="far fa-clock fa-lg"></i>&nbsp;&nbsp;<?php echo timeago($r["Ld_LeadDate"]) ?></span>
                                    <span class="mx-2">|</span>
                                    <span class="d-flex align-items-center text-danger fw-600"><i class="fas fa-phone"></i>&nbsp;&nbsp;<?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?></span>
                                    <span class="mx-2">|</span>
                                    <span class="text-danger"><i class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;<?php echo $r["callcount"] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="statusactions"></div>
                </div>
            </div>
    <?php 
        }
    }?>
</div>

