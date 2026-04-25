<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}
	class torreModel extends mainModel{
		public function traer_dependencias_torre_model($id_torre){
			$query=self::connect()->prepare("SELECT idcasadevida,casadevida FROM casadevida where idtorre=$id_torre");
			$query->execute();
			return $query; 
		}
         
		public function traer_torre_CDV_model($idtorre,$usuario){
			//$usuario=$_SESSION['userName'];
			$query=self::connect()->prepare("SELECT distinct ca.idcasadevida,ca.casadevida 
			FROM casadevida ca 
			left OUTER join asignacion asg on ca.idcasadevida=asg.idcasadevida and ca.idtorre=asg.idtorre
			inner join cuenta cu on asg.codigo=cu.Codigo 
			where cu.Usuario='$usuario' and ca.idtorre=$idtorre");
			$query->execute();
			return $query; 

		}

		/*----------  Add Torres Model  ----------*/
		public function add_torre_model($data){
            

			$query=self::connect()->prepare("INSERT INTO torre(torre,estado)VALUES(:torre,1)");

			$query->bindParam(":torre",$data['torre']);
			$query->execute();
			return $query;
		}

		/*----------  Data Torres Model  ----------*/
		public function data_torre_model($data){

			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idtorre,torre FROM torre where estado=1");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM torre 
                where idtorre=:idtorre and estado=1");
				$query->bindParam(":idtorre",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Delete Torres Model  ----------*/
		public function delete_torre_model($code){
			$query=self::connect()->prepare("UPDATE torre set estado=0 WHERE idtorre=:idtorre and estado=1");
			$query->bindParam(":idtorre",$code);
			$query->execute();
			return $query;
		}

		/*----------  Update Torres Model  ----------*/
		public function update_torre_model($data){
			$query=self::connect()->prepare("UPDATE torre SET torre=:torre WHERE idtorre=:idtorre and estado=1");
			$query->bindParam(":idtorre",$data['Codigo']);
			$query->bindParam(":torre",$data['torre']);
			$query->execute();
			return $query;
		}

    }
?>