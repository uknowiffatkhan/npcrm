$(document).ready(function(){
    $(document).on("change",".switch-input",function(){
        var st = (this.checked == true ? "Active" : "Inactive");
        var i = $(this).attr("data-val");
        changeStatus(i,st);
    })
    UserSearch('', '', '', currentPage, true);
   
})
var lastScrollTop = 0;
var isLoading = false;
var currentPage = 1;


$(window).scroll(function() {
    var st = $(this).scrollTop();
    if (st > lastScrollTop){  // check if scrolling down
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            if (!isLoading) {
                UserSearch('', '', '', currentPage, true);
            }
        }
    }
    lastScrollTop = st;
});

function UserSearch(s = "", t = "", r = "", page, append = false) {
    if (isLoading) return;
    isLoading = true;
    initLoader(true);

    var form = new FormData();
    form.append("search", s);
    form.append("type", t);
    form.append("role", r);
    form.append("page", page);

    $.ajax({
        method: "POST",
        url: baseurl + "layouts/partials/lead/user.php",
        data: form,
        processData: false,
        contentType: false,
        success: function(data) {
            if (append) {
                $("#userdetail").append(data);
                
            } else {
                $("#userdetail").html(data);
            }
            isLoading = false;
            initLoader(false);
            currentPage++;
        },
        
    });
}

$(document).on("change", "#userType", function () {
    applyFilters();
});

$(document).on("change", "#userRole", function () {
    applyFilters();
});

$(document).on("keyup", "[name=userSearch]", function () {
    applyFilters();
});


$(document).on("click", ".userlogin", function() {
    var id = $("input[name='uid']").val();
    var form = new FormData();
    form.append("id",id);

    $.ajax({
        method: "POST",
        url: baseurl + "/login.php",
        data: form,
        processData: false,
        contentType: false,
        success: function(data) {
            // $("#userdetail").html(data);
            console.log(data);
            // initSearchLoader(false);
        }
    });
});

function applyFilters() {
    var searchval = $("[name=userSearch]").val();
    var type = $("#userType").val();
    var role = $("#userRole").val();  
    var page =   $("input[name='page']").val();
    UserSearch(searchval, type, role,page);
}

function changeStatus(id,status){

    var form = new FormData();
    form.append("mode","changestatus");
    form.append("uid",id);
    form.append("status",status);

    $.ajax({
        method: "POST",
        url: baseurl + "actions/users.php",
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
            alert("Status changed Successfully");
            // var d = data.split('/');
            location.reload();
        }
    })
}