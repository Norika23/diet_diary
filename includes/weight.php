<?php

class Weight extends Db_object{

    protected static $db_table = "weights";
    protected static $db_table_fields = array('user_id','weight','date');
    public $id;
    public $user_id;
    public $weight;
    public $date;


    public static function find_by_user_id_and_date($user_id,$date) {

        global $database;

        $the_result_array = static::find_by_query("SELECT * FROM  " . static::$db_table . " WHERE user_id = $user_id and date ='$date' LIMIT 1");

        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }




} // End of Class Meal



?>