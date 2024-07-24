$(document).ready(function(){
    validateUser();
    validateTeam(); 

    $("select").each(function(){
        try{
            var v = $(this).attr("data-selected");
            $(this).find("option[value='" + v + "']").attr("selected", true);    
            $(this).find("option[value='" + v + "']")[0].selected = true;   
        }
        catch(e){}
    });

    console.log("Session Type ID:", sessionTypeId); 
    if (sessionTypeId == "1" && $("[name=openuser]").val() != "") {
        $("#sidecard").addClass("open");
        getUsers($("[name=openuser]").val());
    }

        $('#userRole').on('change', function() {
            var userRole = $('#userRole').val();           
            if (userRole == '2' || userRole == '4'  ) {
                $('#addTeamBtn').css('display', 'block'); 
            } else {
                $('#addTeamBtn').css('display', 'none'); 
            }

            dynamicTeam();
        })
    
});

function dynamicTeam(){
   
    var form = new FormData($("#createTeam")[0]);
    var role = $("[name=userRole]").val();  
    var type =  $("[name=userType]").val();  
    form.append('role',role)
    form.append('type',type)

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/dropdowns/team.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            $('#userTeam').append(data);

        }
    });    
}
function validateUser() {
    var form = $('form#adduser');
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
        return /^$|(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/.test(value);
    }, "This is invalid");

    var $validator = $('form#adduser').validate({
        rules: {
            fullname: {
                required: true,
                minlength: 2,
                regex: "^[a-zA-Z'.\\s]{1,40}$"
            },
            username: {
                required: true,
                minlength: 2,
                remote: {
                    url: baseurl + "actions/userexist.php",
                    type: "post",
                    cache: false,
                    data: {
                        mode: "username",
                        id: function() {
                            return $("[name=uid]").val();
                        },
                        type: function() {
                            return $("[name=mode]").val();
                        },
                        value: function() {
                            return $("[name=username]").val();
                        }
                    },
                    complete: function(d) {
                        return d.responseJSON;
                    }
                },
                regex: "^[a-zA-Z'.\\s]{1,40}$"
            },
            dname: {
                required: true,
                minlength: 2,
                regex: "^[a-zA-Z'.\\s]{1,40}$"
            },
            mobno: {
                required: true,
                minlength: 10,
                maxlength: 10,
                remote: {
                    url: baseurl + "actions/userexist.php",
                    type: "post",
                    cache: false,
                    data: {
                        mode: "usermob",
                        id: function() {
                            return $("[name=uid]").val();
                        },
                        type: function() {
                            return $("[name=mode]").val();
                        },
                        value: function() {
                            return $("[name=mobno]").val();
                        }
                    },
                    complete: function(d) {
                        return d.responseJSON;
                    }
                },
                regex: "^[+]{0,1}[1-9]{1}[0-9]{9,20}$"
            },
            email: {
                required: false,
                minlength: 2,
                remote: {
                    url: baseurl + "actions/userexist.php",
                    type: "post",
                    cache: false,
                    data: {
                        mode: "useremail",
                        id: function() {
                            return $("[name=uid]").val();
                        },
                        type: function() {
                            return $("[name=mode]").val();
                        },
                        value: function() {
                            return $("[name=email]").val();
                        }
                    },
                    complete: function(d) {
                        return d.responseJSON;
                    }
                },
            },
            userType: {
                required: true,
            },
            userRole: {
                required: true,
            }, 
            userTeam: {
                required: true,
            },
            location: {
                required: false,
            },
            add: {
                required: false,
                minlength: 10,
            },
            adharno: {
                required: false,
                regex: "^[+]{0,1}[1-9]{1}[0-9]{9,20}$"
            },
            panno: {
                required: false
            },
        },
        messages: {
            fullname: {
                required: "This is required",
                minlength: "Minimum 2 characters"
            },
            username: {
                required: "This is required",
                minlength: "Minimum 2 characters",
                remote: "Username already exists"
            },
            dname: {
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
                regex: "This is required",
                minlength: "Please enter a 10-digit phone number",
                maxlength: "Please enter a 10-digit phone number",
                remote: "Already exist"
            },
            email: {
                required: "This is required",
                minlength: "Minimum 2 characters",
                remote: "Email already exists"
            },
            userType: {
                required: "This is required",
            },
            userRole: {
                required: "This is required",
            }, 
            userTeam: {
                required: "This is required",
            },
            location: {
                required: "This is required",
            },
            add: {
                required: "This is required",
                minlength: "Minimum 10 characters",
            },
            adharno: {
                required: "This is required",
            },
            panno: {
                required: "This is required"
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#adduser').valid();
            if (!$valid) {
                $validator.focusInvalid();
                return false;
            } else {
                initLoader(true);
                SubmitUser();
            }
        }
    });
}

function validateTeam() {
    var form = $('form#createTeam');
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
        return /^$|(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/.test(value);
    }, "This is invalid");

    var $teamvalidator = $('form#createTeam').validate({
        rules: {
            tname: {
                required: true,
                minlength: 2,
                regex: "^[a-zA-Z'.\\s]{1,40}$"
            },
            teamParent: {
                required: false,
            },
        },
        messages: {
            tname: {
                required: "This is required",
                minlength: "Minimum 2 characters"
            },
            teamParent: {
                required: "This is required",
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var $valid = $('form#createTeam').valid();
            if (!$valid) {
                $teamvalidator.focusInvalid();
                return false;
            } else {
                initLoader(true);
                CreateTeam();
            }
        }
    });
}

function CreateTeam() {
    console.log("CreateTeam function called");
    $("[name=teamSubmit]").attr("disabled", true);
    var form = new FormData($("#createTeam")[0]);
    $.ajax({
        method: "POST",
        url: baseurl + "actions/team.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            alert("Received data: " + data);
            var d = data.split('/');
            console.log("Split data:", d);
            if (d[0] == "insertteam" || d[0] == "updateteam") {
                alert("Team  " + d[0] + "ed Successfully.");
            }
            location.reload();
        }
    });
}

function SubmitUser() {
    $("[name=submit]").attr("disabled", true);
    var form = new FormData($("#adduser")[0]);

    if ($("[name=mode]").val() != "") {
        $.ajax({
            method: "POST",
            url: baseurl + "actions/users.php",
            data: form,
            processData: false,
            contentType: false,
            success: function (data) {
                alert("Received data: " + data);
                var d = data.split('/');
                console.log("Split data:", d);
                if (d[0] == "insertuser" || d[0] == "updateuser") {
                    alert("User Details " + d[0] + "ed Successfully.");
                }
                location.reload();
            }
        });
    }
}
