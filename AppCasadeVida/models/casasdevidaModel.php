<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class casasdevidaModel extends mainModel{

		/*----------  Add Casas de vida Model  ----------*/
		public function add_casasdevida_model($data){
            
			/*print_r($data['torre']);

			exit();*/

			$query=self::connect()->prepare("INSERT INTO casadevida(idtorre,casadevida,estado)VALUES(:torre,:casa,1)");

			$query->bindParam(":casa",$data['casadevida']);
			$query->bindParam(":torre",$data['torre']);
			$query->execute();
			return $query;
		}

		/*----------  Data Casas de vida Model  ----------*/
		public function data_casasdevida_model($data){

			/*print_r($data['Codigo']);

			exit();*/
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idcasadevida,casadevida FROM casadevida where estado=1");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT cs.idcasadevida,cs.idtorre,cs.casadevida,t.torre,cs.estado FROM casadevida cs 
                inner join torre t on cs.idtorre=t.idtorre
                where cs.idcasadevida=:idcasadevida and cs.estado=1");
				$query->bindParam(":idcasadevida",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Delete Casas de vida Model  ----------*/
		public function delete_casasdevida_model($code){
			$query=self::connect()->prepare("UPDATE casadevida set estado=0 WHERE idcasadevida=:idcasadevida and estado=1");
			$query->bindParam(":idcasadevida",$code);
			$query->execute();
			return $query;
		}

		/*----------  Update Casas de vida Model  ----------*/
		public function update_casasdevida_model($data){
			$query=self::connect()->prepare("UPDATE casadevida SET casadevida=:casadevida,idtorre=:torre WHERE idcasadevida=:idcasadevida and estado=1");
			$query->bindParam(":idcasadevida",$data['Codigo']);
			$query->bindParam(":casadevida",$data['casadevida']);
			$query->bindParam(":torre",$data['torre']);
			$query->execute();
			return $query;
		}


		
	}