<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 11-Feb-17
 * Time: 4:21 PM
 */

include_once("../base/config.php");
include_once("../../../../libs/fiilife-core.php");
$conn = FiiCore::globalAccess();

session_set_cookie_params(3600 * 24 * 4);
session_start();


    $error = '';
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $error = "Username or Password not set";
        } else {
            $email = secureString($_POST['email']);
            $password = md5(secureString($_POST['password']));
            $SQL = "SELECT * FROM admin WHERE password='" . $password . "' AND email='" . $email . "' LIMIT 1";
            $results = $conn->query($SQL);

            if ($results->num_rows > 0) {
                $row = $results->fetch_assoc();

                $_SESSION['userID'] = $row['ID'];
                $_SESSION['userName'] = $row['name'];
                $_SESSION['userEmail'] = $row['email'];
                $_SESSION['userType'] = $row['type'];
                $token = $_POST['token'];

                $SQL = " UPDATE admin SET token='" . $token . "' WHERE ID='" . $row['ID'] . "' LIMIT 1";
                $results = $conn->query($SQL);

                if ($results) {
                    $_SESSION['userToken'] = $token;
                    //SESSION IS NOW SET
                    $text = "response-ok";
                    exit ($text);
                }
                else exit("response-negative");
            } else {
                //SESSION WAS UNSUCCESSFUL
                $error = "Username or Password are invalid";
                exit("response-negative");
            }
        }
    }else exit("response-negative");


exit ("response-negative");


?>