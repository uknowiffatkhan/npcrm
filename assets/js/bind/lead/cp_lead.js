$(document).ready(function(){

    validateLead();



    $("select").each(function(){
        try{
            var v = $(this).attr("data-selected");
            $(this).find("option[value='" + v + "']").attr("selected", true);    
            $(this).find("option[value='" + v + "']")[0].selected = true;   
        }
        catch(e){}
        
    })

    if($("[name=openlead]").val() != ""){
        $("#sidecard").addClass("open");
        getLeadDetails($("[name=openlead]").val());
    }


    

})

function SubmitLead() {
    $("[name=submit]").attr("disabled", true);
    var form = new FormData($("#customerform")[0]);
    if ($("[name=mode]").val() != "") {
       
        $.ajax({
           
            method: "POST",
            url: baseurl + "actions/lead.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (data) {
                alert("Received data: " + data);
                var d = data.split('/');
                if (d[0] == "insertcplead" || d[0] == "updatecplead") {
                    alert("Booking Details " + d[0] + "ed Successfully.");
                }
                else if (d[0] == "paymentinsert" || d[0] == "paymentupdate") {
                    alert("Payment Plan Inserted Successfully.");
                }

                location.reload();
            }
        })
    }
    else {
        var step = $("[name=step]").val();
        location.href = "booking.php?bid=1&step=" + (parseInt(step) + 1);
    }
}


function validateLead() {
    var form = $('form#customerform');
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


    var $validator = $('form#customerform').validate({
        //doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        //errorElement: 'span', //default input error message container
        //errorClass: 'error-block1', // default input error message class
        //focusInvalid: false, // do not focus the last invalid input
        rules: {

            fullname: {
                required: true,
                minlength: 2,
                regex: "^[a-zA-Z'.\\s]{1,40}$"
            },
            mobno: {
                required: true,
                minlength: 10,
                maxlength: 10,
                remote: {
                    url: baseurl + "actions/cpexist.php",
                    type: "post",
                    cache:false,
                    data: {
                        mode:"leadmob",
                        id:function() {
                            return $("[name=lid]").val();
                          },
                        type:function() {
                            return $("[name=mode]").val();
                          },
                        value: function() {
                            return $( "[name=mobno]" ).val();
                        }
                    },
                    complete: function(d) {
                        // if(d.responseJSON == true){
                        //     return true;
                        // }
                        // else{
                        //     return d;
                        // }
                        return d.responseJSON;
                        
                    }
                },
                regex: "^[+]{0,1}[1-9]{1}[0-9]{9,20}$"
            },
            altmobno: {
                regex: "^[+]{0,1}[1-9]{1}[0-9]{9,20}$",
                minlength: 10,
                maxlength: 10,
              	remote: {
                    url: baseurl + "actions/cpexist.php",
                    type: "post",
                    cache:false,
                    data: {
                        mode:"leadmob",
                        id:function() {
                            return $("[name=lid]").val();
                          },
                        type:function() {
                            return $("[name=mode]").val();
                          },
                        value: function() {
                            return $( "[name=altmobno]" ).val();
                        }
                    },
                    complete: function(d) {
                        // if(d.responseJSON == true){
                        //     return true;
                        // }
                        // else{
                        //     return d;
                        // }
                        return d.responseJSON;
                    }
                },
            },
            email: {
                required: false,
                minlength: 2,
                EmailAddress: true
            },
            ref: {
                required: false,
                
            },
            location:{
                required: false,
            },
            address: {
                required: false,
                minlength: 10,
                //regex: "^[+]{1}[0-9]{20}$"
            },
            city: {
                required: false,
            },
            pin: {
                required: false
            },
            source: {
                required: true,
            },
            leadstatus: {
                required: true,
            },
            interestedfor: {
                required: false,
            },
            leaddate: {
                required: true,
            }
            


        },

        messages: {


            fullname: {
                required: "This is required",
                minlength: "Minimum 2 characters"
            },
            mobno: {
                required: "This is required",
                minlength: "Please enter a 10-digit phone number",
                maxlength: "Please enter a 10-digit phone number",
                remote:"Already exist"
            },
          	altmobno: {
                regex: "This is required",
                minlength: "Please enter a 10-digit phone number",
                maxlength: "Please enter a 10-digit phone number",
                remote:"Already exist"
            },
            email: {
                minlength: "Minimum 2 characters",
            },
            ref: {
                required: "This is required",
                
            },
            location:{
                required: "This is required",
            },
            address: {
                required: "This is required",
                minlength: "Minimum 10 characters",
                //regex: "^[+]{1}[0-9]{20}$"
            },
            city: {
                required: "This is required",
            },
            pin: {
                required: "This is required"
            },
            source: {
                required: "This is required",
            },
            leadstatus: {
                required: "This is required",
            },
            interestedfor: {
                required: "This is required",
            },
            leaddate: {
                required: "This is required",
            }


        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#customerform').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            else {
              	initLoader(true);
                SubmitLead();
            }
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }
    });
}