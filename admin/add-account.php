<?php

include_once("base/config.php");
include_once('session/check.php');
extractSession(PAGE_ADD_ACCOUNT);

session_set_cookie_params(3600 * 24 * 4);
session_start();

$token = $_SESSION['userToken'];
$userID = $_SESSION['userID'];
$userType = $_SESSION['userType'];
if($userType == "2") header("Location:students.php");

?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Account</title>
    <link rel="stylesheet" href="css/students.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script language="JavaScript" type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="support/mdl/material.min.css">
    <script src="support/mdl/material.min.js"></script>

    <link rel="stylesheet" href="css/util.css">


    <script src="support/loading-pace/pace.min.js"></script>
    <link rel="stylesheet" href="support/loading-pace/pace.css">
    <script src="support/md5/md5.js"></script>

    <link rel="stylesheet" href="css/add-account.css">


</head>
<body>
<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <span class="mdl-layout-title">Add Account</span>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation mdl-layout--large-screen-only">

                <a class="mdl-navigation__link" style="background: #1976D2" href="http://sycity.ro/fiilife/admin/add-account.php">Add Account</a>
                <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
                <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
                <a class="mdl-navigation__link"  href="http://sycity.ro/fiilife/admin/students.php">Students</a>
                <a class="mdl-navigation__link"  href="session/log-out.php">Logout</a>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Tools</span>
        <nav class="mdl-navigation">

            <a class="mdl-navigation__link" style="background: #eeeeee" href="http://sycity.ro/fiilife/admin/add-account.php">Add Account</a>
            <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
            <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
            <a class="mdl-navigation__link"  href="http://sycity.ro/fiilife/admin/students.php">Students</a>
            <a class="mdl-navigation__link" href="session/log-out.php">Logout</a>
        </nav>
    </div>
    <main class="mdl-layout__content">
        <div class="page-content">

            <div style="overflow-x: auto; width: 90%;margin: 0 auto; max-width: 1000px; padding-top: 50px; ">


                <div class="mdl-card shadow1DP" style="width: 100%; min-height: 100px;">
                    <div class="" style="margin: 0;width: 100%; max-width: 600px; padding: 20px;">

                        <div style="margin-bottom: 10px;">
                            <span class="containerLabel">PRIMARY INFO</span>
                        </div>

                        <div class="adminInputContainer">

                            <label for="name" class="adminInputLabel">Full Name</label>

                            <input id="name" style="background-color: #eee; color: #000" name="name" title="name" type="text" placeholder="Name" class="adminInput"/>

                        </div>

                        <div class="adminInputContainer">

                            <label for="email" class="adminInputLabel">Email Address</label>

                            <input id="email" name="email" title="email" type="email" placeholder="Email" class="adminInput"/>

                        </div>

                        <div class="adminInputContainer">

                            <label for="password" class="adminInputLabel">Password</label>

                            <input id="password" name="password" title="password" type="password" placeholder="Password" class="adminInput"/>

                        </div>

                        <div class="adminInputContainer">

                            <label for="rank" class="adminInputLabel">Admin Rank</label>

                            <select id="rank" name="rank" title="rank" class="adminInput">
                                <option value="2">TEACHER</option>
                                <option value="1">STUDENT</option>
                            </select>

                        </div>

                        <div>

                            <button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="saveButton">
                                Create new account
                            </button>

                        </div>

                    </div>
                </div>



            </div>

        </div>
    </main>
</div>



<script>
    var type = 2;
    $(function(){
    $("#rank").on("change", function(){
       type = $(this).find('option:selected').attr('value');
    });

    $("#saveButton").on("click",function(){
        createAccount();
    })
});




    function createAccount(){

        var password = $("#password").val();
        if(password.trim().length <= 3) {
            showToast("Please add a longer password",600);
            return;
        }

        var email = $("#email").val();
        if(email.trim().length <= 5) {
            showToast("Please add a longer email",600);
            return;
        }

        password = md5(email+password);

        var name = $("#name").val();
        if(name.trim().length <= 2) {
            showToast("Please add a longer name",600);
            return;
        }

        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/create-account.php",
            type:"POST",
            data : {
            type : type,
            password : password,
            name : name,
            email : email,
            userID : "<?php echo $userID ?>",
                token : "<?php echo $token ?>"
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
            if(msg['status'] == "ok"){
                showToast("New account created.",600);
                alert("New account created");
                window.location.reload();
            } else if(msg['status'] == "email"){
                showToast("Email is already in use.",600);
            }
            else {showToast(msg['body'],600);

            }
        });
        req.fail(function(){
            showToast("Server Error.");
        });
    }

</script>


<script src="base/data.js" ></script>
<script src="js/util.js"></script>

</body>




</html>

