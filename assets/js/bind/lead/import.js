$(document).ready(function(){
    validateLead();


    $("select").each(function(){
        var v = $(this).attr("data-selected");
        var option = $(this).find("option[value='" + v + "']")[0];

        if (option) {
            $(option).attr("selected", true);
            option.selected = true;
        }
        // var v = $(this).attr("data-selected");
        // $(this).find("option[value='" + v + "']").attr("selected", true);    
        // $(this).find("option[value='" + v + "']")[0].selected = true;    
    })
})


function SubmitLead() {
    initLoader(true);
    $("[name=next]").attr("disabled", true);
    var id = "";
    var form = new FormData($("#importform")[0]);
    if($("[name=type]:checked").val() == "touser"){
        //form.append("typeid",$("[name=users]").val());
        id = $("[name=users]").val();
    }
    else if($("[name=type]:checked").val() == "toteam"){
        //form.append("typeid",$("[name=teams]").val());
        id = $("[name=teams]").val();
    }
    else if($("[name=type]:checked").val() == "byproject"){
        //form.append("typeid",$("[name=projects]").val());
        id = $("[name=projects]").val()
    }
    else{
        //form.append("typeid","");
        id = "0";
    }

    if(id != ""){
        form.append("typeid",id);        
    }
    else{
        alert("Please select an option properly");
        initLoader(false);
        return;
    }



    if ($("[name=mode]").val() != "") {
        $.ajax({
            method: "POST",
            url: baseurl + "actions/lead.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data == "nousers"){
                    alert("No Users Active");
                    initLoader(false);
                }
                else{
                    $(".result").html("Uploaded Successfully.")
                    $(".leadlist").html("No of records inserted:"+data.split('#')[0]+"<br/><br/> Duplicate Records: <br/>"+data.split('#')[1]);
                    initLoader(false);
                    alert("Leads imported Successfully");
                }
                
            }
        })
    }
}


function validateLead() {
    var form = $('form#importform');
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


    var $validator = $('form#importform').validate({
        //doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        //errorElement: 'span', //default input error message container
        //errorClass: 'error-block1', // default input error message class
        //focusInvalid: false, // do not focus the last invalid input
        rules: {

            file: {
                required: true
            }
        },

        messages: {
            file: {
                required: "This is required"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#importform').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            else {
                SubmitLead();
            }
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }
    });
}