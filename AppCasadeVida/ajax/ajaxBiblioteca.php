<?php
	$actionsRequired=true;
	require_once "../controllers/bibliotecaController.php";

	$insBiblioteca = new bibliotecaController();

	if(isset($_POST['title'])){
		echo $insBiblioteca->add_biblioteca_controller();
	}

	if(isset($_POST['bibliotecaCode'])){
		echo $insBiblioteca->delete_biblioteca_controller($_POST['bibliotecaCode']);
	}

	if(isset($_POST['upid']) && isset($_POST['upcode'])){
		echo $insBiblioteca->update_biblioteca_controller();
	}

?>