<?php if(!isset($_SESSION['user_id'])) { ?>
	<script>

		$(function(){
			$('.login').on('click',function(){
					$('.js-modal').fadeIn();
				return false;
			});
			
			$('.js-modal-close').on('click',function(){
				$('.js-modal').fadeOut();
				return false;
			});
		});

	</script>
<?php } ?>

<div class="modal js-modal">
	<div class="modal__bg js-modal-close"></div>
	<div class="modal__content">
		<p>ログインをしてください</p>
		<a class="float-left" href="login.php">ログイン</a>
		<a class="js-modal-close float-right" href="">閉じる</a>
	</div><!--modal__inner-->
</div>