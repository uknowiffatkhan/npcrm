<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
include("../../../model/dropdownmodel.php");

$uid = $_SESSION["UId"];
$typeid = $_SESSION["TypeId"];
$roleid = $_SESSION["Role"];

$date = date('Y-m-d');  

if($typeid  == 0 ){
    $uid = $_POST['UId']; 
}

if(isset($_POST['UId']) && isset($_POST['date'])) {
    $uid = $_POST['UId']; 
    $date = $_POST['date'];
    $sw = getTodaysScope($uid,$date);

}else{
    $sw = getTodaysScope($uid,$date);
}


$new = getNewLeads($uid);
$newupdate = getNewUpdateLeads($uid);

?>


<div class="d-flex flex-nowrap align-items-center mb-3">


<?php if($typeid  == 0 ){?>
    <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=New&filtertype=leadstatus&range=2001-01-01_<?php echo date('Y-m-d')?>&misc=nocall<?php echo isset($uid) ? "&uid=" . urlencode(encrypt($uid)) : "" ?>">
        <?php } elseif( $roleid == 2){?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=New&filtertype=leadstatus&range=2001-01-01_<?php echo date('Y-m-d')?>&misc=nocall<?php echo isset($uid) ? "&uid=" . urlencode(encrypt($uid)) : "" ?>">

        <?php }else { ?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=New&filtertype=leadstatus&range=2001-01-01_<?php echo date('Y-m-d')?>&misc=nocall">
        <?php } 
        ?>
    <div class="card mr-1 mb-0">
        <div class="px-3 py-1 text-center bg-New text-white fs-xl box">
            <?php
            if($new->num_rows > 0){
                while($n = $new->fetch_assoc()){
                    ?>
                    <span style="font-size: 0.9rem;">New - <?php echo $n["newleads"]?></span>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    </a>

    


    <?php if($typeid  == 0  ){?>
    <a href="<?php echo $baseurl?>v/lead/list.php?type=all&range=2001-01-01_<?php echo date('Y-m-d')?>&misc=newupdate<?php echo isset($uid) ? "&uid=" . urlencode(encrypt($uid)) : "" ?>">
        <?php }elseif($roleid == 2 ){?>
           <a href="<?php echo $baseurl?>v/lead/list.php?type=all&range=2001-01-01_<?php echo date('Y-m-d')?>&misc=newupdate&cid=<?php echo isset($uid) ? "&cid=" . urlencode(encrypt($uid)) : "" ?>">
        <?php } else{ ?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=all&range=2001-01-01_<?php echo date('Y-m-d')?>&misc=newupdate">
        <?php } 
        ?>
    <div class="card mr-1 mb-0">
        <div class="px-3 py-1 text-center bg-Follow-Up text-white fs-xl">
            <?php
            if($newupdate->num_rows > 0){
                while($n = $newupdate->fetch_assoc()){
                    ?>
                    <span style="font-size: 0.9rem;">New Update- <?php echo $n["newupdateleads"]?></span>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    </a>
</div>


<div class="d-flex flex-wrap">
<?php
if ($sw->num_rows > 0) {
    while ($r = $sw->fetch_assoc()) {
        if($typeid == 0) { ?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=wise&wisefilter=time<?php echo isset($uid) ? "&uid=" . urlencode(encrypt($uid)) : "" ?>">        
        <?php } elseif($roleid == 2) { ?>
            <a href="<?php echo $baseurl; ?>v/lead/list.php?type=wise&wisefilter=time&fromDate=<?php echo date('Y-m-d'); ?><?php echo isset($uid) ? "&cid=" . urlencode(encrypt($uid)) : "" ?>">        
        <?php } else { ?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=wise&wisefilter=time&fromDate=<?php echo date('Y-m-d'); ?>">
        <?php } ?>
            <div class="card m-2">
                <div class="card-body box2  <?php echo $r["label"] == "Missed" ? "bg-danger text-white" : "" ?>">
                    <label><i class="fas fa-circle mr-1"></i>
                        <?php echo $r["label"] ?>
                    </label>
                    <h1 class="<?php echo $r["label"] == "Missed" ? "text-white" : "" ?> mb-0">
                        <?php echo $r["leadcount"] ?>
                    </h1>
                </div>
            </div>
        </a>
        <?php
        } 
        
        if($typeid  == 0 || $roleid == 2 ){
            $ut = getUsertype($uid);
            if ($ut['U_TypeId'] == 5 ){
                $sw = getConfirmCp($uid);
                if ($sw->num_rows > 0) {
                    while ($r = $sw->fetch_assoc()) {
                        ?>
                        <a href="<?php echo $baseurl?>v/lead/confirmcp_lead.php?type=all&filtertype=confirmcp&range=<?php echo "2001-01-01_".date('Y-m-d')?><?php echo isset($uid) ? "&cid=" . urlencode(encrypt($uid)) : "" ?>">   
                            <div class="card m-2">
                                <div class="card-body box2 bg-primary text-white">
                                    <label><i class="fas fa-circle mr-1"></i>
                                        Channel Partner
                                    </label>
                                    <h1 class="m-0 text-white">
                                    <?php echo $r["totals"] ?>
                                    </h1>
                                </div>
                            </div>
                        </a>    
                <?php }
                } 
            }
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
</div>
