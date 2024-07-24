$(document).ready(function () {
    $(document).on("click", "#addrow", function () {
        var row = $("#clonerow > table > tbody").html();
        row = row.replace(/data-/g, "");
        $("#realtable tbody").append(row);
    })

    $(document).on("click", ".clearrow", function () {
        var row = $(this).closest("tr");
        $(row).remove();
    })


    $(document).on("keypress", ".num", function (e) {
        if (e.which > 47 && e.which < 58) {
        }
        else {
            e.preventDefault();
        }
    })

    $(document).on("click", "#sidecard .before", function () {
        $("#sidecard").removeClass("open");
        $(".sidecard-container").html("");
    })


    $(document).on("click", "#filtercard .before", function () {
        $("#filtercard").removeClass("open");
    })

    $(document).on("click", ".notifications a", function () {
        getNotifications();
    })
    
    //toastr.options.closeButton = true;
    checkNotify();
    getCallLogs();
    checklivereminderontime();
    setInterval(function () { checkNotify(); checklivereminderontime(); getCallLogs(); }, 60000);

    $(document).on("click", ".showdetails", function () {
        $("#sidecard").addClass("open");
        var d = $(this).find("[name=leadid]").val();
        getLeadDetails(d);
    })

    $(document).on("click", ".cpshowdetails", function () {
        $("#sidecard").addClass("open");
        var d = $(this).find("[name=leadid]").val();
        getCpDetails(d);
    })

    $(document).on("click", ".cpleadshowdetails", function () {
        $("#sidecard").addClass("open");
        var d = $(this).find("[name=leadid]").val();
        getCpLeadDetails(d);
    })


    $(document).on("click", ".open-notify", function () {
        $("#sidecard").addClass("open");
        var d = $(this).attr("data-id");
        var ld = $(this).attr("data-lid");
        getLeadDetails(ld);
        markread(d);
    })

    $(document).on("click", ".btn-projectdetail", function () {
        if ($(".sidecard-container .projectdetails").length > 0) {
            $(".sidecard-container .projectdetails").remove();
            $(".btn-projectdetail").html("Project Details").addClass("btn-info").removeClass("btn-danger");
        }
        else {
            var d = $(this).closest(".lead-details-blk").find("[name=detailid]").val();
            getProjectDetails(d);
        }



    })


    $(document).on("click", ".btn-reminder", function () {
        if ($(".sidecard-container .reminder-blk").length > 0) {
            $(".sidecard-container .reminder-blk").remove();
            $(".btn-reminder").html("Add Reminder").addClass("btn-secondary").removeClass("btn-danger");
        }
        else {
            getReminderForm();
        }

    })

    $(document).on("click", ".btn-calllog", function () {
        if ($(".sidecard-container .call-log-blk").length > 0) {
            $(".sidecard-container .call-log-blk").remove();
            $(".btn-calllog").html("Add Call Log").addClass("btn-primary").removeClass("btn-danger");
        }
        else {
            getCallForm();
        }

    })


    $(document).on("change", "[name=callstatus]", function () {
        if (this.value == "2") {
            $(".reminderdate").removeClass("d-none");
            getLastConnectedDate();
        }
        else {
            $(".reminderdate").addClass("d-none");
            $("[name=reminderdate]").val("");
        }

        if (this.value == "1" || this.value == "8" || this.value == "9" || this.value == "10"  || this.value == "12" || this.value == "13" ) {
            $(".leadstatusblk").removeClass("d-none");
            if ($(".leadstatusblk [name=leadstatus]").val() == "2" || $(".leadstatusblk [name=leadstatus]").val() == "3" || $(".leadstatusblk [name=leadstatus]").val() == "4" ) {
                $(".reminderdate").removeClass("d-none");
                    if( $(".leadstatusblk [name=leadstatus]").val() == "4"){
                        $(".leadstatusblk [name=leadstatus]").val("");
                        $("[name=reminderdate]").val("");

                    }else{
                        getLastConnectedDate();

                    }

            }
            else {
                $(".reminderdate").addClass("d-none");
                $("[name=reminderdate]").val("");
            }

            if(this.value == "1" || this.value == "12" || this.value == "13" ){
                $("#calltype").removeClass("d-none");
            }
            else{
                $("#calltype").addClass("d-none");
            }
           

            if ($(".leadstatusblk [name=leadstatus]").val() == "4") {
                $(".project").removeClass("d-none");
            }
            else {
                $(".project").addClass("d-none");
            }
        }
        else if (this.value == "2") {

            $(".reminderdate").removeClass("d-none");
            getLastConnectedDate();
            $("#calltype").removeClass("d-none");
            $(".project").addClass("d-none");

        }else {
            $(".leadstatusblk").addClass("d-none");
            $(".leadstatusblk [name=leadstatus]").find("option[value='" + $("[name=hfleadstatus]").val() + "']").attr("selected", true);
            $(".leadstatusblk [name=leadstatus]").val($("[name=hfleadstatus]").val());
            $(".leadstatusblk [name=leadstatus]").find("option[value='" + $("[name=hfleadstatus]").val() + "']")[0].selected = true;
            $(".project").addClass("d-none");
            if (($(".leadstatusblk [name=leadstatus]").val() == "2" || $(".leadstatusblk [name=leadstatus]").val() == "3") && (this.value == "1" || this.value == "8" || this.value == "9" || this.value == "10")) {
                $(".reminderdate").removeClass("d-none");
                getLastConnectedDate();
            }
            else {
                $(".reminderdate").addClass("d-none");
                $("[name=reminderdate]").val("");
            }
            $("#calltype").addClass("d-none");
        }

    })
    $(document).on("change", "[name=callstatus]", function () {

        if (this.value == "12" ) {
            InPersonType();
        }else if (this.value == "13"){
            VcType();
        }else{
            $("#calltypeselect").html(
                "<option>Outgoing</option><option>Incoming</option>"
            );
        }
        
    })

    $(document).on("change", "[name=leadstatus]", function () {
        if (this.value == "4" || this.value == "2" || this.value == "3" || this.value == "12" || this.value == "17" ) {

            $(".reminderdate").removeClass("d-none");
            if (this.value == "4") {
                $("[name=reminderdate]").val("");
            } else {
                getLastConnectedDate();
            }

          
        }
        else {
            $(".reminderdate").addClass("d-none");
            $("[name=reminderdate]").val("");
        }
        if (this.value == "4" || this.value == "17" ) {
            $(".project").removeClass("d-none");
        }
        else {
            $(".project").addClass("d-none");
        }
    })

    $(document).on("change", "[type=checkbox]", function () {
        if (this.checked == true) {
            $(this).attr("checked", true);
        }

    })


    $(document).on("click", "#updatelead", function () {
        LeadStatLblUpdate();
    })


    $(document).on("click", ".menu-link.menu-toggle", function () {
        $(this).closest(".menu-item").toggleClass("open");
    })

    $(document).on("click", "#reloadleaddetails", function () {
        getLeadDetails(this.value);
    })


    //   if(Notification.permission === "granted"){
    //     //setTimeout(function(){shownotification();},2000);
    //     new Notification ("Desktop notification example");
    // }
    // else if(Notification.permission !== "denied"){
    //     Notification.requestPermission().then(permission => {
    //         alert("granted");
    //     })
    // }

    $(document).on("click", ".btn-showquote", function () {
        if ($(".sidecard-container .lead-quotelist").length > 0) {
            $(".sidecard-container .lead-quotelist").remove();
            $(".btn-showquote").html("Show Quotations").removeClass("btn-danger");
        }
        else {
            getQuoteList();
        }

    })

    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //     return new bootstrap.Tooltip(tooltipTriggerEl)
    // })



    $(document).on("change", ".layout-menu-toggle", function () {
        $(".layout-menu").attr("style", "transform:translate3d(0, 0, 0)");
    })
    var delaySearch;
    var searchval;
    $(document).on("keyup", "[name=globalsearch]", function () {
        if (this.value.length >0) {
            clearTimeout(delaySearch);
            searchval = this.value;
            delaySearch = setTimeout(function () {

                QuickSearch(searchval);
            }, 1000);
        }

    })

    $(document).on("click", ".s-close", function () {
        $("#quicksearchcont").html("");
        $("#quicksearchcont").addClass("d-none");
        $("[name=globalsearch]").val("");
    })





    $(document).on("click", "#claimlead", function () {
        var d = $(this).closest(".lead-details-blk").find("[name=detailid]").val();
        claimLead(d);
    })

    $(".select2").select2();


    $(document).on("click", ".showmorelessdetails", function () {
        $(this).closest(".more-detail").find(".showmorecont").toggleClass("show");
        if (this.innerHTML == "Show More") {
            this.innerHTML = "Show Less";
        }
        else {
            this.innerHTML = "Show More";
        }
    })


    $(document).on("click","#btnjunk",function(){
        setJunkLead();
    })

})


