<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class loginModel extends mainModel{

		/* Modelo para iniciar sesion - Model to log in*/
		public function login_session_start_model($data){
			$query=self::connect()->prepare("SELECT * FROM cuenta WHERE Usuario=:Usuario AND Clave=:Clave");
			$query->bindParam(":Usuario",$data['Usuario']);
			$query->bindParam(":Clave",$data['Clave']);
			$query->execute();
			return $query;
		}

		/* Modelo para destruir sesion - Model to destroy session*/
		public function login_session_destroy_model($data){
			if($data['userName']!="" && $data['userToken']==$data['token']){
				session_destroy();
				return true;
			}else{
				return false;
			}
		}
		/* Funcion para guardar el log de inicio de sesion */
		public function login_session_log($data){
		    $now=date('Y-m-d H:i:s');
		    $query=self::connect()->prepare("INSERT INTO logs(Usuario,Codigo,Fecha,FechaCierreAcceso) VALUES(:Usuario,:Codigo,:Now,null)");
			$query->bindParam(":Usuario",$data['Usuario']);
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":Now",$now);
			$query->execute();
			return $query;
		}

		/* Funcion para guardar el log de fin de sesion */
		public function login_cerro_session_log($data){
			$FechaCierreAcceso=date('Y-m-d H:i:s');
		    $query=self::connect()->prepare("UPDATE logs lo1 INNER join (select MAX(Fecha) as Fecha from logs where usuario=:usuario) lo2 on lo1.Fecha=lo2.Fecha SET lo1.FechaCierreAcceso=:FechaCierreAcceso WHERE lo1.usuario=:usuario");
				$query->bindParam(":usuario",$data['userName']);
				$query->bindParam(":FechaCierreAcceso",$FechaCierreAcceso);
				$query->execute();
				return $query;
		}
	}