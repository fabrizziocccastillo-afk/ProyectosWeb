<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class alumnonewModel extends mainModel{

	/*----------  Data Alumno New -  Model  ----------*/
		public function show_alumnonew_model(){
			$query=self::connect()->prepare("SELECT * FROM estudiante order by Nombres");
			$query->execute();
			return $query->fetchAll();
			$query->close();
			$query=null;
		}	
	}