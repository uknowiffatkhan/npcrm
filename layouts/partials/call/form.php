<?php 

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/callmodel.php";


$ld = $_POST["lid"];

$gclast = getLastConnectedCall($ld);
if($gclast->num_rows > 0){
    $gclast = $gclast->fetch_assoc();
}

?>

<div class="call-log-blk">
    <h5>Add Activity Log</h5>
    <form id="calllogform">
        <div>
            <div class="mb-3">
                <label>Activity</label>
                <div>
                    <select class="form-control form-control-sm" name="callstatus" id="cstype">
                        <?php include("../dropdowns/callstatus.php") ?>
                    </select>
                </div>
            </div>

            <div class="mb-3 d-none" id="calltype">
                <label>Call Type</label>
                <div>
                    <select class="form-control form-control-sm" name="calltype"  id="calltypeselect" >
                        <option>Outgoing</option>
                        <option>Incoming</option>
                    </select>
                </div>
            </div>

            
            <div class="mb-3 leadstatusblk d-none">
                <label>Lead Status</label>
                <div>
                    <select class="form-control form-control-sm" name="leadstatus">
                        <?php include("../dropdowns/leadstatus.php") ?>
                    </select>
                </div>
            </div>
            <div class="mb-3 reminderdate d-none">
                <label>Date Time</label>
                <div>
                    <input type="datetime-local" class="form-control form-control-sm" name="reminderdate" value="<?php echo date('Y-m-d\TH:i:s');  ?>"  min="<?php echo date('Y-m-d\TH:i:s');  ?>"/>
                </div>
            </div>
            <div class="mb-3 project d-none">
                <label>Project</label>
                <div>
                    <select name="project" class="form-control form-control-sm"
                        <?php echo isset($det) ? "data-selected=" . $det["Ld_ProjectId"] . "" : "" ?>>
                        <?php include("../dropdowns/project.php") ?>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label>Remark</label>
                <div>
                    <textarea rows="5" class="form-control form-control-sm" name="callremark"></textarea>
                </div>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-sm btn-success btn-save-calllog">Save Call Log</button>
            <button type="button" class="btn btn-sm btn-primary mr-1 mb-2 btn-calllog d-block d-md-none">Close</button>
        </div>
    </form>

</div>