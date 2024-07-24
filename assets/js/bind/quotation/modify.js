$(document).ready(function () {
    $(document).on("click", "#addrow2", function () {
        clonerows();
    })


    $(document).on("change", "[name*=amount], [name*=dur]", function () {
        totalamount(this);
    })


    $(document).on("change", "[name*=type]", function () {
        var t = this.value;
        $(this).closest("tr").find(".dur").val("");
        if (t == "Once") {
            $(this).closest("tr").find(".dur").addClass("d-none");
            $(this).closest("tr").find(".nodur").removeClass("d-none");
        }
        else {
            $(this).closest("tr").find(".dur").removeClass("d-none");
            $(this).closest("tr").find(".nodur").addClass("d-none");
        }
    })


    validateQuote();

    $(document).on("click", ".clearrow", function () {
        CalcTotalAmount();
    })

    $(document).on("change","input,select",function(){
        if(parseFloat($(".totalamount").html()) == parseFloat($("[name=totalvalue]").val())){
            $("button[type=submit]").removeAttr("disabled");
        }
        else{
            $("button[type=submit]").attr("disabled",true);
        }
    })

    $(document).on("change","table#quotation input, table#quotation select",function(){
        validatePlan();
    })


    $(document).on("change",".valuesblk input:not(.ttl)",function(){
        calcProjectTotalPrice()
    })

    $("select").each(function(){
        try{
            var v = $(this).attr("data-selected");
            $(this).find("option[value='" + v + "']").attr("selected", true);    
            $(this).find("option[value='" + v + "']")[0].selected = true;    
        }
        catch(e){}
        
    })


    $("table#quotation").find("tr").each(function(){
        totalamount(this);
        if(parseFloat($(".totalamount").html()) == parseFloat($("[name=totalvalue]").val())){
            $("button[type=submit]").removeAttr("disabled");
        }
        else{
            $("button[type=submit]").attr("disabled",true);
        }
    })
    CalcTotalAmount()

})


function calcProjectTotalPrice(){
    var t = 0;
    $(".valuesblk").find("input:not(.ttl)").each(function(){
        if(this.value != ""){
            t = parseFloat(t) + parseFloat(this.value);
        }
    })


    // var a = $("[name=agreement]").val();
    // var d = $("[name=development]").val();
    // var g = $("[name=govtcharge]").val();
    // var t = $("[name=totalvalue]").val();

    // var t = parseFloat(a) + parseFloat(d) + parseFloat(g);
    $("[name=totalvalue]").removeAttr("readonly");
    $("[name=totalvalue]").val(t);
    $("[name=totalvalue]").attr("readonly",true);
}



function totalamount(el) {
    var am = $(el).closest("tr").find("[name*=amount]").val();
    var d = $(el).closest("tr").find(".dur").val();
    var t = $(el).closest("tr").find(".total");
    if (d != "") {
        $(t).html((am * d));
        $(el).closest("tr").find("[name*=totalramount]").val((am * d));
    }
    else {
        $(t).html(am);
        $(el).closest("tr").find("[name*=totalramount]").val(am);
    }

    CalcTotalAmount();
}


function CalcTotalAmount(){
    var t = 0;
    var ft = 0;
    $("#quotation tbody").find("tr").each(function(){
        t = $(this).find(".total").html();
        ft = parseFloat(ft) + parseFloat(t);
    })

    $("#quotation tfoot .totalamount").html(ft);

}


function clonerows() {
    var d = $("#clonerow > table > tbody").clone();
    d = d.html().replace(/data-/g, '');
    $("#quotation > tbody").append(d);
}




function validateQuote() {
    var form = $('form#quotationform');
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


    var $validator = $('form#quotationform').validate({
        //doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        //errorElement: 'span', //default input error message container
        //errorClass: 'error-block1', // default input error message class
        //focusInvalid: false, // do not focus the last invalid input
        rules: {

            fullname: {
                required: true,
                minlength: 2,
                regex: "^[a-zA-Z\/'.\\s]{1,40}$"
            },
            mobno: {
                required: true,
                minlength: 10,
                maxlength: 10,
                //regex: "^[+]{1}[0-9]{20}$"
            },
            project: {
                required: true,
            },
            config:{
                required: true
            },
            // phase: {
            //     required: true,
            // },
            wing: {
                required: true,
            },
            floor: {
                required: true,
            },
            roomno: {
                required: true,
            },
            saleable:{
                required: true
            },
            carpet:{
                required: true
            },
            agreement: {
                required: true,
                regex: "^[0-9]{1,12}$"
            },
            development: {
                required: true,
                regex: "^[0-9]{1,12}$"
            },
            govtcharge: {
                required: true,
                regex: "^[0-9]{1,12}$"
            },
            totalvalue: {
                required: true,
                regex: "^[0-9]{1,12}$"
            },
            estbooking: {
                required: true
            }


        },

        messages: {


            fullname: {
                required: "This is required",
                minlength: "Minimum 2 characters",
                regex: "Invalid Input"
            },
            mobno: {
                required: "This is required",
                minlength: "Please enter a 10-digit phone number",
                maxlength: "Please enter a 10-digit phone number",
                minlength: "Minimum 10 characters",
            },
            project: {
                required: "This is required",
            },
            config:{
                required: "This is required"
            },
            phase: {
                required: "This is required",
            },
            wing: {
                required: "This is required",
            },
            floor: {
                required: "This is required",
            },
            roomno: {
                required: "This is required",
            },
            saleable:{
                required: "This is required"
            },
            carpet:{
                required: "This is required"
            },
            agreement: {
                required: "This is required",
                regex: "Invalid Input"
            },
            development: {
                required: "This is required",
                regex: "Invalid Input"
            },
            govtcharge: {
                required: "This is required",
                regex: "Invalid Input"
            },
            totalvalue: {
                required: "This is required",
                regex: "Invalid Input"
            },
            estbooking: {
                required: "This is required"
            }

        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#quotationform').valid();
            
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            else {
                SubmitQuotation();
            }
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }
    });
    
}


function validatePlan(){
    
    var v = 0;

    $("[name*=part]").each(function(){
        if(this.value == ""){
            $(this).attr("style","border-color:red");
            v = v + 1;
        }
        else{
            $(this).removeAttr("style");
        }
    });

    $("[name*=amount]").each(function(){
        if(this.value == ""){
            $(this).attr("style","border-color:red");
            v = v + 1;
        }
        else{
            $(this).removeAttr("style");
        }
    });

    $("[name*=type]").each(function(){
        if(this.value != "Once"){
            if($(this).closest("tr").find("[name*=dur]").val() == ""){
                $(this).closest("tr").find("[name*=dur]").attr("style","border-color:red");
                v = v + 1;
            }
            else{
                $(this).closest("tr").find("[name*=dur]").removeAttr("style");
            }
        }
    });

    // if(v == 0){
    //     $("button[type=submit]").removeAttr("disabled");
        
    // }
    // else{
    //     $("button[type=submit]").attr("disabled",true);
    // }
}


function SubmitQuotation() {
    $("[name=next]").attr("disabled", true);
    var form = new FormData($("#quotationform")[0]);
    if ($("[name=mode]").val() != "") {
        $.ajax({
            method: "POST",
            url: baseurl + "actions/quotation.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (data) {
                var d = data.split('/');
                if (d[0] == "insert" || d[0] == "update") {
                    alert("Quotation Details " + d[0] + "ed Successfully.");
                    window.location.href = "print.php?qid="+d[1];
                }
            }
        })
    }
}