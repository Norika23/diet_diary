<?php
include("includes/header.php");
include("includes/navbar.php");

    $date = $database->escape_string($_GET['day']);
    $meal = new Meal();

if(isset($_POST['edit'])) {
    $meal->id = $_POST['edit'];
    $meal->user_id = $user_id;
    $meal->name = $_POST['name'];
    $meal->calorie = $_POST['calorie'];
    $meal->date = $_GET['day'];
    $meal->update();
    header("Location:show.php?day=".$_GET['day']);

}

    $sql = "SELECT * FROM meal WHERE user_id = $user_id AND id = ".$_GET['meal_id'];
    $edit_meals = Meal::find_by_query($sql);
    foreach($edit_meals as $edit_meal) {

?>

<div class="show-container">

<div class="input-container">
        <h1 class="text-center m-3">食べたものを編集</h1>
        <div class="col-md-12">
            <form method="post" name="input" action="">
                <div class="form-group center-block">
                    <label for="name">Food Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="name" required value="<?php echo $edit_meal->name; ?>">
                </div>
                <div class="form-group">
                    <label for="calorie">Calorie</label>
                    <input type="text" class="form-control" name="calorie" id="calorie" placeholder="calorie" value="<?php echo $edit_meal->calorie; ?>">
                </div>
                <button name="edit" value="<?php echo $edit_meal->id; ?>" type="submit" class="btn btn-primary float-right">編集</button>
            </form>
        </div>
    </div>
<?php   }; ?>

</div>

