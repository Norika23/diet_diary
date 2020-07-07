<?php

class Point extends Db_object{

    protected static $db_table = "point";
    protected static $db_table_fields = array('user_id','date','point_type','point_value');
    public $id;
    public $user_id;
    public $date;
    public $point_type;
    public $point_value;

    public static function insert_point_day($user_id) {

        global $database;
        $date = $_GET['day'];

        if(isset($_POST['point_type1'])) {
            $point_type1 = $_POST['point_type1'];
            $point_type1_value = $_POST['point_type1_value'];
        } else {
            $point_type1 = 'point_type1';
            $point_type1_value = 0;
        }
    
        if(isset($_POST['point_type2'])) {
            $point_type2 = $_POST['point_type2'];
            $point_type2_value = $_POST['point_type2_value'];
        } else {
            $point_type2 = 'point_type2';
            $point_type2_value = 0;
        }
    
        if(isset($_POST['point_type3'])) {
            $point_type3 = $_POST['point_type3'];
            $point_type3_value = $_POST['point_type3_value'];
        } else {
            $point_type3 = 'point_type3';
            $point_type3_value = 0;
        }
    
        $sql = "INSERT INTO point (user_id, date, point_type, point_value) VALUES ($user_id, '$date', '$point_type1', $point_type1_value), ($user_id, '$date', '$point_type2', $point_type2_value), ($user_id, '$date', '$point_type3', $point_type3_value)";
        $insert_point = $database->query($sql);
    }


    public static function update_point_day($user_id) {

        global $database;
        $date = $_GET['day'];

        if(isset($_POST['point_type1'])) {
            $point_type1 = $_POST['point_type1'];
            $point_type1_value = $_POST['point_type1_value'];
        } else {
            $point_type1 = 'point_type1';
            $point_type1_value = 0;
        }
    
        if(isset($_POST['point_type2'])) {
            $point_type2 = $_POST['point_type2'];
            $point_type2_value = $_POST['point_type2_value'];
        } else {
            $point_type2 = 'point_type2';
            $point_type2_value = 0;
        }
    
        if(isset($_POST['point_type3'])) {
            $point_type3 = $_POST['point_type3'];
            $point_type3_value = $_POST['point_type3_value'];
        } else {
            $point_type3 = 'point_type3';
            $point_type3_value = 0;
        }

        $sql1 = "UPDATE `point` SET `point_type` = '$point_type1', `point_value` = $point_type1_value WHERE user_id = $user_id AND date = '$date' AND point_type = '$point_type1'"; 
        $sql2 = "UPDATE `point` SET `point_type` = '$point_type2', `point_value` = $point_type2_value WHERE user_id = $user_id AND date = '$date' AND point_type = '$point_type2'"; 
        $sql3 = "UPDATE `point` SET `point_type` = '$point_type3', `point_value` = $point_type3_value WHERE user_id = $user_id AND date = '$date' AND point_type = '$point_type3'"; 

        $update_point = $database->query($sql1);
        $update_point = $database->query($sql2);
        $update_point = $database->query($sql3);
    }
   

    public function point_save($user_id) {

        global $database;
        $date = $_GET['day'];

        $sql = "SELECT * FROM point WHERE user_id = $user_id AND date = '$date'";
        $check_data = $database->query($sql);

         return mysqli_num_rows($check_data) > 0 ? static::update_point_day($user_id) : static::insert_point_day($user_id);

    }


} // End of Class Meal



?>