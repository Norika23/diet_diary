<?php
include("includes/header.php");
include("includes/navbar.php");

$user = new User;
$users = User::find_by_id($user_id);

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $error = [
            'username'=>'',
            'email' => ''
        ];

        if($users->username != $_POST['username']) {
            if($user->username_exists($_POST['username'])) {
                $error['username'] = 'Username already exists, pick another one ';
            }
        }

        if($users->email != $_POST['email']) {
            echo "work";
            if($user->email_exists($_POST['email'])) {
                $error['email'] = 'Email already exists, pick another one ';
            }
        }


        $user->id = $user_id;
        $user->username = $_POST['username'];
        $user->email = $_POST['email'];
        $user->gender = $_POST['gender'];
        $user->birth_year = $_POST['birth_year'];
        $user->birth_month = $_POST['birth_month'];
        $user->birth_day = $_POST['birth_day'];
        $user->height = $_POST['height'];
        $user->start_weight = $_POST['start_weight'];
        $user->activity_level = $_POST['activity_level'];
        $user->goal_weight = $_POST['goal_weight'];
        $user->goal_intake_calorie = $_POST['goal_intake_calorie'];

        $currentDate = date('Y/m/d');
        $birthday = $user->birth_year.'/'.$user->birth_month.'/'.$user->birth_day;
        $c = (int)date('Ymd', strtotime($currentDate));
        $b = (int)date('Ymd', strtotime($birthday));
        $user->age = (int)(($c - $b) / 10000);

        if($user->gender == "man") {
            $user->basal_metabolic_rate = 13.397*$users->current_weight+4.799*$user->height-5.677*$user->age+88.362;
        } elseif($user->gender == "woman") {
            $user->basal_metabolic_rate = 9.247*$users->current_weight+3.098*$user->height-4.33*$user->age+447.593;
        }

       $user->nomal_intake_calorie = $user->activity_level*$user->basal_metabolic_rate;


       if($user->username == '') {
        $error['username'] = 'Username cannot be empty';
        }

        if($user->email == '') {
            $error['email'] = 'Email cannot be empty';
        }


        foreach ($error as $key => $value) {
            if(empty($value)) {
                unset($error[$key]);
            }
        }

        if(empty($error)) {
            $user->edit_user();
        }
        
    } 

    $users = User::find_by_id($user_id);
    $year = 0;
    $month = 0;
    $day = 0;
    $height = 0;
    $weight = 0;
    $goal_weight = 0;

    for ($i=1920; $i <= 2020; $i++) {
        if($i == $users->birth_year){
            $year .= '<option value="'.$i.'" selected>'.$i.'年</option>';
        }else{
            $year .= '<option value="'.$i.'">'.$i.'年</option>';
        }
    }

    for ($i=1; $i <= 12; $i++) {
        if($i == $users->birth_month) {
            $month .= '<option value="'.$i.'" selected>'.$i.'月</option>';
        } else{
            $month .= '<option value="'.$i.'">'.$i.'月</option>';
        }
    }

    for ($i=1; $i <= 31; $i++) {
        if($i == $users->birth_day) {
            $day .= '<option value="'.$i.'" selected>'.$i.'日</option>';
        }else {
            $day .= '<option value="'.$i.'">'.$i.'日</option>';
        }
    }

    for ($i=0; $i <= 250; $i++) {
        if($i == $users->height){
            $height .= '<option value="'.$i.'" selected>'.$i.'cm</option>';
        }else{
            $height .= '<option value="'.$i.'">'.$i.'cm</option>';
        }
    }

    for ($i=0; $i <= 250; $i++) {
        if($i == $users->start_weight){
            $weight .= '<option value="'.$i.'" selected>'.$i.'kg</option>';
        }else{
            $weight .= '<option value="'.$i.'">'.$i.'kg</option>';
        }
    }

    for ($i=0; $i <= 250; $i++) {
        if($i == $users->goal_weight){
            $goal_weight .= '<option value="'.$i.'" selected>'.$i.'kg</option>';
        }else{
            $goal_weight .= '<option value="'.$i.'">'.$i.'kg</option>';
        }
    }

    $checked_woman = "";
    $checked_man = "";
