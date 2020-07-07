<?php
include("includes/header.php");
include("includes/navbar.php");

$user = new User;

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $birth_year = $_POST['birth_year'];
        $birth_month = $_POST['birth_month'];
        $birth_day = $_POST['birth_day'];
        $height = $_POST['height'];
        $start_weight = $_POST['start_weight'];
        $current_weight = $_POST['start_weight'];
        $activity_level = $_POST['activity_level'];
        $goal_weight = $_POST['goal_weight'];

        $currentDate = date('Y/m/d');
        $birthday = $birth_year.'/'.$birth_month.'/'.$birth_day;
        $c = (int)date('Ymd', strtotime($currentDate));
        $b = (int)date('Ymd', strtotime($birthday));
        $age = (int)(($c - $b) / 10000);

        if($gender == "man") {
            $basal_metabolic_rate = 13.397*$start_weight+4.799*$height-5.677*$age+88.362;
        } elseif($gender == "woman") {
            $basal_metabolic_rate = 9.247*$start_weight+3.098*$height-4.33*$age+447.593;
        }

       $nomal_intake_calorie = $activity_level*$basal_metabolic_rate;

         
        $error = [
            'username'=>'',
            'password'=>'',
            'email' => ''
        ];

        if($username == '') {
            $error['username'] = 'Username cannot be empty';
        }

        if($email == '') {
            $error['email'] = 'Email cannot be empty';
        }

        if($user->username_exists($username)) {
            $error['username'] = 'Username already exists, pick another one ';
        }

        if($user->email_exists($email)) {
            $error['email'] = 'Email already exists, pick another one ';
        }

        if($password == '') {
            $error['password'] = 'password cannot be empty';
        }

        foreach ($error as $key => $value) {
            if(empty($value)) {
                unset($error[$key]);
            }
        }

        if(empty($error)) {
            $user->register_user($username,$password,$email,$gender,$age,$birth_year,$birth_month,$birth_day,$start_weight,$current_weight,
            $goal_weight,$height,$activity_level,$nomal_intake_calorie,$basal_metabolic_rate);
            $user_found = User::verify_user($username, $password);
            if($user_found) {
                $session->login($user_found);
                header("Location: index.php");
            } 
        }
    } 

    $year = 0;
    $month = 0;
    $day = 0;
    $height = 0;
    $weight = 0;

    for ($i=1920; $i <= 2020; $i++) {
        if($i == 1990){
            $year .= '<option value="'.$i.'" selected>'.$i.'年</option>';
        }else{
            $year .= '<option value="'.$i.'">'.$i.'年</option>';
        }
    }

    for ($i=1; $i <= 12; $i++) {
            $month .= '<option value="'.$i.'">'.$i.'月</option>';
    }

    for ($i=1; $i <= 31; $i++) {
            $day .= '<option value="'.$i.'">'.$i.'日</option>';
    }

    for ($i=0; $i <= 250; $i++) {
        if($i == 165){
            $height .= '<option value="'.$i.'" selected>'.$i.'cm</option>';
        }else{
            $height .= '<option value="'.$i.'">'.$i.'cm</option>';
        }
    }

    for ($i=0; $i <= 250; $i++) {
        if($i == 65){
            $weight .= '<option value="'.$i.'" selected>'.$i.'kg</option>';
        }else{
            $weight .= '<option value="'.$i.'">'.$i.'kg</option>';
        }
    }


?>

<div class="row justify-content-center">
    <div class="col-md-3 col-md-offset-3">
        <h1 class="text-center m-5">新規登録</h1>
        <form role="form" action="register.php" method="post" id="login-form" autocomplete="off">

            <div class="form-group">ユーザーネーム
                <label for="username" class="sr-only">username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="ユーザーネームを入力" aocomplete="on">
                <h4 class="bg-warning"><?php echo isset($error['username']) ? $error['username'] : '' ?></p></h4>
            </div>

            <div class="form-group">メールアドレス
                <label for="email" class="sr-only">email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="メールアドレスを入力" autocomplete="on">
                <h4 class="bg-warning"><?php echo isset($error['email']) ? $error['email'] : '' ?></p></h4>
            </div>

            <div class="form-group">パスワード
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="key" class="form-control" placeholder="パスワードを入力">
                <h4 class="bg-warning"><?php echo isset($error['password']) ? $error['password'] : '' ?></p></h4>
            </div>

            <div class="form-group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="woman" checked>
                    <label class="form-check-label" for="inlineRadio1" >女性</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="man">
                    <label class="form-check-label" for="inlineRadio2">男性</label>
                </div>
            </div>

            生年月日
            <div class="form-inline">
                <select class="form-control" name="birth_year"><?php echo $year; ?></select>
                <select class="form-control" name="birth_month"><?php echo $month; ?></select>
                <select class="form-control" name="birth_day"><?php echo $day; ?></select>
            </div>

            身長・体重
            <div class="form-inline">
                <select class="form-control" name="height"><?php echo $height; ?></select>
                <select class="form-control" name="start_weight"><?php echo $weight; ?></select>
            </div>

            活動レベル
            <div class="form-inline">
                <select class="form-control" name="activity_level">
                    <option name="activity_level" value="1.2">運動しない・又はデスクワーク</option>
                    <option name="activity_level" value="1.375">軽い運動・又は立ち仕事もあり</option>
                    <option name="activity_level" value="1.55">中程度の運動・又は基本立ち仕事など動く</option>
                    <option name="activity_level" value="1.725">激しい運動・又は重労働</option>
                    <option name="activity_level" value="1.9">アスリート並みの運動</option>
                </select>
            </div>

            目標体重
            <div class="form-inline">
                <select class="form-control" name="goal_weight"><?php echo $weight; ?></select>
            </div>

            <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="登録">
        </form>
    </div> 
</div> 
