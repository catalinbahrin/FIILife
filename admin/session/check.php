<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 11-Feb-17
 * Time: 3:03 PM
 */

function extractSession2(){

};
function extractSession($key){

    /**
     * include_once("../base/config.php") in the HTML FILE
     */
    $pathToIndex = goToRootTarget($key, PAGE_INDEX_KEY);
    $pathToLibs = goToBaseTarget($key, 'libs/fiilife-core.php');
    include($pathToLibs);


    $conn = FiiCore::globalAccess();
    session_start(); /** When using the session, do not forget to start it before */
    if(!isset($_SESSION['userID']))  {header('Location: '.$pathToIndex); exit(); }/** First check if there is any SESSION userID inserted */
    $userID = $_SESSION['userID'];

    $SQL = "SELECT ID, email,name, token FROM admin WHERE ID='" . $userID . "' LIMIT 1";

    $results = $conn -> query($SQL);

    if($results -> num_rows > 0){

        while($row = $results -> fetch_assoc()){
            if(!isset($row['ID'])){
                /**
                 * If the userID is not found on the server, he must have been deleted or does not exist any more.
                 * Go to Index
                 */
                header('Location: '.$pathToIndex);
            }
            else if(!isset($row['token']) || $row['token'] == null || empty($row['token']) || $row['token'] == "not_defined"  ){
                /**
                 * If the token is not set on the server, than the user is not logged in and has to be checked again.
                 * Go to Index
                 */
                header('Location: '.$pathToIndex);
            }
            else {
                $_SESSION['userToken'] = $row['token'];
            }
        }
    }
    else{
       header('Location: '.$pathToIndex);
        /**
         * If there is nothing coming back from the server, there must be an error
         * Go to Index
         */
    }

/**
 * If everything is fine, resume with your work.
 * Do not make changes to the environment in this case
 */
}
?>