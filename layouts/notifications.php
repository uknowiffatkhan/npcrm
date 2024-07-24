<?php

if (!isset($_SESSION)) {
    session_start();
}

include('../config/db.php');

include('../config/encrypter.php');

$uid = $_SESSION["UId"];

$baseurl = $_SESSION["baseurl"];
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/remindermodel.php";
if(isset($_GET["date"])){
    $notify = getNotifications($uid, date('Y-m-d', strtotime($_GET["date"])));
}
else{
    $notify = getNotifications($uid);
}




?>

<?php
if ($notify->num_rows > 0) {
    while ($not = $notify->fetch_assoc()) {
        if ($not["Ld_Id"] != "") {
            ?>
            <li>
                <div class="open-notify <?php echo date("d-m-Y", strtotime($not["Rm_DateTime"])) == date("d-m-Y") ? "today" : "" ?>" data-id="<?php echo $not["Rm_Id"] ?>" data-lid="<?php echo $not["Ld_Id"] ?>">
                    <h3>
                        <?php echo $not["Ld_Name"] ?>
                    </h3>
                    <div>
                        <span>
                            <?php echo $not["Rt_Name"] ?> |
                            <?php echo $not["Ls_Name"] ?>
                        </span>
                        <span>
                            <?php echo date("d-m-Y h:i A", strtotime($not["Rm_DateTime"])) ?> <span class="badge badge-success" style="padding:0.15rem;">Today</span>
                        </span>
                        <span>
                            <?php echo $not["Rm_Remark"] ?>
                        </span>
                    </div>
                </div>
            </li>
            <?php
        } else {
            ?>
            <li>
                No Notifications
            </li>
            <?php
        }
        ?>

        <?php
    }
} else {
    ?>
    <li>
        No Notifications
    </li>
    <?php
}
?>