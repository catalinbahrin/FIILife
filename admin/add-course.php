<?php

include_once("base/config.php");
include_once('session/check.php');
extractSession(PAGE_ADD_COURSE);

session_set_cookie_params(3600 * 24 * 4);
session_start();

$token = $_SESSION['userToken'];
$userID = $_SESSION['userID'];

?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
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
            <span class="mdl-layout-title">Add Course</span>
            <!-- Add spacer, to align navigation to the right -->
            <div class="mdl-layout-spacer"></div>
            <!-- Navigation. We hide it in small screens. -->
            <nav class="mdl-navigation mdl-layout--large-screen-only">

                <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-account.php">Add Account</a>
                <a class="mdl-navigation__link" style="background: #1976D2"  href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
                <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
                <a class="mdl-navigation__link"  href="http://sycity.ro/fiilife/admin/students.php">Students</a>
                <a class="mdl-navigation__link"  href="session/log-out.php">Logout</a>
            </nav>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Tools</span>
        <nav class="mdl-navigation">

            <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-account.php">Add Account</a>
            <a class="mdl-navigation__link"  style="background: #eeeeee" href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
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

                            <label for="name" class="adminInputLabel">Course Name</label>

                            <input id="name" style="background-color: #eee; color: #000" name="name" title="name" type="text" placeholder="Name" class="adminInput"/>

                        </div>

                        <div class="adminInputContainer">

                            <label for="description" class="adminInputLabel">Course Description</label>

                            <input id="description"  style="background-color: #eee; color: #000" name="description" title="description" type="text" placeholder="Description" class="adminInput"/>

                        </div>

                        <div class="adminInputContainer">

                            <label for="day" class="adminInputLabel">Course Day</label>

                            <select id="day" name="day" title="day" class="adminInput">
                                <option value="5">Friday</option>
                                <option value="4">Thursday</option>
                                <option value="3">Wednesday</option>
                                <option value="2">Tuesday</option>
                                <option value="1">Monday</option>
                            </select>

                        </div>

                        <div>

                            <button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="saveButton">
                                Create new course
                            </button>

                        </div>

                    </div>
                </div>



                <div class="mdl-card shadow1DP" style="width: 100%; min-height: 100px;">
                    <div class="" style="margin: 0;width: 100%; max-width: 600px; padding: 20px;">

                        <div style="margin-bottom: 10px;">
                            <span class="containerLabel">ALL AVAILABLE COURSES</span>
                        </div>

                        <div id="printActiveCourses">

                        </div>
                        </div>

                    </div>


            </div>

        </div>
    </main>
</div>



<script>
    var day = 5;
    $(function(){
        requestAllCourses();
        $("#day").on("change", function(){
            day = $(this).find('option:selected').attr('value');
        });

        $("#saveButton").on("click",function(){
            createAccount();
        })
    });



    function requestAllCourses(){
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/retrieve-all-courses.php",
            type : "POST",
            data : {
                userID : "<?php echo $userID ?>",
                token : "<?php echo $token ?>"
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
            var printPlace = $("#printActiveCourses");
            if(msg['status']!="negative")
                for(var i=0;i< msg['body'].length;i++){

                    var item = msg['body'][i];
                    var text = item['text'];
                    var value = item['value'];
                    var name = item['name'];
                    var print = " <div style='margin-bottom: 5px;'> <span style='font-weight: 600; font-size: 14px;margin-right: 20px;'>ID:"+value+"</span>" +
                        "<span style='font-size: 12px;'>"+text+"</span>" +
                        "<span style='font-size: 10px;margin-left: 20px;font-weight: 600;cursor: pointer;color: #F44336' onclick='deleteCourse("+value+")'>DELETE</span></div>";

                    if(name != "Unknown Course")
                    printPlace.append(print);

                }


        });
        req.fail(function(){
            alert("Fail All Courses");
        });
    }



    function deleteCourse(ID){
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/delete-course.php",
            type : "POST",
            data : {
                userID : "<?php echo $userID ?>",
                token : "<?php echo $token ?>",
                courseID : ID
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
            if(msg['status'] == "ok"){
                showToast("Course removed.",600);
                window.location.reload();
            }
            else showToast("Error", 600);
        });
        req.fail(function(){
            showToast("Course Fail",600);
        })
    }

    function createAccount(){

        var description = $("#description").val();
        if(description.trim().length == 0) {
            showToast("Please add a longer description",600);
            return;
        }

        var name = $("#name").val();
        if(name.trim().length <= 2) {
            showToast("Please add a longer name",600);
            return;
        }

        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/create-course.php",
            type:"POST",
            data : {
                name : name,
                description : description,
                day : day,
                userID : "<?php echo $userID ?>",
                token : "<?php echo $token ?>"
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
            if(msg['status'] == "ok"){
                showToast("New course created.",600);
                alert("New course created");
                window.location.reload();
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

