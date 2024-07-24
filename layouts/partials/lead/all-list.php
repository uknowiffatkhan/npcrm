<?php

include('../../../config/db.php');

include('../../../config/encrypter.php');

include("../../../utils/helper.php");

include("../../../model/leadmodel.php");
include("../../../model/dropdownmodel.php");

$uid = $_SESSION["UId"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // print_r($_POST);
    // $type = $_POST["type"];
    $leadtype = "";
    $misc = "";
    $stat = $_POST["status"];
    $src = $_POST["source"];
    $int = $_POST["interest"];
    $sdate = $_POST["sdate"];
    $edate = $_POST["edate"];
    $dateby = $_POST["dateby"];
    $leadsearch = $_POST["leadsearch"];
    $cid = $_POST["cid"];
    if(isset($_POST["misc"])){
        $misc = $_POST["misc"];
    }
    if(isset($_POST["lbl"])){
        $misc = $_POST["misc"];
    }
    
    
    if($cid != ""){
        $uid = $cid;
        $typeId = "4";
        $leadtype = 1;
    }

    if(($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1")){

        $uid = $_POST["uid"];
        
        if($_POST["cid"]){
            $uid = $_POST["cid"]  ;
        }

        $ut = getUsertype($uid);
        if ($ut['U_TypeId'] == 5 ){
            $leadtype = 2;
        }
        $re = getAllListByFilter($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch,$leadtype,$misc);

    }elseif(($_SESSION["TypeId"] == "5" && $_SESSION["Role"] == "2")){
        $re = getAllCpListByFilter($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch, $misc);
    }elseif($_SESSION["TypeId"] == "7" ){
        $re = getAllRecepListByFilter($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch,1, $misc);

    }else{
        $re = getAllListByFilter($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch,$leadtype,$misc);
    }


}

?>



<div class="all-list">
    <div class="d-flex">
        <?php if (isset($re)) {
            if ($re->num_rows > 0) {
                while ($r = $re->fetch_assoc()) {
                    ?>

                    <div class="lead-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="leaddetails d-flex align-items-center">
                                    <label class="mr-1">
                                        <input type="checkbox" />
                                    </label>
                                    <div class="d-grid showdetails">
                                        <input type="hidden" name="leadid" value="<?php echo $r["Ld_Id"] ?>" />
                                        <span
                                            class="status-badge badge badge-<?php echo str_replace(" ", "-", $r["Ls_Name"]) ?>"><?php echo ($r["ParentLabel"] ? $r["ParentLabel"].' - ' : ""). $r["Ls_Name"] ?></span>
                                        <span class="leadtitle mt-1">
                                            <?php echo $r["Ld_Name"] ?>
                                        </span>
                                        <p>
                                            <?php echo $r["Rt_Name"] . " | " . $r["Sc_Name"] ?>
                                        </p>
                                        <span>
                                            <?php echo $r["Ld_Mobile"] ?>
                                        </span>
                                        <div class="labels-list">
                                            <?php

                                            $lbs = getLabelsByLeadId($r["Ld_Id"]);

                                            if (isset($lbs)) {
                                                if ($lbs->num_rows > 0) {
                                                    while ($lb = $lbs->fetch_assoc()) {
                                                        ?>

                                                        <span class="label-tag" style="color:<?php echo $lb["Lb_ColorCode"] ?>">
                                                            <i class="fas fa-circle"></i>
                                                            <?php echo $lb["Lb_Name"] ?>
                                                        </span>

                                                    <?php }
                                                }
                                            } ?>
                                        </div>
                                        <div class="d-flex mt-1">
                                            <span data-toggle="tooltip" title="Lead Date <br/> <?php echo date('d M Y',strtotime($r["Ld_CreatedDate"])) ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                    class="far fa-clock fa-lg"></i>&nbsp;&nbsp;
                                                <?php echo timeago($r["Ld_LeadDate"]) ?>
                                            </span>
                                            <span class="mx-2">|</span>
                                            <span data-toggle="tooltip" title="Last Call <br/> <?php echo $r["Ld_LastCallDate"] != "" ? date('d M Y h:i A',strtotime($r["Ld_LastCallDate"])) : "-" ?>" data-placement="bottom" class="d-flex align-items-center text-danger fw-600"><i
                                                    class="fas fa-phone"></i>&nbsp;&nbsp;
                                                <?php echo $r["Ld_LastCallDate"] != "" ? timeago($r["Ld_LastCallDate"]) : "-" ?>
                                            </span>
                                            <span class="mx-2">|</span>
                                            <!-- <span><i class="fas fa-circle fa-md text-info mr-1"></i></span> -->
                                            <span data-toggle="tooltip" title="Call Counts" data-placement="bottom" class="text-danger"><i class="fas fa-headset fa-lg"></i>&nbsp;&nbsp;
                                                <?php echo $r["callcount"] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="statusactions">
                                <!-- <ul class="d-grid text-center mb-0">
                        <li><i class="fas fa-circle fa-xs text-info"></i>
                        </li>
                        <li><i class="fas fa-headset fa-md text-danger"></i>
                        </li>
                    </ul> -->
                            </div>
                        </div>
                    </div>

                <?php }
            }
        } ?>
    </div>
</div>