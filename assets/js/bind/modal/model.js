

$(document).ready(function () {
    validateLead(); 
   
});

    // Event handler for the submit button
    $("#submitFormBtn").off("click").on("click", function () {
        console.log("Submit button clicked");
        var $valid = $('form#lead_form').valid();
        if ($valid) {
            submitFormData(); // Submit form via AJAX if valid
        }
    });
 
    function submitFormData() {
        // If validation is successful, submit the form using AJAX
        $.ajax({
            type: "POST",
            url:  baseurl+"register_cp.php",
            data: {
                id: $("#ld_id").val(),
                uid:$("#uid").val(),
                team_id:$("#team_id").val(),
                name: $("#name").val(),
                email: $("#email").val(),
                mobile: $("#mobno").val(),
                altMobile: $("#altmobno").val(),
                Rerano: $("#rerano").val(),
                username: $("#username").val(),
                roleId: $("#roleid").val(),
                typeId: $("#typeid").val(),
                createdId: $("#createdId").val(),
                modifyId: $("#modifyId").val(),
                status: $("#status").val(),
                del: $("#del").val(),
               
                // Add more fields as needed...
            },
            success: function (response) {
                alert(response);
                $("#registrationModal").modal("hide");
                location.reload();
            
            },
            error: function (error) {
                console.error("Error:", error);
            }
        });
    }




function validateLead() {
    // alert("here dialod cp");
 
    var form = $('form#lead_form');
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


    var $validator = $('form#lead_form').validate({
        //doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
        //errorElement: 'span', //default input error message container
        //errorClass: 'error-block1', // default input error message class
        //focusInvalid: false, // do not focus the last invalid input
        rules: {
            name: {
                required: true,
                minlength: 2,
                regex: "^[a-zA-Z'.\\s]{1,40}$"
            },
            mobno: {
                required: true,
                minlength: 10,
                maxlength: 10,
                regex: "^[+]{0,1}[1-9]{1}[0-9]{9,20}$",
                 remote: {
                    url: baseurl+"api/mobile.php", // Replace with the actual server-side script to check username availability
                    type: "post",
                    data: {
                        cid: function () {
                            return $("[name=mobno]").val();
                        },
                        mobno: function () {
                            return $("[name=mobno]").val();
                        }
                    },complete: function(d) {

                        // if(d.responseJSON == true){
                        //     return true;
                        // }
                        // else{
                        //     return d;
                        // }
                        return d.responseJSON;
                        
                    }
                }
            },
            altmobno: {
                required: true,
                minlength:10,
                maxlength: 10,
                regex: "^[+]{0,1}[1-9]{1}[0-9]{9,20}$",
                 remote: {
                    url: baseurl+"api/altmobno.php", // Replace with the actual server-side script to check username availability
                    type: "post",
                    data: {
                        altmobno: function () {
                            return $("[name=altmobno]").val();
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

                }
            },
            email: {
                required: true,
                minlength: 2,
                EmailAddress: true,
                remote: {
                    url: baseurl + "api/email.php",
                    type: "post",
                    cache:false,
                    data: {
                        mode:"leademail",
                        id:function() {
                            return $("[name=lid]").val();
                          },
                        type:function() {
                            return $("[name=mode]").val();
                          },
                        value: function() {
                            return $( "[name=email]" ).val();
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
            rerano: {
                required: true,
                // add your regex pattern here if needed
                remote: {
                    url: baseurl+"api/rerano.php", // Replace with the actual server-side script to check rerano availability
                    type: "post",
                    data: {
                        rerano: function () {
                            return $("[name=rerano]").val();
                        }
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
            username: {
                required: true,
                // add your regex pattern here if needed
                remote: {
                    url: baseurl+"api/username.php", // Replace with the actual server-side script to check rerano availability
                    type: "post",
                    data: {
                        rerano: function () {
                            return $("[name=rerano]").val();
                        }
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
            }
        },

        messages: {

            name: {
                required: "This is required",
                minlength: "Minimum 2 characters"
            },
            mobno: {
                required: "This is required",
                minlength: "Please enter a 10-digit phone number",
                maxlength: "Please enter a 10-digit phone number",
                remote: "Already exist"
            },
            altmobno: {
                required: "This is required",
                minlength: "Please enter a 10-digit phone number",
                maxlength: "Please enter a 10-digit phone number",
                remote: "Already exist"
            },
            email: {
                minlength: "Minimum 2 characters",
                remote: "Already exist"

            },
            rerano:{
                required:"This is required",
                remote:"Already Exist"
            }
        },

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#lead_form').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            }
            else {
                submitFormData();
            }
            //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
        }
    });
}