function QuickSearch(s) {

    initSearchLoader(true);
    var form = new FormData();
    form.append("mode" , "user")
    form.append("search", s);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/search.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#quicksearchcont").html(data);
            $("#quicksearchcont").removeClass("d-none");
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip({ html: true });
            }, 500);
            initSearchLoader(false);
        }
    });

}

function VcType() {

    var form = new FormData();
    
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dropdowns/vctype.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#calltypeselect").html(data);
        }
    });

}
function InPersonType() {

    var form = new FormData();
    
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dropdowns/inperson.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#calltypeselect").html(data);
        }
    });

}



function openreminder(id,rid){
    markread(rid);
    getLeadDetails(id);
}

function shownotification() {
    let notification = new Notification("Reminder!", {
        body: "You have a reminder to attend"
    })

    notification.onclick = (e) => {
        window.parent.parent.focus();
    }
}


function LeadStatLblUpdate() {
    initLoader(true);
    var form = new FormData();
    form.append("mode", "updatelabel");
    form.append("leadid", $("[name=detailid]").val());
    form.append("status", $("[name=leadupdate]").val());
    form.append("labels", $("[name=labelupdate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "actions/lead.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            initLoader(false);
            //$(".filter-container").html(data);
            $("#reload").click();
        }
    });
}


