<?php 
  include '../includes/init.php';
   if(isset($_POST['hashtag'])){	
   	  if(!empty($_POST['hashtag'])){
   	  	 $hashtag = $getFromU->checkInput($_POST['hashtag']);
   	  	 $mension = $getFromU->checkInput($_POST['hashtag']);

		  if(substr($hashtag, 0,1) === '#'){
		  	 $trend   = str_replace('#', '', $hashtag);
		  	 $trend   = $getFromT->getTrendByHash($trend);
			//   var_dump($trend);
			  while($row = $trend->fetch_assoc()) {
		  	//  while ($trend) {
		 	   echo '<li><a href="#"><span class="getValue">#'.$row['hashtag'].'</span></a></li>';
		  	 }
		   }

   	  	 if(substr($mension, 0,1) === '@'){
   	  	 	$mension = str_replace('@', '', $mension);
   	  	 	$mensions = $getFromT->getMension($mension);
   	  	 	while ($row = $mensions->fetch_assoc()) {
   	  	 	  echo '<li><div class="nav-right-down-inner">
						<div class="nav-right-down-left">
							<span><img width="30px" src="'.$row['profileImage'].'"></span>
						</div>
						<div class="nav-right-down-right">
							<div class="nav-right-down-right-headline">
								<span class="getValue">@'.$row['username'].'</span>
							</div>
						</div>
					</div><!--nav-right-down-inner end-here-->
					</li>';
   	  	 	}

   	  	 }
   	  }
   }
 
?>
