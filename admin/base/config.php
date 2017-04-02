<?php
/**
 * User: "Razvan Gabriel Apostu"
 * Date: 08-Feb-17
 * Time: 11:34 PM
 */


/*The keys used here will be used on the entire website*/
/* NAMES=KEYS cannot be changed as this would cause damage to website */


const SYSTEM_PAGE_CONFIG = 'config';

const SYSTEM_PAGE_SESSION_CHECK_KEY = 'session-check';
const SYSTEM_PAGE_LOG_IN_KEY = 'log-in';
const SYSTEM_PAGE_LOG_OUT_KEY = 'log-out';

const PAGE_INDEX_KEY = 'index';
const PAGE_STUDENTS_KEY = 'students';
const PAGE_USER_PROFILE = 'user-profile';
const PAGE_TEACHERS_KEY= 'teachers';

const PAGE_ADD_ACCOUNT = 'add-account';
const PAGE_ADD_COURSE = 'add-course';




const GLOBAL_DEFAULT_USER_ID = 3;

const ROOT = 'https://www.sycity.ro/';




$depthToBase = 3; /**the depth difference between Base of Server and Root folder of Website*/



$depthToRoot = array(
    PAGE_INDEX_KEY => 0, /** Homepage/Landing for the public/unregistered user */
    SYSTEM_PAGE_SESSION_CHECK_KEY=>1, /**SYSTEM page for checking if session is set*/
    SYSTEM_PAGE_CONFIG => 1,
    SYSTEM_PAGE_LOG_IN_KEY => 1,
    SYSTEM_PAGE_LOG_OUT_KEY=>1,
    PAGE_STUDENTS_KEY=>0,
    PAGE_TEACHERS_KEY=>0,
    PAGE_USER_PROFILE=>0,
    PAGE_ADD_ACCOUNT=>0,
    PAGE_ADD_COURSE=>0,


);


/**
 * $pageKey is an Array that contains the names for every page.
 * Its purpose is to help the dev when targeting a certain page.
 * Key may be named ~whatever is easier for dev to refer to. MUST MATCH WITH $depthToRoot
 * Value must be path to page from root of Website
 */

$pathFromRoot = array(
    PAGE_INDEX_KEY => 'index.php',
    SYSTEM_PAGE_SESSION_CHECK_KEY => 'session/check.php',
    SYSTEM_PAGE_CONFIG => 'base/config.php',
    SYSTEM_PAGE_LOG_IN_KEY => 'session/log-in.php',
    SYSTEM_PAGE_LOG_OUT_KEY=>'session/log-out.php',
    PAGE_STUDENTS_KEY => 'students.php',
    PAGE_USER_PROFILE => 'user-profile.php',
    PAGE_TEACHERS_KEY => 'teachers.php',
    PAGE_ADD_ACCOUNT=>'add-account.php',
    PAGE_ADD_COURSE => 'add-course.php'

);


/**
 * Go To Root folder of Website and than go to target-page (by pageKey)
 * @param $from - will be a const KEY
 * @param $to  - will be a const KEY
 * @return string - will be the full path needed to access the "to" file from "from"
 */

function goToRootTarget($from,$to){
    global $depthToRoot;
    global $pathFromRoot;
    $path = "";
    for($i=0;$i<$depthToRoot[$from];$i++) $path.="../";
    $path.= $pathFromRoot[$to];
    return $path;
    //goToRoot from $from and than goTo$to
}
/**
 * Go To Base folder of Server and than go to target-page (by full path)
 */
function goToBaseTarget($from,$to){
    global $depthToRoot, $depthToBase;
    $path = "";
    for($i=0;$i< $depthToRoot[$from]+$depthToBase; $i++){ $path.="../";}
    $path.=$to;
    return $path;
    // example : goToBase('credentials','libs/example-core.php') = "../../libs/example-core.php"
}


/* API
 * $_SESSION['userID']
 * $_SESSION['userName']
 * $_SESSION['userFirstName']
 * $_SESSION['userLastName']
 * $_SESSION['userEmail']
 */














function secureString($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}


?>