function setJunkLead(){
    initLoader(true);
    var form = new FormData();

    form.append("mode", "setjunk");
    form.append("leadid", $("[name=detailid]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "actions/lead.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            initLoader(false);
            $("#reload").click();
            $("#reloadleaddetails").click();
        }
    });
}



function getLeadDetails(d) {
    initLoader(true);
    var form = new FormData();

    form.append("lid", d);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/details.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").html(data);
            if(!$("#sidecard").hasClass("open")){
                $("#sidecard").addClass("open");
            }
            try {
                $("[name=leadupdate]").find("option[value='" + $("[name=leadupdate]").attr("data-selected") + "']").attr("selected", true);
                $("[name=leadupdate]").find("option[value='" + $("[name=leadupdate]").attr("data-selected") + "']")[0].selected = true;
                var lbls = $("[name=labelupdate]").attr("data-selected");
                lbls = lbls.split(',');
                $(lbls).each(function () {
                    if (this != "") {
                        $("[name=labelupdate]").find("option[value='" + this + "']").attr("selected", true);
                        $("[name=labelupdate]").find("option[value='" + this + "']")[0].selected = true;
                    }
                })
            }
            catch (e) { }
            var showjunk = 0;
            $(".calllogcard").each(function(){
                var cs = $(this).find("[name=hfcallstatus]").val();
                if(cs == "Disconnected"){
                    showjunk = showjunk + 1;
                }
                else{
                    return false;
                }
            })
            if(showjunk > 4){
                $("#btnjunk").removeClass("d-none");
            }
            else{
                $("#btnjunk").addClass("d-none");
            }
            $(".select2").select2();
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip({ html: true });
            }, 500);
            initLoader(false);
        }
    });
}

