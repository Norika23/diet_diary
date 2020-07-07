<?php
include("includes/header.php");
include("includes/navbar.php");

    $diary = new Diary();
    // $calendar = new Calendar();
    // echo $calendar->today;
    // $date = isset($_GET['day']) ? $database->escape_string($_GET['day']) : $calendar->today;

    $date = $database->escape_string($_GET['day']);



if(isset($_POST['create_diary'])) {

    if($diary) {
        
        $diary->user_id = $user_id;
        $diary->title = $_POST['title'];
        $diary->content = $_POST['content'];
        $diary->status = $_POST['status'];
        $diary->date = $date;
        $diary->set_file($_FILES['image']);
        $session->message("The diary has been added");
        $diary->save();
        
        // redirect("parking.php");
    }
   
}

?>
<div class="container ">
    <div class="card">
        <div class="card-header text-center">
            <h1>日記を書く</h1>
        </div>
        <div class="justify-content-center p-5">
                <!-- <div class="card mb-4 shadow-sm"> -->
                <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title">タイトル</label>
                <input type="text" class="form-control" name="title">
        </div>


        <!-- <div class="form-group">
            <label for="title">Post Author</label>
                <input type="text" class="form-control" name="post_author">
        </div> -->



        <div class="form-group">
            <label for="image">画像</label>
                <input type="file" name="image">
        </div>

        <!-- <div class="form-group">
            <label for="post_tags">Post Tags</label>
                <input type="text" class="form-control" name="post_tags">
        </div> -->

        <div class="form-group">
            <label for="post_content">内容</label>
                <textarea class="form-control" name="content" id="body" cols="30" rows="10"></textarea>
        </div>

        <div class="form-group">
            <input class="btn btn-primary float-right login" type="submit" name="create_diary" value="Publish Post">
        </div>

        <div class="form-group">
            <select name="status" id="">
                <option value="private">公開状態</option>
                <option value="published">公開</option>
                <option value="private">非公開</option>
            </select>
        </div>



        </form>

        </div>
    </div>

</div>

<?php
include("includes/footer.php");
?>