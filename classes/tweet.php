<?php
 /*
  Developed by Aizaz dinho (@aizazdinho)
  Designed  by Meezan (@iamMeezi)
 */ 
class Tweet extends Db_object{

	protected static $db_table = "tweets";
    protected static $db_table_fields = array('user_id','date','title','image','content','status');
    public $tweetID;
    public $status;
    public $tweetBy;
    public $retweetID;
    public $retweetBy;
    public $tweetImage;
	public $likesCount;
	public $retweetCount;
    public $PostedOn;
    public $retweetMsg;
	public $profileImage;
	public $username;
	public $postedOn ;
	// protected $message;

 	// public function __construct($pdo){
	// 	$this->pdo = $pdo;
	// }
 
	public function tweets($user_id, $num){
		global $database;
		
		// $tweets = $database->query("SELECT * FROM tweets");
		// var_dump("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `tweetBy` = `id` AND `retweetBy` != $user_id AND `tweetBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` =$user_id) ORDER BY `tweetID` DESC LIMIT $num");
		//$tweets = self::find_by_query("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `tweetBy` = `id` AND `retweetBy` != $user_id AND `tweetBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` =$user_id) ORDER BY `tweetID` DESC LIMIT $num");
		//var_dump("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `tweetBy` = `id` AND `retweetBy` != $user_id AND `tweetBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` =$user_id) ORDER BY `tweetID` DESC LIMIT $num");
		$tweets = self::find_by_query("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `tweetBy` = `id` AND `retweetBy` != $user_id  ORDER BY `tweetID` DESC LIMIT $num");
		//var_dump("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `tweetBy` = `id` AND `retweetBy` != $user_id  ORDER BY `tweetID` DESC LIMIT $num");
// var_dump($tweets);
		// $stmt->bindParam('i',":user_id", $user_id);
		// $stmt->bindParam('iiii', $user_id, $user_id, $user_id, $num);
	    // $stmt->bindParam(":num", $num);
	    // $stmt->execute();
	    // $tweets = $stmt->fetchAll(Database::FETCH_OBJ);

	    foreach ($tweets as $tweet) {

		  $likes = $this->likes($user_id, $tweet->tweetID);
	      $retweet = $this->checkRetweet($tweet->tweetID, $user_id);
		  $user = $this->userData($tweet->retweetBy);

		  echo '<li class="list-group-item">
		  <div class="all-tweet">
			      <div class="t-show-wrap">
			       <div class="t-show-inner">
			       '.(($retweet['retweetID'] === $tweet->retweetID OR $tweet->retweetID > 0) ? '
			      	<div class="t-show-banner">
			      		<div class="t-show-banner-inner">
			      			<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user['username'].' Retweeted</span>
			      		</div>
			      	</div>'
			        : '').'

			        '.((!empty($tweet->retweetMsg) && $tweet->tweetID === $retweet['tweetID'] or $tweet->retweetID > 0) ? '<div class="t-show-head">
			        <div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
					  <div class="tweet-h-img">
			
			        		<img class="tweet-h-img" src="'.$user['profileImage'].'"/>
			        	</div>
			        	<div class="t-s-head-content">
			        		<div class="t-h-c-name">
			        			<span><a href="profile.php?username='.BASE_URL.$user['username'].'">'.$user['username'].'</a></span>
			        			<span>@'.$user['username'].'</span>
								<span>'.$this->timeAgo($retweet['postedOn']).'</span>
								
			        		</div>
			        		<div class="t-h-c-dis">
			        			'.$this->getTweetLinks($tweet->retweetMsg).'
			        		</div>
			        	</div>
			        </div>
			        <div class="t-s-b-inner">
			        	<div class="t-s-b-inner-in">
			        		<div class="retweet-t-s-b-inner">
			            '.((!empty($tweet->tweetImage)) ? '
			        			<div class="retweet-t-s-b-inner-left">
			        				<img class="tweet-h-img" width="420px" src="'.BASE_URL.$tweet->tweetImage.'" class="imagePopup" data-tweet="'.$tweet->tweetID.'"/>
			        			</div>' : '').'
			        			<div>
			        				<div class="t-h-c-name">
			        					<span><a href="profile.php?username='.BASE_URL.$tweet->username.'">'.$tweet->username.'</a></span>
			        					<span>@'.$tweet->username.'</span>
			        					<span>'.$this->timeAgo($tweet->postedOn).'</span>
			        				</div>
			        				<div class="retweet-t-s-b-inner-right-text" style="word-wrap: break-word;">
			        					'.$this->getTweetLinks($tweet->status).'
			        				</div>
			        			</div>
			        		</div>
			        	</div>
			        </div>
			        </div>' : '

			      	<div class="t-show-popup" data-tweet="'.$tweet->tweetID.'">
			      		<div class="t-show-head">
			      		
			      			
			      			
			      			<div class="t-s-head-content">
								  <div class="t-h-c-name">
								  <img class="tweet-h-img" src="'.$tweet->profileImage.'"/>
			      					<span><a href="profile.php?username='.$tweet->username.'">'.$tweet->username.'</a></span>
			      					<span>@'.$tweet->username.'</span>
			      					<span>'.$this->timeAgo($tweet->postedOn).'</span>
			      				</div>
			      				<div class="t-h-c-dis" style="word-wrap: break-word;">
			      					'.$this->getTweetLinks($tweet->status).'
			      				</div>
			      			</div>
			      		</div>'.
			          ((!empty($tweet->tweetImage)) ?
			      		 '<!--tweet show head end-->
			            		<div class="t-show-body">
			            		  <div class="t-s-b-inner">
			            		   <div class="t-s-b-inner-in">
			            		     <img src="'.$tweet->tweetImage.'" width="420px"  class="imagePopup" data-tweet="'.$tweet->tweetID.'"/>
			            		   </div>
			            		  </div>
			            		</div>
			            		<!--tweet show body end-->
			          ' : '').'

			      	</div>').'
			      	<div class="t-show-footer">
			      		<div class="t-s-f-right">
			      			<ul style="margin-top:10px; margin-bottom:0px">
			      				<li><i class="fa fa-share" aria-hidden="true"></i></li>
			      				<li>'.(($tweet->tweetID === $retweet['retweetID']) ? 
			      					'<div class="retweeted login" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></div>' : 
			      					'<div class="retweet login" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($tweet->retweetCount > 0) ? $tweet->retweetCount : '').'</span></div>').'
			      				</li>
			      				<li>'.(($likes['likeOn'] === $tweet->tweetID) ? 
			      					'<div class="unlike-btn login" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></div>' : 
			      					'<div class="like-btn login" data-tweet="'.$tweet->tweetID.'" data-user="'.$tweet->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($tweet->likesCount > 0) ? $tweet->likesCount : '' ).'</span></div>').'
			      				</li>
			               
