<?php
include("includes/header.php");
include("includes/navbar.php");

$diary = new Diary();

$d_id = $_GET['id'];
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <div class="float-left"><a class="text-dark" href="add_diary.php?day=<?php echo $date; ?>">日記を書く
                    <svg class="bi bi-pencil float-right ml-2 mt-1 " style="cursor: pointer" data-toggle="modal" data-target="#exampleModal" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-9 9a1 1 0 01-.39.242l-3 1a1 1 0 01-1.266-1.265l1-3a1 1 0 01.242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 00.5.5H4v.5a.5.5 0 00.5.5H5v.5a.5.5 0 00.5.5H6v-1.5a.5.5 0 00-.5-.5H5v-.5a.5.5 0 00-.5-.5H3z" clip-rule="evenodd"/>
                    </svg></a>
                </div>
                <h5 class="page-header">
                    <a class="float-right login" href="my_diary.php">私の日記</a>
                    <br>
                </h5>

                <!-- First Blog Post -->
                <?php


$show_diary = Diary::find_by_id($d_id);

    
                ?>


                <hr>
                <?php 
                // $sql = "SELECT FROM user WHERE id = $show_diary->user_id";
               $user = User::find_by_id($show_diary->user_id);
                
                ?>
                <img class="tweet-h-img" src="<?php echo $user->profileImage; ?>" width="50px">
                <a href="user_diary.php?id=<?php echo $show_diary->user_id ?>"><?php echo $user->username ?></a>
               
                <h2>
                    <?php echo $show_diary->title; ?>
                </h2>
 
                <p class="float-right"><span class="glyphicon glyphicon-time "></span> <?php echo $show_diary->date ?></p>
            <br>
                <p><?php 
                    echo $show_diary->content;
                
                 ?>
            
                </p>
                
                
                <img class="img-responsive" width="300px" src="images/<?php echo $show_diary->image; ?>" alt="">
                
 


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