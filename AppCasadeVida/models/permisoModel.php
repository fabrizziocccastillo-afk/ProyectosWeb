<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class permisoModel extends mainModel{

		/*----------  Add permiso Model  ----------*/
		public function add_permiso_model($data){
			$query=self::connect()->prepare("INSERT INTO permisos(idrol,idmodulo,ver,crear,consultar,modificar, eliminar, estado) VALUES(:idrol,:idmodulo,:ver,:crear,:consultar,:modificar, :eliminar,:estado)");
			$query->bindParam(":idrol",$data['rol']);
			$query->bindParam(":idmodulo",$data['modulo']);
            $query->bindParam(":ver",$data['ver']);
            $query->bindParam(":crear",$data['crear']);
            $query->bindParam(":consultar",$data['consultar']);
            $query->bindParam(":modificar",$data['modificar']);
            $query->bindParam(":eliminar",$data['eliminar']);
			$query->bindParam(":estado",$data['estado']);
			$query->execute();
			return $query;
		}


		/*----------  Data permiso Model  ----------*/
		public function data_permiso_model($data){
			/*print_r($data['Tipo']);
			print_r($data['Codigo']);
			print_r($data['materia']);*/
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT * FROM permisos where estado=1");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM permisos  
												WHERE idpermiso=:idpermiso and estado=1");
				$query->bindParam(":idpermiso",$data['idpermiso']);
				//$query->bindParam(":materia",$data['materia']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete permiso Model  ----------*/
		public function delete_permiso_model($code){
			$query=self::connect()->prepare("UPDATE permisos set estado=0 WHERE idpermiso=:idpermiso and estado=1");
			$query->bindParam(":idpermiso",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update permiso Model  ----------*/
		public function update_permiso_model($data){
			$query=self::connect()->prepare("UPDATE permisos SET permiso=:permiso,nomenclatura=:nomenclatura WHERE idpermiso=:idpermiso and estado=1");
			$query->bindParam(":idpermiso",$data['idpermiso']);
			$query->bindParam(":permiso",$data['permiso']);
			$query->bindParam(":nomenclatura",$data['nomenclatura']);
			$query->execute();
			return $query;
		}
	}