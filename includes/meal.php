<?php

class Meal extends Db_object{

    protected static $db_table = "meal";
    protected static $db_table_fields = array('user_id','date','name','calorie');
    public $id;
    public $user_id;
    public $date;
    public $name;
    public $calorie;



} // End of Class Meal



?>