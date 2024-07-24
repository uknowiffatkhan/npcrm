<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/callmodel.php");
include("../../../utils/helper.php");
$uid = $_SESSION["UId"];


if(isset($_POST["userid"]) && $uid == 1){
    if($_POST["userid"] != ""){
        $uid = $_POST["userid"];
    }
    
}


$sw = getSitevistPlan($uid);


?>

<?php

if ($sw->num_rows > 0) {
    while ($r = $sw->fetch_assoc()) {
        if (isset($r["actiondate"])):
        ?>
        <?php if($_SESSION['TypeId'] == 0):?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Site%20Visit%20Plan&filtertype=leadstatus&visitrange=<?php echo $r["actiondate"] != "0" ? date('Y-m-d',strtotime($r["actiondate"])) : date('Y-m-d',strtotime('-1 years'))  ?>_<?php echo $r["actiondate"] != "0" ? date('Y-m-d',strtotime($r["actiondate"])) : date('Y-m-d') ?><?php echo $r["actiondate"] == "0" ? "&misc=missed" : "" ?><?php echo isset($uid) ? "&uid=" . urlencode(encrypt($uid)) : "" ?>" >

        <?php else: ?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Site%20Visit%20Plan&filtertype=leadstatus&visitrange=<?php echo $r["actiondate"] != "0" ? date('Y-m-d',strtotime($r["actiondate"])) : date('Y-m-d',strtotime('-1 years'))  ?>_<?php echo $r["actiondate"] != "0" ? date('Y-m-d',strtotime($r["actiondate"])) : date('Y-m-d') ?><?php echo $r["actiondate"] == "0" ? "&misc=missed" : "" ?>" >

        <?php endif;?> 
            <div class="card mr-1">
                <div class="card-body <?php echo $r["actiondate"] != "0" ? "" : "bg-danger text-white" ?>">
                    <label><i class="fas fa-circle"></i>
                        <?php echo $r["actiondate"] != "0" ? getRangeDateString(strtotime($r["actiondate"])) : "Missed" ?>
                    </label>
                    <h1 class="m-0 <?php echo $r["actiondate"] != "0" ? "" : "bg-danger text-white" ?>">
                        <?php echo $r["leadcount"] ?>
                    </h1>
                </div>
            </div>
        </a>
        <?php
        endif;
    }

} else {
    ?>
    <div class="card mr-3">
        <div class="card-body ">
            No Records Found
        </div>
    </div>
    <?php
}
?>