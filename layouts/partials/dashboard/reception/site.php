<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../../model/leadmodel.php");
$uid = $_SESSION["UId"];

if (isset($_POST["userid"]) && $uid == 1) {
    if ($_POST["userid"] != "") {
        $uid = $_POST["userid"];
    }
}

$svp = getAllReceptionSiteVisitPlan();
$sv = getAllSalesSiteVisitCount();

if ($svp->num_rows > 0) {
    while ($r = $svp->fetch_assoc()) {
        ?>
        <div class="card flex-fill w-50">
            <div class="card-header p-3 bg-danger-gradient text-center px-4">
                <i class="fa-solid fa-building-user fa-2xl text-white"></i>
            </div>
            <div class="card-body pt-0 p-3 text-center">
                <h6 class="text-center mb-0 mt-2">Site Visit Plan</h6>
                <span class="text-xs">For Today</span>
                <hr class="horizontal dark my-3">
                <h5 class="mb-0"><?php echo $r["count"]; ?></h5>
            </div>
        </div>
        <?php
    }
}

if ($sv->num_rows > 0) {
    while ($s = $sv->fetch_assoc()) {
        ?>
        <div class="card flex-fill w-50">
            <div class="card-header p-3 bg-success-gradient text-center px-4">
                <i class="fa-solid fa-building-user fa-2xl text-white"></i>
            </div>
            <div class="card-body pt-0 p-3 text-center">
                <h6 class="text-center mb-0 mt-2">Site Visited</h6>
                <span class="text-xs">Today</span>
                <hr class="horizontal dark my-3">
                <h5 class="mb-0"><?php echo $s["count"]; ?></h5>
            </div>
        </div>
        <?php
    }
}
?>
