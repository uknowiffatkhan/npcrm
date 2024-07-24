<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];


$sw = getSourceWiseCounts($uid);


?>

<?php
if ($sw->num_rows > 0) {
    while ($r = $sw->fetch_assoc()) {
        ?>
        <a href="<?php echo $baseurl ?>v/lead/list.php?type=all&filter=<?php echo $r["Sc_Name"] ?>&filtertype=source&range=<?php echo "2001-01-01_".date('Y-m-d')?>"
            target="_blank">
            <div class="card mr-3">
                <div class="card-body text-<?php echo $r["Sc_Name"] ?>">
                    <label>
                        <?php echo $r["Sc_Name"] ?>
                    </label>
                    <h1 class="m-0">
                        <?php echo $r["totals"] ?>
                    </h1>
                </div>
            </div>
        </a>

        <?php
    }
} else {
    ?>
    <div class="card mr-3">
        <div class="card-body text-<?php echo $r["Ls_Name"] ?>">
            No Records Found
        </div>
    </div>
    <?php
}
?>