<?php
ini_set('display_errors', "On");

include("includes/header.php");
include("includes/navbar.php");

$user = User::find_by_id($user_id);
$calendar = new Calendar;
// タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

// カレンダー作成の準備
$weeks = [];
$week = '';

// 第１週目：空のセルを追加
// 例）１日が水曜日だった場合、日曜日から火曜日の３つ分の空セルを追加する
$week .= str_repeat('<td></td>', $calendar->youbi);

for ( $day = 1; $day <= $calendar->day_count; $day++, $calendar->youbi++) {
    if(strlen($day)==1) {
        $dday = '0'.$day;
    } else {
        $dday = $day;
    }

    $meal = $database->query("SELECT * FROM meal WHERE user_id = $user->id AND date = '$calendar->this_month/$dday'");
    $sum_calorie = 0;
    while($row = mysqli_fetch_array($meal)) {    
        $sum_calorie += $row['calorie'];
    }

    // 2017-07-3
    $date = $calendar->ym . '/' . $day;
   
    if ($calendar->today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= "<td class='today'><h4><a href='show.php?day=$calendar->this_month/$dday'>" . $day;
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
        $week .= "<h4><a href=show.php?day=$calendar->this_month/$dday>" . $day;

    }

    $week .= '</a></h4><p class="text-center none">摂取カロリー<br><div class="text-center">'.$sum_calorie.'</div></p></td>';

    // 週終わり、または、月終わりの場合
    if ($calendar->youbi % 7 == 6 || $day == $calendar->day_count) {

        if ($day == $calendar->day_count) {
            // 月の最終日の場合、空セルを追加
            // 例）最終日が木曜日の場合、金・土曜日の空セルを追加
            $week .= str_repeat('<td></td>', 6 - ($calendar->youbi % 7));
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

    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
  マニュアル
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">使い方<br></h5>
   
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
      <div class="modal-body">
      <p>※ 痩せるためには、変動しやすい体重ではなく、<br>カロリーでコントロールする方が効果的です。</p>
        <ol>
            <li>毎日食べたものを全て記入する</li>
            <li>食べたもののカロリーを記入する</li>
            <li>一日の摂取カロリーを決める</li>
            <li>ひたすら続ける</li>
            <li>食事制限は頑張りすぎない</li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

        <h3><a href="?ym=<?php echo $calendar->prev; ?>">&lt;</a> <?php echo $calendar->html_title; ?> <a href="?ym=<?php echo $calendar->next; ?>">&gt;</a></h3>
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
    </div> 
</div>


</body>
</html>

<?php
include("includes/footer.php");
?>