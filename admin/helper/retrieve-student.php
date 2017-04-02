<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 02-Apr-17
 * Time: 1:06 AM
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



$studentList = array();
$SQL = "SELECT * FROM student WHERE ID = '".$studentID."' LIMIT 1";
$results = $conn->query($SQL);

if($results->num_rows > 0){

    $row = $results->fetch_assoc();

        $ID = $row['ID'];
        $name = $row['name'];
        $email = $row['email'];

        $student = array(
            "ID" => $ID,
            "name" => $name,
            "email" => $email
        );
    exit(json_encode(array(
        "status" => "ok",
        "body" => $student
    )));
}
else exit(json_encode(array(
    "status" => "negative",
    "body" => "There may be no students or there is a server error."


)))



?>