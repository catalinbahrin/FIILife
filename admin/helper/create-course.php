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

$day = $_POST['day'];
$description = FiiCore::secureString($_POST['description']);



if(!isset($userID) || !isset($token) || !isset($description)  ||  !isset($name) ||  !isset($day)){
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


    $SQL = "INSERT INTO course SET
             name = '".$name."',
             description = '".$description."',
             day = '".$day."'
             ";
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