function getCpDetails(d) {
    initLoader(true);
    var form = new FormData();

    form.append("lid", d);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/cpdetails.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").html(data);
            if(!$("#sidecard").hasClass("open")){
                $("#sidecard").addClass("open");
            }
            try {
                $("[name=leadupdate]").find("option[value='" + $("[name=leadupdate]").attr("data-selected") + "']").attr("selected", true);
                $("[name=leadupdate]").find("option[value='" + $("[name=leadupdate]").attr("data-selected") + "']")[0].selected = true;
                var lbls = $("[name=labelupdate]").attr("data-selected");
                lbls = lbls.split(',');
                $(lbls).each(function () {
                    if (this != "") {
                        $("[name=labelupdate]").find("option[value='" + this + "']").attr("selected", true);
                        $("[name=labelupdate]").find("option[value='" + this + "']")[0].selected = true;
                    }
                })
            }
            catch (e) { }
            var showjunk = 0;
            $(".calllogcard").each(function(){
                var cs = $(this).find("[name=hfcallstatus]").val();
                if(cs == "Disconnected"){
                    showjunk = showjunk + 1;
                }
                else{
                    return false;
                }
            })
            if(showjunk > 4){
                $("#btnjunk").removeClass("d-none");
            }
            else{
                $("#btnjunk").addClass("d-none");
            }
            $(".select2").select2();
            // var l = JSON.parse(labellist);
            // var tags = new Tagify($(".labels")[0], {
            //     whitelist: [l],
            //     dropdown: {
            //         classname: "color-blue",
            //         enabled: 0,              // show the dropdown immediately on focus
            //         maxItems: 5,
            //         position: "text",         // place the dropdown near the typed text
            //         closeOnSelect: false,          // keep the dropdown open after selecting a suggestion
            //         highlightFirst: true
            //     }
            // });
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip({ html: true });
            }, 500);
            initLoader(false);
        }
    });
}

function getCpLeadDetails(d) {
    initLoader(true);
    var form = new FormData();

    form.append("lid", d);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/cpleaddetails.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").html(data);
            if(!$("#sidecard").hasClass("open")){
                $("#sidecard").addClass("open");
            }
            try {
                $("[name=leadupdate]").find("option[value='" + $("[name=leadupdate]").attr("data-selected") + "']").attr("selected", true);
                $("[name=leadupdate]").find("option[value='" + $("[name=leadupdate]").attr("data-selected") + "']")[0].selected = true;
                var lbls = $("[name=labelupdate]").attr("data-selected");
                lbls = lbls.split(',');
                $(lbls).each(function () {
                    if (this != "") {
                        $("[name=labelupdate]").find("option[value='" + this + "']").attr("selected", true);
                        $("[name=labelupdate]").find("option[value='" + this + "']")[0].selected = true;
                    }
                })
            }
            catch (e) { }
            var showjunk = 0;
            $(".calllogcard").each(function(){
                var cs = $(this).find("[name=hfcallstatus]").val();
                if(cs == "Disconnected"){
                    showjunk = showjunk + 1;
                }
                else{
                    return false;
                }
            })
            if(showjunk > 4){
                $("#btnjunk").removeClass("d-none");
            }
            else{
                $("#btnjunk").addClass("d-none");
            }
            $(".select2").select2();
            // var l = JSON.parse(labellist);
            // var tags = new Tagify($(".labels")[0], {
            //     whitelist: [l],
            //     dropdown: {
            //         classname: "color-blue",
            //         enabled: 0,              // show the dropdown immediately on focus
            //         maxItems: 5,
            //         position: "text",         // place the dropdown near the typed text
            //         closeOnSelect: false,          // keep the dropdown open after selecting a suggestion
            //         highlightFirst: true
            //     }
            // });
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip({ html: true });
            }, 500);
            initLoader(false);
        }
    });
}




function getQuoteList() {
    initLoader(true);
    var form = new FormData();

    form.append("lid", $("[name=detailid]").val());
    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/quote/detaillist.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").append(data);
            $(".btn-showquote").html("Hide Quotations").addClass("btn-danger");
            initLoader(false);
        }
    });
}


