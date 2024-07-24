<?php 

if (!isset($_SESSION)) {
    session_start();
}
include_once "../config/encrypter.php";
include_once "../config/db.php";
include_once "../layouts/auth.php";
include_once "../model/leadmodel.php";
include_once "../model/quotemodel.php";
include_once "../model/remindermodel.php";


$conn = dbconnect();
$uid = $_SESSION["UId"];
$team = $_SESSION["Team"][0]->Tm_Id;


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST["mode"] == "insert"){
        $leadid = mysqli_real_escape_string($conn, $_POST["lid"]);
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        // $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $config = mysqli_real_escape_string($conn, $_POST["config"]);
        $phase = mysqli_real_escape_string($conn, $_POST["phase"]);
        $wing = mysqli_real_escape_string($conn, $_POST["wing"]);
        $floor = mysqli_real_escape_string($conn, $_POST["floor"]);
        $roomno = mysqli_real_escape_string($conn, $_POST["roomno"]);
        $saleable = mysqli_real_escape_string($conn, $_POST["saleable"]);
        $carpet = mysqli_real_escape_string($conn, $_POST["carpet"]);
        $agreement = mysqli_real_escape_string($conn, $_POST["agreement"]);
        $development = mysqli_real_escape_string($conn, $_POST["development"]);
        $govtcharge = mysqli_real_escape_string($conn, $_POST["govtcharge"]);
        $registration = mysqli_real_escape_string($conn, $_POST["registration"]);
        $clubmembersip = mysqli_real_escape_string($conn, $_POST["clubmembersip"]);
        $parking = mysqli_real_escape_string($conn, $_POST["parking"]);
        $society = mysqli_real_escape_string($conn, $_POST["society"]);
        $legal = mysqli_real_escape_string($conn, $_POST["legal"]);
        $stampduty = mysqli_real_escape_string($conn, $_POST["stampduty"]);
        $totalvalue = mysqli_real_escape_string($conn, $_POST["totalvalue"]);
        $estbooking = mysqli_real_escape_string($conn, $_POST["estbooking"]);

        $code = getNewQCode();

        if($leadid == ""){
            $leadid = insertLead($lname, $lmob, "", "", "", "", "", "", "", "", "", 1, 5, date('Y-m-d'), 1, $uid);    
            AssignLead($leadid, $uid, $team, 0);
        }
        
        $qi = insertQuote($code, date('Y-m-d'), $project, $leadid, $lname, $lmob, date('Y-m-d H:i:s',strtotime($estbooking)), $uid);


        delQuotDetail($project, $qi, $uid);

        $qdi = insertQuoteDetail($project, $qi, $config, $phase, $wing, $floor, $roomno, $saleable, $carpet, $agreement, $development, $govtcharge, $clubmembersip,
                                $parking, $society, $registration,$stampduty,$legal, $totalvalue, $uid);

        $amountcnt = $_POST["amount"];
        $countarr = count($amountcnt);

        delQuotPlans($project, $qi, $leadid, $uid);

        for ($i = 0; $i < $countarr; $i++) {
            
            $part = mysqli_real_escape_string($conn, $_POST["part"][$i]);
            $amount = mysqli_real_escape_string($conn, $_POST["amount"][$i]);
            $type = mysqli_real_escape_string($conn, $_POST["type"][$i]);
            $dur = mysqli_real_escape_string($conn, $_POST["dur"][$i]);
            $totalramount = mysqli_real_escape_string($conn, $_POST["totalramount"][$i]);

            
            $qpid = insertQuotePayPLan($project, $qi, $leadid, $part, $type, $dur, $amount, $totalramount, $uid);
        }
        
        updateStatus($leadid, 5, $uid);

        $rid = insertReminder($leadid, NULL, $estbooking, "Estimated Booking Date", $uid);


        echo "insert/" . $qi;
    }
    else if($_POST["mode"] == "update"){
        $leadid = mysqli_real_escape_string($conn, $_POST["lid"]);
        $qid = mysqli_real_escape_string($conn, $_POST["qid"]);
        $lname = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $lmob = mysqli_real_escape_string($conn, $_POST["mobno"]);
        // $laltmob = mysqli_real_escape_string($conn, $_POST["altmobno"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $config = mysqli_real_escape_string($conn, $_POST["config"]);
        $phase = mysqli_real_escape_string($conn, $_POST["phase"]);
        $wing = mysqli_real_escape_string($conn, $_POST["wing"]);
        $floor = mysqli_real_escape_string($conn, $_POST["floor"]);
        $roomno = mysqli_real_escape_string($conn, $_POST["roomno"]);
        $saleable = mysqli_real_escape_string($conn, $_POST["saleable"]);
        $carpet = mysqli_real_escape_string($conn, $_POST["carpet"]);
        $agreement = mysqli_real_escape_string($conn, $_POST["agreement"]);
        $development = mysqli_real_escape_string($conn, $_POST["development"]);
        $govtcharge = mysqli_real_escape_string($conn, $_POST["govtcharge"]);
        $registration = mysqli_real_escape_string($conn, $_POST["registration"]);
        $clubmembersip = mysqli_real_escape_string($conn, $_POST["clubmembersip"]);
        $parking = mysqli_real_escape_string($conn, $_POST["parking"]);
        $society = mysqli_real_escape_string($conn, $_POST["society"]);
        $legal = mysqli_real_escape_string($conn, $_POST["legal"]);
        $stampduty = mysqli_real_escape_string($conn, $_POST["stampduty"]);
        $totalvalue = mysqli_real_escape_string($conn, $_POST["totalvalue"]);
        $estbooking = mysqli_real_escape_string($conn, $_POST["estbooking"]);

        $qi = updateQuote($qid, date('Y-m-d'), $project, $leadid, $lname, $lmob, date('Y-m-d H:i:s',strtotime($estbooking)), $uid);

        $qd = updateQuoteDetail($project, $qi, $config, $phase, $wing, $floor, $roomno, $saleable, $carpet, $agreement, $development, $govtcharge,$clubmembersip,
        $parking, $society, $registration,$stampduty,$legal, $totalvalue, $uid);

        $amountcnt = $_POST["amount"];
        $countarr = count($amountcnt);

        delQuotPlans($project, $qi, $leadid, $uid);

        for ($i = 0; $i < $countarr; $i++) {
            
            $part = mysqli_real_escape_string($conn, $_POST["part"][$i]);
            $amount = mysqli_real_escape_string($conn, $_POST["amount"][$i]);
            $type = mysqli_real_escape_string($conn, $_POST["type"][$i]);
            $dur = mysqli_real_escape_string($conn, $_POST["dur"][$i]);
            $totalramount = mysqli_real_escape_string($conn, $_POST["totalramount"][$i]);

            
            $qpid = insertQuotePayPLan($project, $qi, $leadid, $part, $type, $dur, $amount, $totalramount, $uid);
        }

        echo "update/" . $qi;
    }

}

?>