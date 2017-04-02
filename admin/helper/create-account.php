<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 02-Apr-17
 * Time: 5:45 AM
 */


include_once("../../../../libs/fiilife-core.php");
$conn = FiiCore::globalAccess();

//testeaza token

$userID = $_POST['userID'];
$token = $_POST['token'];
$name = FiiCore::secureString($_POST['name']);
$password = $_POST['password'];
$password = md5($password);
$type = $_POST['type'];
$email = FiiCore::secureString($_POST['email']);

if(!isset($userID) || !isset($token) || !isset($email) ||  !isset($password) ||  !isset($name) ||  !isset($type)){
    exit(json_encode(array(
        "status" => "negative",
        "body" => "Not enough data was sent."
    )));

}

$tokenSQL = "SELECT token FROM admin WHERE ID = '" . $userID . "'  AND token = '".$token."' ";
$results = $conn->query($tokenSQL);
if ($results->num_rows == 0)
    exit(json_encode(array(
        "status" => "negative",
        "body" => "Invalid Token"
    )));

/**Check Email */
$SQL = "SELECT email FROM ";
if($type == "2") $SQL.=" admin ";
else $SQL.= " student ";
$SQL.= "WHERE email = '".$email."'";

$results = $conn->query($SQL);
if($results->num_rows > 0){
    exit(json_encode(array(
        "status" => "email",
        "body" => "Email already in use".$type
    )));
}


if($type == "2") {
    $SQL = "INSERT INTO admin SET
             name = '".$name."',
             email = '".$email."',
             password = '".$password."',
             type = 2
             ";
}
else if($type == 1){
    $SQL = "INSERT INTO student SET
             name = '".$name."',
             email = '".$email."',
             password = '".$password."'
             ";
}


$res = $conn->query($SQL);
if($res){
    exit(json_encode(array(
        "status" => "ok",
        "body" => "Account has been created."
    )));
}

exit(json_encode(array(
    "status" => "negative",
    "body" => "Server Error"
)));











?>