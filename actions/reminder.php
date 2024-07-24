<?php


if (!isset($_SESSION)) {
    session_start();
}
include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/callmodel.php";
include_once "../model/remindermodel.php";
include_once "../model/leadmodel.php";


$conn = dbconnect();
$uid = $_SESSION["UId"];


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST["mode"] == "insert") {
        $lid = mysqli_real_escape_string($conn, $_POST["ldid"]);
        $reminddate = mysqli_real_escape_string($conn, $_POST["reminderdate"]);
        $remindremark = mysqli_real_escape_string($conn, $_POST["reminderremark"]);


        $rid = insertReminder($lid, NULL, $reminddate, $remindremark, $uid);

        echo "insert/" . $rid;

    } else if ($_POST["mode"] == "markread") {
        $lid = mysqli_real_escape_string($conn, $_POST["lid"]);


        $rid = markReminderRead($lid, $uid);

        echo "marked";

    }
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $url_components = parse_url($_SERVER["REQUEST_URI"]);

    parse_str($url_components['query'], $params);

    if ($params['mode'] == "checknotifications") {

        $res = checkNotifications($uid);

        $res = $res->fetch_assoc();


        echo json_encode($res["notifycount"]);

    } else if ($params["mode"] == "checklivereminders") {
        $res = checkLiveReminders($uid);
        
        $d = array();
        while ($row = $res->fetch_assoc()) {
            $d[] = $row;
        }
        

        echo json_encode($d);
    }

}




?>