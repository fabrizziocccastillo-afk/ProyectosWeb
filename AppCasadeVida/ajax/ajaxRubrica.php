<?php
	$actionsRequired=true;
	require_once "../controllers/rubricaController.php";

	$insAgenda = new rubricaController();

	if(isset($_POST['titulo'])){
		echo $insAgenda->add_rubrica_controller();
	}

	if(isset($_POST['rubricaCode'])){
		echo $insAgenda->delete_rubrica_controller($_POST['rubricaCode']);
	}

	if(isset($_POST['upid']) && isset($_POST['upcode'])){
		echo $insAgenda->update_rubrica_controller();
	}

?>