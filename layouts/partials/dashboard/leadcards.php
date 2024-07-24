<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
include("../../../utils/helper.php");
$uid = $_SESSION["UId"];
$sw = getLeads10($uid);

?>

<?php
if ($sw->num_rows > 0) {
    while ($r = $sw->fetch_assoc()) {
        ?>

        <div class="card mb-3">
            <div class="card-body">
                <div class="lead-card">
                    <div class="">
                        <div>
                            <div class="leaddetails ">

                                <div class="d-grid showdetails">
                                    <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>">
                                    <!-- <span class="status-badge badge badge-success">New</span> -->
                                    <span class="leadtitle">
                                    <?php echo $r["Ld_Name"] ?> </span>
                                    <p class="m-0">
                                    <?php echo $r["Rt_Name"] ?> | <?php echo $r["Sc_Name"] ?> </p>
                                    <span>
                                    <?php echo $r["Ld_Mobile"] ?> </span>
                                    <div class="labels-list"></div>
                                    <div class="d-flex mt-1">
                                        <span class="d-flex align-items-center text-danger fw-600"><i
                                                class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                <?php echo timeago($r["Ld_LeadDate"]) ?> </span>
                                        <span class="mx-2">|</span>
                                        <span class="d-flex align-items-center text-danger fw-600"><i
                                                class="fas fa-phone"></i>&nbsp;&nbsp;
                                                <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?> </span>
                                        <span class="mx-2">|</span>
                                        <!-- <span class="text-info mr-1"><i class="fas fa-circle fa-md "></i></span> -->
                                        <span class="text-danger"><i class="fas fa-headset fa-lg "></i>&nbsp;&nbsp;
                                        <?php echo $r["callcount"] ?> </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="statusactions">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}
else {
    ?>
    <div class="card mr-3">
        <div class="card-body text-<?php echo $r["Ls_Name"] ?>">
            No Records Found
        </div>
    </div>
    <?php
}
?>