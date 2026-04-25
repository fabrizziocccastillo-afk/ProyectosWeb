<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class moduloModel extends mainModel{

		/*----------  Add Modulo Model  ----------*/
		public function add_modulo_model($data){
			$query=self::connect()->prepare("INSERT INTO modulo(modulo,nomenclatura, estado) VALUES(:modulo,:nomenclatura,:estado)");
			$query->bindParam(":modulo",$data['modulo']);
			$query->bindParam(":nomenclatura",$data['nomenclatura']);
			$query->bindParam(":estado",$data['estado']);
			$query->execute();
			return $query;
		}


		/*----------  Data modulo Model  ----------*/
		public function data_modulo_model($data){
			/*print_r($data['Tipo']);
			print_r($data['Codigo']);
			print_r($data['materia']);*/
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idmodulo,modulo FROM modulo where estado=1");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM modulo  
												WHERE idmodulo=:idmodulo and estado=1");
				$query->bindParam(":idrol",$data['idmodulo']);
				//$query->bindParam(":materia",$data['materia']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete modulo Model  ----------*/
		public function delete_modulo_model($code){
			$query=self::connect()->prepare("UPDATE modulo set estado=0 WHERE idmodulo=:idmodulo and estado=1");
			$query->bindParam(":idmodulo",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update modulo Model  ----------*/
		public function update_modulo_model($data){
			$query=self::connect()->prepare("UPDATE modulo SET modulo=:modulo,nomenclatura=:nomenclatura WHERE idmodulo=:idmodulo and estado=1");
			$query->bindParam(":idmodulo",$data['idmodulo']);
			$query->bindParam(":modulo",$data['modulo']);
			$query->bindParam(":nomenclatura",$data['nomenclatura']);
			$query->execute();
			return $query;
		}
	}