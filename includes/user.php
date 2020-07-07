<?php

class User extends Db_object{

    protected static $db_table = "users";
    protected static $db_table_fields = array('username','password','email','gender','age','birth_year','birth_month','birth_day','start_weight',
    'current_weight','goal_weight','height','activity_level','goal_intake_calorie','nomal_intake_calorie','basal_metabolic_rate');
    public $id;
    public $username;
    public $password;
    public $email;
    public $profileImage;
    public $profileCover;
    public $following;
    public $followers;
    public $gender;
    public $age;
    public $birth_year;
    public $birth_month;
    public $birth_day;
    public $start_weight;
    public $current_weight;
    public $goal_weight;
    public $height;
    public $activity_level;
    public $goal_intake_calorie;
    public $nomal_intake_calorie;
    public $basal_metabolic_rate;


    public function register_user($username,$password,$email,$gender,$age,$birth_year,$birth_month,$birth_day,$start_weight,$current_weight,
    $goal_weight,$height,$activity_level,$nomal_intake_calorie,$basal_metabolic_rate) {
        
        global $database;
    
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
        $email = $database->escape_string($email);
        $gender = $database->escape_string($gender);
        $age = $database->escape_string($age);
        $birth_year = $database->escape_string($birth_year);
        $birth_month = $database->escape_string($birth_month);
        $birth_day = $database->escape_string($birth_day);
        $start_weight = $database->escape_string($start_weight);
        $current_weight = $database->escape_string($start_weight);
        $goal_weight = $database->escape_string($goal_weight);
        $height = $database->escape_string($height);
        $activity_level = $database->escape_string($activity_level);
        $nomal_intake_calorie = $database->escape_string($nomal_intake_calorie);
        $basal_metabolic_rate = $database->escape_string($basal_metabolic_rate);

        $sql = "INSERT INTO users (username, password, email,gender, age, birth_year, birth_month, birth_day, start_weight,current_weight,
        goal_weight,height,activity_level,nomal_intake_calorie,basal_metabolic_rate) ";
        $sql .= "VALUES('{$username}', '{$password}', '{$email}', '{$gender}', '{$age}', '{$birth_year}', '{$birth_month}', '{$birth_day}'
        , '{$start_weight}', '{$current_weight}', '{$goal_weight}', '{$height}', '{$activity_level}', '{$nomal_intake_calorie}', '{$basal_metabolic_rate}') ";

        $database->query($sql);

        $message = "Your registration has been submitted";

    }

    public function edit_user() {
        
        global $database;

        $sql = "UPDATE `users` SET `username` = '$this->username', `email` = '$this->email', `gender` = '$this->gender', 
        `age` = '$this->age', `birth_year` = '$this->birth_year', `birth_month` = '$this->birth_month', `birth_day` = '$this->birth_day',
         `start_weight` = '$this->start_weight', `goal_weight` = '$this->goal_weight',`height` = '$this->height', 
         `activity_level` = '$this->activity_level',  `goal_intake_calorie` = '$this->goal_intake_calorie', 
         `nomal_intake_calorie` = '$this->nomal_intake_calorie',`basal_metabolic_rate` = '$this->basal_metabolic_rate' WHERE `users`.`id` = $this->id";

        $database->query($sql);

        $message = "Your registration has been submitted";

    }



    public static function verify_user($username, $password) {

        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $find_username_query = "SELECT * FROM users WHERE username = '{$username}'";
        $find_username = $database->query($find_username_query);

        $row = mysqli_fetch_array($find_username);

        if(password_verify($password,$row['password'])){
             
            $the_result_array = self::find_by_query($find_username_query);

            return !empty($the_result_array) ? array_shift($the_result_array) : false;

        };

    }


    public function username_exists($username) {

        global $database;
    
        $result = $database->query("SELECT username FROM users WHERE username = '$username' ");

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

    }


    public function email_exists($email) {

        global $database;
    
        $result = $database->query("SELECT email FROM users WHERE email = '$email' ");

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

    }


	public function checkInput($data){
		$data = htmlspecialchars($data);
		$data = trim($data);
		$data = stripcslashes($data);
		return $data;
	}

    
	// public function t_create($table, $fields = array()){
    //     global $database;
    //     $columns = implode(',', array_keys($fields));
    //     // var_dump($columns);
    //     $values  = '\''.implode("','", array_values($fields)).'\'';
    //     $sql     = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
    //     $database->query($sql);
    //     return $database->the_insert_id();

    // }
    

    public function uploadImage($file){
        $filename   = $file['name'];
      $fileTmp    = $file['tmp_name'];
      $fileSize   = $file['size'];
      $errors     = $file['error'];

       $ext = explode('.', $filename);
      $ext = strtolower(end($ext));
       
       $allowed_extensions  = array('jpg','png','jpeg');
  
      if(in_array($ext, $allowed_extensions)){
          
          if($errors ===0){
              
              if($fileSize <= 2097152){

                   $root = 't_images/' . $filename;
                     move_uploaded_file($fileTmp,$_SERVER['DOCUMENT_ROOT'].'/diet/'.$root);
                   return $root;

              }else{
                      $GLOBALS['imgError'] = "File Size is too large";
                  }
          }
        }else{
                  $GLOBALS['imgError'] = "Only alloewd JPG, PNG JPEG extensions";
               }
   }


   public function userIdbyUsername($username){
        global $database;
        $stmt = $database->query("SELECT `id` FROM `users` WHERE (`username`  = '$username')");
        // return !empty($stmt) ? array_shift($stmt) : false;
        // return $stmt->fetch_assoc();
        while($row = mysqli_fetch_array($stmt)) {

            $user_id = $row['id'];

        }
        return $user_id;

     // $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE (`username`  = :username)");
    // $stmt->bindParam("username", $username, PDO::PARAM_STR);
    // $stmt->execute();
    // $user = $stmt->fetch(PDO::FETCH_OBJ);
    // return $user->user_id;
            
        }

	public function loggedIn(){
		return (isset($_SESSION['user_id'])) ? true : false;
	}



} // End of Class User

































?>