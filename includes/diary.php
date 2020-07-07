<?php

class Diary extends Db_object{

    protected static $db_table = "diary";
    protected static $db_table_fields = array('user_id','date','title','image','content','status');
    public $id;
    public $user_id;
    public $date;
    public $title;
    public $image;
    public $content;
    public $status;

    public $tmp_path;
    public $upload_directory = "images";


    public function set_file($file) {

        if(empty($file) || !$file || !is_array($file)) {

            $this->errors[] = "There was no file uploaded here";
            return false;

        } elseif($file['error'] = 0) {

            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;

        } else {

            $this->image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];

        }

    }


    public function picture_path() {

        return $this->upload_directory.DS.$this->image;

    }


    // public function save() {

    //     if($this->id) {

    //         $this->update();

    //     } else {
     
    //         if(!empty($this->errors)) {

    //             return false;

    //         }

    //         if(empty($this->image) || empty($this->tmp_path)) {

    //             $this->errors[] = "the file was not available";
    //             return false;

    //         }
          
    //         $target_path = SITE_ROOT . DS . $this->upload_directory . DS . $this->image;
   
    //         if(file_exists($target_path)) {

    //             $this->errors[] = "The file {$this->image} already exists";
    //             return false;

    //         }


    //         if(move_uploaded_file($this->tmp_path, $target_path)) {

    //             if($this->create()) {
              
    //                 unset($this->tmp_path);
    //                 return true;

    //             } else {

    //                 $this->errors[] = "the file directory was not have permission";
    //                 return false;

    //             }

    //         }

    //     }

    // }


    public function delete_photo() {

        if($this->delete()) {

            $target_path = BASE_URL.DS.'admin'.DS.$this->picture_path();

            return unlink($target_path) ? true : false;

        } else {

            return false;

        }

    }


} // End of Class Meal



?>