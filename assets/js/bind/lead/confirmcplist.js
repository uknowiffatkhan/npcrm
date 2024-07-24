$(document).ready(function () {
    // alert("Document is ready!");

    if($("[name=masterfilterdate]").val() != ""){
        var dt = $("[name=masterfilterdate]").val();
        $("[name=startdate]").val(dt.split('_')[0]);
        $("[name=enddate]").val(dt.split('_')[1]);
    }



    initDatePicker(".daterange",30);
    getLeadFilter();
    // getAllList()
    // getStatusWise();
    // $(document).on("change", ".btn-listtype input", function () {
    //     alert("first step");
    //     $(this).closest(".d-flex").find(".btn-listtype").each(function () {
    //         $(this).removeClass("checked")
    //     });
    //     $(this).closest(".btn-listtype").addClass("checked");

    //     $(".statuswisefilter").addClass("d-none");
    //         getAllList();
        

    // })

    // if($("[name=openlead]").val() != ""){
    //     $("#sidecard").addClass("open");
    //     getCpLeadDetails($("[name=openlead]").val());
    // }
    
    


    $(document).on("click", ".showfilter", function () {
        $("#filtercard").addClass("open");

    })

    // $(document).on("change", "[name=statuswise]", function () {
    //     getStatusWise();
    //     if(this.value == "time"){
    //         $("[name=dateby], .daterange").addClass("d-none");
    //     }
    //     else{
    //         $("[name=dateby], .daterange").removeClass("d-none");
    //     }
    // })



    
    $(document).on("change","[name=dateby], [name=startdate], [name=enddate], [name=leadsearch]",function(){
      
        var ftype = $("[name=filtertype]:checked").val();
        if (ftype == "alllist") {
            getAllList();
        }
    })

    $(document).on("click", "#filterapply, #reload", function () {
       
        var ftype = $("[name=filtertype]:checked").val();
         if (ftype == "alllist") {
            getAllList();
        }
        

    })
});


function initList(){
    
    $(".btn-listtype").each(function () {
        $(this).removeClass("checked")
    });
        $("[name=filtertype][value='alllist']").closest(".btn-listtype").addClass("checked");
        $("[name=filtertype][value='alllist']").click();
        $(".statuswisefilter").addClass("d-none");
        getAllList();
    
}


function getAllList() {
   
    initLoader(true);
    var form = new FormData();

    var pin = "";
    var loc = "";

    $("[name=dateby], .daterange").removeClass("d-none");
    $("[name*=pin]:checked").each(function () {
        pin = pin + "," + this.value;

    })
    pin = pin.slice(1, pin.length);

    $("[name*=loc]:checked").each(function () {
        loc = loc + "," + this.value;

    })
    loc = loc.slice(1, loc.length);

    form.append("pin", pin);
    form.append("loc", loc)
    form.append("dateby", $("[name=dateby]").val());
    form.append("sdate", $("[name=startdate]").val());
    form.append("edate", $("[name=enddate]").val());
    form.append("leadsearch", $("[name=leadsearch]").val());
    form.append("uid", $("[name=uid]").val());
    form.append("cid", $("[name=cid]").val());


    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/confirm-cp-list.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".list-container").html(data);
            calccards();
            $('[data-toggle="tooltip"]').tooltip({html:true});
            initLoader(false);
        }
    });
}


function calccards() {
    var sect = $(".status-divider");

    $(sect).each(function () {
        $(this).find(".divider-title").append(" - (" + $(this).find(".lead-card").length + ")");
    })

    var all = $(".lead-card").length;
    $("#all-count").html(all + " Leads")
    
}









function 
getLeadFilter() {
    var form = new FormData();

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/Cpfilter.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".filter-container").html(data);
            if($("[name=masterfilterfiltertype]").val() == "leadstatus"){
                $("[name*=leadstat]").each(function(){
                    $(this).closest(".form-check").find("label").html() == $("[name=masterfilterfilter]").val() ? (this.checked = true) : "";
                })
            }
            if($("[name=masterfilterfiltertype]").val() == "source"){
                $("[name*=src]").each(function(){
                    $(this).closest(".form-check").find("label").html() == $("[name=masterfilterfilter]").val() ? (this.checked = true) : "";
                })
            }
            if($("[name=masterfilterfiltertype]").val() == "interest"){
                $("[name*=intin]").each(function(){
                    $(this).closest(".form-check").find("label").html() == $("[name=masterfilterfilter]").val() ? (this.checked = true) : "";
                })
            }
            
            initList();
        }
    });
}


