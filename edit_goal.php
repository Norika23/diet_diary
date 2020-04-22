<?php
include("includes/header.php");
include("includes/navbar.php");

$user = User::find_by_id($_GET['id']);

 if(isset($_POST['submit'])) {

    $user->id = $_GET['id'] ;
    $user->nomal_intake_calorie = $_POST['nomal_intake_calorie'];
    $user->goal_intake_calorie = $_POST['goal_intake_calorie'];

    $user->update();
    header("Location:show_goal.php");
}
?>

<div class="container ">
    <div class="input-container">
        <h1 class="text-center m-3">Set your Goal</h1>
        <div class="col-md-12">
            <form method="post" action="">
                <div class="form-group">
                    <label for="calorie">Goal Intake Calorie</label>
                    <input type="text" class="form-control" name="goal_intake_calorie" placeholder="目標摂取カロリー" value="<?php echo $user->goal_intake_calorie; ?>" >
                </div>
                <div class="form-group center-block">
                    <label for="name">Nomal Intake Calorie</label>
                    <input type="text" class="form-control" name="nomal_intake_calorie" placeholder="標準摂取カロリー" value="<?php echo $user->nomal_intake_calorie; ?>" >
                </div>
                <button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
            </form>
        </div>
    </div>
</div>