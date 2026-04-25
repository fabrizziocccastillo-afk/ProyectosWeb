<?php

if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class materiamaestroModel extends mainModel{


/*----------  Add usuario Model  ----------*/
		public function add_materiamaestro_model($data){
			$query=self::connect()->prepare("INSERT INTO materia(materia,Tutor, correo, ciclo,fotomaestro) VALUES(:materia,:Tutor, :correo, :ciclo,:fotomaestro)");
			$query->bindParam(":materia",$data['materia']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":correo",$data['correo']);
			$query->bindParam(":ciclo",$data['ciclo']);
			$query->bindParam(":fotomaestro",$data['foto']);
			//print_r($data);
			$query->execute();
			return $query;
		}

		/*----------  Data Update Student Model  ----------*/
		public function data_materiamaestro_actualiza_ADM_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idmateria FROM materia");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM materia 
												WHERE idmateria=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Delete Student Model  ----------*/
		public function delete_materiamaestro_model($code){
			$query=self::connect()->prepare("DELETE FROM materia WHERE idmateria=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;
		}

				/*----------  Update usuario Model  ----------*/
				public function update_materiamaestro_model($data){
					$query=self::connect()->prepare("UPDATE materia SET materia=:materia,Tutor=:Tutor,correo=:correo,ciclo=:ciclo,notminaprueba=:notminaprueba
					WHERE idmateria=:Codigo");
					$query->bindParam(":materia",$data['materia']);
					$query->bindParam(":Tutor",$data['Tutor']);
					$query->bindParam(":correo",$data['correo']);
					$query->bindParam(":ciclo",$data['ciclo']);
					$query->bindParam(":Codigo",$data['Codigo']);
					$query->bindParam(":notminaprueba",$data['notminaprueba']);
					$query->execute();
					return $query;
				}

    }
?>