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

$SQL = "SELECT c.ID, c.name, c.day, c.description FROM student_course sc INNER JOIN course c ON sc.courseID = c.ID WHERE sc.studentID = '".$studentID."'";
$results = $conn->query($SQL);
if($results->num_rows >0){
    while($row = $results->fetch_assoc()){
        $value = $row['ID'];
        $text = $row['name']." | ".$row['description']." | ".$row['day'];
        $obj = array(
            "ID"=>$value,
            "description"=>$text,
            "name" => $row['name']
        );
        array_push($arr,$obj);
    }
    exit(json_encode(array(
        "status" => "ok",
        "body" => $arr
    )));

}
else exit(json_encode(array(
    "status" => "negative",
    "body" => "No Courses Available"
)));







//text
//value