<?php
		if($actionsRequired){
			      require_once "../models/materiaModel.php";
		}else{
		          require_once "./models/materiaModel.php";   
		        }

		$materiaModel = new materiaModel();
		$datosMateria = $materiaModel->show_materia_model();
	

?>