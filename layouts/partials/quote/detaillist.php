<?php

if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "utils/helper.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/quotemodel.php";
$uid = $_SESSION["UId"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lid = $_POST["lid"];
    $det = getQuotesListByLid($lid, $uid);


}



?>


<div class="lead-quotelist">
    <div class="quote-list">
        <?php
        if ($det->num_rows > 0) {
            while ($d = $det->fetch_assoc()) {
                ?>
                <div class="quote-list-detail">
                    <div class="d-flex flex-nowrap align-items-center justify-content-between">
                        <div>
                            <div class="date"><?php echo date('d-m-Y', strtotime($d["Qt_Date"])) ?></div>
                            <div class="quote-code">
                                <?php echo $d["Qt_Code"] ?>
                            </div>
                        </div>
                        <div>
                            <div class="creatername">
                                <?php echo $d["U_DisplayName"] ?>
                            </div>
                        </div>
                    </div>
                    <div class="quote-projectname">
                        <?php echo $d["Pr_Name"] ?>
                    </div>
                    <div class="config">
                        <?php echo $d["Qpd_Config"];
                        echo ($d["Qpd_Config"] != "" ? " - " : ""); ?>
                        <?php echo $d["Qpd_Phase"];
                        echo ($d["Qpd_Phase"] != "" ? " - " : ""); ?>
                        <?php echo $d["Qpd_Wing"];
                        echo ($d["Qpd_Wing"] != "" ? " - " : ""); ?>
                        <?php echo $d["Qpd_Floor"] . " Floor";
                        echo ($d["Qpd_Floor"] != "" ? " - " : ""); ?>
                        <?php echo $d["Qpd_Roomno"];
                        echo ($d["Qpd_Roomno"] != "" ? " - " : ""); ?>
                        <?php echo $d["Qpd_Saleable"] . " sq. ft." ?>
                    </div>
                    <div class="d-flex flex-nowrap align-items-center justify-content-between">
                        <div class="quote-ttlprc">₹ <?php echo format_curr($d["Qpd_Totalvalue"]) ?></div>
                        <div>
                            <a href="<?php echo $baseurl ?>v/quotation/print.php?qid=<?php echo $d["Qt_Id"] ?>" target="_blank" class="mx-2" title="Print"><i class="fas fa-print"></i></a>
                            <?php if($_SESSION["UId"] == $d["Qt_Uid"]){
                                ?>
                                <a href="<?php echo $baseurl ?>v/quotation/modify.php?qid=<?php echo urlencode(encrypt($d["Qt_Id"])) ?>" target="_blank" title="Edit Quotation" class="text-black-50"><i class="fas fa-edit"></i></a>
                                <?php
                            }?>
                        </div>
                    </div>
                    
                </div>
                <?php
            }
        }
        ?>

    </div>

</div>