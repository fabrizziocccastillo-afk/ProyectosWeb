<?php
		if($actionsRequired){
			      require_once "../models/alumnonewModel.php";
		}else{
		          require_once "./models/alumnonewModel.php";   
		        }

		$alumnonewModel = new alumnonewModel();
		$datosAlumnonew = $alumnonewModel->show_alumnonew_model();