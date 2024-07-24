<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../../model/dashboard.php");
$uid = $_SESSION["UId"];
$sdate = $_POST["sdate"];
$edate = $_POST["edate"];

$sw = getLeadOverviewAdminBySource($sdate,$edate);


?>

<?php
if ($sw->num_rows > 0) {
    ?>
    <div class="card mr-1 w-100">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
            <table class="table table-response w-100">
                <thead>
                    <tr>
                        <th>Source</th>
                        <th>Total Leads</th>
                        <th class="status-New">New</th>
                        <th class="status-Follow-Up">Followup</th>
                        <th class="status-Interested">Interested</th>
                        <th class="status-Site-Visit-Plan">Visit Plan</th>
                        <th class="status-Site-Visited">Visited</th>
                        <th class="text-black">No Call</th>
                        <th>Not Interested</th>
                        <th>Hold</th>
                        <th>Junk</th>
                    </tr>
                </thead>
                <?php
                while ($r = $sw->fetch_assoc()) {
                    ?>
                    <a href="<?php echo $baseurl ?>v/lead/list.php?type=wise&wisefilter=time" target="_blank">
                        <tr>
                        
                            <td><b><?php echo $r["Sc_Name"] ?></b></td>
                            <td>
                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["leadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["leads"] ?></a>
                            </td>
                            <td class="status-New">
                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["newleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["new"] ?><a>  
                                
                        </td>
                            <td class="status-Follow-Up">
                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["followupleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["followup"] ?><a>               
                            </td>
                            <td class="status-Interested">

                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["interestedleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["interested"] ?><a> 
                            </td>
                            <td class="status-Site-Visit-Plan">

                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["visitplanleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["visitplan"] ?><a>   
                            </td>
                            <td class="status-Site-Visited">

                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["visitedleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["visited"] ?><a>   

                            </td>
                            <td>

                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["nocallleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["nocall"] ?><a>   
                            </td>
                            <td>

                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["notinterestedleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["notinterested"] ?><a>   
                            </td>
                            <td>
                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["holdleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["hold"] ?><a>   
                            </td>
                            <td>

                            <input type="hidden" class="lead-id" name="leadid" value="<?php echo $r["junkleadsid"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal">
                            <?php echo $r["junk"] ?><a>   

                            </td>
                        </tr>
                    </a>
                    <?php
                }
                ?>
            </table>
            </div>
            
        </div>
    </div>
    <?php
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