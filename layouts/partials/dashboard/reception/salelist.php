<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../../model/commonmodel.php");

$uid = $_SESSION["UId"];

$search="";
if(isset($_POST['search'])){
    $search = $_POST['search'];
}

$sl = getActiveSaleList($search);



?>

<?php

if ($sl->num_rows > 0) {
    while ($r = $sl->fetch_assoc()) {
        ?>
         <li class="list-group-item border-1 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
               <div class="d-flex align-items-center">
                  <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                     <i class="ni ni-mobile-button text-white opacity-10"></i>
                  </div>
                  <div class="d-flex flex-column ">
                     <h6 class="mb-1 text-dark text-sm"><?= $r["U_DisplayName"]?></h6>
                     <?php
                            $status = $r["U_Online"] == 1 ? 'Online' : 'Offline';
                            $colorClass = $status == 'Online' ? 'text-primary' : 'text-danger';
                    ?>
                    <p class="text-xs mb-0" style="font-size: 12px;">
                        Contact : <?= $r["U_Mobile"]?>
                    </p>
                    <p class="text-xs mb-0" style="font-size: 12px;">
                        Emp Code : <?= $r["U_EmpCode"]?>
                    </p>
                    
                    <p class="text-xs mb-0 fw-bold <?php echo $colorClass; ?>" style="font-size: 12px;">
                        Status : <?php echo $status; ?>
                    </p>

                  </div>
               </div>
               <div class="py-2 align-items-center">
               <p class="text-xs mb-0 text-danger fw-bold" style="font-size: 12px;">
                  <?= ($vp = getSalesVisitPlanCount($r["U_Id"])) ? "+" . $vp['leadcount'] . " Visit Plan" : "0 Visit Plan" ?>
                </p>
                   
               <p class="text-xs mb-0 text-primary fw-bold" style="font-size: 12px;">
               <?= ($v = getSalesVisitCount($r["U_Id"])) ? "+" . $v['leadcount'] . " Visited" : "0 Visited" ?>
                </p>
            
            </div>

              
            </li>
        <?php
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