<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include("../../../model/dashboard.php");
$uid = $_SESSION["UId"];
$sdate = $_POST["sdate"];
$edate = $_POST["edate"];

$sw = getTodaysReportforAdmin($sdate,$edate);


?>



<?php
if ($sw->num_rows > 0) {
    ?>
    <div class="card mr-1 w-100" >
        <div class="card-body">
            <table class="table w-100">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Leads</td>
                        <td>Total Calls</td>
                        <td>Connected</td>
                        <td>Disconnected</td>
                    </tr>
                </thead>
                <?php
                while ($r = $sw->fetch_assoc()) { ?>
                    <tr>
                        <td>
                        <input type="hidden" class="user-id" value="<?php echo $r["U_Id"] ?>">
                           
                            
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="user-modal"> <label><i class="fas fa-circle <?php echo $r["U_Online"] == 1 ? "status-New" : "text-dark-50" ?>"></i>
                                <?php echo $r["U_DisplayName"] ?>
                            </label></a>
                        </td>
                        <td>
                        <input type="hidden" class="lead-id" value="<?php echo $r["LeadIDs"] ?>">
                            <a href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#leadmodalCenter" class="open-modal"><?php echo $r["totallead"] ?></a>
                        </td>
                        <td>
                            <?php echo $r["totalcalls"] ?>
                        </td>
                        <td>
                            <?php echo $r["Connected"] ?>
                        </td>
                        <td>
                            <?php echo $r["Disconnected"] ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
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
