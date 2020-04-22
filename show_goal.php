<?php
include("includes/header.php");
include("includes/navbar.php");

if(isset($_SESSION['user_id'])){
    $user = User::find_by_id($_SESSION['user_id']);
} else {
    $user = User::find_by_id(1);
}

?>

    <div class="show-container">
        <h1 class="text-center">Your Goal</h1>
        <div class="m-5">
                
            <h3 class="text-center">目標摂取カロリー</h3>
                <h4 class="text-center"><?php echo $user->goal_intake_calorie; ?> カロリー</h4>
                    <br>
            <h3 class="text-center">１日の消費カロリー</h3>
                <h4 class="text-center"><?php echo $user->nomal_intake_calorie; ?> カロリー</h4>
                     <br>
            <?php 
                $diet_calorie = $user->nomal_intake_calorie-$user->goal_intake_calorie;
                $month_diet_calorie = $diet_calorie*30;
                $fat = 7200;
                $month_losing_weight = $month_diet_calorie/$fat;
                round($month_losing_weight,1);
            ?>

            <p class="text-center">１キロの脂肪は7200カロリーのため、<br>
            1ヶ月(30日)このペースで続けると<br>
            約<?php echo round($month_losing_weight,1) ?>キロ痩せられます。</p>

        </div>
        <a href="index.php"><h4 class="btn btn-primary ml-3">Back</h4></a>
        <a href="edit_goal.php?id=<?php echo $user->id; ?>"><h4 class="btn btn-primary  float-right">Edit</h4></a>
    </div>




<!-- </div> -->
