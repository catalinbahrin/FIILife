<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 02-Apr-17
 * Time: 3:31 AM
 */

include_once("../../../../libs/fiilife-core.php");
$conn = FiiCore::globalAccess();

//testeaza token

$userID = $_POST['userID'];
$token = $_POST['token'];
$studentID = $_POST['studentID'];
$courseID = $_POST['courseID'];

if(!isset($userID) || !isset($token) || !isset($studentID)){
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

$arr = array();

$SQL = "INSERT INTO student_course SET studentID = '".$studentID."', courseID = '".$courseID."' ";
$results = $conn->query($SQL);
if($results){
    exit(json_encode(array(
        "status" => "ok",
        "body" => "Insert Done."
    )));

}
else exit(json_encode(array(
    "status" => "negative",
    "body" => "No Courses Available"
)));







//text
//value