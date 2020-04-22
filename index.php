<?php
include("includes/header.php");
include("includes/navbar.php");

if(isset($_SESSION['user_id'])){
    $user = User::find_by_id($_SESSION['user_id']);
} else {
    $user = User::find_by_id(1);
}

// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // 今月の年月を表示
    $ym = date('Y-m');
}

// タイムスタンプを作成し、フォーマットをチェックする
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// 今日の日付 フォーマット　例）2018-07-3
$today = date('Y-m-j', time());

// カレンダーのタイトルを作成　例）2017年7月
$html_title = date('Y年n月', $timestamp);

// 前月・次月の年月を取得
// 方法１：mktimeを使う mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
$this_month = date('Y-m', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

// 方法２：strtotimeを使う
// $prev = date('Y-m', strtotime('-1 month', $timestamp));
// $next = date('Y-m', strtotime('+1 month', $timestamp));

// 該当月の日数を取得
$day_count = date('t', $timestamp);

// １日が何曜日か　0:日 1:月 2:火 ... 6:土
// 方法１：mktimeを使う
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
// 方法２：strtotimeを使う
// $youbi = date('w', $timestamp);



// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
// 例）１日が水曜日だった場合、日曜日から火曜日の３つ分の空セルを追加する
$week .= str_repeat('<td></td>', $youbi);

for ( $day = 1; $day <= $day_count; $day++, $youbi++) {
    // $sql = "SELECT * FROM meal WHERE user_id = $user_id AND date = '$this_month-$day'";
    // $show_meals = Meal::find_by_query($sql);
    $meal = $database->query("SELECT * FROM meal WHERE user_id = $user->id AND date = '$this_month-$day'");
    $sum_calorie = 0;
    while($row = mysqli_fetch_array($meal)) {    
        $sum_calorie += $row['calorie'];
    }

    // 2017-07-3
    $date = $ym . '-' . $day;
   
    if ($today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= "<td class='today'><h4><a href='show.php?day=$this_month-$day'>" . $day;
    } else {

        if($sum_calorie > 500 + $user->nomal_intake_calorie) {
            $week .= '<td class="danger">';
        }elseif($sum_calorie > $user->nomal_intake_calorie && $sum_calorie < 500 + $user->nomal_intake_calorie) {
            $week .= '<td class="warning">';
        }elseif($sum_calorie < $user->goal_intake_calorie-1000) {
            $week .= '<td class="warning2">';
        }else{
            $week .= "<td>";
        }
        $week .= "<h4><a href=show.php?day=$this_month-$day>" . $day;

    }

    $week .= '</a></h4><p class="text-center">摂取カロリー<br><h5 class="text-center">'.$sum_calorie.'</h5></p></td>';

    // 週終わり、または、月終わりの場合
    if ($youbi % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // 月の最終日の場合、空セルを追加
            // 例）最終日が木曜日の場合、金・土曜日の空セルを追加
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }

        // week配列にtrを追加する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
	}
}
?>

<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <div class="card-group mb-3">
        <table class="table table-bordered">
            <tr class=>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div> </div>
</body>
</html>