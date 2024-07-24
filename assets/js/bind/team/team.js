$(document).ready(function(){
    initDatePicker(".team-daterange",30);

    getTeams();
    
    
});

$(document).on("change", "[name=month], [name=year]", function() {
    var form = $(this).closest("form");
    var id = form.find("[name=memberid]").val();
    var month = form.find("[name=month]").val();
    getMemberCalendar(id, month);
});

$(document).on("change", "#teamview", function() {
    var id = $(this).val();
    getTeams(id);
});
$(document).on("change", ".team-daterange", function() {
    getTeams();
});

$(document).on("click", ".member", function() {
    
    var id = $(this).find("[name=memberid]").val();
    var month = $(this).find("[name=month]").val();

    getMemberReport(id);
    getMemberLeads(id);
    getMemberCalendar(id,month);
     
 });

function getMemberReport(id){
    var form = new FormData();
    form.append('UId',id)
    
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/todayswork.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            var collapseElement = $("#overview" + id); 
            collapseElement.empty();
            collapseElement.append(data);        
            }
    });
}

function getMemberCalendar(id,month){
    var form = new FormData();
    if(month !="" &&  month !="undefined"  &&  month != undefined  ){
        form.append("month", $("[name=month]").val());
        form.append("year", $("[name=year]").val());
    }
   
    form.append('member',id)
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/calender.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            var collapseElement = $("#calendar" + id); 
            collapseElement.empty();
            collapseElement.append(data);        
            }
    });
}

function getMemberLeads(id){
    var form = new FormData();
    
    form.append('uid',id)
    form.append("sdate",$(".team-daterange [name=startdate]").val());
    form.append("edate",$(".team-daterange [name=enddate]").val());
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/statuswise.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            var collapseElement = $("#lead_overview" + id); 
            collapseElement.empty();
            collapseElement.append(data);        
            }
    });
}
function getTeams(id=''){
    var form = new FormData();
    form.append("sdate",$(".team-daterange [name=startdate]").val());
    form.append("edate",$(".team-daterange [name=enddate]").val());
    if(id != ''){
        form.append('team',id)
    }

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/team/teams.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#memberview").empty();
            $("#memberview").append(data);
        }
    });
}

