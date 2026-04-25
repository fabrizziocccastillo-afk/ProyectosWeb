<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class materiaModel extends mainModel{

	/*----------  Data Materia -  Model  ----------*/
		public function show_materia_model(){
			$query=self::connect()->prepare("SELECT idmateria,materia FROM materia");
			$query->execute();
			return $query->fetchAll();
			$query->close();
			$query=null;
		}
		
		
	}