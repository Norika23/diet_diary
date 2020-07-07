<?php

require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("session.php");
require_once("meal.php");
require_once("goal.php");
require_once("point.php");
require_once("calendar.php");
require_once("weight.php");
require_once("diary.php");



global $database;


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $user_id = 1;


defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

$url = $_SERVER['HTTP_HOST'];
if(strstr($url,'localhost')==true) {

    defined('BASE_URL') ? null : define('BASE_URL', 'C:'. DS . 'xampp' . DS . 'htdocs' . DS . 'diet' );

} elseif(strstr($url,'punipuni.space')==true) {

    defined('BASE_URL') ? null : define('BASE_URL', $_SERVER['DOCUMENT_ROOT'] . DS . 'diet' );

}

require_once(BASE_URL.'/classes/tweet.php');
require_once(BASE_URL.'/classes/follow.php');
$getFromU = new User($database);
$getFromT = new Tweet($database);
$getFromF = new Follow($database);

//   define('BASE_URL', 'http://localhost/twitter/');
?>
