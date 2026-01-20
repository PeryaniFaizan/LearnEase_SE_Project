
function checkAdminLogin(){
    // console.log("sds")
    let adminLogEmail=$("#adminemail").val();
    let adminLogPass=$("#adminpassword").val();

    $.ajax({
        url: 'Admin/admin.php',
        method: "POST",
        data:{
            checkLogemail:"checklogmail",
            adminLogEmail:adminLogEmail,
            adminLogPass:adminLogPass,
        },
        success:function(data){
            // console.log(data);
             data = $.trim(data);  // important

            if (data == "1") {
                $("#statusAdminLogMsg").html('<small style="color:green;">Logging in...</small>');
                window.location.href = "instructor-dashboard.php";
            } else {
                $("#statusAdminLogMsg").html('<small style="color:red;">Invalid Email or Password!</small>');
            }
        },
    });
}