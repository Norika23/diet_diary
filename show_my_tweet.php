<?php
include("includes/header.php");
include("includes/navbar.php");

$user = User::find_by_id(1);
?>

<div class="row justify-content-center">
    <div class="col-4 col-md-offset-3">
		<ul class="list-group">
			<li class="list-group-item">
			<!-- <div class="tweet-h-img"> -->
			<!-- PROFILE-IMAGE -->
				<img class="tweet-h-img" src="<?php echo $user->profileImage; ?>" >
			<!-- </div> -->
			<textarea name="" id="" cols="40" rows="3"></textarea>
			<div class="t-fo-left">
				<ul>
					<input type="file" name="file" id="file"/>
					<li><label for="file"><i class="fa fa-camera" aria-hidden="true"></i></label>
					<span class="tweet-error"><?php if(isset($error)){echo $error;}else if(isset($imgError)){echo $imgError;} ?></span>
					</li>
				</ul>
			</div>
			<button type="button" class="btn btn-success float-right btn-sm m-2">Tweet</button>
			</li>

				<div class="tweets">
 				  	<?php $getFromT->tweets($user_id, 10); ?>
 				 </div>

		</ul>
		<div class="loading-div">
		    		<img id="loader" src="assets/images/loading.svg" style="display: none;"/>
		    	</div>
				<div class="popupTweet"></div>
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