			                '.(($tweet->tweetBy === $user_id) ? '
			              	    <li>
			      					<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
			      					<ul>
			      					  <li><label class="deleteTweet" data-tweet="'.$tweet->tweetID.'">Delete Tweet</label></li>
			      					</ul>
			      				</li>' : '').'

			      			</ul>
			      		</div>
			      	</div>
			      </div>
			      </div>
			      </div>';
	    }
	}
  
	public function getUserTweets($user_id){
		global $database;

		$stmt = $database->query("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `id` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `retweetBy` = $user_id ORDER BY `tweetID` DESC");
		return $stmt;
		// $stmt = $this->pdo->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweetBy` = `user_id` WHERE `tweetBy` = :user_id AND `retweetID` = '0' OR `retweetBy` = :user_id ORDER BY `tweetID` DESC");
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->execute();
		// return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function addLike($user_id, $tweet_id, $get_id){
		// $stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`+1 WHERE `tweetID` = :tweet_id");
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->execute();
		global $database;

		$stmt = $database->query("UPDATE `tweets` SET `likesCount` = `likesCount`+1 WHERE `tweetID` = $tweet_id");


		$this->t_create('likes', array('likeBy' => $user_id, 'likeOn' => $tweet_id));
	}

	public function unLike($user_id, $tweet_id, $get_id){
		// $stmt = $this->pdo->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`-1 WHERE `tweetID` = :tweet_id");
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->execute();

		// $stmt = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id and `likeOn` = :tweet_id");
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->execute(); 
		global $database;

		$database->query("UPDATE `tweets` SET `likesCount` = `likesCount`-1 WHERE `tweetID` = $tweet_id");
		$database->query("DELETE FROM `likes` WHERE `likeBy` = $user_id and `likeOn` = $tweet_id");
	}

	public function likes($user_id, $tweet_id){
		global $database;

		// $stmt = $this->pdo->prepare("SELECT * FROM `likes` WHERE `likeBy` = :user_id AND `likeOn` = :tweet_id");

		$stmt = $database->query("SELECT * FROM `likes` WHERE `likeBy` = $user_id AND `likeOn` = $tweet_id");
		// var_dump("SELECT * FROM `likes` WHERE `likeBy` = $user_id AND `likeOn` = $tweet_id");
	
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->bind_param ('ii', $user_id, $tweet_id);
			// var_dump($stmt);
		// $stmt->execute();
		//return $stmt->fetch(PDO::FETCH_ASSOC);
		// var_dump($stmt);
		// $result = $stmt->execute();
		// var_dump($stmt->execute());
		return $stmt->fetch_assoc();
	}
	
	public function getTrendByHash($hashtag){
		// $stmt = $this->pdo->prepare("SELECT * FROM `trends` WHERE `hashtag` LIKE :hashtag LIMIT 5");
		// $stmt->bindValue(":hashtag", $hashtag.'%');
		// $stmt->execute();
		// return $stmt->fetchAll(PDO::FETCH_OBJ);
		global $database;
		// var_dump("SELECT * FROM `trends` WHERE `hashtag` LIKE $hashtag LIMIT 5");
		$stmt = $database->query("SELECT * FROM `trends` WHERE `hashtag` LIKE '$hashtag%' LIMIT 5");
		// $result = $stmt->get_result();
		return $stmt;
	}


	public function getMension($mension){
		// $stmt = $this->pdo->prepare("SELECT `user_id`,`username`,`username`,`profileImage` FROM `users` WHERE `username` LIKE :mension OR `username` LIKE :mension LIMIT 5");
		// $stmt->bindValue("mension", $mension.'%');
		// $stmt->execute();
		// return $stmt->fetchAll(PDO::FETCH_OBJ);
		global $database;
		$stmt = $database->query("SELECT `id`,`username`,`username`,`profileImage` FROM `users` WHERE `username` LIKE '$mension%' OR `username` LIKE '$mension%' LIMIT 5");
		return $stmt;
	}

	public function addTrend($hashtag){
		global $database;
		preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
		if($matches){
			$result = array_values($matches[1]);
		}
		foreach ($result as $trend) {
			$sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES ('$trend', CURRENT_TIMESTAMP)";
			$database->query($sql);
		}
	}

	public function checkTrend($hashtag){
		global $database;
		preg_match_all("/#+([a-zA-Z0-9_]+)/i", $hashtag, $matches);
		if($matches){
			$result = array_values($matches[1]);
		}
		foreach ($result as $trend) {
			// $sql = "INSERT INTO `trends` (`hashtag`, `createdOn`) VALUES ('$trend', CURRENT_TIMESTAMP)";
			$sql = "SELECT * FROM trends WHERE hashtag = '$trend' ";
			$database->query($sql);
		}
		return true;
	}

	public function addMention($status,$user_id, $tweet_id){
		global $database;
		if(preg_match_all("/@+([a-zA-Z0-9_]+)/i", $status, $matches)){
			if($matches){
				$result = array_values($matches[1]);
			}
			foreach ($result as $trend) {
				$sql = "SELECT * FROM `users` WHERE `username` = '$trend'";
				$database->query($sql);
				// if($stmt = $this->pdo->prepare($sql)){
				// 	$stmt->execute(array(':mention' => $trend));
				// 	$data = $stmt->fetch(PDO::FETCH_OBJ);
				// }
			}
		}
	}

	public function getTweetLinks($tweet){
		$tweet = preg_replace("/(https?:\/\/)([\w]+.)([\w\.]+)/", "<a href='$0' target='_blink'>$0</a>", $tweet);
		$tweet = preg_replace("/#([\w]+)/", "<a href='http://localhost/twitter/hashtag/$1'>$0</a>", $tweet);		
		$tweet = preg_replace("/@([\w]+)/", "<a href='http://localhost/twitter/$1'>$0</a>", $tweet);
		return $tweet;		
	}

	public function getPopupTweet($tweet_id){
		// $stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID` = :tweet_id AND `tweetBy` = `user_id`");
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->execute();
		// return $stmt->fetch(PDO::FETCH_OBJ);
		global $database;
		$stmt = $database->query("SELECT * FROM `tweets`,`users` WHERE `tweetID` = $tweet_id AND `tweetBy` = `id`");
		return $stmt->fetch_assoc();
	}

	public function retweet($tweet_id, $user_id, $get_id, $comment){
		// $stmt = $this->pdo->prepare("UPDATE `tweets` SET `retweetCount` = `retweetCount`+1 WHERE `tweetID` = :tweet_id AND `tweetBy` = :get_id");
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->bindParam(":get_id", $get_id, PDO::PARAM_INT);
		// $stmt->execute();

		// $stmt = $this->pdo->prepare("INSERT INTO `tweets` (`status`,`tweetBy`,`retweetID`,`retweetBy`,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`,`retweetMsg`) SELECT `status`,`tweetBy`,`tweetID`,:user_id,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`,:retweetMsg FROM `tweets` WHERE `tweetID` = :tweet_id");
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->bindParam(":retweetMsg", $comment, PDO::PARAM_STR);
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->execute();
		global $database;
		$stmt = $database->query("UPDATE `tweets` SET `retweetCount` = `retweetCount`+1 WHERE `tweetID` = $tweet_id AND `tweetBy` = $get_id");
		$stmt = $database->query("INSERT INTO `tweets` (`status`,`tweetBy`,`retweetID`,`retweetBy`,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`,`retweetMsg`) SELECT `status`,`tweetBy`,`tweetID`,$user_id,`tweetImage`,`postedOn`,`likesCount`,`retweetCount`,$retweetMsg FROM `tweets` WHERE `tweetID` = $tweet_id");

 	}

	public function checkRetweet($tweet_id, $user_id){
		global $database;
		$stmt = $database->query("SELECT * FROM `tweets` WHERE `retweetID` = $tweet_id AND `retweetBy` = $user_id or `tweetID` = $tweet_id and `retweetBy` = $user_id");
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->execute();
		return $stmt->fetch_assoc();
	}

	public function tweetPopup($tweet_id){
		global $database;
		$stmt = $database->query("SELECT * FROM `tweets`,`users` WHERE `tweetID` = $tweet_id and `id` = `tweetBy`");
		return $stmt->fetch_assoc();
		// $stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetID` = :tweet_id and `user_id` = `tweetBy`");
		// $stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		// $stmt->execute();
		// return $stmt->fetch(PDO::FETCH_OBJ);

	}

	public function comments($tweet_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `comments` LEFT JOIN `users` ON `commentBy` = `user_id` WHERE `commentOn` = :tweet_id");
		$stmt->bindParam(":tweet_id", $tweet_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function countTweets($user_id){
		global $database;
		$stmt = $database->query("SELECT COUNT(`tweetID`) AS `totalTweets` FROM `tweets` WHERE `tweetBy` = $user_id AND `retweetID` = '0' OR `retweetBy` = $user_id");
		$count = $stmt->fetch_array();
		echo $count['totalTweets'];
		// $stmt = $this->pdo->prepare("SELECT COUNT(`tweetID`) AS `totalTweets` FROM `tweets` WHERE `tweetBy` = :user_id AND `retweetID` = '0' OR `retweetBy` = :user_id");
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->execute();
		// $count = $stmt->fetch(PDO::FETCH_OBJ);
		// echo $count->totalTweets;
	}

	public function countLikes($user_id){
		global $database;
		$stmt = $database->query("SELECT COUNT(`likeID`) AS `totalLikes` FROM `likes` WHERE `likeBy` = $user_id");
		$count = $stmt->fetch_array();
		echo $count['totalLikes'];
		// $stmt = $this->pdo->prepare("SELECT COUNT(`likeID`) AS `totalLikes` FROM `likes` WHERE `likeBy` = :user_id");
		// $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		// $stmt->execute();
		// $count = $stmt->fetch(PDO::FETCH_OBJ);
		// echo $count->totalLikes;
	} 

	public function getUsersByHash($hashtag){
		$stmt = $this->pdo->prepare("SELECT DISTINCT * FROM `tweets` INNER JOIN `users` ON `tweetBy` = `user_id` WHERE `status` LIKE :hashtag OR `retweetMsg` LIKE :hashtag GROUP BY `user_id`");
		$stmt->bindValue(":hashtag", '%#'.$hashtag.'%', PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function userData($user_id){
		global $database;
		
		$stmt = $database->query('SELECT * FROM `users` WHERE `id` ='. $user_id);

		return $stmt->fetch_assoc();
	}


}
?>	