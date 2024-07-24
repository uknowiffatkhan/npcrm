<?php

if (!isset($_SESSION)) {
    session_start();
}
// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/callmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/quotemodel.php";
$uid = $_SESSION["UId"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lid = $_POST["lid"];
    // echo $lid;
    $det = getCpLeadById($lid,$uid);
   
    $detcnt = $det->num_rows;

    $det = $det->fetch_assoc();


    $callog = getCallLogById($lid, $uid);
    $qcount = getQuoteCountsByLid($lid);

    $assignedsales = getAssignedSalesList($lid);
    $assignedusers = getAssignedCpLead($lid);
    $assignedusers2 = getAssignedCpLead($lid);

    $visited = getVisitedCounts($lid);
    $salesassigned = $assignedusers2->num_rows;
    $samesales = false;

    $asngdusers = getAssignedCpLead($lid);
    while ($asnd = $asngdusers->fetch_assoc()) {
        if ($uid == $asnd["U_Id"]) {
            ReadNewUpdateLead($lid, $uid);
            break;
        }
    }

    if (isset($_SESSION["openlead"])) {
        $_SESSION["openlead"] = "";
    }
}



?>


<div class="lead-details-blk">
    <div>

    <h4 style="font-weight: bold; font-size: 13px;">Channel Partner Details : </h4>
     
        <hr />

        <input type="hidden" name="detailid"
            value="<?php echo $detcnt > 0 ? ($det["Cp_Id"] != "" ? $det["Cp_Id"] : "") : "" ?>" />
        <h4 class="d-grid align-items-center justify-content-between">
            <div class="mb-1">
            <span style="font-size: 15px; font-size: 1.5rem;">
                <?php echo $detcnt > 0 ? ($det["Cp_Name"] != "" ? $det["Cp_Name"] : "-") : "-" ?>
            </span>
                <button type="button" id="reloadleaddetails"
                    value="<?php echo $detcnt > 0 ? ($det["Cp_Id"] != "" ? $det["Cp_Id"] : "") : "" ?>"
                    class="btn btn-xs btn-transparent"><i class="fas fa-rotate"></i></button>
            </div>
           
            <b style="font-size: 0.8rem;">
            <?php echo $detcnt > 0 ? ($det["Cp_Code"] != "" ? $det["Cp_Code"] : "-") : "-" ?>
            </b>
         
            &nbsp;
            &nbsp;
            &nbsp;
            <?php if ($salesassigned > 0) {
                ?>
                <div style="font-size:0.8rem">
               <i class="fas <?php echo $salesassigned > 1 ? "fa-users" : "fa-user" ?>"></i>&nbsp;
                    <?php if ($salesassigned > 0) {
                        $disp = "";
                        while ($ass = $assignedusers2->fetch_assoc()) {
                            if ($ass["U_Id"] == $uid) {
                                if ($ass["U_TypeId"] == 5) {
                                    $samesales = true;
                                }

                            }
                            $disp = $disp . "<span data-toggle='tooltip' data-placement='bottom' title='" . $ass["UType_Name"] . "'>" . $ass["U_DisplayName"] . "</span>, ";
                            ?>


                            <?php
                        }
                        echo trim($disp, ', ');
                    } ?>
                </div>
                <?php
            } ?>


        </h4>
    <div class="details-blk">
        <div class="details-container">

            <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                        <label><small>Mobile No.</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Cp_Mobile"] != "" ? $det["Cp_Mobile"] : "-") : "-" ?>
                            </b>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                    <label><small>Alt. Mobile No.</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Cp_AltMobile"] != "" ? $det["Cp_AltMobile"] : "-") : "-" ?>
                            </b>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label><small>Location</small></label>
                            <div>
                                <b>
                                    <?php echo $detcnt > 0 ? ($det["Cp_Location"] != "" ? $det["Cp_Location"] : "-") : "-" ?>
                                </b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label><small>E-Mail</small></label>
                            <div>
                                <b>
                                    <?php echo $detcnt > 0 ? ($det["Cp_Email"] != "" ? $det["Cp_Email"] : "-") : "-" ?>
                                </b>
                            </div>
                        </div>
                    </div>

            </div>
            
            
            <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label><small>joining Date</small></label>
                            <div>
                                <b>
                                    <?php echo $detcnt > 0 ? date("d M Y", strtotime($det["Cp_CreatedDate"])) : "-" ?> |
                                    <small>
                                        <?php echo timeago($det["Cp_CreatedDate"]) ?> ago
                                    </small>
                                </b>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="mb-3">
                            <label><small>Rera Number</small></label>
                            <div>
                                <b>
                                    <?php echo $detcnt > 0 ? ($det["Cp_ReraNo"] != "" ? $det["Cp_ReraNo"] : "-") : "-" ?>
                                </b>
                            </div>
                        </div>
                    </div>

            </div>

            <div class="row">


                    <div class="col-md-6">
                        <div class="mb-3">
                            <label><small>Address</small></label>
                            <div>
                                <b>
                                    <?php echo $detcnt > 0 ? ($det["Cp_Address"] != "" ? $det["Cp_Address"] : "-") : "-" ?>
                                </b>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="mb-3">
                            <label><small>Pin</small></label>
                            <div>
                                <b>
                                    <?php echo $detcnt > 0 ? ($det["Cp_Pin"] != "" ? $det["Cp_Pin"] : "-") : "-" ?>
                                </b>
                            </div>
                        </div>
                    </div>

                    

            </div>
        </div>
    </div>
  
        <?php
        $userasgd = false;
        while ($asdu = $assignedusers->fetch_assoc()) {

            if ($asdu["U_Id"] == $uid) {
                $userasgd = true;
                ?>
                <div class="d-flex flex-wrap">
                <?php if (empty($_SESSION['AId'])) : ?>

                    <a target="_blank"
                        href="<?php echo $baseurl ?>v/lead/add_cp.php?cpid=<?php echo $detcnt > 0 && $det["Cp_Id"] != "" ? urlencode(encrypt($det["Cp_Id"])) : "" ?>"
                        class="btn btn-sm btn-primary btn-edit"><b>Edit</b></a>
                        <div style="margin-right: 10px;"></div>
                        <?php endif;?>

                        <a target="_blank"
                            href="<?php echo $baseurl ?>v/lead/list.php?cid=<?php echo ($detcnt > 0 && $det["U_Id"] != "") ? urlencode(encrypt($det["U_Id"])) : "" ?>&range=<?php echo "2001-01-01_" . date('Y-m-d') ?>"
                            class="btn btn-sm btn-primary btn-edit"><b>View Leads</b></a>
                </div>

                        
                </div>
                <div class="d-flex flex-wrap">
                
                <!-- <div class="mt-4">
                    <div>
                        <label class="w-100">&nbsp;</label>
                        <button type="button" id="updatelead" class="btn btn-sm btn-primary">Update</button>
                    </div>

                </div> -->
                <?php
            }

        }
        ?>

    </div>
</div>