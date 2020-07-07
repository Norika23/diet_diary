<?php
include("includes/header.php");
include("includes/navbar.php");

$user = User::find_by_id($user_id);

if(isset($_POST['tweet'])){
    $status = $getFromU->checkinput($_POST['status']);
    $tweetImage = '';

    if(!empty($status) or !empty($_FILES['file']['name'][0])){
      if(!empty($_FILES['file']['name'][0])){
        $tweetImage = $getFromU->uploadImage($_FILES['file']);
      }

      if(strlen($status) > 140){
        $error = "The text of your tweet is too long";
      }
         $tweet_id = $getFromU->t_create('tweets', array('status' => $status, 'tweetBy' => $user_id, 'tweetImage' => $tweetImage, 'postedOn' => date('Y-m-d H:i:s')));
       preg_match_all("/#+([a-zA-Z0-9_]+)/i", $status, $hashtag);

      if(!empty($hashtag)){
		  if(!$getFromT->checkTrend($status)) {
			$getFromT->addTrend($status);
		  }
      }
      $getFromT->addMention($status, $user_id, $tweet_id);
    }else{
      $error = "Type or choose image to tweet";
    }
  }

?>

<div class="row justify-content-center">
    <div class="col-4 col-md-offset-3">
	<!-- <form method="post" enctype="multipart/form-data">
							<textarea class="status"  maxlength="141" name="status" placeholder="Type Something here!" rows="4" cols="50"></textarea>
 						 	<div class="hash-box">
						 		<ul>
  						 		</ul>
						 	</div>
 						 </div>
						 <div class="tweet-footer">
						 	<div class="t-fo-left">
						 		<ul>
						 			<input type="file" name="file" id="file"/>
						 			<li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
						 			<span class="tweet-error"><?php if(isset($error)){echo $error;}else if(isset($imgError)){echo $imgError;} ?></span>
						 			</li>
						 		</ul>
						 	</div>
						 	<div class="t-fo-right">
						 		<span id="count">140</span>
						 		<input type="submit" name="tweet" value="tweet"/>
				 		</form> -->
		<ul class="list-group">
	
			<li class="list-group-item">
			<form method="post" enctype="multipart/form-data">
			<!-- <div class="tweet-h-img"> -->
			<!-- PROFILE-IMAGE -->

				<img class="tweet-h-img" src="<?php echo $user->profileImage; ?>" >
			<!-- </div> -->
			<div>
			<textarea class="status"  maxlength="141" name="status" placeholder="Type Something here!" rows="4" cols="40"></textarea>
			<div class="hash-box">
						 		<ul>
  						 		</ul>
							 </div>
							 </div>
			<div class="t-fo-left">
				<!-- <ul> -->
					<input type="file" name="file" id="file"/>
					<li><label style="cursor:pointer" for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
					<span class="tweet-error"><?php if(isset($error)){echo $error;}else if(isset($imgError)){echo $imgError;} ?></span>
					</li>
				<!-- </ul> -->
			</div>
			<!-- <button type="button" class="btn btn-success float-right btn-sm m-2">Tweet</button> -->
		
						 		<input class="btn btn-success float-right mr-4 login" type="submit" name="tweet" value="tweet"/>
								 <span id="count" class="float-right mr-3">140</span>
								 </form>
			</li>
			</ul>
				<div class="tweets">
 				  	<?php $getFromT->tweets($user_id, 10); ?>
 				 </div>


		<script type="text/javascript" src="assets/js/hashtag.js"></script>
		<div class="loading-div">
		    		<img id="loader" src="assets/images/loading.svg" style="display: none;"/>
		    	</div>
				<div class="popupTweet"></div>
				<!--Tweet END WRAPER-->
		        <script type="text/javascript" src="assets/js/like.js"></script>
		        <script type="text/javascript" src="assets/js/retweet.js"></script>
		        <script type="text/javascript" src="assets/js/popuptweets.js"></script>
		        <script type="text/javascript" src="assets/js/delete.js"></script>
		        <script type="text/javascript" src="assets/js/comment.js"></script>
		        <script type="text/javascript" src="assets/js/popupForm.js"></script>
		        <script type="text/javascript" src="assets/js/fetch.js"></script>
<?php 

// $tweets = $database->query("SELECT * FROM tweets");

// $sql = "SELECT * FROM tweets";
// $edit_meals = Tweet::find_by_query($sql);
// var_dump($edit_meals);
// foreach($edit_meals as $edit_meal) {
// 	echo "aaa";
// 	echo $edit_meal->tweetID;
// }
?>
				  

		<!-- <div class="list-group">
			<a href="#" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">List group item heading</h5>
					<small class="text-muted">3 days ago</small>
				</div>
				<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				<small class="text-muted">Donec id elit non mi porta.</small>
			</a>
			<a href="#" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">List group item heading</h5>
					<small class="text-muted">3 days ago</small>
				</div>
				<p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
				<small class="text-muted">Donec id elit non mi porta.</small>
			</a>
		</div> -->
	</div>
</div>


<?php
include("includes/footer.php");
?>