<?php
include("includes/header.php");
include("includes/navbar.php");

$diary = new Diary();
$calendar = new Calendar();
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <div class="float-left"><a class="text-dark" href="add_diary.php?day=<?php echo $calendar->today; ?>">日記を書く
                    <svg class="bi bi-pencil float-right ml-2 mt-1 " style="cursor: pointer" data-toggle="modal" data-target="#exampleModal" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
                    </svg></a>
                </div>
                <h5 class="page-header">
                    <a class="float-right" href="show_diary.php">みんなの日記</a>
                    <br>
                </h5>

                <!-- First Blog Post -->
                <?php

                    $show_diarys = Diary::find_by_user_id($user_id);
                    
                    foreach($show_diarys as $show_diary) {
    
                ?>


                <hr>
                <?php 
                // $sql = "SELECT FROM user WHERE id = $show_diary->user_id";
                
               $user = User::find_by_id($user_id);
                
                ?>
                <img class="tweet-h-img" src="<?php echo $user->profileImage; ?>" width="50px">
                <a href="user_diary.php?id=<?php echo $show_diary->user_id; ?>"><?php echo $user->username ?></a>
               
                <h2>
                    <a href="diary_detail.php?id=<?php echo $show_diary->id; ?>"><?php echo $show_diary->title; ?></a>
                </h2>
 
                <p class="float-right"><span class="glyphicon glyphicon-time "></span> <?php echo $show_diary->date ?></p>
            
                <p><?php 
                if(mb_strlen($show_diary->content)>150) {
                    echo mb_substr($show_diary->content,0,150)."......";
                }else {
                    echo $show_diary->content;
                }
                 ?>
                
                <a class="btn btn-primary float-right" href="diary_detail.php?id=<?php echo $show_diary->id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                </p>
                
                <a href="diary_detail.php?id=<?php echo $show_diary->id; ?>">
                <img class="img-responsive" width="300px" src="images/<?php echo $show_diary->image; ?>" alt="">
                </a>

                
               


					<?php   
					   } 
					
					?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php //include "includes/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

        <ul class="pager">

            <?php

                // for($i=1; $i<=$count; $i++) {

                //     if($i == $page) {

                //         echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                        
                //     } else {

                //         echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";

                //     }               

                // }

            ?>

        </ul>


<?php
include("includes/footer.php");
?>