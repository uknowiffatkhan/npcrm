<style>
  .fixed-size-div {
    width: 250px;
   /*  max-width: 260px; Set the width as per your requirement */
    height: auto; /* Set the height as per your requirement */
    max-height:  130px; 
 overflow: auto; /* Enable scrolling if content overflows */
 
  }
</style>
<?php
include "../../../config/db.php";

include "../../../config/encrypter.php";

include "../../../utils/helper.php";

include "../../../model/leadmodel.php";
include "../../../model/dropdownmodel.php";

$url_components = parse_url($_SERVER["REQUEST_URI"]);
if (isset($url_components["query"])) {
    parse_str($url_components["query"], $params);
}

$uid = $_SESSION["UId"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // print_r($_POST);
    // $type = $_POST["type"]
    $pin = $_POST["pin"];
    $loc = $_POST["loc"];
    $sdate = $_POST["sdate"];
    $edate = $_POST["edate"];
    $dateby = $_POST["dateby"];
    $leadsearch = $_POST["leadsearch"];
    // if(isset($_POST["misc"])){
    //     $misc = $_POST["misc"];
    // }

    if ($_SESSION["TypeId"] == "0" && $_SESSION["Role"] == "1") {
        if (isset($_POST["uid"])) {
            $uid = $_POST["uid"];
        }
        if (isset($_POST["cid"])) {
            $uid = $_POST["cid"];
        }
    }
    $re = getAllConfirmCpListByFilter(
        $uid,
        $dateby,
        $sdate,
        $edate,
        $pin,
        $loc,
        $leadsearch
    );

    // if ($_SESSION["TypeId"] == "5" && $_SESSION["Role"] == "2") {
    //     // Call getAllCpListByFilter if conditions are met
    //     $re = getAllCpListByFilter($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch, $misc);
    // } else {
    //     // Call getAllListByFilter if conditions aren't met
    //     $re = getAllListByFilter($stat, $src, $int, $uid, $dateby, $sdate, $edate, $leadsearch, $misc);
    // }
}
?>



<div class="all-list">
    <div class="d-block">
    <div class="row  row-cols-md-3 row-cols-lg-4 g-4">

        <?php if (isset($re)) {
            if ($re->num_rows > 0) {
                while ($r = $re->fetch_assoc()) { ?>
                <div class="col">
                    <div class="card h-100 p-1 cpshowdetails ">
                    <input type="hidden" name="leadid" value="<?php echo $r[
                        "Cp_Id"
                    ]; ?>" />

                    <div class="card-header py-1 badge text-wrap" style="font-size: 15px;background-color: #347e94;">
                    <?php echo "Code : " . $r["Cp_Code"]; ?>
                    </div>

                    <div class="card-body py-0 w-100 ">
                        <span class="leadtitle text-break text-uppercase py-0 mt-1 mb-0 " style="font-size: 15px;font-weight: 800;"><?php echo $r[
                            "Cp_Name"
                        ]; ?></span>
                        <div class="row card-text py-0" style="font-size: 10px;font-weight: 600;">
                            <div class="col-12 "><?php echo !empty(
                                $r["Cp_Mobile"]
                            )
                                ? '<i class="fa-solid fa-phone fa-xs mr-1"></i>' .
                                    $r["Cp_Mobile"]
                                : "-"; ?></div>
                            <div class="col-12">
                            <?php
                            echo '<i class="fas fa-map-pin fa-sm mr-1"></i>';
                            echo !empty($r["Cp_Location"])
                                ? $r["Cp_Location"] .
                                    (!empty($r["Cp_Pin"])
                                        ? " - " . $r["Cp_Pin"]
                                        : "")
                                : "Unavailable";
                            ?>
                            
                            </div>
                            <?php
                            $lddet = getLeadCountByCpid($r["Cp_Id"]);
                            $ldcount = "0";
                            $latestLeadFormatted = "-";
                            $lddate = "";

                            if (
                                $lddet &&
                                ($det = $lddet->fetch_assoc()) &&
                                isset($det["ldcount"]) &&
                                isset($det["latest_lead"])
                            ) {
                                $ldcount = $det["ldcount"];
                                $latestLeadDate = date_create(
                                    $det["latest_lead"]
                                );
                                if ($latestLeadDate) {
                                    $currentDate = date_create(date("Y-m-d"));
                                    $dateDiff = date_diff(
                                        $latestLeadDate,
                                        $currentDate
                                    );
                                    $latestLeadFormatted = $dateDiff->format(
                                        "%a days ago"
                                    );
                                    $lddate = $latestLeadDate->format("d-m-Y");
                                }
                            }

                            $tooltipTitle = "$ldcount";
                            ?>

<div class="col-12 d-flex mt-1">
    <span data-toggle="tooltip" data-placement="bottom" class="d-flex align-items-center text-danger fw-600 " data-bs-original-title="<?php echo "Lead Count "; ?>">
    <i class="fa-solid fa-list fa-2xs mr-1"></i><?php echo $tooltipTitle; ?>
    </span> 
    <span class=" mx-2 ">|</span>
    <span data-toggle="tooltip" data-placement="bottom" class="d-flex align-items-center text-danger fw-600 " data-bs-original-title="<?php echo "Last Lead : " .
        $lddate; ?>">
            <i class="fa-regular fa-clock fa-2xs mr-1 "></i><?php echo $latestLeadFormatted; ?>
    </span>
</div>

                       
                        </div>
                        <div>
                        </div>
                    </div>
                    </div>
                </div>
                  
                <?php }
            }
        } ?>
        </div>
    </div>
</div>