if($user->gender == "man") {
    $checked_man = "checked";
} else {
    $checked_woman = "checked";
}

$selected_level_1 = "";
$selected_level_2 = "";
$selected_level_3 = "";
$selected_level_4 = "";
$selected_level_5 = "";

if($users->activity_level == 1.2) {
    $selected_level_1 = "selected";
}elseif($users->activity_level == 1.375){
    $selected_level_2 = "selected";
}elseif($users->activity_level == 1.55){
    $selected_level_3 = "selected";
}elseif($users->activity_level == 1.725){
    $selected_level_4 = "selected";
}elseif($users->activity_level == 1.9){
    $selected_level_5 = "selected";
}


?>


<div class="row justify-content-center">
    <div class="col-md-3 col-md-offset-3">
        <h1 class="text-center m-5">プロフィールの編集</h1>
        <form role="form" action="edit_profile.php" method="post" id="login-form" autocomplete="off">

            <div class="form-group">ユーザーネーム
                <label for="username" class="sr-only">username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="ユーザーネームを入力" aocomplete="on" value="<?php echo $users->username; ?>">
                <h4 class="bg-warning"><?php echo isset($error['username']) ? $error['username'] : '' ?></p></h4>
            </div>

            <div class="form-group">メールアドレス
                <label for="email" class="sr-only">email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="メールアドレスを入力" autocomplete="on" value="<?php echo $users->email; ?>">
                <h4 class="bg-warning"><?php echo isset($error['email']) ? $error['email'] : '' ?></p></h4>
            </div>

            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="woman" <?php echo $checked_woman; ?>>
                    <label class="form-check-label" for="inlineRadio1" >女性</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="man" <?php echo $checked_man; ?>>
                    <label class="form-check-label" for="inlineRadio2">男性</label>
                </div>
            </div>

            生年月日
            <div class="form-inline">
                <select class="form-control" name="birth_year"><?php echo $year; ?></select>
                <select class="form-control" name="birth_month"><?php echo $month; ?></select>
                <select class="form-control" name="birth_day"><?php echo $day; ?></select>
            </div>

            身長・始めた時の体重
            <div class="form-inline">
                <select class="form-control" name="height"><?php echo $height; ?></select>
                <select class="form-control" name="start_weight"><?php echo $weight; ?></select>
            </div>

            活動レベル
            <div class="form-inline">
                <select class="form-control" id="activity_level" name="activity_level">
                    <option name="activity_level" value="1.2" <?php echo $selected_level_1; ?>>運動しない・又はデスクワーク</option>
                    <option name="activity_level" value="1.375" <?php echo $selected_level_2; ?>>軽い運動・又はデスクワーク＋立ち仕事もあり</option>
                    <option name="activity_level" value="1.55" <?php echo $selected_level_3; ?>>中程度の運動・又は基本立ち仕事など動く</option>
                    <option name="activity_level" value="1.725" <?php echo $selected_level_4; ?>>激しい運動・又は重労働</option>
                    <option name="activity_level" value="1.9" <?php echo $selected_level_5; ?>>アスリート並みの運動</option>
                </select>
            </div>

            目標体重
            <div class="form-inline">
                <select class="form-control" name="goal_weight"><?php echo $goal_weight; ?></select>
            </div>

            <div class="form-group">目標摂取カロリー
                <label for="username" class="sr-only">username</label>
                <input type="text" name="goal_intake_calorie" id="username" class="form-control" placeholder="カロリーを入力" aocomplete="on" value="<?php echo $users->goal_intake_calorie; ?>">
            </div>

            <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="編集">
        </form>
    </div> 
</div> 
