<?php

class Goal extends Db_object{

    protected static $db_table = "goal";
    protected static $db_table_fields = array('user_id','nomal_intake_calorie','goal_intake_calorie');
    public $id;
    public $user_id;
    public $nomal_intake_calorie;
    public $goal_intake_calorie;


} // End of Class Meal



?>