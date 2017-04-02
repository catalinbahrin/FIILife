<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 22-Feb-17
 * Time: 2:46 PM
 */
include_once("base/config.php");
include_once('session/check.php');
extractSession(PAGE_USER_PROFILE);

session_set_cookie_params(3600 * 24 * 4);
session_start();

$token = $_SESSION['userToken'];
$userID = $_SESSION['userID'];
$type = $_SESSION['userType'];

$studentID = $_GET['studentID'];
if(!isset($studentID)){
    header("Location:students.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="pinterest" content="nopin" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes">
    <script language="JavaScript" type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="support/mdl/material.min.css">
    <script src="support/mdl/material.min.js"></script>
    <link rel="stylesheet" href="support/bootstrap/css/bootstrap.css">
    <script src="support/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="css/util.css">


    <script src="support/loading-pace/pace.min.js"></script>
    <link rel="stylesheet" href="support/loading-pace/pace.css">





    <script src="support/alert/bootbox.min.js"></script>
    <script src="support/moment/moment.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="stylesheet" href="css/util.css">
    <link rel="stylesheet" href="css/user-profile.css" >
    <script src="base/data.js"></script>

</head>



<body style="">

<script>

    var token = "<?php echo $token ?>";
    var studentID = "<?php echo $studentID ?>";
    var userID = "<?php echo $userID ?>";
    var userType = "<?php echo $type?>";
    var courses = {};




</script>

<div id="drawerContainer">
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">

            <div class="mdl-layout__drawer-button" id="backButton" onclick="backToStudents()">
                <i class="material-icons">&#xE5C4;</i>
            </div>
            <div class="mdl-layout__header-row">
                <!-- Title -->
                <span class="mdl-layout-title" id="toolbarTitle" >User Profile</span>
                <!-- Add spacer, to align navigation to the right -->
                <div class="mdl-layout-spacer"></div>
            </div>
        </header>
    </div>
</div>


<div style="padding-top: 80px">
    <div class="mdl-grid" style="width: 100%; max-width: 1000px;">
        <div class="mdl-cell mdl-cell--4-col">
            <div style="display: flex; justify-content: center;width: 100%;">

                <div class="demo-card-square mdl-card mdl-shadow--2dp" style="height: inherit;margin-bottom: 10px;">
                    <div class="mdl-card__title mdl-card--expand" style="display: flex;justify-content: center;align-items: center; min-height: 120px;">
                        <i class="material-icons" style="font-size: 50px; margin-right:10px;color: #2196F3">&#xE80C;</i>
                        <h4 id="studentName" style="font-size: 22px;">Student</h4>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <div style="display: flex; flex-direction: row;font-size: 14px;">
                         <span style="font-weight: 700;margin-right: 5px;font-size: 14px;">UserID: </span><span id="userID"></span><br>
                        </div>
                        <div style="display: flex; flex-direction: row;font-size: 14px;">
                            <span style="font-weight: 700;margin-right: 5px;font-size: 14px;">UserName: </span> <span id="userName"></span><br>
                            </div>
                            <div style="display: flex; flex-direction: row;font-size: 14px;">
                            <span style="font-weight: 700;margin-right: 5px;font-size: 14px;">UserEmail: </span> <span id="userEmail"></span>
                        </div>



                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" style="display: block" onclick="backToStudents()">
                            Back to Student List
                        </a>
                        <a id="deleteUserButton" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" style="color:#F44336; display: block;" onclick="deleteStudent(<?php echo $userID ?>)">
                            Delete Student
                        </a>

                    </div>
                </div>

            </div>

        </div>
        <div class="mdl-cell mdl-cell--8-col">

            <div class="demo-card-square mdl-card mdl-shadow--2dp" style="height: inherit; width: 100%;">

                <div style="margin: 10px;">
                    <div style="display: flex;flex-direction: row">
                        <span style="flex: 1; font-size: 18px; font-weight: 600;">Courses</span>
                        <div id="addCourse" style="display: flex;flex-direction: row;color: #3F51B5;align-items: center; padding: 2px 20px; background: #f5f5f5; cursor: pointer;border-radius: 3px;">
                            <i class="material-icons" style="margin-right: 5px;">&#xE148;</i>
                            <span> Add Course</span>
                            </div>
                    </div>


                    <div style="height: 1px; background: #ccc; width: 100%; margin-top: 10px; margin-bottom: 10px;">

                    </div>

                    <div id="printActiveCourses">

                    </div>




                </div>

            </div>







        </div>
    </div>



</div>
<script>

    $(function(){
        $("#addCourse").on("click",function(){
            showToast("Loading Courses...", 600);
        });
        retrieveStudent();
        requestAllCourses();
        getStudentCourses();


        if(userType == "2") $("#deleteUserButton").hide();
    });

    function retrieveStudent(){

        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/retrieve-student.php",
            type : "POST",
            data : {
                token : token,
                userID : userID,
                studentID : studentID
            }
        });
        req.done(function (msg){
            console.log(msg);
           msg = JSON.parse(msg);
            if(msg['status']!="negative" && msg['status']=="ok"){
                msg = msg['body'];
            $("#userID").text(msg['ID']);
            $("#userName").text(msg['name']);
            $("#userEmail").text(msg['email']);
                $("#studentName").text(msg['name']);
                }
            else {
                alert("Wrong data");
                window.location.href = "students.php";
            }
        });
        req.fail(function(msg){
            alert("Wrong data");
            window.location.href = "students.php";
        })

    }




    function deleteStudent(ID){


        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/delete-student.php",
            type : "POST",
            data : {
                studentID : ID,
                token : "<?php echo $token ?>",
                userID : "<?php echo $userID ?>"
            }
        });
        req.done(function(){
            alert("Big up ! You're a killer.");
            window.location.href = "students.php"
        });
        req.fail(function(){
            alert("Oh no! Server Error.");
        })

    }


    function backToStudents(){
        window.location.href = "students.php";
    }



    function addCourse(){
        console.log(courses);
        bootbox.prompt({
            title: "This is a prompt with select!",
            inputType: 'select',
            inputOptions: courses,
            callback: function (result) {
                console.log(result);
                if(result) addCourseToUser(result);
            }
        });
    }


    function requestAllCourses(){
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/retrieve-all-courses.php",
            type : "POST",
            data : {
                token : token,
                userID : userID
            }
        });
        req.done(function(msg){
            msg = JSON.parse(msg);
            courses  = msg['body'];
            console.log(courses);
            $("#addCourse").off('click');
            $("#addCourse").on("click",function(){
                addCourse(courses);
            });
        });
        req.fail(function(){
            alert("Fail All Courses");
        });
    }


    function getStudentCourses(){
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/retrieve-student-courses.php",
            type: "POST",
            data : {
                token : token,
                userID: userID,
                studentID : studentID
            }
        });
        req.done(function(msg){
            msg= JSON.parse(msg);
            console.log(msg);
            var printPlace = $("#printActiveCourses");
            if(msg['status']!="negative")
            for(var i=0;i< msg['body'].length;i++){
                var course = new Course(msg['body'][i]);
                var print = " <div style='margin-bottom: 5px;'> <span style='font-weight: 600; font-size: 14px;margin-right: 20px;'>"+course.name+"</span>" +
                    "<span style='font-size: 12px;'>"+course.description+"</span>" +
                    "<span style='font-size: 10px;margin-left: 20px;font-weight: 600;cursor: pointer;color: #F44336' onclick='removeCourse("+course.ID+")'>DELETE</span></div>";

                printPlace.append(print);

            }
        })
    }



    function removeCourse(ID){
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/remove-course-from-student.php",
            type : "POST",
            data : {
                studentID : studentID,
                token : token,
                userID : userID,
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


    function addCourseToUser(ID){
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/add-course-to-student.php",
            type : "POST",
            data : {
                studentID : studentID,
                token : token,
                userID : userID,
                courseID : ID
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
            if(msg['status'] == "ok"){
                showToast("Course added.",600);
                window.location.reload();
            }
            else showToast("Error", 600);
        });
        req.fail(function(){
            showToast("Course Fail",600);
        })
    }

</script>


<script src="js/util.js"></script>

<script src="js/user-profile.js"></script>
</body>
</html>
