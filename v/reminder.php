<?php

include('../layouts/head.php');
include('../layouts/auth.php');
include('../model/leadmodel.php');
include('../model/remindermodel.php');
include('../model/dashboard.php');

$baseurl = $_SESSION["baseurl"];
$uid = $_SESSION["UId"];

function build_calendar($month, $year, $dateArray)
{
    $baseurl = $_SESSION["baseurl"];

    $daysOfWeek = array('S', 'M', 'T', 'W', 'T', 'F', 'S');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];

    $calendar = "<table class='table table-bordered table-hover'>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    $currentDay = 1;
    $calendar .= "</tr><tr>";

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
        $rm = getReminderbydate($_SESSION["UId"], date('Y-m-d', strtotime($date)));
        $rm = $rm->num_rows;
        $rmm = "";
        if ($rm > 0) {
            $rmm = "<div class='fs-sm bg-New rounded px-2 text-white' onclick=getNotifications('" . date('Y-m-d', strtotime($date)) . "') >$rm Reminders</div>";
        }
    

        $vpp = "";
        $vppc = 0;

        if($_SESSION['TypeId'] == 7){
            $vp = getReceptionSiteVisitPlanByDate($_SESSION["UId"], date('Y-m-d', strtotime($date)));
            if ($vp->num_rows > 0) {
                while ($r = $vp->fetch_assoc()) {
                    $vppc = $vppc + $r["ldc"];
                }
            }
            if ($vppc > 0) {
    
                $vpp = "<a href='" . $baseurl . "v/lead/list.php?type=all&visitrange=" . date('Y-m-d', strtotime($date)) . "_" . date('Y-m-d', strtotime($date)) . "'><div class='fs-sm bg-Site-Visit-Plan rounded px-2 text-white'>$vppc Visit Plan</div></a>";
            }
        }else{

            $vp = getSiteVisitPlanByDate($_SESSION["UId"], date('Y-m-d', strtotime($date)));
           
            if ($vp->num_rows > 0) {
                while ($r = $vp->fetch_assoc()) {
                    $vppc = $vppc + $r["ldc"];
                }
            }
            if ($vppc > 0) {
    
                $vpp = "<a href='" . $baseurl . "v/lead/list.php?type=all&visitrange=" . date('Y-m-d', strtotime($date)) . "_" . date('Y-m-d', strtotime($date)) . "'><div class='fs-sm bg-Site-Visit-Plan rounded px-2 text-white'>$vppc Visit Plan</div></a>";
            }
        }
        

        $calls = getTodaysScope($_SESSION["UId"], date('Y-m-d', strtotime($date)));
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
        if ($ttlcls != 0 || $fhcls != 0 || $shcls != 0) {
            $callogs = "FH: " . $fhcls . " + SH: " . $shcls . " = TC: " . $ttlcls;
            $callogs = "<div class='fs-sm bg-dark rounded px-2 text-white Opentodayreportmodal' data-uid='" . $_SESSION["UId"] . "' data-date='$date'>$callogs</div>";
        }

        $calendar .= "<td class='day' rel='$date'><div>$currentDay</div>$rmm $vpp $callogs</td>";

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}


function generateMonthYearDropdowns($selectedMonth, $selectedYear)
{
    $months = array(
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    );

    $currentYear = date('Y');
    $currentMonth = date('n');
    $yearRange = range($currentYear, $currentYear + 5);

    $html = '<div class="row"><div class="col-2"><select class="form-select form-select-lg mb-3" aria-label="Large select example" id="monthSelect" name="month">';
    foreach ($months as $monthNumber => $monthName) {
        $selected = ($monthNumber == $selectedMonth) ? 'selected' : '';
        $disabled = ($monthNumber < $currentMonth && $selectedYear == $currentYear) ? 'disabled' : '';
        $html .= "<option value='$monthNumber' $selected $disabled>$monthName</option>";
    }
    $html .= '</select></div>';

    $html .= '<div class="col-2"><select class="form-select form-select-lg mb-3" aria-label="Large select example" id="yearSelect" name="year">';
    foreach ($yearRange as $year) {
        $selected = ($year == $selectedYear) ? 'selected' : '';
        $disabled = ($year < $currentYear) ? 'disabled' : '';
        $html .= "<option value='$year' $selected $disabled>$year</option>";
    }
    $html .= '</select></div></div>';

    return $html;
}


?>
<style>
    table{
        width:100%;
    }
    table th,
    table td {
        width: calc(100%/7);
        height: 60px;
        /* border: 1px solid #bbb; */
        vertical-align: baseline;
        font-size: 1.2rem;
        padding: 0.5rem;
    }
</style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include('../layouts/sidemenu.php') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php
                $pagetitle = "Calender ". date('M Y');

                include('../layouts/header.php')
                ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">


                    <div class="container-xxl flex-grow-1 container-p-y">

                        <?php
                        $dateComponents = getdate();
                        $month = isset($_GET['month']) ? $_GET['month'] : $dateComponents['mon'];
                        $year = isset($_GET['year']) ? $_GET['year'] : $dateComponents['year'];
                        echo generateMonthYearDropdowns($month, $year);
                        echo build_calendar($month, $year, null);

                        ?>
           <div class="modal fade" id="todayReportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="todayReportBody"></div>
                        </div>
                    </div>
                </div>
            </div>


                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include('../layouts/footer.php') ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <?php include('../layouts/foot.php') ?>
    <script src="<?php echo $baseurl ?>assets/js/bind/users/activate.js"></script>

    <!-- JavaScript to handle the dropdown change events -->
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('monthSelect').addEventListener('change', function() {
            let month = this.value;
            let year = document.getElementById('yearSelect').value;
            window.location.href = "?month=" + month + "&year=" + year;
        });

        document.getElementById('yearSelect').addEventListener('change', function() {
            let year = this.value;
            let month = document.getElementById('monthSelect').value;
            window.location.href = "?month=" + month + "&year=" + year;
        });
    });

    $(document).on('click', '.Opentodayreportmodal', function() {
    var uid = '<?php echo $uid; ?>';
    var fromDate = $(this).data('date');
    openUserModal(uid, fromDate);
}); 



function openUserModal(uid, fromDate)
 {
    var form = new FormData();
    form.append("UId", uid);
    form.append("date", fromDate)
    $.ajax({
        method: "POST",
        url: "<?php echo $baseurl; ?>layouts/partials/dashboard/todayswork.php",
        data: form,
        processData: false,
        contentType: false,
        success: function(data) {
            $('#todayReportBody').html(data);

            $('#todayReportBody a').each(function() {
                var currentUrl = new URL($(this).attr('href'), window.location.href);
                    currentUrl.searchParams.set('fromDate', fromDate);
                    $(this).attr('href', currentUrl.toString());
                });
            
            $('#todayReportModal').modal('show');
        }
    });

    }
    </script>

</body>

</html>
