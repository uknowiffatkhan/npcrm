<?php

if (!isset($_SESSION)) {
    session_start();
}

// $baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];

$sdate = $_POST["sdate"];
$edate = $_POST["edate"];

$sw = getCallsCounts($uid, $sdate, $edate);

?>

<?php
if ($sw->num_rows > 0) {

$ind = 0;
    ?>
    <i class="fas fa-headset fa-lg mr-1"></i>

    

    <?php while ($r = $sw->fetch_assoc()) {
        if ($r["label"] == "Connected") {
            if ($r["totals"] > 0) {
                ?>
                <p class="mb-0 mr-3 status-New"><b><i class="bx bxs-phone"></i>:
                        <?php echo $r["totals"] . "(" . round($r["totals"] / $r["all"] * 100) . "%)" ?>
                    </b></p>

            <?php } else { ?>
            <p class="mb-0 mr-3 status-New"><b><i class="bx bxs-phone"></i>: 0 (0%)</b></p>
        <?php }
        } 
        if ($r["label"] == "Disconnected") {
            if ($r["totals"] > 0) {
                ?>
                <p class="mb-0 mr-3 text-danger"><b><i class='bx bxs-phone-off'></i>:
                    <?php echo $r["totals"] . "(" . round($r["totals"] / $r["all"] * 100) . "%)" ?>
                    </b></p>

            <?php } else { ?>
            <p class="mb-0 mr-3 text-danger"><b><i class='bx bxs-phone-off'></i>: 0 (0%)</b></p>
        <?php }
        }
        if ($r["label"] == "Message") {
            if ($r["totals"] > 0) {
                ?>
                <p class="mb-0 mr-3"><b><i class='bx bxs-message-rounded-detail'></i>:
                    <?php echo $r["totals"] . "(" . round($r["totals"] / $r["all"] * 100) . "%)" ?>
                    </b></p>

            <?php } else { ?>
            <p class="mb-0 mr-3"><b><i class='bx bxs-message-rounded-detail'></i>: 0 (0%)</b></p>
        <?php }
        }
        
        
        $ind = $ind + 1;
    } ?>
<?php


} else { ?>
    <i class="fas fa-headset fa-lg mr-1"></i>
    <p class="mb-0 mr-3 status-New"><b><i class="bx bxs-phone"></i>: 0 (0%)</b></p>
    <p class="mb-0 mr-3 text-danger"><b><i class='bx bxs-phone-off'></i>: 0 (0%)</b></p>
    <p class="m-0"><b><i class='bx bxs-message-rounded-detail'></i>: 0 (0%)</b></p>
<?php } ?>