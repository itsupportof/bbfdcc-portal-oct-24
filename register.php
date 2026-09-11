<?php
session_start();
if(isset($_SESSION['currentSession'])){
    header("Location: /");
}
require 'lib.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bright Beginnings Family Day Care Centre</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script type="text/javascript">
        // ---- Password policy (keep in sync with validatePassword() in lib.php) ----
        function passwordRules(pw){
            return {
                len: pw.length >= 8 && pw.length <= 72,
                upper: /[A-Z]/.test(pw),
                lower: /[a-z]/.test(pw),
                num: /[0-9]/.test(pw),
                special: /[^A-Za-z0-9]/.test(pw)
            };
        }
        function passwordPolicyError(pw){
            var r = passwordRules(pw);
            if (pw.length < 8)  return "Password must be at least 8 characters long.";
            if (pw.length > 72) return "Password must be at most 72 characters long.";
            if (!r.upper)   return "Password must include at least one uppercase letter (A-Z).";
            if (!r.lower)   return "Password must include at least one lowercase letter (a-z).";
            if (!r.num)     return "Password must include at least one number (0-9).";
            if (!r.special) return "Password must include at least one special character (e.g. ! @ # $ %).";
            return "";
        }
        function updatePwChecklist(pw){
            var r = passwordRules(pw);
            Object.keys(r).forEach(function(k){
                var el = document.querySelector('#pwreq li[data-rule="'+k+'"]');
                if(!el) return;
                el.style.color = r[k] ? '#1cc88a' : '#888';
                el.querySelector('.mark').textContent = r[k] ? '✓' : '○';
            });
        }
        $(document).ready(function() {
            $('#Password').on('keyup input', function(){ updatePwChecklist($(this).val()); });
            $('#registrationform').submit(function(e) {
                e.preventDefault();
                $("#errorblock").css("display","none");
                $("#messageblock").css("display","none");
                var first_name = $('#FirstName').val();
                var last_name = $('#LastName').val();
                var email = $('#Email').val();
                var password = $('#Password').val();
                var repeatPassword = $('#RepeatPassword').val();
                var EmailregEx = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var nameRegEx=/^(?=.{1,50}$)[a-z]+(?:['_.\s][a-z]+)*$/i;
                var errorCount=0;
                $(".error").remove();

                var validFirstName = nameRegEx.test(first_name);
                if (first_name.length < 1) {
                    $('#FirstName').after('<div class="error" style="padding-top:10px; margin:0px;"><p class="error" style="color:red; font-size:12px;margin:0px;">This field is required</p></div>');
                    errorCount++;
                }else if (!validFirstName) {
                    $('#FirstName').after('<div class="error" style="padding-top:10px; margin:0px;"><p class="error" style="color:red; font-size:12px;margin:0px;">Enter a valid First Name</p></div>');
                    errorCount++;
                }

                var validLastName = nameRegEx.test(last_name);
                if (last_name.length < 1) {
                    $('#LastName').after('<div class="error" style="padding-top:10px;margin:0px;"><p class="error" style="color:red; font-size:12px;margin:0px;">This field is required</p></div>');
                    errorCount++;
                }else if(!validLastName) {
                    $('#LastName').after('<div class="error" style="padding-top:10px;margin:0px;"><p class="error" style="color:red; font-size:12px;margin:0px;">Enter a valid Last Name</p></div>');
                    errorCount++;
                }


                if (email.length < 1) {
                    $('#Email').after('<div class="error" style="padding-top:10px;margin:0px;"><p style="color:red; font-size:12px;margin:0px;">This field is required</p></div>');
                    errorCount++;
                } else {

                    var validEmail = EmailregEx.test(email);
                    if (!validEmail) {
                        $('#Email').after('<div class="error" style="padding-top:10px;"margin:0px;><p class="error" style="color:red; font-size:12px;margin:0px;">Enter a valid email</p></div>');
                        errorCount++;
                    }
                }
                var pwErr = passwordPolicyError(password);
                if (pwErr) {
                    $('#passworderror').append('<div class="error" style="padding-top:10px;margin:0px;"><p class="error" style="color:red; font-size:12px;">'+pwErr+'</p></div>');
                    errorCount++;
                }else if(password!=repeatPassword){
                    $('#passworderror').append('<div class="error" style="padding-top:10px;margin:0px;"><p class="error" style="color:red; font-size:12px;">Passwords do not match.</p></div>');
                    errorCount++;
                }

                var role=$("#role option:selected").text();
                if(role=="Select your account type"){
                    $('#fundingerror').after('<div class="error" id="sourceerror" style="padding-top:10px; margin:0px;"><p class="error" style="color:red; font-size:12px;margin:0px;">Please select one of the options</p></div>');
                    $('#fundingerror').remove();
                    errorCount++;
                }else{
                    $('#sourceerror').remove();
                }

                $('#role').change(function(){
                    var role=$("#role option:selected").text();
                    if(role=="Select your account type"){
                        $('#sourceerror').remove();
                        $('#fundingerror').after('<div class="error" id="sourceerror" style="padding-top:10px; margin:0px;"><p class="error" style="color:red; font-size:12px;margin:0px;">Please select one of the options</p></div>');
                        $('#fundingerror').remove();
                    }else{
                        $('#sourceerror').remove();
                    }
                });

                if(errorCount==0){
                    var role=$("#role option:selected").val();
                    //alert();
                    $.ajax({
                        url: "lib.php",
                        type: "POST",
                        data: {
                            FirstName: first_name,
                            LastName: last_name,
                            Email: email,
                            Password: password,
                            Role:role,
                            registerationProcess:1
                        },
                        success: function(data){
                            alert(data);
                            if (data.includes("Success")) {
                                $("#messageblock").css("display","block");
                                $('#msg').html(data);
                                $('#registrationform').find('input').val('');
                            } else {
                                $("#errorblock").css("display","block");
                                $('#errormsg').html(data);
                            }


                        }
                    });

                }
            });

        });
    </script>

</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <div class="sidebar-brand-text mx-3" style="padding: 20px;"><img src="img/bbfdc logo.png" width="150px;"></div>
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" id="registrationform" method="post" action="">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="FirstName"
                                           placeholder="First Name" name="firstname">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="LastName"
                                           placeholder="Last Name" name="lastname">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="Email"
                                       placeholder="Email Address" name="email">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           id="Password" placeholder="Password" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                           id="RepeatPassword" placeholder="Repeat Password" name="repeatpassword">
                                </div>
                                <div id="passworderror" style="margin-left: 20px;">

                                </div>
                                <div id="pwreq" style="font-size:12px; color:#888; margin: 8px 0 0 20px;">
                                    <div style="margin-bottom:4px;">Your password must include:</div>
                                    <ul style="list-style:none; padding-left:0; margin:0;">
                                        <li data-rule="len"><span class="mark">○</span> At least 8 characters</li>
                                        <li data-rule="upper"><span class="mark">○</span> One uppercase letter (A&ndash;Z)</li>
                                        <li data-rule="lower"><span class="mark">○</span> One lowercase letter (a&ndash;z)</li>
                                        <li data-rule="num"><span class="mark">○</span> One number (0&ndash;9)</li>
                                        <li data-rule="special"><span class="mark">○</span> One special character (! @ # $ % &hellip;)</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group row">
                                <select class="browser-default custom-select form-select" id="role">
                                    <option value="funding" selected="">Select your account type</option>
                                    <option value="2" style="">Educator/Assistant</option>
                                    <option value="3">Parent</option>
                                </select>
                                <div id="fundingerror" style="margin-left: 20px;"></div>
                            </div>
                            <input type="submit" name="submitBtnLogin" id="submitBtnLogin" value="Register Account" class="btn btn-primary btn-user btn-block" />

                            <div id="messageblock" style="padding-top:10px; display: none; ">
                                <div class="card mb-4 py-3 border-left-success" style="padding-top:0px !important;padding-bottom:0px !important; ">
                                    <div class="card-body" style="color:#1cc88a" id="msg">
                                    </div>
                                </div>
                            </div>

                            <div id="errorblock" style="padding-top:10px; display: none; ">
                                <div class="card mb-4 py-3 border-left-danger" style="padding-top:0px !important;padding-bottom:0px !important; ">
                                    <div class="card-body" style="color:red" id="errormsg">
                                    </div>
                                </div>
                            </div>

                            <hr>
                        </form>
                        <div class="text-center">
                            <a class="small" href="forgot-password.php">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.php">Already have an account? Login!</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="https://brightbeginningsfdcc.com.au/">Go back to Bright Beginnings Website</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->

</body>

</html>