function markread(id) {
    var form = new FormData();
    form.append("mode", "markread");
    form.append("lid", id);

    $.ajax({
        method: "POST",
        url: baseurl + "actions/reminder.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            // if(data == "marked"){
            //     alert("successfull");
            // }

        }
    });
}



function CurrFormat(x) {
    x = x.toString();
    var afterPoint = '';
    if (x.indexOf('.') > 0)
        afterPoint = x.substring(x.indexOf('.'), x.length);
    x = Math.floor(x);
    x = x.toString();
    var lastThree = x.substring(x.length - 3);
    var otherNumbers = x.substring(0, x.length - 3);
    if (otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    return res;
}


function PrintElem(elem) {
    var mywindow = window.open('', 'PRINT');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(elem.innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}


function checkNotify() {
    $.ajax({
        method: "GET",
        url: baseurl + "actions/reminder.php?mode=checknotifications",
        dataType: "json",
        contentType: "application/json",
        success: function (data) {
            if (data > 0) {
                $(".notifications .notify-here > i").addClass("d-none");
                $(".notifications .notify-here > img").removeClass("d-none");
                $(".notifications .notify-here > span").html(data);
            }
        }
    });
}


function checklivereminderontime() {
    $.ajax({
        method: "GET",
        url: baseurl + "actions/reminder.php?mode=checklivereminders",
        dataType: "json",
        contentType: "application/json",
        success: function (data) {
            if(data.length > 0){
                for(var i = 0; i < data.length; i++){
                    //toastr.info("<div class='text-white d-grid' onclick='openreminder("+data[i].Ld_Id+","+data[i].Rm_Id+")'><b>" + data[i].Ld_Name + "</b><span class='fs-sm text-white'>" + data[i].Rm_Remark + "</span></div>", '<small class="text-white"><b>Reminder!</b></small>',{timeOut: 0,extendedTimeOut: 0});
                }
            }
            
            //toastr.info("<div class='text-black d-grid'><b>" + data.Ld_Name + "</b><span class='fs-sm'>" + data.Rm_Remark + "</span></div>", '<small class="text-black-50"><b>Reminder!</b></small>');

        }
    });
}


function getNotifications(dt = "") {
    var url = "layouts/notifications.php";
    if(dt != ""){
        url = "layouts/notifications.php?date="+dt;
        $(".notifications .dropdown-menu.dropdown-menu-end").addClass("show").attr("data-bs-popper","static");
    }
    $.ajax({
        method: "GET",
        url: baseurl + url,
        success: function (data) {
            $(".notifications ul").html(data);
        }
    });
}


function initLoader(s) {
    if (s == true) {
        $("#loader").addClass("show");
    }
    else {
        $("#loader").removeClass("show");
    }
}

function initSearchLoader(s) {
    if (s == true) {
        $("[name=globalsearch]").closest("div").find(".fa-spinner").attr("style", "visibility: show;");
    }
    else {
        $("[name=globalsearch]").closest("div").find(".fa-spinner").attr("style", "visibility: hidden;");
    }
}

function claimLead(lid) {
    initLoader(true);
    var form = new FormData();
    form.append("mode", "claimlead");
    form.append("lid", lid);

    $.ajax({
        method: "POST",
        url: baseurl + "actions/lead.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == "true") {
                alert("Lead Claimed Successfully");
            }
            else {
                alert("Something Went Wrong");
            }
            initLoader("false");
            getLeadDetails($("[name=detailid]").val());
        }
    });
}

function getProjectDetails(d) {
    initLoader(true);
    var form = new FormData();
    form.append("lid", d);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/project/details.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").append(data);
            $(".btn-projectdetail").html("Close Details").addClass("btn-danger").removeClass("btn-info");
            initLoader(false);
        }
    });
}


function getCallLogs() {
    // initLoader(true);
    var form = new FormData();

    form.append("sdate", $("[name=todaydate]").val());
    form.append("edate", $("[name=todaydate]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dashboard/calllogs.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $("#todaycalls").html(data);
            // initLoader(false);
        }
    });
}



