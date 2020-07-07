
  <nav class="navbar navbar-expand-lg navbar-light p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">

    <h5 class="my-0 mr-md-auto font-weight-normal"><a class="text-dark" href="index.php">Diet Diary</a></h5>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-5" id="navbarsExample09">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item mr-2">
          <a class="nav-link text-dark login" href="show_tweet.php">Tweet <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item mr-2">
          <a class="nav-link text-dark login"  href="show_diary.php">Diary</a>
        </li>
        <li class="nav-item mr-2">
          <a class="nav-link text-dark login"  href="show_status.php">Status</a>
        </li>
        <li class="nav-item mr-2">
          <a class="nav-link text-dark login"  href="show_goal.php">Goal</a>
        </li>
        <li class="nav-item mr-2">
          <a class="nav-link text-dark login"  href="my_profile.php">Profile</a>
        </li>
        <li class="nav-item mr-2">
        <?php
if($session->is_signed_in()) {
    echo "<a class='btn btn-outline-primary mt-1' href='logout.php'>Logout</a>";
}else{
    echo '<a class="btn btn-outline-primary mt-1" href="login.php">Sign up</a>';
}
?>
 </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdown09">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li> -->
      </ul>
      <form class="form-inline my-2 my-md-0">
        <input class="form-control" type="text" placeholder="Search" aria-label="Search">
      </form>
    </div>
  </nav>
