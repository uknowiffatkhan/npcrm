<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
include("../../../model/leadmodel.php");

$uid = $_SESSION["UId"];

$vl = getVisitPlanCount($uid,date('Y-m-d'),date('Y-m-d', strtotime('+1 year')));
$vtd = getVisitedCount($uid,date('Y-m-d'),date('Y-m-d', strtotime('+1 year')));
$bl = getBookedCount($uid,date('Y-m-d'),date('Y-m-d', strtotime('+1 year')));
?>


<?php if($_SESSION["TypeId"] == "4"){
    ?>
      <div class="d-flex flex-wrap  align-items-center justify-content-start my-2 w-100">
      <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Site Visit Planned&filtertype=leadstatus&visitrange=<?php echo date('Y-m-d')."_". date('Y-m-d', strtotime('+1 year'))?>">

      <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-danger border-4 mr-1 mb-0">
        <div class="card-body p-0 m-0">
            <div class="d-flex">
                <div class="me-3 d-flex align-items-center ">
                <div class="rounded-circle bg-danger text-white px-3 py-2" style="width: 30px; height: 30px;justify-content: center;display: flex;align-items: center;">
                    <i class="fa-solid fa-pause"></i>
                </div>
                </div>
                <div>
                <h5 class="card-title mb-0"><?php echo isset($vl) ? $vl['counts'] : "0" ?></h5>
                <p class="card-text small" style="line-height: normal;">Site Visit Planned</p>
                </div>
            </div>
        </div>
      </div>
</a>
      <a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Site Visited&filtertype=leadstatus&visitrange=<?php echo date('Y-m-d')."_". date('Y-m-d', strtotime('+5 year'))?>">

        <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-primary border-4 mr-1 mb-0">
            <div class="card-body p-0 m-0">
                <div class="d-flex">
                    <div class="me-3 d-flex align-items-center ">
                    <div class="rounded-circle bg-primary text-white px-3 py-2" style="width: 30px; height: 30px;justify-content: center;display: flex;align-items: center;">
                        <i class="fa-solid fa-pause"></i>
                    </div>
                    </div>
                    <div>
                    <h5 class="card-title mb-0"> <?php echo isset($vtd) ? $vtd['counts'] : "0" ?> </h5>
                    <p class="card-text small" style="line-height: normal;">Site Visited</p>
                    </div>
                </div>
            </div>
        </div>
</a>
<a href="<?php echo $baseurl?>v/lead/list.php?type=all&filter=Booked&filtertype=leadstatus&visitrange=<?php echo date('Y-m-d')."_". date('Y-m-d', strtotime('+5 year'))?>">

        <div class="card card-raised border-bottom-0 border-end-0 border-top-0 border-info border-4 mr-1 mb-0">
            <div class="card-body p-0 m-0">
                <div class="d-flex">
                    <div class="me-3 d-flex align-items-center ">
                    <div class="rounded-circle bg-info text-white px-3 py-2" style="width: 30px; height: 30px;justify-content: center;display: flex;align-items: center;">
                        <i class="fa-solid fa-pause"></i>
                    </div>
                    </div>
                    <div>
                    <h5 class="card-title mb-0"> <?php echo isset($bl) ? $bl['counts'] : "0" ?> </h5>
                    <p class="card-text small" style="line-height: normal;">Total Booking</p>
                    </div>
                </div>
            </div>
        </div>      
      </div>
</a>
   
<?php

}

?>