$(document).ready(function(){
    initDatePicker(".status-daterange", 0);
    initDatePicker(".sourcelead-daterange", 0);
    initDatePicker(".activityreport-daterange", 0);
    getTodayScope();
    getSourceOverview();
    getActivityReport();
    //getSiteVisitPlan();
    $(document).on("change",".status-daterange [name=startdate]",function(){
        setTimeout(function(){
            getTodayScope();
        },500)
        
    })

    $(document).on("change",".sourcelead-daterange [name=startdate]",function(){
        getSourceOverview();
    })

    $(document).on("change",".activityreport-daterange [name=startdate], [name=activityusers]",function(){
        getActivityReport();
    })

    $(document).on("change","[name=visitplanusers]",function(){
        getSiteVisitPlan();
    })

    $(".site-visit-plan").html("<div class='card'><div class='card-body'>Select Any One User</div></div>");

    $(document).on('click', '.open-modal', function() {
        // alert("clicked");
        var leadID = $(this).closest('td').find('.lead-id').val();

        if (leadID != 0) {
            openLeadModal(leadID);

        }
    });
    $(document).on('click', '.user-modal', function() {
        // alert("clicked");
        var uID = $(this).closest('td').find('.user-id').val();
        if (uID >= 1) {
            openUserModal(uID);
        }
    });
    $(document).on('click', '.visit-modal', function() {
        var leadID = $(this).find('.lead-id').val();

        if (leadID != 0) {
            openLeadModal(leadID);
        }
    });
})

function openLeadModal(leadID) {
    var form = new FormData();
    form.append("lid", leadID);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/admin/detailmodal.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#leadModal').html(data);
            $('#exampleModal').modal('show');
        }
    });
   
}

function openUserModal(uID) {
    var form = new FormData();
    form.append("UId", uID);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/todayswork.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#leadModal').html(data);
            $('#exampleModal').modal('show');
        }
    });

}


function getTodayScope(){
    initLoader(true);
    var form = new FormData();
    form.append("sdate",$(".status-daterange [name=startdate]").val());
    form.append("edate",$(".status-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/todaysreport.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".todays-scope").html(data);
            initLoader(false);
        }
    });
}
function getUserScope(){
    //initLoader(true);
    var form = new FormData();


    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/todayswork.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".todays-scope").html(data);
            initLoader(false);
            getSiteVisitPlan();
            getActivityReport();
        }
    });
}
function getSourceOverview(){
    initLoader(true);
    var form = new FormData();
    form.append("sdate",$(".sourcelead-daterange [name=startdate]").val());
    form.append("edate",$(".sourcelead-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/admin/leadoverviewstatus.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sourcelead-overview").html(data);
            initLoader(false);
        }
    });
}


function getActivityReport(){
    initLoader(true);
    var form = new FormData();

    form.append("sdate",$(".activityreport-daterange [name=startdate]").val());
    form.append("edate",$(".activityreport-daterange [name=enddate]").val());
    form.append("userid",$("[name=activityusers]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/calllogdetail.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".activityreport.status-cards").html(data);
            initLoader(false);
        }
    });
}


function getSiteVisitPlan(){
    initLoader(true);
    var form = new FormData();
    form.append("userid",$("[name=visitplanusers]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/sitevisit.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".site-visit-plan").html(data);
            initLoader(false);
            getStatusWise();
        }
    });
}