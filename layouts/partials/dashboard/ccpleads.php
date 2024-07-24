<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];


$sw = getcpleads($uid);
// var_dump($sw); // Debugging to see the contents of $sw

?>

<?php
if ($sw->num_rows > 0) {
    while ($r = $sw->fetch_assoc()) {
        ?>
        <!-- <button type="button" class="btn btn-white text-black mr-1 p-2 px-4"> -->
                <h6 class="mr-1 mt-3 text-black"><b>CP Leads &nbsp; - &nbsp; <?php echo $r["totals"]  ?></b></h6>
                <!-- </button>     -->

            <?php echo $r["totals"] ?>
      
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