function getReminderForm() {
    initLoader(true);
    var form = new FormData();

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/reminder/form.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").append(data);
            $(".btn-reminder").html("Close Reminder").addClass("btn-danger").removeClass("btn-secondary");
            validateReminder()
            initLoader(false);
        }
    });
}



function getCallForm() {
    initLoader(true);
    var form = new FormData();
    form.append("lid", $("[name=detailid]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/call/form.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $(".sidecard-container").append(data);
            $(".btn-calllog").html("Close Call Log").addClass("btn-danger").removeClass("btn-primary");
            $(".leadstatusblk [name=leadstatus]").find("option[value='" + $("[name=hfleadstatus]").val() + "']").attr("selected", true);
            $(".leadstatusblk [name=leadstatus]").val($("[name=hfleadstatus]").val());
            $(".leadstatusblk [name=leadstatus]").find("option[value='" + $("[name=hfleadstatus]").val() + "']")[0].selected = true;
            validateCall();
            initLoader(false);

            
            // document.getElementsByName('reminderdate').value = now.toISOString().replace(/\.\d\d\dZ/, "");
        }
    });
}


function getLastConnectedDate(){
    var dt = "";
    $(".calllogcard").each(function(){
        dt = $(this).find("p.lstatus > small")[0].innerText;
        dt = dt.replace(/\n/g, '');
        if(dt != ""){
            return false;
        }
    })
    
    if(dt != ""){
        setTimeout(function () {
            var last = new Date(dt);
            var now = new Date(Date.now());
            console.log(last);
            if(last < now){
            }
            else{
                last.setMinutes(last.getMinutes() - last.getTimezoneOffset());
                console.log(last.toISOString().replace(/\.\d\d\dZ/, ""));
                $("[name=reminderdate]").val(last.toISOString().replace(/\.\d\d\dZ/, ""));
            }
            
        }, 500)
    }
}


function insertCallLog() {
    initLoader(true);
    var form = new FormData($('form#calllogform')[0]);
    form.append("ldid", $("[name=detailid]").val());
    form.append("mode", "insert");
    // form.append("callstatus",$("[name=callstatus]").val());
    // form.append("callbackdate",$("[name=callbackdate]").val());
    // form.append("leadstatus",$("[name=leadstatus]").val());
    // form.append("callremark",$("[name=callremark]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "actions/calllog.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.split('/')[0] == "insert") {
                alert("successfull");
                $("#reload").click();
                $(".btn-calllog").click();
                getLeadDetails($("[name=detailid]").val());
            }
            location.reload();
        }
    });
}


