<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];


$sw = getConfirmCp($uid);
// var_dump($sw); // Debugging to see the contents of $sw

?>

<?php
if ($sw->num_rows > 0) {
    while ($r = $sw->fetch_assoc()) {
        ?>
        <a class =" btn text-white" href="<?php echo $baseurl?>v/lead/confirmcp_lead.php?type=all&filtertype=confirmcp&range=<?php echo "2001-01-01_".date('Y-m-d')?>">
        <button type="button" class="btn btn-info mr-1  px-3">
                Confirm CP &nbsp; - &nbsp;<?php echo $r["totals"] ?>
                </button>    
        </a>
        <?php
    }
} else {
    ?>
    <div class="card mr-3">
        <div class="card-body text-Confirm CP">
            No Records Found
        </div>
    </div>
    <?php
}
?>