
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal"><a class="text-dark" href="index.php">Diet Diary</a></h5>

    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="show_goal.php">Goal</a>
    </nav>
    <?php

    if($session->is_signed_in()) {
        echo "<a class='btn btn-outline-primary' href='logout.php'>Logout</a>";
    }else{
        echo '<a class="btn btn-outline-primary" href="login.php">Sign up</a>';
    }

?>
    
</div>