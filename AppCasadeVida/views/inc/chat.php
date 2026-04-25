<?php if($_SESSION['userType']=="Estudiante" && CHATCODE!=""): ?>
<section class="full-box chat-container">
	<div class="full-box text-center text-titles chat-button">
		<i class="zmdi zmdi-facebook"></i> &nbsp; Chat de Facebook
	</div>
	<div class="full-box chat-content">
		<?php 
			if(CHATCODE!=""){
				echo CHATCODE;
			}
		?>
	</div>
</section>
<?php endif; ?>