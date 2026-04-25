<?php
	$actionsRequired=true;
	require_once "../controllers/agendaController.php";

	$insAgenda = new agendaController();

	if(isset($_POST['titulo'])){
		echo $insAgenda->add_agenda_controller();
	}

	if(isset($_POST['agendaCode'])){
		echo $insAgenda->delete_agenda_controller($_POST['agendaCode']);
	}

	if(isset($_POST['upid']) && isset($_POST['upcode'])){
		echo $insAgenda->update_agenda_controller();
	}

?>