<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];

$sw = getInterestWiseCounts($uid);


?>
<?php if($_SESSION["TypeId"] == "4"){
        if ($sw->num_rows > 0) {

    ?>
    
     <div class="card w-100 mt-0 " style="overflow-x: hidden;overflow-y: scroll;height: 300px;">
                 <div class="card-body">
                     <table class="skeleton-table table">
                         <thead>
                             <tr>
                             <td>Unit</td>
                             <td>Count</td>
                             <td></td>

                             </tr>
                         </thead>
                         <tbody>
                            <?php
                                while ($r = $sw->fetch_assoc()) {?>
                                <tr><td><?php echo $r["Rt_Name"] ?></td>
                                 <td><?php echo $r["totals"] ?></td>
                                <td>
                                <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=<?php echo $r["Rt_Name"] ?>&filtertype=interest&range=<?php echo "2001-01-01_".date('Y-m-d')?>"><i class="fa-solid fa-arrow-up-right-from-square" style="color: #005eff;"></i></a> 
                                </td>
                                </tr>
                                <?php } ?>
                         </tbody>
                         </table>
                    </div>
        </div> 
<?php
 }else{
    ?>
    <div class="card  w-100 mr-3">
        <div class="card-body">
            No Records Found
        </div>
    </div>
    <?php 
}

}else{
    if ($sw->num_rows > 0) {
        while ($r = $sw->fetch_assoc()) {
            ?>
            <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=<?php echo $r["Rt_Name"] ?>&filtertype=interest&range=<?php echo "2001-01-01_".date('Y-m-d')?>">
                <div class="card mr-3">
                    <div class="card-body status-<?php echo (isset($r["Rt_Name"]) ? str_replace(" ", "-", $r["Rt_Name"]) : "") ?>">
                        <label><i class="fas fa-circle"></i>
                            <?php echo $r["Rt_Name"] ?>
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
        <div class="card mr-3 w-100">
            <div class="card-body">
                No Records Found
            </div>
        </div>
        <?php
    }
}

?>