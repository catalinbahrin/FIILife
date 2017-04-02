<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 02-Apr-17
 * Time: 1:22 AM
 */
include_once("../../../../libs/fiilife-core.php");
$conn = FiiCore::globalAccess();


$ID = $_POST['teacherID'];
$userID = $_POST['userID'];
$token = $_POST['token'];

if(!isset($userID) || !isset($token) || !isset($ID)){
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






$newName = "Unknown User";
$newPass = "no_pass";


$SQL = "UPDATE admin SET name = '" .$newName ."' , password  = '" .$newPass ." '  WHERE ID = '" . $ID . "'";
$results = $conn->query($SQL);











?>