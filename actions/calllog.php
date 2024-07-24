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
include_once "../model/commonmodel.php";
include_once "../utils/sendmsg.php";


$conn = dbconnect();
$uid = $_SESSION["UId"];
$team = $_SESSION["Team"][0]->Tm_Id;
$teamLeader = $_SESSION["Team"][1]->Team_Leader_Id;



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST["mode"] == "insert") {

        $lid = mysqli_real_escape_string($conn, $_POST["ldid"]);
        $callstatus = mysqli_real_escape_string($conn, $_POST["callstatus"]);
        $callbackdate = mysqli_real_escape_string($conn, $_POST["reminderdate"]);
        $leadstatus = mysqli_real_escape_string($conn, $_POST["leadstatus"]);
        $callremark = mysqli_real_escape_string($conn, $_POST["callremark"]);
        $project = mysqli_real_escape_string($conn, $_POST["project"]);
        $calltype = mysqli_real_escape_string($conn, $_POST["calltype"]);
        $sid = "";
        $callsts = getCallStatusById($callstatus);
        InactiveAllCallLogs($lid, $uid);

        
        if ($callstatus == "1" && ($leadstatus == "4" || $leadstatus == "17" )) {
            InactiveAllVivistCall($lid, $uid);
            markReminderRead($lid, $uid);
        }

        $visitplan = getLatestVisitPlan($lid);

        $clid = insertCall($lid, $callstatus, $calltype, $leadstatus, $callbackdate, $callremark, $uid);

        $salesid = checksalesassign($lid);
        $assigndsales = $salesid->num_rows;

        $ul = updateLastCallDateLead($lid, $uid);

        if ($callstatus == "2" ) {
            markReminderRead($lid, $uid);
            $cldate = date("Y-m-d H:i:s", strtotime($callbackdate));
            insertReminder($lid, $clid, $cldate, $callremark, $uid);
        } else if ($callstatus == "1" || $callstatus == "12" || $callstatus == "13") {
            updateStatus($lid, $leadstatus, $uid);
            DelAssignDateLead($lid, $uid);
            if ($leadstatus == "4" || $leadstatus == "17" ) {
                if ($callbackdate != "") {
                    markReminderRead($lid, $uid);
                    $cldate = date("Y-m-d H:i:s", strtotime("-1 days", strtotime($callbackdate)));
                    insertReminder($lid, $clid, $cldate, $callremark, $uid);
                }

                if ($assigndsales == 0) {
                    // AssignToSales($lid, $uid, $project, date("Y-m-d", strtotime($callbackdate)));
                    // sendSiteVisitMsgtoCust($lid);
                    // sendSiteVisitMsgtoAgent($lid);
                } else {
                    // InactiveAllVivistCall($lid, $uid); 
                    $same = false;
                    if ($visitplan->num_rows > 0) {
                        $visitpland = $visitplan->fetch_assoc();
                        $visitdate = $visitpland["Cl_ActionDate"];
                        if (date("Y-m-d", strtotime($callbackdate)) == date("Y-m-d", strtotime($visitdate))) {
                            $same = true;
                        }
                    }
                    if ($same != true) {
                        sendSiteVisitMsgtoCust($lid);
                        sendSiteVisitMsgtoAgent($lid);
                    }

                }


            }
            if ($leadstatus == "2" || $leadstatus == "3" ||  $leadstatus == "12" ) {
                if ($callbackdate != "") {
                    $asigntime = date('Y-m-d H:i:s', strtotime($callbackdate));
                    updateAssignDateTimeLead($lid, $asigntime, $uid);
                }

            }
        }
        if ($callstatus == "3" || $callstatus == "4" || $callstatus == "5" || $callstatus == "6" || $callstatus == "7" || $callstatus == "11") {
            $tcc = getCallCountByLId($lid, $uid, date('Y-m-d'), "", "");
            $asigntime = '';
            //echo $tcc->num_rows."<br/>";
            if ($tcc->num_rows > 0) {
                $tcc = $tcc->fetch_assoc();
                // echo $tcc["count"]."<br/>";
                // echo date('H')."<br/>";
                if ($tcc["count"] > 1) {

                    $cc = getCallCountByLId($lid, $uid, "", "", "");
                    $cccount = $cc->num_rows;
                    if ($cccount > 0) {
                        $disconnected = 0;
                        while ($c = $cc->fetch_assoc()) {
                            if ($c["ctype"] == "Disconnected") {
                                $disconnected = $disconnected + 1;
                            } else {
                                break;
                            }
                        }
                    }
                    // echo "Disconneted".$disconnected."<br/>";
                    $calrule = getcallrule($leadstatus, "Disconnected", "After", $disconnected);
                    if ($calrule->num_rows > 0) {
                        $calrule = $calrule->fetch_assoc();
                        //echo $calrule["CslaC_ScheduleDay"]; 
                        if ($calrule["CslaC_ScheduleDay"] != "Junk") {

                            $asigntime = date('Y-m-d', strtotime(str_replace("#", "+", $calrule["CslaC_ScheduleDay"])));
                            $asigntime = getNonWeekOffLeaveDate($uid, $asigntime);
                            $asigntime = date('Y-m-d 15:00:00', strtotime($asigntime));
                            updateAssignDateTimeLead($lid, $asigntime, $uid);
                            sendDisconnectedSMS($lid, $uid);

                        } else if ($calrule["CslaC_ScheduleDay"] == "Junk") {
                            AssignLead($lid, $teamLeader, $team, 0);
                            insertActionsLog($uid, "Lead Assigned To Team Leader : $teamLeader", "");
                            insertLabel($lid, 6, $uid);
                            updateStatus($lid, 8, $uid);
                            DelAssignDateLead($lid, $uid);
                        }
                    } else if ($disconnected > 6) {
                        AssignLead($lid, $teamLeader, $team, 0);
                        insertActionsLog($uid, "Lead Assigned To Team Leader : $teamLeader", "");
                        insertLabel($lid, 6, $uid);
                        updateStatus($lid, 8, $uid);
                        DelAssignDateLead($lid, $uid);
                    } else {
                        if ($leadstatus == "1" || $leadstatus == "2" || $leadstatus == "12" ) {
                            $asigntime = date('Y-m-d', strtotime("+1 days"));
                            $asigntime = getNonWeekOffLeaveDate($uid, $asigntime);
                            $asigntime = date('Y-m-d 15:00:00', strtotime($asigntime));
                            updateAssignDateTimeLead($lid, $asigntime, $uid);

                        }
						else if ($leadstatus == "3"){
                        DelAssignDateLead($lid, $uid);
                      }

                        sendDisconnectedSMS($lid, $uid);

                    }



                } else {
                  
                    $cc = getCallCountByLId($lid, $uid, "", "", "");
                    $cccount = $cc->num_rows;
                    if ($cccount > 0) {
                        $disconnected = 0;
                        while ($c = $cc->fetch_assoc()) {
                            if ($c["ctype"] == "Disconnected") {
                                $disconnected = $disconnected + 1;
                            } else {
                                break;
                            }
                        }
                    }

                    $calrule = getcallrule($leadstatus, "Disconnected", "After", $disconnected);
                    if ($calrule->num_rows > 0) {
                        $calrule = $calrule->fetch_assoc();
                        // echo $disconnected."<br/>";
                        if ($calrule["CslaC_ScheduleDay"] != "Junk") {
                            $asigntime = date('Y-m-d', strtotime(str_replace("#", "+", $calrule["CslaC_ScheduleDay"])));
                            $asigntime = getNonWeekOffLeaveDate($uid, $asigntime);
                            $asigntime = date('Y-m-d 15:00:00', strtotime($asigntime));
                            updateAssignDateTimeLead($lid, $asigntime, $uid);
                            sendDisconnectedSMS($lid, $uid);

                        } else if ($calrule["CslaC_ScheduleDay"] == "Junk") {
                            AssignLead($lid, $teamLeader, $team, 0);
                            insertActionsLog($uid, "Lead Assigned To Team Leader : $teamLeader", "");

                            insertLabel($lid, 6, $uid);
                            updateStatus($lid, 8, $uid);
                            DelAssignDateLead($lid, $uid);
                        }
                    } else if ($disconnected > 6) {
                        AssignLead($lid, $teamLeader, $team, 0);
                        insertActionsLog($uid, "Lead Assigned To Team Leader : $teamLeader", "");
                        insertLabel($lid, 6, $uid);
                        updateStatus($lid, 8, $uid);
                        DelAssignDateLead($lid, $uid);
                    } else {
                        if ($leadstatus == "1" || $leadstatus == "2" || $leadstatus == "12") {
                            $asigntime = date('Y-m-d', strtotime("+1 days"));
                            $asigntime = getNonWeekOffLeaveDate($uid, $asigntime);
                            $asigntime = date('Y-m-d 15:00:00', strtotime($asigntime));
                            updateAssignDateTimeLead($lid, $asigntime, $uid);

                        }
						else if ($leadstatus == "3"){
                        DelAssignDateLead($lid, $uid);
                      }

                        sendDisconnectedSMS($lid, $uid);
                    }
                }
            }
        }
        else if($callstatus == "8" || $callstatus == "9" || $callstatus == "10"){
            DelAssignDateLead($lid, $uid);
        }






        echo "insert/" . $clid;

    }
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
}



?>