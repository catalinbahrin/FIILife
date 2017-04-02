<?php

include_once("base/config.php");
include_once('session/check.php');
extractSession(PAGE_TEACHERS_KEY);

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
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/teachers.css">
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



</head>
<body>
   <!-- Always shows a header, even in smaller screens. -->
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <div class="mdl-layout__header-row">
              <!-- Title -->
              <span class="mdl-layout-title">Administrator</span>
              <!-- Add spacer, to align navigation to the right -->
              <div class="mdl-layout-spacer"></div>
              <!-- Navigation. We hide it in small screens. -->
              <nav class="mdl-navigation mdl-layout--large-screen-only">

                  <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-account.php">Add Account</a>
                  <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
                  <a class="mdl-navigation__link" style="background: #1976D2" href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
                  <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/students.php">Students</a>
                  <a class="mdl-navigation__link"  href="session/log-out.php">Logout</a>
              </nav>
          </div>
      </header>
      <div class="mdl-layout__drawer">
          <span class="mdl-layout-title">Tools</span>
          <nav class="mdl-navigation">

              <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-account.php">Add Account</a>
              <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
              <a class="mdl-navigation__link"style="background: #eeeeee"  href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
              <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/students.php">Students</a>
              <a class="mdl-navigation__link" href="session/log-out.php">Logout</a>
          </nav>
      </div>
      <main class="mdl-layout__content">
          <div class="page-content">

<div style="overflow-x: auto; width: 90%;margin: 0 auto; max-width: 1000px; padding-top: 50px; ">


              <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp">
                  <thead>
                  <tr>

                      <th>TeacherID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody id="printHere">

                  </tbody>
              </table>
</div>

          </div>
      </main>
  </div>




<script>




    $(function(){
     requestTeachers();
    });


    function requestTeachers(){

        Pace.restart();
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/retrieve-teachers.php",
            type : "POST",
            data : {
                token : "<?php echo $token ?>",
                userID : "<?php echo $userID ?>"
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
           // console.log(msg);
            var status = msg['status']; //ok / negative
            if(status!="negative"){
                var teachers = JSON.parse(msg['body']);
                if(teachers.length == null || teachers.length == 0) printTeachers(teachers);
                else
                for(var i=0;i<teachers.length;i++){
                    printTeachers(teachers[i]);
                }
            }

        });
        req.fail(function(){
            alert("Oh no! Server Error.");
        })

    }


    function printTeachers(data){
        var teacher = new Teacher(data);
        console.log(teacher);
        if(teacher.name=="Unknown User") return;
        var print='<tr> ' +
            '<td>'+teacher.ID+'</td> ' +
            '<td>' + teacher.name +'</td> ' +
            '<td>'+ teacher.email +'</td> ' +
            '<td style=""> ' +
            '<div class="actionButtonContainer" style="margin-right: 10px;color: #F44336;" onclick="deleteTeacher('+teacher.ID+')"> ' +
            '<i class="material-icons" style="font-size: 18px;">&#xE92B;</i> ' +
            '<span class="actionButton">Delete</span> ' +
            '</div> ' +
            '</td> ' +
            '</tr>';

        $("#printHere").append(print);


    }


    function deleteTeacher(ID){


        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/delete-teacher.php",
            type : "POST",
            data : {
                teacherID : ID,
                token : "<?php echo $token ?>",
                userID : "<?php echo $userID ?>"
            }
        });
        req.done(function(){
            alert("Big up ! You're a killer.");
            window.location.reload(true);
        });
        req.fail(function(){
            alert("Oh no! Server Error.");
        })

    }

    function editTeacher(ID){
    }






</script>


<script src="base/data.js" ></script>

</body>




</html>

