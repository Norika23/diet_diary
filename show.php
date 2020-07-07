<?php
include("includes/header.php");
include("includes/navbar.php");

// $session_id = "";
// $session_id = $_SESSION['user_id'];
$session_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
$weight = new Weight();
$meal = new Meal();

$date = $database->escape_string($_GET['day']);

echo $weight->id;

if(!isset($_GET['day'])) {
    header("Location: index.php");
}

if(isset($_POST['check'])) {
   
    Point::point_save($user_id);
}

$submit_disabled = "";

if(isset($_POST['input'])) {

    if($session->is_signed_in()) {
        $_POST['calorie'] = mb_convert_kana($_POST['calorie'], "n");
        $meal->name = $_POST['name'];
        $meal->calorie = $_POST['calorie'];
        $meal->date = $date;
        $meal->user_id = $user_id;
        $meal->create();
    } 

} 

$user_weight = Weight::find_by_user_id_and_date($user_id,$date);
if(isset($user_weight->id)) {
    $user_weight_id = $user_weight->id;
} else {
    $user_weight_id ="";
}

if(isset($_POST['weight'])) {

    $_POST['weight'] = mb_convert_kana($_POST['weight'], "n");
    if($user_weight_id>1) {
        $weight->id = $user_weight_id;
    }

    $weight->weight = $_POST['weight'];
    $weight->user_id = $user_id;
    $weight->date = $date;
    $weight->save();
}

$user_weight = Weight::find_by_user_id_and_date($user_id,$date);
if(isset($user_weight->weight)) {
    $date_weight=$user_weight->weight;
} else {
    $date_weight = "";
}

// if($_SERVER["REQUEST_METHOD"] = "POST") {
    
//     if($session->is_signed_in()) {

//     }

//  }

?>

<div class="container ">
<!-- <div class="row"> -->
    <div class="float-right"><a class="text-dark" href="add_diary.php?day=<?php echo $date; ?>">日記
        <svg class="bi bi-pencil float-right ml-2 mt-1 " style="cursor: pointer" data-toggle="modal" data-target="#exampleModal" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
        </svg></a>
    </div><br>
    <!-- <div class="input-container"> -->
  
        <h1 class="text-center">食べたものを入力</h1>
        <div class="col-lg-6 mx-auto">
            <form method="post" name="input" action="">
                <div class="form-group center-block">
                    <label for="name">Food Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="name" required>
                </div>
                <div class="form-group">
                    <label for="calorie">Calorie</label>
                    <input type="text" class="form-control" name="calorie" id="calorie" placeholder="calorie">
                </div>
                <button name="input" type="submit" class="btn btn-primary float-right login" data-user_id="<?php echo $session_id; ?>">Submit</button>
                <!-- <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Launch demo modal
                </button> -->
            </form>
        <!-- </div> -->
    <!-- </div> -->
    <!-- <div class="show-container"> -->
    <br>
        <h1 class="text-center">1日食べたもの</h1>
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
                       
                        <a class="text-dark" href="edit_show.php?day=<?php echo $_GET['day']; ?>&meal_id=<?php echo $show_meal->id; ?>">
            <svg class="bi bi-pencil float-right ml-2 mt-1 " style="cursor: pointer" data-toggle="modal" data-target="#exampleModal" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
            </svg>
            </a>

       
                        <div class="float-right"><?php echo $show_meal->calorie; ?> カロリー</div>
                        <hr>

                </ul>
            <?php } 
                $back_month = substr($_GET['day'], 0, 7);
            ?>
            <a href="index.php?ym=<?php echo $back_month ?>"><h4 class="btn btn-primary ml-3">Back</h4></a>

            <div class="float-right">合計　<?php echo $sum_calorie; ?> カロリー</div> 
        </div>
        <h2 class="text-center">１日の確認</h2>
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
            <button name="check" type="submit" class="btn btn-primary float-right login" <?php //echo $submit_disabled ?>>Submit</button>
        </form>
    <!-- </div> -->
<br>
    <!-- <div class="input-container"> -->
        <h3 class="m-3 text-center">体重を記入</h3>
            <div class="form-inline offset-4">   
                <form method="post" name="input_weight" action="">
                    <input type="text" class="form-control col-4" name="weight" placeholder="体重" required value="<?php echo $date_weight; ?>">
                    <button name="input_weight" type="submit" class="btn btn-primary login">Submit</button>
                </form>
                <label for="name">記入例）59.1</label>
            </div>
    </div>
    
    <div class="popupTweet"></div>

</div>

<div class="container">
        <form action="＃" method="get" class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <label for="name"><span class="label label-danger">必須</span> お名前</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="例：ジャングル オーシャン" autofocus required>
                </div>
                <div class="form-group">
                    <label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="例：raffaello@jungleocean.com" required>
                </div>
                <div class="form-group">
                    <label for="tel"><span class="label label-danger">必須</span> 電話番号</label>
                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="例：080-1234-5678" required>
                </div>
                <button type="submit" class="btn btn-primary">送信する</button>
            </div>
        </form>
    </div>

<!-- end container -->
<script type="text/javascript" src="assets/js/login_modal.js"></script>
<?php

include("includes/footer.php");

?>
