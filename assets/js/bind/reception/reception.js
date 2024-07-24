$(document).ready(function(){
    
SalesPersons();
SiteVisitPLan();
SiteVisitLead();
getCalendar();

});
$(document).on("change", "[name=month], [name=year]", function() {
    var form = $(this).closest("form");
    var month = form.find("[name=month]").val();
    getCalendar(month);
});

$(document).on("keyup", "[name=salesearch]", function () {

    SalesPersons();
});
$(document).on("keyup", "[name=visitleadsearch]", function () {

    SiteVisitLead();
});


function SalesPersons() {
    var form = new FormData();
    form.append("search", $("[name=salesearch]").val());
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/reception/salelist.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#sale_List').empty();
            $('#sale_List').html(data);
        }
    });
   
}
function getCalendar(month){
    var form = new FormData();
    if(month !="" &&  month !="undefined"  &&  month != undefined  ){
        form.append("month", $("[name=month]").val());
        form.append("year", $("[name=year]").val());
    }
   

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/calender.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#reception_calender').empty();
            $('#reception_calender').html(data);
            }
    });
}

function SiteVisitPLan() {
    var form = new FormData();
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/reception/site.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#site_visit_plan').empty();
            $('#site_visit_plan').html(data);
        }
    });
   
}

function SiteVisitLead() {
    var form = new FormData();
    form.append("search", $("[name=visitleadsearch]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/reception/sitelead.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#visit_planned_lead').empty();
            $('#visit_planned_lead').html(data);
        }
    });
   
}