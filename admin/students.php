<?php

include_once("base/config.php");
include_once('session/check.php');
extractSession(PAGE_STUDENTS_KEY);

session_set_cookie_params(3600 * 24 * 4);
session_start();

$token = $_SESSION['userToken'];
$userID = $_SESSION['userID'];
$userType = $_SESSION['userType'];


?>


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
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



</head>
<body>
   <!-- Always shows a header, even in smaller screens. -->
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <div class="mdl-layout__header-row">
              <!-- Title -->
              <span class="mdl-layout-title">Students</span>
              <!-- Add spacer, to align navigation to the right -->
              <div class="mdl-layout-spacer"></div>
              <!-- Navigation. We hide it in small screens. -->
              <nav class="mdl-navigation mdl-layout--large-screen-only">

                  <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-account.php">Add Acount</a>
                  <a class="mdl-navigation__link"href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
                  <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
                  <a class="mdl-navigation__link" style="background: #1976D2" href="http://sycity.ro/fiilife/admin/students.php">Students</a>
                  <a class="mdl-navigation__link"  href="session/log-out.php">Logout</a>
              </nav>
          </div>
      </header>
      <div class="mdl-layout__drawer">
          <span class="mdl-layout-title">Tools</span>
          <nav class="mdl-navigation">

              <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-account.php">Add Acount</a>
              <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/add-course.php">Add Course</a>
              <a class="mdl-navigation__link" href="http://sycity.ro/fiilife/admin/teachers.php">Teachers</a>
              <a class="mdl-navigation__link" style="background: #eeeeee" href="http://sycity.ro/fiilife/admin/students.php">Students</a>
              <a class="mdl-navigation__link" href="session/log-out.php">Logout</a>
          </nav>
      </div>
      <main class="mdl-layout__content">
          <div class="page-content">

<div style="overflow-x: auto; width: 90%;margin: 0 auto; max-width: 1000px; padding-top: 50px; ">


              <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp">
                  <thead>
                  <tr>

                      <th>StudentID</th>
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

    var adminType = "<?php echo $userType ?>";


    $(function(){
     requestStudents();
    });


    function requestStudents(){

        Pace.restart();
        var req = $.ajax({
            url : "http://sycity.ro/fiilife/admin/helper/retrieve-students.php",
            type : "POST",
            data : {
                token : "<?php echo $token ?>",
                userID : "<?php echo $userID ?>"
            }
        });
        req.done(function(msg){
            console.log(msg);
            msg = JSON.parse(msg);
            console.log(msg);
            var status = msg['status']; //ok / negative
            if(status!="negative"){
                var students = JSON.parse(msg['body']);
                if(students.length == null || students.length == 0) printTeachers(students);
                for(var i=0;i<students.length;i++){
                    printStudent(students[i]);
                }
            }

        });
        req.fail(function(){
            alert("Oh no! Server Error.");
        })

    }


    function printStudent(data){
        var student = new Student(data);
        if(student.name=="Unknown User") return;
        var print='<tr onclick="goToUser('+student.ID+')" style="cursor: alias;"> ' +
            '<td>'+student.ID+'</td> ' +
            '<td>' + student.name +'</td> ' +
            '<td>'+ student.email +'</td> ' +
            '<td style=""> ';
        if(adminType == "1")
        print+=
            '<div class="actionButtonContainer" style="margin-right: 10px;color: #F44336;" onclick="deleteStudent('+student.ID+')"> ' +
            '<i class="material-icons" style="font-size: 18px;">&#xE92B;</i> ' +
            '<span class="actionButton">Delete</span> ' +
            '</div> ';

        print+=
            '<div class="actionButtonContainer"  onclick="editStudent('+student.ID+')"> ' +
            '<i class="material-icons" style="font-size: 18px;">&#xE254;</i> ' +
            '<span class="actionButton">Edit</span> ' +
            '</div> ' +
            '</td> ' +
            '</tr>';

        $("#printHere").append(print);


    }

    function goToUser(ID){
        window.location.href = "user-profile.php?studentID="+ID;
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
            window.location.reload(true);
        });
        req.fail(function(){
            alert("Oh no! Server Error.");
        })

    }

    function editStudent(ID){
goToUser(ID);
    }

</script>


<script src="base/data.js" ></script>

</body>




</html>

