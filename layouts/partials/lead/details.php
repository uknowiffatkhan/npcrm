<?php

if (!isset($_SESSION)) {
    session_start();
}


$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/callmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/quotemodel.php";

$uid = $_SESSION["UId"];
$team = @$_SESSION['Team'][0]->Tm_Id;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lid = $_POST["lid"];
    $det = getLeadById($lid, $uid);

    $detcnt = $det->num_rows;

    $det = $det->fetch_assoc();

    $callog = getCallLogById($lid, $uid);
    $qcount = getQuoteCountsByLid($lid);

    $assignedsales = getAssignedSalesList($lid);
    $assignedusers = getAssignedUsersLead($lid);
    $assignedusers2 = getAssignedUsersLead($lid);

    $visited = getVisitedCounts($lid);
    $salesassigned = $assignedusers2->num_rows;
    $samesales = false;

    $asngdusers = getAssignedUsersLead($lid);
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

<body>
<div class="lead-details-blk">
    <div>
        <input type="hidden" name="detailid"
            value="<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? $det["Ld_Id"] : "") : "" ?>" />
        <h4 class="d-grid align-items-center justify-content-between">
            <div class="mb-1">
                <?php echo $detcnt > 0 ? $det["Ld_Name"] : "-" ?>
                <button type="button" id="reloadleaddetails"
                    value="<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? $det["Ld_Id"] : "") : "" ?>"
                    class="btn btn-xs btn-transparent"><i class="fas fa-rotate"></i></button>
            </div>
            <?php if ($salesassigned > 0) {
                ?>
                <div style="font-size:0.8rem">
                    <i class="fas <?php echo $salesassigned > 1 ? "fa-users" : "fa-user" ?>"></i>&nbsp;
                    <?php if ($salesassigned > 0) {
                        $disp = "";
                        while ($ass = $assignedusers2->fetch_assoc()) {
                            if ($ass["U_Id"] == $uid) {
                                if ($ass["U_TypeId"] == 2) {
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
            <div class="mb-3">
                <label><small>Mobile No.</small></label>
                <div>
                    <b>
                        <?php echo $detcnt > 0 ? ($det["Ld_Mobile"] != "" ? $det["Ld_Mobile"] : "-") : "-" ?>
                    </b>
                </div>
            </div>
            <div class="mb-3">
                <label><small>Alt. Mobile No.</small></label>
                <div>
                    <b>
                        <?php echo $detcnt > 0 ? ($det["Ld_AltMobile"] != "" ? $det["Ld_AltMobile"] : "-") : "-" ?>
                    </b>
                </div>
            </div>
            <div class="mb-3">
                <label><small>Source</small></label>
                <div>
                    <b>
                        <?php echo $detcnt > 0 ? ($det["Sc_Name"] != "" ? $det["Sc_Name"] : "-") : "-" ?>
                    </b>
                </div>
            </div>
            <div class="mb-3">
                <label><small>Lead Status</small></label>
                <div>
                    <input type="hidden" name="hfleadstatus"
                        value="<?php echo $detcnt > 0 ? ($det["Ls_Id"] != "" ? $det["Ls_Id"] : "") : "" ?>">
                    <b>
                        <?php echo $detcnt > 0 ? ($det["Ls_Name"] != "" ? $det["Ls_Name"] : "-") : "-" ?>
                    </b>
                </div>
            </div>
            <div class="mb-3">
                <label><small>Interested In</small></label>
                <div>
                    <b>
                        <?php echo $detcnt > 0 ? ($det["Rt_Name"] != "" ? $det["Rt_Name"] : "-") : "-" ?>
                    </b>
                </div>
            </div>
            <div class="mb-3">
                <label><small>Project</small></label>
                <div>
                    <b>
                        <?php echo $detcnt > 0 ? ($det["Pr_Name"] != "" ? $det["Pr_Name"] : "-") : "-" ?>
                    </b>
                </div>
            </div>
            <div class="more-detail">
                <div class="details-blk showmorecont">
                    <div class="mb-3">
                        <label><small>Location</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Ld_Location"] != "" ? $det["Ld_Location"] : "-") : "-" ?>
                            </b>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><small>Budget</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Bd_Name"] != "" ? $det["Bd_Name"] : "-") : "-" ?>
                            </b>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><small>E-Mail</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Ld_Email"] != "" ? $det["Ld_Email"] : "-") : "-" ?>
                            </b>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label><small>Reference</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Ld_Reference"] != "" ? $det["Ld_Reference"] : "-") : "-" ?>
                            </b>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label><small>Lead Date</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? date("d M Y", strtotime($det["Ld_LeadDate"])) : "-" ?> |
                                <small>
                                    <?php echo timeago($det["Ld_LeadDate"]) ?> ago
                                </small>
                            </b>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label><small>Last Call Date</small></label>
                        <div>
                            <b>
                                <?php echo $detcnt > 0 ? ($det["Ld_LastCallDate"] != "" ? date("d M Y", strtotime($det["Ld_LastCallDate"])) : "-") : "-" ?>
                                | <small>
                                    <?php echo $detcnt > 0 ? ($det["Ld_LastCallDate"] != "" ? timeago($det["Ld_LastCallDate"]) . " ago" : "-") : "-" ?>
                                </small>
                            </b>
                        </div>
                    </div>
                </div>
                <span class="showmorelessdetails">Show More</span>
            </div>


        </div>
        <div>
        <?php if ($_SESSION['TypeId'] == '7') : ?>
            <?php  if (empty($det['Ld_RNo'])): ?>
                <a target="_blank" href="<?php echo $baseurl ?>v/lead/modify.php?lid=<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? urlencode(encrypt($det["Ld_Id"])) : "") : "" ?>
" class="btn btn-sm my-3  btn-primary"><b>Confirm</b></a>
                     
                <?php else:?>
                    <a target="_blank" href="<?php echo $baseurl ?>v/lead/modify.php?lid=<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? urlencode(encrypt($det["Ld_Id"])) : "") : "" ?>
" class="btn btn-sm mr-1 mb-2 btn-edit"><b>Edit</b></a>
                <?php endif;?>

            <?php endif;?>
        </div>
        <div class="mb-3">
            <label><small>Remark</small></label>
            <div>
                <b>
                    <?php echo $detcnt > 0 ? ($det["Ld_Remark"] != "" ? $det["Ld_Remark"] : "-") : "-" ?>
                </b>
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

                    <button type="button" class="btn btn-sm btn-secondary mr-1 mb-2 btn-reminder">Add Reminder</button>
                    <button type="button" class="btn btn-sm btn-primary mr-1 mb-2 btn-calllog">Add Activity</button>
                <?php endif;?>
                    <?php if ($_SESSION["TypeId"] == "5") { ?>
                        <?php if (empty($_SESSION['AId'])) : ?>
                        <a target="_blank"
                        href="<?php echo $baseurl ?>v/lead/source.php?lid=<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? urlencode(encrypt($det["Ld_Id"])) : "") : "" ?>"
                        class="btn btn-sm mr-1 mb-2 btn-edit"><b>Edit</b></a>
                        <?php endif;?>

                    <?php } else {?>
                        <?php if (empty($_SESSION['AId'])) : ?>
                        <a target="_blank"
                        href="<?php echo $baseurl ?>v/lead/modify.php?lid=<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? urlencode(encrypt($det["Ld_Id"])) : "") : "" ?>"
                        class="btn btn-sm mr-1 mb-2 btn-edit"><b>Edit</b></a>
                        <?php endif;?>

                        <?php } ?>

                    <?php if ($_SESSION["TypeId"] == "2") {
                        ?>
                    <?php if (empty($_SESSION['AId'])) : ?>
                        <a target="_blank"
                            href="<?php echo $baseurl ?>v/quotation/modify.php?lid=<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? urlencode(encrypt($det["Ld_Id"])) : "") : "" ?>"
                            class="btn btn-sm mr-1 mb-2 btn-info"><b>Create Quotation</b></a>
                            <?php endif;?>

                        <?php if ($qcount > 0) {
                            ?>
                            <button type="button" class="btn btn-sm btn-clean underline mr-1 mb-2 btn-showquote"><b>Show
                                    Quotation</b></button>
                            <?php
                        } ?>

                        <?php
                    }  else if($_SESSION["TypeId"] == "5") { ?>
                    <?php if (empty($_SESSION['AId'])) : ?>
                        <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#registrationModal" class="btn btn-sm mr-1 mb-2 btn-info" > <label>
                            Click for Registration
                            </label>
                        </a>
                        <?php endif;?>

                    <?php } ?>
                    <?php if ($det["Ls_Id"] != 8) {
                        ?>
                        <div>
                            <button type="button" class="btn btn-sm btn-danger" id="btnjunk"
                                value="<?php echo $det["Ld_Id"] ?>">JUNK</button>
                        </div>
                        <?php
                    } ?>
                    


                </div>
                <div class="mt-3 <?php echo $detcnt > 0 ? ($det["Ld_ProjectId"] != "" ? "" : "d-none") : "d-none" ?>">
                    <button type="button" class="btn btn-sm btn-info btn-projectdetail">Project Details</button>
                </div>
                <div class="mt-4">
                    <div class="">

                        <!-- <div>
                            <label><small>Lead Status</small></label>
                            <select class="form-control form-control-sm mr-3" name="leadupdate" <?php echo isset($det) ? "data-selected=" . $det["Ls_Id"] . "" : "" ?>>
                                <?php include("../dropdowns/leadstatus.php") ?>
                            </select>
                        </div> -->
                        <?php if (empty($_SESSION['AId'])) : ?>

                        <div>
                            <label><small>Labels</small></label>
                            <select class="select2 form-control form-control-sm mr-3" name="labelupdate" multiple <?php echo isset($det) ? "data-selected=" . $det["labelids"] . "" : "" ?>>
                                <?php $type = "";
                                include("../dropdowns/label.php") ?>
                            </select>
                            <!-- <input class="labels form-control form-control-sm mr-3" name="labelupdate" /> -->
                            <!-- <script>var labellist = <?php $type = "arr";
                            trim(include("../dropdowns/label.php"), '"') ?></script> -->
                        </div>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label class="w-100">&nbsp;</label>
                        <?php if (empty($_SESSION['AId'])) : ?>
                        <button type="button" id="updatelead" class="btn btn-sm btn-primary">Update</button>
                        <?php endif;?>

                    </div>

                </div>
                <?php
            }

        }
        if ($userasgd == false) {
            if ($_SESSION["TypeId"] == 1) {
                ?>
            <?php if (empty($_SESSION['AId'])) : ?>
                <button type="button" class="btn btn-sm btn-primary mr-1 mb-2 btn-calllog">Add Call Log</button>
                <?php endif;?>

                <?php
            } else {
                ?>
                <div>
                    <h5><i class="fas fa-exclamation-triangle text-danger"></i> Action Permission Denied</h5>
                </div>
                <?php
            }

        }
        if (($salesassigned == 1 && $_SESSION["TypeId"] == 2) || ($salesassigned > 1 && $visited == 0 && $_SESSION["TypeId"] == 2 && $samesales == false)) {
            // if($salesassigned > 0){
            ?>
        <!-- <button type="button" id="claimlead" class="btn btn-sm btn-success">Claim Lead</button> -->
        <?php
        // }
        ?>
    <?php if (empty($_SESSION['AId'])) : ?>
        <button type="button" id="claimlead" class="btn btn-sm btn-success">Claim Lead</button>
        <?php endif;?>
       
            <?php
        }

        ?>

        <hr />
        <div>
            <p>Call Log</p>

            <div>
                <?php
                if ($callog->num_rows > 0) {
                    $i=1;
                    while ($cl = $callog->fetch_assoc()) {
                        $st=$cl["Cl_LeadStatus"];
                        ?>
                        <div class="calllogcard">
                            <input type="hidden" name="hfcallstatus" value="<?php echo $cl["Cs_Type"] ?>" />
                            <span
                                class="status-badge badge badge-warning <?php echo $cl["U_Id"] == $_SESSION["UId"] ? "you" : "others" ?>"><?php echo $cl["U_Id"] == $_SESSION["UId"] ? "you" : $cl["U_DisplayName"] ?></span>
                            <h6>
                                <div
                               
                                    class="<?php echo ($cl["Cs_Name"] == "Connected" ? 
                                    ($cl["Cl_CallType"] == "Incoming" ? "status-New" : "status-New") : 
                                    ($cl["Cs_Type"] == "Message" ? "status-New" : 
                                    ($cl["Cs_Type"] == "Meeting" ? "status-New" : "text-danger"))) ?>">

                                    <i class="<?php echo ($cl["Cs_Name"] == "Connected" ? 
                                        ($cl["Cl_CallType"] == "Incoming" ? "bx bxs-phone-incoming" : "bx bxs-phone-outgoing") :
                                        ($cl["Cs_Type"] == "Message" ? "fas fa-comment-dots" :
                                        (in_array($cl["Cl_CallType"], ["Zoom", "Google Meet", "WhatsApp Video Call"]) ? "fa-solid fa-mobile-screen" :
                                        (in_array($cl["Cl_CallType"], ["On Site", "Off Site"]) ? "fa-regular fa-handshake" : "bx bxs-phone-off")))) ?>"></i>

                                    <?php echo ($cl["Cs_Name"] != "" ? $cl["Cs_Name"] : "Remark") ?>
                                </div>
                                <div>
                                    <small data-toggle='tooltip' data-placement='bottom' title="Call Date Time"><i
                                            class="fas fa-clock"></i>&nbsp;
                                        <?php echo date("d M h:i A", strtotime($cl["Cl_CreatedDate"])) ?>
                                    </small>
                                    <?php echo $cl["Rm_Id"] != "" ? "<i class='fas fa-bell' data-toggle='tooltip' data-placement='bottom' data-html='true' title='Reminder <br/>" . date("d M Y h:i A", strtotime($cl["Rm_DateTime"])) . "'></i>" : "" ?>
                                </div>
                            </h6>
                            <div>
                                <p class="lstatus" style="line-height:1;margin-top:5px;">
                                <?php
                                        echo $cl['Parentid'] != "" ? 
                                        $cl['Parentname'].'<i class="fa-solid fa-arrow-right mx-1"></i><span data-id="status-'.$i.'">'. $cl["Ls_Name"] .'</span>'.
                                            ($cl["Cl_LeadStatus"] == 17 ? '<span data-id-value =""></span>' : "") 
                                             : 
                                            '<span data-id="status-'.$i.'">' . $cl["Ls_Name"] . '</span>';
                                        ?>

                                    <small>
                                        <?php echo $cl["Cl_CallStatus"] == 1 && ($cl["Cl_LeadStatus"] == 2 || $cl["Cl_LeadStatus"] == 3 || $cl["Cl_LeadStatus"] == 4) ? "<br/>" . date("d M Y h:i A", strtotime($cl["Cl_ActionDate"])) : "" ?>
                                    </small>
                                </p>
                                <p class="remark">
                                    <?php echo $cl["Cl_Remark"] ?>
                                </p>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
                ?>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="height: 100%; display: flex; flex-direction: column;">
        <div class="modal-content" style="flex: 1; display: flex; flex-direction: column;">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationModalLabel">CP Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <!-- Text fields to display details -->
                <form id="lead_form" name="lead_form" method="post">
                    <input type="hidden" name="ld_id" id="ld_id" value="<?php echo $detcnt > 0 ? ($det["Ld_Id"] != "" ? $det["Ld_Id"] : "-") : "-"; ?>">
                    <input type="hidden" name="uid" id="uid" value="<?php echo isset($uid) ? $uid : ""; ?>">
                    <input type="hidden" name="team_id" id="team_id" value="<?php echo isset($team) ? $team : ""; ?>">
                    <div class="form-group">
                        <label for="leadName">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $detcnt > 0 ? ($det["Ld_Name"] != "" ? $det["Ld_Name"] : "-") : "-"; ?>">
                    </div>
                    <div class="form-group">
                        <label for="leadEmail">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $detcnt > 0 ? ($det["Ld_Email"] != "" ? $det["Ld_Email"] : "-") : "-"; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="leadMobile">Mobile Number:</label>
                        <input type="text" class="form-control" name="mobno" id="mobno" value="<?php echo $detcnt > 0 ? ($det["Ld_Mobile"] != "" ? $det["Ld_Mobile"] : "-") : "-"; ?>">
                    </div>
                    <div class="form-group">
                        <label for="leadAltMobile">Alt Mobile Number:</label>
                        <input type="text" class="form-control" name="altmobno" id="altmobno" value="<?php echo $detcnt > 0 ? ($det["Ld_AltMobile"] != "" ? $det["Ld_AltMobile"] : "-") : "-"; ?>">
                    </div>
                    <div class="form-group">
                        <label for="leadReraNumber">Rera Number:</label>
                        <input type="text" class="form-control" name="rerano" id="rerano">
                    </div>
                    <div class="form-group">
                        <label for="leadUsername">User Name:</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>

                    <input type="hidden" name="roleid" id="roleid" value="2">
                    <input type="hidden" name="typeid" id="typeid" value="4">
                    <input type="hidden" name="createdId" id="createdId" value="1">
                    <input type="hidden" name="modifyId" id="modifyId" value="1">
                    <input type="hidden" name="status" id="status" value="Active">
                    <input type="hidden" name="del" id="del" value="0">

                    <!-- Add more text fields as needed... -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>

                        <!-- Additional modal buttons if needed -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Include jQuery (make sure it's included before your modal.js file) -->
<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

<!-- Include Bootstrap JS (assuming you are using Bootstrap for modals) -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->


<script>
    $(document).ready(function () {
    var visible = $('.calllogcard').is(':visible');
       
    if (visible) {
        var siteVisitPlanCount = 0;
        var siteVisitPlanIds = [];
        var card = $('.calllogcard');
        var previousDate = null;

        card.each(function(i, el) {
            var lstatusSpan = $(el).find('.lstatus span');
            var dateString = $(el).find('small[data-toggle="tooltip"]').text().trim();
            
            var dateObj = new Date(dateString);
            var date = ('0' + (dateObj.getMonth() + 1)).slice(-2) + '-' + ('0' + dateObj.getDate()).slice(-2);
            var text = lstatusSpan.text().trim();
            
           

            if (text.startsWith("Site Visit Plan")) {
                if (previousDate === null || date !== previousDate) {
                    siteVisitPlanCount++;
                    previousDate = date;
                    siteVisitPlanIds.push($(lstatusSpan).attr('data-id'));
                }

            }
        });

        if (siteVisitPlanCount) {
            var modifiedElements = siteVisitPlanIds.map(function(id, index) {
                var element = $('[data-id="' + id + '"]');
                var decrementedValue = siteVisitPlanCount - index;
                var newText = element.text() + ' ( ' + decrementedValue + ' )';
                console.log("Modified Element:", newText);
                return element.text(newText);
            });

        }
    }







        $("#openRegistrationPopup").click(function () {

            $("#registrationModal").modal({
                backdrop: 'static', 
                keyboard: false      
            });
        });
    });
</script>
<script src="<?php echo $_SESSION['baseurl'] ?>assets/js/bind/modal/model.js"></script>

</body>


