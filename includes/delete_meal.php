<?php include("header.php");

$date = $_GET['day'];

    if(empty($_GET['id'])) {

        header("Location:../show.php?day=$date");
    }

$meal = Meal::find_by_id($_GET['id']);

if($meal) {

    $session->message("The {$meal->name} has been deleted");
    $meal->delete();
    header("Location:../show.php?day=$date");

} else {

    header("Location:../show.php?day=$date");
}


?>