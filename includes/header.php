<?php

require_once("init.php");

// require_once("db_object.php");
// require_once("user.php");
// require_once("session.php");
// require_once("meal.php");
// require_once("goal.php");
// require_once("point.php");
// require_once("calendar.php");
// require_once("weight.php");
// require_once("diary.php");



// global $database;


// $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $user_id = 1;


// defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

// $url = $_SERVER['HTTP_HOST'];
// if(strstr($url,'localhost')==true) {

//     defined('BASE_URL') ? null : define('BASE_URL', 'C:'. DS . 'xampp' . DS . 'htdocs' . DS . 'diet' );

// } elseif(strstr($url,'punipuni.space')==true) {

//     defined('BASE_URL') ? null : define('BASE_URL', $_SERVER['DOCUMENT_ROOT'] . DS . 'diet' );

// }

// require_once(BASE_URL.'./classes/tweet.php');
// require_once(BASE_URL.'./classes/follow.php');
// $getFromU = new User($database);
// $getFromT = new Tweet($database);
// $getFromF = new Follow($database);

//   define('BASE_URL', 'http://localhost/twitter/');
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダイエット記録</title>
    <link rel="stylesheet" href="assets/css/style-complete.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<?php
include(BASE_URL."/ajax/modal.php");

?>