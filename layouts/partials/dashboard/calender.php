
<?php
if (!isset($_SESSION)) {
    session_start();
}

$baseurl = $_SESSION["baseurl"];

include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/teammodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/remindermodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/leadmodel.php";
include_once $_SERVER['DOCUMENT_ROOT'] . $baseurl . "model/dashboard.php";

$uid = $_SESSION["UId"];

function build_calendar($month, $year, $dateArray,$uid)
{
    $baseurl = $_SESSION["baseurl"];


    $daysOfWeek = array('S', 'M', 'T', 'W', 'T', 'F', 'S');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<div><table class='table table-bordered table-hover bg-white'>";
    $calendar .= "<tr class='text-center'>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header p-1' style='font-size: 10px;'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr style='height: 20px'>";

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
        $rm = getReminderbydate($uid, date('Y-m-d', strtotime($date)));
        $rm = $rm->num_rows;
        $rmm = "";
        if ($rm > 0) {
            $rmm = "<span class='badge text-bg-warning text-white float-end' onclick=getNotifications('" . date('Y-m-d', strtotime($date)) . "') >$rm</span>";
        }

        $vpp = "";
        $vppi="";
        $vppc = 0;
        if($_SESSION['TypeId'] == 7){
            $vp = getReceptionSiteVisitPlanByDate($uid, date('Y-m-d', strtotime($date)));
            if ($vp->num_rows > 0) {
                while ($r = $vp->fetch_assoc()) {
                    $vppc = $vppc + $r["ldc"];
                }
            }
            if ($vppc > 0) {
                $vpp = "<a href='" . $baseurl . "v/lead/list.php?type=all&visitrange=" . date('Y-m-d', strtotime($date)) . "_" . date('Y-m-d', strtotime($date)) . "'><span class='badge text-bg-warning text-white float-end bg-Site-Visit-Plan rounded px-1' style='font-size: 9px;'>0$vppc</span></a>";

            }
        }else{

            $vp = getSiteVisitPlanByDate($uid, date('Y-m-d', strtotime($date)));
           
            if ($vp->num_rows > 0) {
                while ($r = $vp->fetch_assoc()) {
                    $vppc = $vppc + $r["ldc"];
                }
            }
            if ($vppc > 0) {
                $cid = urlencode(encrypt($uid));
                $vpp = "<a href='" . $baseurl . "v/lead/list.php?type=all&visitrange=" . date('Y-m-d', strtotime($date)) . "_" . date('Y-m-d', strtotime($date)) . "&cid=$cid'><span class='badge text-bg-warning text-white float-end bg-Site-Visit-Plan rounded px-1 text-white' style='font-size: 9px;'>0$vppc</span></a>";
            }
        }
        
      

        $calls = getTodaysScope($uid, date('Y-m-d', strtotime($date)));
        $callogs = "";
        $ttlcls = "";
        $fhcls = "";
        $shcls = "";
        while ($cll = $calls->fetch_assoc()) {
            if ($cll["label"] == "Total Calls") {
                $ttlcls = $cll["leadcount"];
            }
            if ($cll["label"] == "First Half") {
                $fhcls = $cll["leadcount"];
            }
            if ($cll["label"] == "Second Half") {
                $shcls = $cll["leadcount"];
            }
        }
        // $callogs
        if ($ttlcls != 0 || $fhcls != 0 || $shcls != 0) {
            $callogs = "FH: " . $fhcls . " + SH: " . $shcls . " = TC: " . $ttlcls;
            $callogs = "<div class='fs-sm bg-dark rounded px-1 text-white Opentodayreportmodal' data-uid='" . $uid . "' data-date='$date'></div>";
        }

        $calendar .= "<td class='day p-1' rel='$date'><span> $vpp </span><span style='font-size: 15px;font-weight: bold;'>$currentDay </span></td>";

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";
    $calendar .= "</table></div></div>";

    return $calendar;
}


function generateMonthYearDropdowns($selectedMonth, $selectedYear,$id)
{
    $months = array(
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    );

    $currentYear = date('Y');
    $currentMonth = date('n');
    $yearRange = range($currentYear, $currentYear + 5);

    $html = '<form method="POST" action="" id="calenderDropdown"><div class="row" style="width:300px" >
    <div class="col-6">
<input type="hidden" name="memberid" value="'.$id.'">
    <select class="form-select form-select-sm  mb-3"  id="monthSelect" name="month">';
    foreach ($months as $monthNumber => $monthName) {
        $selected = ($monthNumber == $selectedMonth) ? 'selected' : '';
        $disabled = ($monthNumber < $currentMonth && $selectedYear == $currentYear) ? 'disabled' : '';
        $html .= "<option value='$monthNumber' $selected $disabled>$monthName</option>";
    }
    $html .= '</select></div>';

    $html .= '<div class="col-6"><select class="form-select form-select-sm  mb-3"  id="yearSelect" name="year">';
    foreach ($yearRange as $year) {
        $selected = ($year == $selectedYear) ? 'selected' : '';
        $disabled = ($year < $currentYear) ? 'disabled' : '';
        $html .= "<option value='$year' $selected $disabled>$year</option>";
    }
    $html .= '</select></div></form>';

    return $html;
}

            $dateComponents = getdate();
            $month = isset($_POST['month']) ? $_POST['month'] : $dateComponents['mon'];
            $year = isset($_POST['year']) ? $_POST['year'] : $dateComponents['year'];
            $id =isset($_POST['member']) ? $_POST['member'] : $uid;

            echo generateMonthYearDropdowns($month, $year,$id);
            echo build_calendar($month, $year, null,$id);


?>

               