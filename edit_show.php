<?php
include("includes/header.php");
include("includes/navbar.php");

    $date = $database->escape_string($_GET['day']);
    $user_id = $_SESSION['user_id'];

?>

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
                    <a href="" class="close ml-4"><span class="float-right" aria-hidden="true">&times;</span></a>
                    <div class="float-right"><?php echo $show_meal->calorie; ?> カロリー</div>
                    <hr>
                </li>
            </ul>
        <?php } ?>
        <a href="edit_show.php"><h4 class="btn btn-primary m-2">Edit</h4></a>
        <div class="float-right">合計　<?php echo $sum_calorie; ?> カロリー</div>
        <a class="btn btn-danger" href="">&times;</a>

        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    </div>
</div>

