<?php
include("includes/header.php");
include("includes/navbar.php");

$calendar = new Calendar;
$user = User::find_by_id($user_id);

$month = date('m') < 10 ? substr(date('m'), 1) : date('m');

if(isset($_GET['ym'])) {
    $month = substr($_GET['ym'], -2);
    if($month < 10) {
        $month = substr($month, 1);
    }
}

//グラフ用の月
$for_graph_month = isset($_GET['ym']) ? $_GET['ym'] : date('Y/m');
//１か月の日数
$month_day_count = $calendar->day_count;

//体重データの有無の確認
$sql = "SELECT * FROM weights WHERE user_id = $user_id AND date  LIKE '%$calendar->this_month%'";
$check_month_weight = $database->query($sql);
//体重の変数作成
$weight = 0;

//日数ごとにデータを抽出
for ($day = 1; $day <= $month_day_count; $day++) {
    if(strlen($day)==1) {
        $dday = '0'.$day;
    } else {
        $dday = $day;
    }
    //グラフ用の月と日付
    $for_graph_labels[] = "'".$for_graph_month ."/". $dday."'";
    //日ごとの全カロリーを抽出後、合計
    $meal = $database->query("SELECT * FROM meal WHERE user_id = $user->id AND date = '$calendar->this_month/$dday'");
    $sum_calorie = 0;

    while($row = mysqli_fetch_array($meal)) {    
        $sum_calorie += $row['calorie'];
    }
   
    $day_sum_calorie_total[] = $sum_calorie;
    $max_calorie = max($day_sum_calorie_total);
    $month_day_sum_calorie[] = "'".$sum_calorie."'";

   if(mysqli_num_rows($check_month_weight) > 0) {
        $sql = "SELECT * FROM weights WHERE user_id = $user_id AND date  = '$calendar->this_month/$dday'";
        $select_weight = $database->query($sql);
        while($row = mysqli_fetch_array($select_weight)) {    
            $weight= $row['weight'];
        }
    }
   $all_day_weights[] = $weight;
}

 $all_day_weights_string = implode( ",", $all_day_weights);
 $max_weight = max($all_day_weights);

$month_day_sum_calorie = implode( ",", $month_day_sum_calorie);
$for_graph_labels = implode( ",", $for_graph_labels);


//1ヶ月のカロリー合計算出
$sql = "SELECT * FROM meal WHERE user_id = $user_id AND date LIKE '%$calendar->ym%'";
$invest_months_calorie = $database->query($sql);
$montsh_sum_calorie = 0;
while($row = mysqli_fetch_array($invest_months_calorie)) {
    // $for_graph_calorie[] = "'".$$row['calorie']."'";
    $montsh_sum_calorie += (int)$row['calorie'];
}

//カロリー記入チェックを月ごとに抽出
$sql = "SELECT COUNT(*) FROM point WHERE user_id = $user_id AND date LIKE '%$calendar->ym%'";
$invest_months_point = $database->query($sql);
$all_points = 0;
$row = mysqli_fetch_array($invest_months_point);
$all_points = array_shift($row);

//1日に3ポイントあるので、それを割ることでレコードした日にちを抽出
$record_days = $all_points /3;
//記録のない日を数える
$no_record_days = $month_day_count-$record_days;
//ペナルティーのカロリー
$penalty_calorie = $user->nomal_intake_calorie + 300;
//レコードしていない合計カロリー
$no_record_day_calories = $no_record_days * $penalty_calorie;
//すべての合計カロリー
$month_total_calorie = $montsh_sum_calorie + $no_record_day_calories;
//普通の摂取カロリーの1か月合計
$month_nomal_intake_sum = $user->nomal_intake_calorie * $month_day_count;
//１か月間のカロリー差分
$month_calorie_diff = $month_nomal_intake_sum - $month_total_calorie;
 //月の目標カロリーの合計
$month_goal_calorie_sum = $user->goal_intake_calorie * $month_day_count;

$fat = 7200;
//カロリー差分を体重差分に
$month_total_calorie_diff = $month_calorie_diff/$fat;
$month_total_weight = round($month_total_calorie_diff,1);
if($month_total_weight > 0) {
    $text = "キロ痩せられる目安になります。";
} else {
    $month_total_weight = substr($month_total_weight, 1);
    $text = "キロ太る目安になります。";
}

?>

<div class="container">

<h3><a href="?ym=<?php echo $calendar->prev; ?>">&lt;</a> <?php echo $calendar->html_title; ?> <a href="?ym=<?php echo $calendar->next; ?>">&gt;</a></h3>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

    <canvas id="myChart"></canvas>
    <script type="text/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: ['2018/01/01', '2018/01/02', '2018/01/03', '2018/01/04', '2018/01/05', '2018/01/06', '2018/01/07'],
                labels: [<?php echo $for_graph_labels; ?>],
                datasets: [{
                    label: '体重',
                    type: "line",
                    fill: false,
                    data: [<?php echo $all_day_weights_string ?>],
                    borderColor: "rgb(154, 162, 235)",
                    yAxisID: "y-axis-1",
                }, {
                //     label: '折れ線B',
                //     type: "line",
                //     fill: false,
                //     data: [8000, 9000, 10000, 9000, 6000, 8000, 7000],
                //     borderColor: "rgb(54, 162, 235)",
                //     yAxisID: "y-axis-1",
                // }, {
                    label: 'カロリー',
                    data: [<?php echo $month_day_sum_calorie ?>],
                    borderColor: "rgb(255, 99, 132)",
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    yAxisID: "y-axis-2",
                }]
            },
            options: {
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        id: "y-axis-1",
                        type: "linear",
                        position: "left",
                        ticks: {
                            max: <?php echo $max_weight ?>,
                            min: <?php echo $user->goal_weight; ?>,
                            stepSize: 0.1
                        },
                    }, {
                        id: "y-axis-2",
                        type: "linear",
                        position: "right",
                        ticks: {
                            max: <?php echo $max_calorie ?>,
                            min: 0,
                            stepSize: 10
                        },
                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }],
                },
            }
        });

    </script>
       
<!-- 
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h1>Your Status</h1>
            </div>
                <div class="card-body">
                    <h3 class="text-center">目標 総摂取カロリー</h3>
                        <h4 class="text-center"><?php echo $month_goal_calorie_sum; ?> カロリー</h4>
                   <hr>
                    <h3 class="text-center">総記録カロリー</h3>
                    <h4 class="text-center"><?php echo $montsh_sum_calorie; ?> カロリー</h4>
                    <hr>
                    <h3 class="text-center">確認できない日数</h3>
                    <h4 class="text-center"><?php echo $no_record_days; ?>日</h4>
                    <p>※確認できない日数は１日の消費カロリー+300とカウントします。</p>
                    <hr>
                    <h3 class="text-center"><?php echo $month; ?>月の総カロリー</h3>
                    <h4 class="text-center"><?php echo $month_total_calorie; ?> カロリー</h4>
                    <hr>
                        <p class="text-center">１キロの脂肪は7200カロリーのため、<br>
                                                1ヶ月間の結果<br>
                                               <?php echo $month_total_weight.$text; ?></p>
                </div>
        </div>
    </div> -->
    <a href="index.php"><h4 class="btn btn-primary ">Back</h4></a>
    <!-- <a href="edit_goal.php?id=<?php echo $user->id; ?>"><h4 class="btn btn-primary  float-right">Edit</h4></a> -->

</div>