<?php
include("includes/header.php");
include("includes/navbar.php");

$users = User::find_by_id($user_id);

?>

<div class="row justify-content-center">
    <div class="col-4 col-md-offset-3">

        <table class="table table-hover">

                            <tbody>

                            <h2 class="text-center m-5">プロフィール</h2>

                                    <td>ユーザーネーム</td>
                                    <td><?php echo $users->username ?></td>
                                <tr>
                                    <td>メールアドレス</td>
                                    <td><?php echo $users->email ?></td>
                                </tr>
                                <tr>
                                    <td>性別</td>
                                    <td><?php echo $users->gender ?></td>
                                </tr>
                                <tr>
                                    <td>生年月日</td>
                                    <td><?php echo $users->birth_year ?>年
                                    <?php echo $users->birth_month ?>月
                                    <?php echo $users->birth_day ?>日
                                    </td>
                                </tr>
                                <tr>
                                    <td>身長</td>
                                    <td><?php echo $users->height ?>cm</td>
                                </tr>
                                <!-- <tr>
                                    <td>現在の体重</td>
                                    <td><?php //echo $users->current_weight ?>kg</td>
                                </tr> -->
                                <tr>
                                    <td>始めた時の体重</td>
                                    <td><?php echo $users->start_weight ?>kg</td>
                                </tr>
                                <tr>
                                    <td>活動レベル</td>
                                    <td><?php 
                                    
                                        if($users->activity_level == 1.2) {
                                            echo "運動しない・又はデスクワーク";
                                        }elseif($users->activity_level == 1.375) {
                                            echo "軽い運動・又は立ち仕事もあり";
                                        }elseif($users->activity_level == 1.55) {
                                            echo "中程度の運動・又は基本立ち仕事などで動く";
                                        }elseif($users->activity_level == 1.725) {
                                            echo "激しい運動・又は重労働";
                                        }elseif($users->activity_level == 1.9) {
                                            echo "アスリート並みの運動";
                                        }
                                     ?></td>
                                </tr>
                                <tr>
                                    <td>基礎代謝の目安</td>
                                    <td><?php echo $users->basal_metabolic_rate ?>cal</td>
                                </tr>
                                <tr>
                                    <td>一日の消費カロリーの目安</td>
                                    <td><?php echo $users->nomal_intake_calorie ?>cal</td>
                                </tr>
                                <tr>
                                    <td>１日の目標摂取カロリー</td>
                                    <td><?php echo $users->goal_intake_calorie ?>cal</td>
                                </tr>
                                <tr>
                                    <td>目標体重</td>
                                    <td><?php echo $users->goal_weight ?>kg</td>
                                </tr>
                            </tbody>

                        </table>

                        <a href="edit_profile.php"><h4 class="btn btn-primary float-right">編集</h4></a>