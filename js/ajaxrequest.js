$(document).ready(function(){
    // Clear validation messages when user edits inputs
    $("#fullname").on("input", function(){ $("#statusMsg1").html(""); $("#successMsg").html(""); });
    $("#email").on("input", function(){ $("#statusMsg2").html(""); $("#successMsg").html(""); });
    $("#password").on("input", function(){ $("#successMsg").html(""); var pwd = $(this).val();}) // Live feedback for short passwords if (pwd.length > 0 && pwd.length < 8) { $("#statusMsg3").html('<small style="color:red;">Password must be at least 8 characters.</small>'); } else { $("#statusMsg3").html(''); } });
    $("#confirmpassword").on("input", function(){ $("#statusMsg4").html(""); $("#successMsg").html(""); });

    // Ajax call to check if email already exists
    $("#email").on("keyup blur", function(){
        let emailPattern = /^[a-zA-Z0-9._%+-]+@maju\.edu\.pk$/;
        var email = $("#email").val();
        $.ajax({
            url: 'Student/addstudent.php',
            method: 'POST',
            data: {
                checkemail: "checkmail",
                email: email,
            },
            success: function(data){
                let count = parseInt(data);

                if (email.trim() === "") {
                    $("#statusMsg2").html('<small style="color:red;">Enter email!</small>');
                    $("#signup").attr("disabled", true);
                    return;
                }

                if (!emailPattern.test(email)) {
                    $("#statusMsg2").html('<small style="color:red;">Use MAJU email only</small>');
                    $("#signup").attr("disabled", true);
                    return;
                }

                if (count !== 0) {
                    $("#statusMsg2").html('<small style="color:red;">Email already in use!</small>');
                    $("#signup").attr("disabled", true);
                } else {
                    $("#statusMsg2").html('<small style="color:green;">Email is valid!</small>');
                    $("#signup").attr("disabled", false);
                }
            },
        });
    });
});

