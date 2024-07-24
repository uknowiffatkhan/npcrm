<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];


if(isset($_POST['uid']) && ($_SESSION["Role"] == 2 || $_SESSION["Role"] == 1  )){
$uid = $_POST['uid'];

}


$sw = getStatusWiseCounts($uid);




?>
<?php if($_SESSION["TypeId"] == "4"){
     if ($sw->num_rows > 0) {
    ?>
     <div class="card w-100 mt-0" style="overflow-x: hidden;overflow-y: scroll;height: 300px;">
                 <div class="card-body" >
                     <table class="skeleton-table table">
                         <thead>
                             <tr>
                             <td>Status</td>
                             <td>Count</td>
                             <td></td>
                             </tr>
                         </thead>
                         <tbody>
                            <?php
                                while ($r = $sw->fetch_assoc()) {?>
                                <tr>
                                <td><?php echo $r["Parent_Name"] != '' ? $r["Parent_Name"] . "-" . $r["Ls_Name"] : $r["Ls_Name"]; ?></td>
                                <td><?php echo $r["totals"] ?></td>
                                    <td><a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=<?php echo $r["Ls_Name"] ?>&filtertype=leadstatus&range=<?php echo "2001-01-01_".date('Y-m-d')?>"><i class="fa-solid fa-arrow-up-right-from-square" style="color: #005eff;"></i></a></td>
                                </tr>
                                <?php }
                            ?>
                         </tbody>
                         </table>
                    </div>
        </div> 
<?php 
    }else{?>
        <div class="card  w-100 mr-3">
        <div class="card-body">
            No Records Found
        </div>
    </div>
   <?php }
}else{

    if ($sw->num_rows > 0) {
        while ($r = $sw->fetch_assoc()) {
    ?>
                <?php if($r["Parent_Name"] != ''):?>
                <p class="w-100 h5 fw-semibold border-top mt-3 pt-2"><?=$r["Parent_Name"]?></p>
                <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=<?php echo $r["Ls_Name"] ?>&filtertype=leadstatus&range=<?php echo "2001-01-01_".date('Y-m-d')?><?php echo isset($uid) ? "&cid=" . urlencode(encrypt($uid)) : "" ?>">
                <div class="card mr-3">
                    <div class="card-body status-<?php echo (isset($r["Ls_Name"]) ? str_replace(" ", "-", $r["Ls_Name"]) : "") ?>">
                        <label><i class="fas fa-circle"></i>
                        <td><?php echo  $r["Ls_Name"] ?></td>
                        </label>
                        <h1 class="m-0">
                            <?php echo $r["totals"] ?>
                        </h1>
                    </div>
                </div>
                </a>
                <?php else:?> 
                    <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=<?php echo $r["Ls_Name"] ?>&filtertype=leadstatus&range=<?php echo "2001-01-01_".date('Y-m-d')?><?php echo isset($uid) ? "&uid=" . urlencode(encrypt($uid)) : "" ?>">
                <div class="card mr-3">
                    <div class="card-body status-<?php echo (isset($r["Ls_Name"]) ? str_replace(" ", "-", $r["Ls_Name"]) : "") ?>">
                        <label><i class="fas fa-circle"></i>
                        <td><?php echo $r["Ls_Name"]; ?></td>
                        </label>
                        <h1 class="m-0">
                            <?php echo $r["totals"] ?>
                        </h1>
                    </div>
                </div>
                </a>
                <?php endif;?>
                
<?php
        }
    }else{?>
        <div class="card   mr-3">
            <div class="card-body w-100">
                No Records Found
            </div>
        </div>
   <?php }
} ?>
