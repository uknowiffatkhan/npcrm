$(document).ready(function(){
    setInterval(function() {
        var getDay = moment().format('dddd');
        var getTime = moment().format('LLL')
        $("#reception_time_day").text(getDay);
        $("#reception_time").text(getTime);

    }, 1000);

    initDatePicker(".status-daterange", 30);
    initDatePicker(".int-daterange", 30);
    initDatePicker(".src-daterange", 30);
    initDatePicker(".clog-daterange", 0);
    initDatePicker(".activityreport-daterange", 0);
    
    getOverview();


    $(document).on("change",".status-daterange [name=startdate],.status-daterange  [name=enddate]",function(){
        getStatusWise();
    })

    $(document).on("change",".int-daterange [name=startdate],.int-daterange  [name=enddate]",function(){
        getInterestWise();
    })

    $(document).on("change",".src-daterange [name=startdate],.src-daterange  [name=enddate]",function(){
        getSourceWise();
    })

    $(document).on("change",".clog-daterange [name=startdate],.clog-daterange  [name=enddate]",function(){
        getCallLogs();
    })
  
    // $(document).on("change",".ccp-daterange [name=startdate],.ccp-daterange  [name=enddate]",function(){
    //     getConfirmCp();
    // })
    $(document).on("change",".activityreport-daterange [name=startdate],.activityreport-daterange  [name=enddate], [name=activityusers]",function(){
        getActivityReport();
    })
   
    getTodayScope();
    getCallLogs();
    getConfirmCp();
    getcplead();
    getnewcp();
})
$(document).on("click", ".svp", function () {
    form.append("sdate",$(".activityreport-daterange [name=startdate]").val());
    form.append("edate",$(".activityreport-daterange [name=enddate]").val());
    form.append("userid",$("[name=activityusers]").val());

})



function getStatusWise(){
    //initLoader(true);
    var form = new FormData();

    form.append("sdate",$(".status-daterange [name=startdate]").val());
    form.append("edate",$(".status-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/statuswise.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".status.status-cards").html(data);
            initLoader(false);
            getInterestWise();
        }
    });
}


function getConfirmCp(){
   
    //initLoader(true);
    var form = new FormData();

    form.append("sdate",$(".ccp-daterange [name=startdate]").val());
    form.append("edate",$(".ccp-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/confirmcp.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".ccp.status-card").html(data);
            initLoader(false);
           
        }
    });
}

function getcplead(){
   
    //initLoader(true);
    var form = new FormData();

    // form.append("sdate",$(".ccpl-daterange [name=startdate]").val());
    // form.append("edate",$(".ccpl-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/ccpleads.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            $(".ccpl.status-card").html(data);
            initLoader(false);
           
        }
    });
}

function getnewcp() {
    var form = new FormData();

    form.append("sdate", $(".ccp-daterange [name=startdate]").val());
    form.append("edate", $(".ccp-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/getnewcp.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
             console.log("Data received:", data);
            // Parse the JSON data returned from the PHP file
            var newData = JSON.parse(data);

            // Clear existing table rows
            $("#latestChannelPartnerListTable tbody").empty();
            
            // Iterate over each row of data and append it to the table
            newData.forEach(function(row) {
                var html = "<tr>";
                html += "<td>" + row['Cp_Code'] + "</td>";
                html += "<td>" + row['Cp_Name'] + "</td>";
                html += "<td>" + row['Cp_CreatedDate'] + "</td>";
                html += "<td>" + row['leads_count'] + "</td>";
                html += `<td><a href='v/lead/list.php?cid=${row['U_Id']}'><i class="fa-solid fa-arrow-up-right-from-square" style="color: #007bff;"></i></a></td>`;
                html += "</tr>";
                $("#latestChannelPartnerListTable tbody").append(html);
            });

            // Hide the loader
            initLoader(false);
        }
    });
}





function getTodayScope(){
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


function getOverview(){
    var form = new FormData();
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/overview.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".overview").empty();
            $(".overview").html(data);
            getStatusWise();

        }
    });
}

function getSiteVisitPlan(){
    //initLoader(true);
    var form = new FormData();
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/sitevisit.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            // $(".site-visit-plan").empty();
            $(".site-visit-plan").html(data);
            initLoader(false);
            getStatusWise();
        }
    });
}


function getSourceWise(){
    //initLoader(true);
    var form = new FormData();

    form.append("sdate",$(".src-daterange [name=startdate]").val());
    form.append("edate",$(".src-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/sourcewise.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".source.status-cards").html(data);
            initLoader(false);
        }
    });
}


function getInterestWise(){
    //initLoader(true);
    var form = new FormData();

    form.append("sdate",$(".int-daterange [name=startdate]").val());
    form.append("edate",$(".int-daterange [name=enddate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/interestwise.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".interest.status-cards").html(data);
            initLoader(false);
            getSourceWise();
        }
    });
}


function getleadsCards(){
    //initLoader(true);
    var form = new FormData();

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/leadcards.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".leads-card").html(data);
            initLoader(false);
        }
    });
}


function getActivityReport(){
    //initLoader(true);
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


