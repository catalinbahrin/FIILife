<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 11-Feb-17
 * Time: 4:46 PM
 */

include_once("../base/config.php");
include_once("../../../../libs/fiilife-core.php");
$conn = FiiCore::globalAccess();

session_start();
$userID = $_SESSION['userID'];


if(session_destroy()) // Destroying All Sessions
{
    $SQL = "UPDATE admin SET token = NULL WHERE ID = '".$userID."'";
    $result = $conn->query($SQL);
    if($result) {
        header("Location: ../index.php"); // Redirecting To Home Page
    }
    else echo "error";
}


?>