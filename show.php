<?php
include("includes/header.php");
include("includes/navbar.php");

$meal = new Meal();
$point = new Point();
$date = $database->escape_string($_GET['day']);

if(!isset($_GET['day'])) {
    header("Location: index.php");
}

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 1;
}

if(isset($_POST['check'])) {
    Point::insert_point_day($user_id);
}



if(isset($_POST['input'])) {

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
                
                <button name="input" type="submit" class="btn btn-primary float-right">Submit</button>
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
        <h2 class="text-center">Check your day</h2>
        <form action="" method="post">
            <div class="form-check ml-5">
            <?php
            $status1 = "";
                $sql = "SELECT * FROM point WHERE user_id = ".$user_id ." AND date =  '" .$date. "'";
                $select_point = $database->query($sql);
                   if(mysqli_num_rows($select_point) > 0){
                        $submit_disabled = "disabled";
                        while($row = mysqli_fetch_assoc($select_point)){

                            $point_type = $row['point_type'];
                            $point_value = $row['point_value'];
                            if($point_type == 'point_type1' && $point_value == 30) {
                                $status1 = "checked";
                            } elseif($point_type == 'point_type1' && $point_value == 0) {
                                $status1 = "";
                            }
                            if($point_type == 'point_type2' && $point_value == 30) {
                                $status2 = "checked";
                            }  elseif($point_type == 'point_type2' && $point_value == 0) {
                                $status2 = "";
                            }
                            if($point_type == 'point_type3' && $point_value == 30) {
                                $status3 = "checked";
                            }  elseif($point_type == 'point_type3' && $point_value == 0) {
                                $status3 = "";
                            }
                        }
                   } else {
                    $status1 = "";
                    $status2 = "";
                    $status3 = "";
                }
            ?>
            <h5><input class="form-check-input" type="checkbox" name="point_type1" value="point_type1" id="defaultCheck1" <?php echo $status1 ?> >
                <input type="hidden" name="point_type1_value" value="30">
                    <label class="form-check-label" for="defaultCheck1">
                    食べたものすべて記入しましたか。
                    </label></h5>
            </div>
            <div class="form-check ml-5">
            <h5><input class="form-check-input" type="checkbox" name="point_type2"  value="point_type2" id="defaultCheck2" <?php echo $status2; ?> >
                    <input type="hidden" name="point_type2_value" value="30">
                    <label class="form-check-label" for="defaultCheck2">
                    
                    正確に調べたカロリーを記入しましたか。
                    </label></h5>
            </div>
            <div class="form-check ml-5">
                <h5><input class="form-check-input" type="checkbox" name="point_type3"  value="point_type3" id="defaultCheck3" <?php echo $status3; ?> >
                    <input type="hidden" name="point_type3_value" value="30">
                    <label class="form-check-label" for="defaultCheck3">
                    目標カロリーを守りましたか。
                    </label></h5>
            </div>
            <button name="check" type="submit" class="btn btn-primary float-right" <?php echo $submit_disabled ?>>Submit</button>
        </form>
    </div>
</div>
