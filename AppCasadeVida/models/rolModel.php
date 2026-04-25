<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class rolModel extends mainModel{

		/*----------  Add Rol Model  ----------*/
		public function add_Rol_model($data){
			$query=self::connect()->prepare("INSERT INTO rol(rol,descripcion, estado) VALUES(:rol,:descripcion,:estado)");
			$query->bindParam(":rol",$data['rol']);
			$query->bindParam(":descripcion",$data['descripcion']);
			$query->bindParam(":estado",$data['estado']);
			$query->execute();
			return $query;
		}


		/*----------  Data Rol Model  ----------*/
		public function data_rol_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idrol,rol FROM rol where estado=1");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM rol  
												WHERE idrol=:idrol and estado=1");
				$query->bindParam(":idrol",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}
        //data_rolacceso_model

		/*----------  Data Rol Acceso Model  ----------*/
		public function data_rolacceso_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idrol,rol FROM rol where estado=1");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM usuariocdv u inner join cuenta c on c.Codigo=u.Codigo INNER join rol r on c.idrol=r.idrol where u.Codigo =:codigo and r.estado=1");
				$query->bindParam(":codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Delete Rol Model  ----------*/
		public function delete_Rol_model($code){
			$query=self::connect()->prepare("UPDATE rol set estado=0 WHERE idrol=:idrol and estado=1");
			$query->bindParam(":idrol",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update Rol Model  ----------*/
		public function update_Rol_model($data){
			$query=self::connect()->prepare("UPDATE rol SET rol=:rol,descripcion=:descripcion WHERE idrol=:idrol and estado=1");
			$query->bindParam(":idrol",$data['Codigo']);
			$query->bindParam(":rol",$data['rol']);
			$query->bindParam(":descripcion",$data['descripcion']);
			$query->execute();
			return $query;
		}
	}