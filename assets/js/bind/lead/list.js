$(document).ready(function () {


    $(document).on("change", "[name=statuswise], [name=fromDate]", handleChange);

    // $(document).on("change", "[name=statuswise]", function () {
    //     getStatusWise();
    //     if (this.value == "time") {
    //         $("[name=dateby], .daterange").addClass("d-none");
    //     } else {
    //         $("[name=dateby], .daterange").removeClass("d-none");
    //     }
    // });



        function handleChange() {
            const statuswiseValue = $("[name=statuswise]").val();
            const fromDateValue = $("[name=fromDate]").val();

            if ($(this).attr("name") === "statuswise") {
                getStatusWise();
            }

            if (statuswiseValue === "time" || fromDateValue !== "") {
                $("[name=dateby], .daterange").addClass("d-none");
            } else {
                $("[name=dateby], .daterange").removeClass("d-none");
            }
        }


   


    if($("[name=masterfilterdate]").val() != ""){
        var dt = $("[name=masterfilterdate]").val();
        $("[name=startdate]").val(dt.split('_')[0]);
        $("[name=enddate]").val(dt.split('_')[1]);
    }



    initDatePicker(".daterange",30);
    getLeadFilter();
    // getStatusWise();
    $(document).on("change", ".btn-listtype input", function () {
        $(this).closest(".d-flex").find(".btn-listtype").each(function () {
            $(this).removeClass("checked")
        });
        $(this).closest(".btn-listtype").addClass("checked");

        if (this.value == "statuswise") {
            $(".statuswisefilter").removeClass("d-none");
            getStatusWise();
        }
        else {
            $(".statuswisefilter").addClass("d-none");
            getAllList();
        }

    })


    
    


    $(document).on("click", ".showfilter", function () {
        $("#filtercard").addClass("open");

    })

       

    
    $(document).on("change","[name=dateby], [name=startdate], [name=enddate], [name=leadsearch]",function(){
        var ftype = $("[name=filtertype]:checked").val();
        if (ftype == "statuswise") {
            getStatusWise();
        }
        else if (ftype == "alllist") {
            getAllList();
        }
    })


    


    $(document).on("click", "#filterapply, #reload", function () {
        var ftype = $("[name=filtertype]:checked").val();
        if (ftype == "statuswise") {
            getStatusWise();
        }
        else if (ftype == "alllist") {
            getAllList();
        }
        

    })


    


});


function initList(){
    $(".btn-listtype").each(function () {
        $(this).removeClass("checked")
    });
    if($("[name=masterfilterlisttype]").val() == "all"){
        $("[name=filtertype][value='alllist']").closest(".btn-listtype").addClass("checked");
        $("[name=filtertype][value='alllist']").click();
        $(".statuswisefilter").addClass("d-none");
        getAllList();
    }
    else if($("[name=masterfilterlisttype]").val() == "wise"){
        $("[name=filtertype][value='statuswise']").closest(".btn-listtype").addClass("checked");
        $(".statuswisefilter").removeClass("d-none");
        getStatusWise();
    }
    else{
        $("[name=filtertype][value='statuswise']").closest(".btn-listtype").addClass("checked");
        $(".statuswisefilter").removeClass("d-none");
        getStatusWise();
    }
}




function getStatusWise() {
    initLoader(true);
    var form = new FormData();
    var sts = "";
    var src = "";
    var int = "";
    var lbl = "";

    if($("[name=statuswise]").val() == "time"){
        $("[name=dateby], .daterange").addClass("d-none");
    }
    else{
        $("[name=dateby], .daterange").removeClass("d-none");
    }

    $("[name*=leadstat]:checked").each(function () {
        sts = sts + "," + this.value;

    })
    sts = sts.slice(1, sts.length);

    $("[name*=src]:checked").each(function () {
        src = src + "," + this.value;

    })
    src = src.slice(1, src.length);

    $("[name*=intin]:checked").each(function () {
        int = int + "," + this.value;

    })
    int = int.slice(1, int.length);

    $("[name*=lb]:checked").each(function () {
        lbl = lbl + "," + this.value;

    })
    lbl = lbl.slice(1, lbl.length);

    form.append("type", $("[name=statuswise]").val());
    form.append("status", sts);
    form.append("source", src);
    form.append("interest", int);
    form.append("label", lbl);
    form.append("misc", $("[name=misc]").val());

    form.append("dateby", $("[name=dateby]").val());

    fromDate =$("[name=fromDate]").val();
    if(fromDate != '' ){
        form.append("sdate",fromDate);
        form.append("edate", fromDate);
    }else{
        form.append("sdate", $("[name=startdate]").val());
        form.append("edate", $("[name=enddate]").val());
    }
    
    form.append("leadsearch", $("[name=leadsearch]").val());
    form.append("cid", $("[name=cid]").val());
    form.append("uid", $("[name=uid]").val());

   
    $.ajax({
        
        method: "POST",
        url: baseurl + "layouts/partials/lead/status-list.php",
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


function getAllList() {
    initLoader(true);
    var form = new FormData();
    var sts = "";
    var src = "";
    var int = "";
    $("[name=dateby], .daterange").removeClass("d-none");
    $("[name*=leadstat]:checked").each(function () {
        sts = sts + "," + this.value;

    })
    sts = sts.slice(1, sts.length);

    $("[name*=src]:checked").each(function () {
        src = src + "," + this.value;

    })
    src = src.slice(1, src.length);

    $("[name*=intin]:checked").each(function () {
        int = int + "," + this.value;

    })
    int = int.slice(1, int.length);

 


    form.append("status", sts);
    form.append("source", src);
    form.append("interest", int);
    form.append("dateby", $("[name=dateby]").val());

    fromDate =$("[name=fromDate]").val();
    if(fromDate != '' ){
        form.append("sdate",fromDate);
        form.append("edate", fromDate);
    }else{
        form.append("sdate", $("[name=startdate]").val());
        form.append("edate", $("[name=enddate]").val());
    }
    
  
    form.append("leadsearch", $("[name=leadsearch]").val());
    form.append("misc", $("[name=misc]").val());
    form.append("uid", $("[name=uid]").val());
    form.append("cid", $("[name=cid]").val());

    
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/all-list.php",
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
        url: baseurl + "layouts/partials/lead/filter.php",
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


