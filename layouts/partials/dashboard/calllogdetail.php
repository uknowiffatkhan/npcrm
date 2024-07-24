<?php
   if (!isset($_SESSION)) {
       session_start();
   }
   
   $baseurl = $_SESSION["baseurl"];
   include("../../../model/dashboard.php");
   include("../../../model/leadmodel.php");
   $uid = $_SESSION["UId"];
   $sdate = $_POST["sdate"];
   $edate = $_POST["edate"];

   
   if(isset($_POST["userid"])){
       if($_POST["userid"] != "" && $_POST["userid"] != "undefined"){
           $uid = $_POST["userid"];
       }
       

     
   }
   if($uid != "" && $uid != 1){
       $sw = getCallLogsDetByUID($sdate, $edate, $uid);
       $vl = getFirstVisitPlanOverview($sdate, $edate, $uid);
       $vtd = getFirstVisited($sdate, $edate, $uid);
       $clg = getCallsCounts($uid, $sdate, $edate);
       $bl = getBookedCount($uid,$sdate, $edate);
   }
   
   
   ?>

<div class="d-flex flex-wrap w-100 align-items-center justify-content-center">
<?php if($_SESSION["TypeId"] != "4"): ?>
   
<div class="card mr-1">
      <div class="card-body">
         <?php
            if (isset($clg) && $clg->num_rows > 0) {
                $ttl = "0";
                $connect = "0";
                $disconnect = "0";
                while ($cl = $clg->fetch_assoc()) {
                    $ttl = $cl["all"];
                    if ($cl["label"] == "Connected") {
                        if ($cl["totals"] > 0) {
                            $connect = $cl["totals"];
                        }
                    }
                    if ($cl["label"] == "Disconnected") {
                        if ($cl["totals"] > 0) {
                            $disconnect = $cl["totals"];
                        }
                    }
                }
                ?>
         <label class="m-0">Total / Connected / Disconnected</label>
         <h2 class="m-0">
            <?php echo $ttl . " / " . $connect . " / " . $disconnect ?>
         </h2>
         <?php
            } else {
                ?>
         <label class="m-0">Total / Connected / Disconnected</label>
         <h2 class="m-0">
            0 / 0 / 0
         </h2>
         <?php
            }
            ?>
      </div>
   </div>

   <?php endif;?>
   <?php
      if($_SESSION["TypeId"] == "0"){?>
   <a href="javascript:;" data-bs-toggle="modal"
      data-bs-target="#leadmodalCenter" class="visit-modal">
      <div class="card mr-1">
      <input type="hidden" class="lead-id" value="<?php echo isset($vl) ? $vl['LeadsId'] : "0" ?> ">
         <div class="card-body">
            <label class="m-0">Site Visit Planned</label>
            <h2 class="m-0">
               <?php echo isset($vl) ? $vl['counts'] : "0" ?>
            </h2>
         </div>
      </div>
   </a>
   <?php } else {?> 
    <!-- <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Site Visit Plan&filtertype=leadstatus&visitrange=<?php echo $sdate."_".$edate?>"> -->
    <div class="card mr-1">
      <div class="card-body">
         <label class="m-0">Site Visit Planned</label>
         <h2 class="m-0">
            <?php echo isset($vl) ? $vl['counts'] : "0" ?>
         </h2>
      </div>
   </div>
   <!-- </a> -->
   <?php }
      if($_SESSION["TypeId"] == "0"){?>
   <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#leadmodalCenter" class="visit-modal">
      
      <div class="card mr-1">
         <input type="hidden" class="lead-id" value="<?php echo isset($vtd) ? $vtd['LeadID'] : "0" ?> ">
         <div class="card-body">
            <label class="m-0">Site Visited</label>
            <h2 class="m-0">
               <?php echo isset($vtd) ? $vtd['counts'] : "0" ?>            
            </h2>
         </div>
      </div>
   </a>

   <?php }else {?> 
    <!-- <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Site Visited&filtertype=leadstatus&visitrange=<?php echo $sdate."_".$edate?>"> -->
   <div class="card mr-1">
      <div class="card-body">
         <label class="m-0">Site Visited</label>
         <h2 class="m-0">
            <?php echo isset($vtd) ? $vtd['counts'] : "0" ?>
         </h2>
      </div>
   </div>
   <!-- </a> -->
 
   <?php } 
         if($_SESSION["TypeId"] == "0"){?>
           <!-- <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Booked&filtertype=leadstatus&visitrange=<?php echo $sdate."_".$edate?>"> -->

           <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#leadmodalCenter" class="visit-modal">
      
      <div class="card mr-1">
         <input type="hidden" class="lead-id" value="<?php echo isset($bl) ? $bl['LeadID'] : "0" ?> ">
         <div class="card-body">
            <label class="m-0">Booked</label>
            <h2 class="m-0">
               <?php echo isset($bl) ? $bl['counts'] : "0" ?>            
            </h2>
         </div>
      </div>
   </a>
   <!-- </a> -->

 <?php }else {?> 
  <!-- <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Booked&filtertype=leadstatus&visitrange=<?php echo $sdate."_".$edate?>"> -->

  <div class="card">
      <div class="card-body">
         <label class="m-0">Booked</label>
         <h2 class="m-0">
            <?php echo isset($bl) ? $bl['counts'] : "0" ?>
         </h2>
      </div>
   </div>
   <!-- </a> -->

   <?php } ?> 
</div>
<div class="card box2 w-100"<?php echo ($_SESSION["TypeId"] == "4") ? 'style="height: 400px;overflow: scroll;"' : (($_SESSION["TypeId"] == "5") ? 'style="height: 300px;overflow-y: scroll;overflow-x: hidden;"' : ''); ?>
   >
   <table class="table">

         <?php
            if (isset($clg) && $_SESSION["TypeId"] == "4") {
                $ttl = "0";
                $connect = "0";
                $disconnect = "0";
                while ($cl = $clg->fetch_assoc()) {
                    $ttl = $cl["all"];
                    if ($cl["label"] == "Connected") {
                        if ($cl["totals"] > 0) {
                            $connect = $cl["totals"];
                        }
                    }
                    if ($cl["label"] == "Disconnected") {
                        if ($cl["totals"] > 0) {
                            $disconnect = $cl["totals"];
                        }
                    }
                }
                ?>
                <tr>
                    <th colspan="4">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-4 text-center">Total - <?php echo $ttl ? $ttl : '0' ?></div>
                        <div class="col-4  text-center">Connected - <?php echo $connect ? $connect : '0' ?></div>
                        <div class="col-4  text-center">Disconnected - <?php echo $disconnect ? $disconnect : '0' ?></div>

                    </div>
                    </th>
            </tr>
         <?php } ?>
         <tr>
            <th style="font-size: 10px;">Status</th>
            <th style="font-size: 10px;">Total Calls</th>
            <th style="font-size: 10px;">Connected</th>
            <th style="font-size: 10px;">Disconnected</th>
         </tr>
         <?php
            if (isset($sw) && $sw->num_rows > 0) {
                while ($r = $sw->fetch_assoc()) {
                    ?>
         <tr>
            <td>
               <?php echo $r["Ls_Name"] ?>
            </td>
            <td>
               <?php echo $r["counts"] ?>
            </td>
            <td>
               <?php echo $r["Connected"] ?>
            </td>
            <td>
               <?php echo $r["Disconnected"] ?>
            </td>
         </tr>
         <?php
            }
            } else {
            ?>
         <tr>
            <td colspan="4">
               No Records Found
            </td>
         </tr>
         <?php
            }
            ?>
      </table>
   </div>
</div>