// Function to add a new student
function addStu(){    let emailPattern = /^[a-zA-Z0-9._%+-]+@maju\.edu\.pk$/;
    // clear previous validation and success messages
    $("#statusMsg1, #statusMsg2, #statusMsg3, #statusMsg4, #statusMsg5, #statusMsg6, #statusMsg7, #successMsg").html('');

    let fullname = $("#fullname").val();
    let email = $("#email").val();
    let gender = $("#std_gender").val();
    let phone = $("#std_phone").val();
    let age = $("#std_age").val();
    let password = $("#password").val();
    let confirmpassword = $("#confirmpassword").val();

    // Validations
        if(fullname.trim()==""){
        $("#statusMsg1").html('<small style="color:red;">Please Enter Name !</small>');
        $("#fullname").focus();
        return false;    
    } 
    else if(email.trim()==""){
        $("#statusMsg2").html('<small style="color:red;">Please Enter Email !</small>');
        $("#email").focus();
        return false;  
    } 
    else if(!emailPattern.test(email)){
        $("#statusMsg2").html('<small style="color:red;">Use MAJU email only (example: abc@maju.edu.pk)</small>');
        $("#email").focus();
        return false;
    }
    else if(password.trim()==""){
        $("#statusMsg3").html('<small style="color:red;">Please Enter Password !</small>');
        $("#password").focus();
        return false;  

    }  else if(confirmpassword.trim()==""){
        $("#statusMsg4").html('<small style="color:red;">Please Confirm Password !</small>');
        $("#confirmpassword").focus();
        return false;

    } else if(password !== confirmpassword){
        $("#statusMsg4").html('<small style="color:red;">Please Enter Correct Confirm Password !</small>');
        $("#confirmpassword").focus();
        return false; 
    
    } 
    else if(phone.trim()==""){
        $("#statusMsg5").html('<small style="color:red;"> Please Enter Phone Number </small>');
        $("#std_phone").focus();
        return false;
    }
    else if(age.trim()=="" || age>100){
        $("#statusMsg6").html('<small style="color:red;"> Please Enter valid age</small>');
        $("#std_age").focus();
        return false;
    }
    else if(gender.trim()==""){
        $("#statusMsg7").html('<small style="color:red;"> Select Gender in drop down</small>');
        $("#std_gender").focus();
        return false;
    } 
    else {
        $.ajax({
        url: 'Student/addstudent.php',
        method: 'POST',
        data: {
            fullname: fullname,
            email: email,
            std_age:age,
            std_phone:phone,
            std_gender:gender,
            password: password,
            
        },
        success: function(data){
            // Normalize response
            console.log('raw register response:', data);

            // Lenient detection: strip HTML tags and whitespace; if 'OK' appears and no 'ERROR' then treat as success
            var rawText = '';
            if (typeof data === 'string') {
                // remove any HTML tags and trim
                rawText = data.replace(/<[^>]*>/g, '').trim();
            }
            if (rawText) {
                var up = rawText.toUpperCase();
                if (up === 'OK' || (/\bOK\b/i.test(rawText) && up.indexOf('ERROR') === -1)) {
                    $("#successMsg").html("<span style='color:green;'>Registration Successful! Redirecting to login...</span>");
                    $("#registerForm")[0].reset();
                    $("#statusMsg1, #statusMsg2, #statusMsg3, #statusMsg4, #statusMsg5, #statusMsg6, #statusMsg7").html("");
                    setTimeout(function(){ window.location.href = "login.php"; }, 1500);
                    setTimeout(() => { $("#successMsg").fadeOut(); }, 2500);
                    return;
                }
            }

            // normalize response: handle JSON strings, quoted strings like "\"OK\"", and plain text
            var resp = data;
            if (typeof resp === 'string') {
                resp = resp.trim();
                // try parse JSON if it looks like JSON
                if ((resp.charAt(0) === '{') || (resp.charAt(0) === '[') || (resp.charAt(0) === '"')) {
                    try {
                        resp = JSON.parse(resp);
                    } catch (e) {
                        // if it's a quoted string like "OK", strip the quotes
                        if (resp.charAt(0) === '"' && resp.charAt(resp.length - 1) === '"') {
                            resp = resp.substring(1, resp.length - 1);
                        }
                    }
                }
            }

            // now handle normalized response
            if (resp === "OK" || (typeof resp === 'string' && resp.trim() === "OK")){
                $("#successMsg").html("<span>Registration Successful! Redirecting to login...</span>");
                $("#registerForm")[0].reset();
                $("#statusMsg1, #statusMsg2, #statusMsg3, #statusMsg4, #statusMsg5, #statusMsg6, #statusMsg7").html("");
                // Redirect to login after short delay so user sees confirmation
                setTimeout(function(){
                    window.location.href = "login.php";
                }, 1500);
                setTimeout(() => {
                    $("#successMsg").fadeOut();
                }, 2500);

            } 
            else if (resp && typeof resp === 'object' && (resp.status || resp.error)){
                // server returned structured error json
                $("#successMsg").html('<span style="color:red;">'+ (resp.error || resp.status || JSON.stringify(resp)) +'</span>');
            } else {
                // Unknown response, show it for debugging
                $("#successMsg").html('<span style="color:red;">Unable to Register. Server responded: '+ JSON.stringify(resp) +'</span>');
            }
        },
        error: function(xhr, status, err){
            console.log('Register AJAX error', status, err, xhr.responseText);
            let resp = xhr.responseText ? xhr.responseText.trim() : '';
            try {
                let parsed = JSON.parse(resp);
                if(parsed === "OK" || (typeof parsed === 'string' && parsed.trim() === "OK")){
                    $("#successMsg").html("<span>Registration Successful!</span>");
                    $("#registerForm")[0].reset();
                    $("#statusMsg1, #statusMsg2, #statusMsg3, #statusMsg4, #statusMsg5, #statusMsg6, #statusMsg7").html("");
                    setTimeout(() => { $("#successMsg").fadeOut(); }, 2500);

                    return;
                }
                if(parsed && (parsed.status || parsed.error)){
                    $("#successMsg").html('<span style="color:red;">'+ (parsed.error || parsed.status) +'</span>');
                    return;
                }
            } catch(e){
                if(resp === 'OK' || resp === '"OK"'){
                    $("#successMsg").html("<span>Registration Successful! Redirecting to login...</span>");
                    $("#registerForm")[0].reset();
                    $("#statusMsg1, #statusMsg2, #statusMsg3, #statusMsg4, #statusMsg5, #statusMsg6, #statusMsg7").html("");
                    setTimeout(function(){
                        window.location.href = "login.php";
                    }, 1500);
                    setTimeout(() => { $("#successMsg").fadeOut(); }, 2500);
                    return;
                }
            }
            $("#successMsg").html('<span style="color:red;">Unable to Register. Server error: ' + resp + '</span>');
        }
    });
    }
}

// Function to handle student login
function checkStuLogin(){
    let stuLogEmail = $("#stuLogEmail").val();
    let stuLogPass = $("#stuLogPass").val();

    if(stuLogEmail.trim() == "" || stuLogPass.trim() == ""){
        $("#statusLogMsg").html('<small style="color:red;">Please fill all fields!</small>');
        return false;
    }
   
    $.ajax({
        url: 'Student/addstudent.php',
        method: "POST",
        data:{
            checkLogemail: "checklogmail", // This triggers the login block in PHP
            stuLogEmail: stuLogEmail,
            stuLogPass: stuLogPass,
        },
        success: function(data){
            console.log('login raw response:', data);
            var resp = data;
            if (typeof resp === 'string') {
                resp = resp.trim();
                try {
                    resp = JSON.parse(resp);
                } catch(e){ /* keep as string */ }
            }

            if (resp && typeof resp === 'object' && resp.status === 'success') {
                $("#statusLogMsg").html('<small style="color:green;">Logging in...</small>');
                if (resp.role === 'student') {
                    window.location.href = "student-dashboard.php";
                } else if (resp.role === 'admin') {
                    window.location.href = "instructor-dashboard.php";
                } else {
                    window.location.href = "index.php";
                }
            } 
            else if (resp === "student") {
                $("#statusLogMsg").html('<small style="color:green;">Logging in...</small>');
                window.location.href = "student-dashboard.php";
            } 
            else if (resp === "admin") {
                $("#statusLogMsg").html('<small style="color:green;">Logging in...</small>');
                window.location.href = "instructor-dashboard.php";
            } 
            else {
                var err = (resp && resp.message) ? resp.message : 'Invalid Email or Password!';
                $("#statusLogMsg").html('<small style="color:red;">'+ err +'</small>');
            }
        },

    });
}