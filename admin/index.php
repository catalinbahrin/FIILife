<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 22-Feb-17
 * Time: 2:46 PM
 */
include_once("base/config.php");

session_set_cookie_params(3600 * 24 * 4);
session_start();
if(isset($_SESSION['userID'])) header("Location: students.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>FiiLife</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="pinterest" content="nopin" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes">
    <script language="JavaScript" type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

    <link rel="stylesheet" href="support/bootstrap/css/bootstrap.css">
    <script src="support/bootstrap/js/bootstrap.js"></script>

    <link rel="stylesheet" href="support/mdl/material.min.css">
    <script src="support/mdl/material.min.js"></script>



    <script src="support/loading-pace/pace.min.js"></script>
    <link rel="stylesheet" href="support/loading-pace/pace.css">

    <script src="support/md5/md5.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/util.css">

</head>



<body style="display: block;">

<script>

</script>


<div class="background">
<div style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">

    <div class="cardContainer">

    <div class="mdl-card mdl-shadow--16dp formOuterContainer">
        <form class="formInputContainer">
            <div style="flex: 1; display: flex;flex-direction: column">
                <input class="formInput" name="email" id="email" type="email" title="Your Email" placeholder="Your Email" required>
                <div class="divider"></div>
            </div>
            <div style="margin-top:30px; flex: 1; display: flex;flex-direction: column">
                <input class="formInput" type="password" name="password" id="password" title="Your Password" placeholder="Your Password" required>
                <div class="divider"></div>
            </div>

            <div style="width: 100%; margin-top: 60px; display: flex; justify-content: center;">
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" style="padding-left: 50px;background: #2196F3; padding-right: 50px;" id="logInButton">
                LOG IN
            </button>
            </div>

        </form>

    </div>



    <div style="position: absolute;width: 100%;display: flex;justify-content: center; z-index: 1">
        <img src="images/logo.png" id="logo" >
    </div>
    </div>



</div>
</div>



<script src="js/index.js"></script>
<script src="js/util.js"></script>
</body>
</html>
