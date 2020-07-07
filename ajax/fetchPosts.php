<?php 

	include '../includes/header.php';

	if(isset($_POST['fetchPost']) && !empty($_POST['fetchPost'])){
		$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
		$limit   = (int) trim($_POST['fetchPost']);
		$getFromT->tweets($user_id, $limit);

	}
?>