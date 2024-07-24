$(document).ready(function(){
    initDatePicker(".daterange", 0);
    $(document).on("change","[name=users]",function(){
        getAllDetailsByUser()
    })

});


function getAllDetailsByUser(){
    initLoader(true);
    var form = new FormData($("#userform")[0]);


    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/report/byuser.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#data-container").html(data);
            initLoader(false);
        }
    });
}