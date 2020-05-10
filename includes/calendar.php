<?php

class Calendar extends Db_object{

    public $ym;
    public $timestamp;
    public $prev;
    public $next;
    public $html_title;
    public $day_count;

    public function __construct() {

        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            $ym = date('Y/m');
        }
        $this->ym = $ym;

        $this->timestamp = strtotime($this->ym . '/01');
        if ($this->timestamp === false) {
            $this->ym = date('Y/m');
            $this->timestamp = strtotime($this->ym . '/01');
        }
        $this->html_title = date('Y年n月', $this->timestamp);
        $this->prev = date('Y/m', mktime(0, 0, 0, date('m', $this->timestamp)-1, 1, date('Y', $this->timestamp)));
        $this->next = date('Y/m', mktime(0, 0, 0, date('m', $this->timestamp)+1, 1, date('Y', $this->timestamp)));
        $this->this_month = date('Y/m', mktime(0, 0, 0, date('m', $this->timestamp), 1, date('Y', $this->timestamp)));

        $this->day_count = date('t', $this->timestamp);

    }




} // End of Class Meal



?>