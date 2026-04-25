<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class videoModel extends mainModel{

		/*----------  Add Video Model  ----------*/
		public function add_video_model($data){
			$query=self::connect()->prepare("INSERT INTO clase(idmateria,Video,Fecha,Titulo,Tutor,Descripcion,Adjuntos) VALUES(:materia,:Video,:Fecha,:Titulo,:Tutor,:Descripcion,:Adjuntos)");
			$query->bindParam(":materia",$data['materia']);
			$query->bindParam(":Video",$data['Video']);
			$query->bindParam(":Fecha",$data['Fecha']);
			$query->bindParam(":Titulo",$data['Titulo']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Descripcion",$data['Descripcion']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->execute();
			return $query;
		}


		/*----------  Data Video Model  ----------*/
		public function data_video_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT id FROM clase");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT cla.*,ma.materia FROM clase cla left OUTER join materia ma on cla.idmateria=ma.idmateria WHERE cla.id=:id");
				$query->bindParam(":id",$data['id']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Data Video Model  ----------*/
		public function data_clasexmateria_model($data,$username){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT id FROM clase");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT cla.id,	cla.idmateria,	cla.Video,	cla.Fecha,	cla.Titulo,	cla.Tutor,	cla.Descripcion,	cla.Adjuntos,	ma.materia,	ma.Tutor,calificacion,mat.fecha,	calificaciontaller,	calificacionactuacion,	aprobado,es.Codigo,es.Nombres,	es.Apellidos,mat.comentario,ma.fotomaestro,ma.correo
				FROM clase cla inner join materia ma on cla.idmateria=ma.idmateria inner join matricula mat on mat.idmateria=ma.idmateria inner join estudiante es on mat.Codigo=es.Codigo inner join cuenta cu on cu.Codigo=es.Codigo where cu.usuario='$username' and ma.idmateria=:id");
				$query->bindParam(":id",$data['id']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete Video Model  ----------*/
		public function delete_video_model($code){
			$query=self::connect()->prepare("DELETE FROM clase WHERE id=:id");
			$query->bindParam(":id",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update Video Model  ----------*/
		public function update_video_model($data){
			$query=self::connect()->prepare("UPDATE clase SET idmateria=:materia,Video=:Video,Fecha=:Fecha,Titulo=:Titulo,Tutor=:Tutor,Descripcion=:Descripcion,Adjuntos=:Adjuntos WHERE id=:id");
			$query->bindParam(":materia",$data['materia']);
			$query->bindParam(":Video",$data['Video']);
			$query->bindParam(":Fecha",$data['Fecha']);
			$query->bindParam(":Titulo",$data['Titulo']);
			$query->bindParam(":Tutor",$data['Tutor']);
			$query->bindParam(":Descripcion",$data['Descripcion']);
			$query->bindParam(":Adjuntos",$data['Adjuntos']);
			$query->bindParam(":id",$data['id']);
			$query->execute();
			return $query;
		}
			/*----------  Update Video Model  ----------*/
			public function update_viovideo_model($data){
				$query=self::connect()->prepare("UPDATE logs SET materia=:materia,vioVideo=:vioVideo WHERE Fecha=(SELECT max(Fecha) FROM logs a	inner join Cuenta b on a.Codigo=b.Codigo
				WHERE b.Usuario=:username)");
				$query->bindParam(":materia",$data['materia']);
				$query->bindParam(":vioVideo",$data['vioVideo']);
				$query->bindParam(":username",$data['username']);
				$query->execute();
				return $query;
			}
	}