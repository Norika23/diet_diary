<?php

class Calendar extends Db_object{

    public $ym;
    public $timestamp;
    public $today;
    public $prev;
    public $next;
    public $this_month;
    public $html_title;
    public $day_count;
    public $youbi;

    public function __construct() {

        // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            // 今月の年月を表示
            $ym = date('Y/m');
        }
        $this->ym = $ym;

        // タイムスタンプを作成し、フォーマットをチェックする
        $this->timestamp = strtotime($this->ym . '/01');
        if ($this->timestamp === false) {
            $this->ym = date('Y/m');
            $this->timestamp = strtotime($this->ym . '/01');
        }

        // 今日の日付 フォーマット　例）2018/07/3
        $this->today = date('Y/m/j', time());

        // カレンダーのタイトルを作成　例）2017年7月
        $this->html_title = date('Y年n月', $this->timestamp);

        // 前月・次月の年月を取得
        // 方法１：mktimeを使う mktime(hour,minute,second,month,day,year)
        $this->prev = date('Y/m', mktime(0, 0, 0, date('m', $this->timestamp)-1, 1, date('Y', $this->timestamp)));
        $this->next = date('Y/m', mktime(0, 0, 0, date('m', $this->timestamp)+1, 1, date('Y', $this->timestamp)));
        $this->this_month = date('Y/m', mktime(0, 0, 0, date('m', $this->timestamp), 1, date('Y', $this->timestamp)));

        // 該当月の日数を取得
        $this->day_count = date('t', $this->timestamp);

        // １日が何曜日か　0:日 1:月 2:火 ... 6:土
        // 方法１：mktimeを使う
        $this->youbi = date('w', mktime(0, 0, 0, date('m', $this->timestamp), 1, date('Y', $this->timestamp)));
    }




} // End of Class Meal



?>