function validateCall() {
    var form = $('form#calllogform');
    var error = $('.form-control', form);

    $.validator.addMethod(
        "regex",
        function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "This is invalid"
    );

    $.validator.addMethod("notEqualTo", function (value, element, param) {
        return this.optional(element) || value != $(param).val();
    }, "This has to be different...");

    jQuery.validator.addMethod("notEqualstatic", function (value, element, param) {
        return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

    $.validator.addMethod("EmailAddress", function (value) {
        return /^$|(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/.test(value)


    }, "This is invalid");


    var $validator = $('form#calllogform').validate({
        //doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        //errorElement: 'span', //default input error message container
        //errorClass: 'error-block1', // default input error message class
        //focusInvalid: false, // do not focus the last invalid input
        rules: {

            callstatus: {
                required: true,
            },
            reminderdate: {
                required: function () {
                    if ($("[name=callstatus]").val() == "2" || ($("[name=leadstatus]").val() == "2" || $("[name=leadstatus]").val() == "4")) {
                        return true;
                    }
                },
                remote: {
                    depends: function () {
                        if ($("[name=callstatus]").val() == "1" && ($("[name=leadstatus]").val() == "4")) {
                            return false;
                        }
                        else {
                            return true;
                        }
                    },
                    param: {
                        url: baseurl + "actions/exist.php",
                        type: "post",
                        cache: false,
                        data: {
                            mode: "checkleave",
                            value: function () {
                                return $("[name=reminderdate]").val();
                            }
                        },
                        complete: function (d) {
                            // if(d.responseJSON == true){
                            //     return true;
                            // }
                            // else{
                            //     return d;
                            // }
                            if ($("[name=callstatus]").val() == "1" && ($("[name=leadstatus]").val() == "4")) {
                                return true;
                            }
                            else {
                                return d.responseJSON;
                            }


                        }
                    }

                },
            },
            leadstatus: {
                required: function () {
                    if ($("[name=callstatus]").val() == "1") {
                        return true;
                    }
                },
            }
        },

        messages: {


            callstatus: {
                required: "This is required",
            },
            callbackdate: {
                required: "This is required",
            },
            reminderdate: {
                required: "This is required",
                remote: "Weekoff / Leave"
            },
            leadstatus: {
                required: "This is required",
            }

        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#calllogform').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            else {
                insertCallLog();
            }
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }
    });
}



function insertReminder() {
    initLoader(true);
    var form = new FormData($('form#reminderform')[0]);
    form.append("ldid", $("[name=detailid]").val());
    form.append("mode", "insert");
    // form.append("callstatus",$("[name=callstatus]").val());
    // form.append("callbackdate",$("[name=callbackdate]").val());
    // form.append("leadstatus",$("[name=leadstatus]").val());
    // form.append("callremark",$("[name=callremark]").val());

    $.ajax({
        method: "POST",
        url: baseurl + "actions/reminder.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.split('/')[0] == "insert") {
                alert("successfull");
                $("#reload").click();
                $(".btn-reminder").click();
                getLeadDetails($("[name=detailid]").val());
            }
        }
    });
}


function validateReminder() {
    var form = $('form#reminderform');
    var error = $('.form-control', form);

    $.validator.addMethod(
        "regex",
        function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "This is invalid"
    );

    $.validator.addMethod("notEqualTo", function (value, element, param) {
        return this.optional(element) || value != $(param).val();
    }, "This has to be different...");

    jQuery.validator.addMethod("notEqualstatic", function (value, element, param) {
        return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

    $.validator.addMethod("EmailAddress", function (value) {
        return /^$|(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/.test(value)


    }, "This is invalid");


    var $validator = $('form#reminderform').validate({
        //doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        //errorElement: 'span', //default input error message container
        //errorClass: 'error-block1', // default input error message class
        //focusInvalid: false, // do not focus the last invalid input
        rules: {

            reminderdate: {
                required: true,
            }
        },

        messages: {


            reminderdate: {
                required: "This is required",
            }

        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#reminderform').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            else {
                insertReminder();
            }
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }
    });
}


function initDatePicker(el = ".daterange", sub = 90) {
    var start, end;
    el = (el == 0 ? ".daterange" : el);

    if ($(el).find("[name=startdate]").val() != "" || $(el).find("[name=enddate]").val() != "") {

        start = moment($(el).find("[name=startdate]").val());
        end = moment($(el).find("[name=enddate]").val());
    }
    else {
        start = moment().subtract(sub, 'days');
        if (sub == 0) {
            end = moment().add(1, 'days');
        }
        else {
            end = moment();
        }

    }



    function cb(start, end) {
        if (start.format('DD MMM YYYY') == moment().format('DD MMM YYYY') && end.format('DD MMM YYYY') == moment().add(1, 'days').format('DD MMM YYYY')) {
            $(el).find('span').html("Today: " + start.format('DD MMM YYYY'));
        }
        else if (start.format('DD MMM YYYY') == moment().subtract(1, 'days').format('DD MMM YYYY')) {
            $(el).find('span').html("Yesterday: " + start.format('DD MMM YYYY'));
        }
        else {
            $(el).find('span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        }
        $(el).find("[name=startdate]").val(start.format('YYYY-MM-DD')).change();
        $(el).find("[name=enddate]").val(end.format('YYYY-MM-DD')).change();

    }

    $(el).daterangepicker({
        startDate: start,
        endDate: end,
        showDropdowns:true,
        ranges: {
            'Today': [moment(), moment().add(1, 'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    
}