<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class proyectoModel extends mainModel{

		/*----------  Add proyecto Model  ----------*/
		public function add_proyecto_model($data){
			$query=self::connect()->prepare("INSERT INTO proyectos(nombreproyecto,idmateria,codigo,estado) VALUES(:nombre,:materia,:codigo,:estado)");

			$query->bindParam(":nombre",$data['nombre']);
            $query->bindParam(":materia",$data['materia']);
			$query->bindParam(":codigo",$data['codigo']);
			$query->bindParam(":estado",$data['estado']);
			$query->execute();
			return $query;
		}


		
	}