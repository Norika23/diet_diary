<?php
include("includes/header.php");
include("includes/navbar.php");

$meal = new Meal();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 1;
}

$date = $database->escape_string($_GET['day']);
//$user_id = $_SESSION['user_id'];

 if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $meal->name = $_POST['name'];
    $meal->calorie = $_POST['calorie'];
    $meal->date = $date;
    $meal->user_id = $user_id;
    $meal->create();

}
?>

<div class="container ">
    <div class="input-container">
        <h1 class="text-center m-3">Put Your Food</h1>
        <div class="col-md-12">
            <form method="post" name="input" action="">
                <div class="form-group center-block">
                    <label for="name">Food Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="name" required >
                </div>
                <div class="form-group">
                    <label for="calorie">Calorie</label>
                    <input type="text" class="form-control" name="calorie" id="calorie" placeholder="calorie" >
                </div>
                
                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </form>
        </div>
    </div>
    <div class="show-container">
        <h1 class="text-center">What have you eaten</h1>
        <div class="m-5">
            <?php
                $sql = "SELECT * FROM meal WHERE user_id = $user_id AND date = '$date'";
                $show_meals = Meal::find_by_query($sql);
                $sum_calorie = 0;
                foreach($show_meals as $show_meal) {
                    $sum_calorie += $show_meal->calorie;
            ?>
                <ul>
                    <li><?php echo $show_meal->name; ?>
                    <a href="includes/delete_meal.php?day=<?php echo $date ?>&id=<?php echo $show_meal->id ?>" class="close ml-3"><span class="float-right" aria-hidden="true">&times;</span></a>
                        <div class="float-right"><?php echo $show_meal->calorie; ?> カロリー</div>
                        <hr>
                    </li>
                </ul>
            <?php } ?>
            <a href="index.php"><h4 class="btn btn-primary ml-3">Back</h4></a>
            <div class="float-right mr-4">合計　<?php echo $sum_calorie; ?> カロリー</div>
        </div>
    </div>
</div>
