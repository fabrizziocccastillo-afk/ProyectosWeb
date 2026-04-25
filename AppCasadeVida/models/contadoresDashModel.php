<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class contadoresModel extends mainModel{

		/*----------  Add Evaluacion Model  ----------*/
		public function add_evaluacion_model($data){
			$query=self::connect()->prepare("INSERT INTO evaluacion(idmateria,titulo,tutor,notamin,descripcion,fecha_inicio,fecha_final,hora,minuto,segundo,estado) VALUES(:materia,:titulo,:tutor,:notamin,:descripcion,:fecha_inicio,:fecha_final,:h,:m,:s,:estado)");
			$query->bindParam(":materia",$data['materia']);
			$query->bindParam(":titulo",$data['titulo']);
			$query->bindParam(":tutor",$data['tutor']);
			$query->bindParam(":notamin",$data['notamin']);
			$query->bindParam(":descripcion",$data['descripcion']);
			$query->bindParam(":fecha_inicio",$data['fecha_inicio']);
			$query->bindParam(":fecha_final",$data['fecha_final']);
			$query->bindParam(":h",$data['h']);
			$query->bindParam(":m",$data['m']);
			$query->bindParam(":s",$data['s']);
			$query->bindParam(":estado",$data['estado']);
			$query->execute();
			return $query;
		}

		/*----------  Add Preguntas Model  ----------*/
		public function add_preguntas_model($data){
			$query=self::connect()->prepare("INSERT INTO preguntas(idevaluacion,pregunta,puntos) VALUES(:idevaluacion,:pregunta,:puntos)");
			$query->bindParam(":idevaluacion",$data['idevaluacion']);
			$query->bindParam(":pregunta",$data['pregunta']);
			$query->bindParam(":puntos",$data['puntos']);
			$query->execute();
			return $query;
		}

		/*----------  Add Respuestas Model  ----------*/
		public function add_respuestas_model($data){
			$query=self::connect()->prepare("INSERT INTO respuestas(idevaluacion,idpreguntas,respuesta,correcta) VALUES(:idevaluacion,:idpreguntas,:respuesta,:correcta)");
			$query->bindParam(":idevaluacion",$data['idevaluacion']);
			$query->bindParam(":idpreguntas",$data['idpreguntas']);
			$query->bindParam(":respuesta",$data['respuesta']);
			$query->bindParam(":correcta",$data['correcta']);
			$query->execute();
			return $query;
		}


		/*----------  Data evaluacion Model  ----------*/
		public function data_evaluacion_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT idevaluacion FROM evaluacion");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM evaluacion ev 
				INNER join preguntas pr on ev.idevaluacion=pr.idevaluacion
				INNER join respuestas res on pr.idpreguntas=res.idpreguntas and ev.idevaluacion=res.idevaluacion
				where ev.idevaluacion=:idevaluacion");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete Evaluacion Model  ----------*/
		public function delete_evaluacion_model($code,$materia){
			$query=self::connect()->prepare("UPDATE evaluacion SET estado=0 WHERE idevaluacion=:idevaluacion and idmateria=:idmateria");
			$query->bindParam(":idevaluacion",$code);
			$query->bindParam(":idmateria",$materia);
			$query->execute();
			return $query;
		}

		/*----------  Delete Preguntas Model  ----------*/
		public function delete_preguntas_model($code){
			$query=self::connect()->prepare("DELETE FROM preguntas WHERE idevaluacion=:idevaluacion and idpreguntas=:idpreguntas");
			$query->bindParam(":idevaluacion",$code);
			$query->bindParam(":idpreguntas",$code);
			$query->execute();
			return $query;
		}

		/*----------  Delete Respuestas Model  ----------*/
		public function delete_respuestas_model($code){
			$query=self::connect()->prepare("DELETE FROM respuestas WHERE idevaluacion=:idevaluacion and idpreguntas=:idpreguntas and idrespuestas=:idrespuestas");
			$query->bindParam(":idevaluacion",$idevaluacion);
			$query->bindParam(":idpreguntas",$idpreguntas);
			$query->bindParam(":idrespuestas",$idrespuestas);
			$query->execute();
			return $query;
		}


		/*----------  Update Evaluacion Model  ----------*/
		public function update_student_model($data){
			$query=self::connect()->prepare("UPDATE evaluacion SET idmateria=:idmateria,tutor=:tutor,titulo=:titulo,descripcion=:descripcion,fecha_inicio=:fecha_inicio,fecha_final:=fecha_final,tiempo=:tiempo,estado=:estado WHERE idevaluacion=:idevaluacion");
			$query->bindParam(":idevaluacion",$data['idevaluacion']);
			$query->bindParam(":idmateria",$data['idmateria']);
			$query->bindParam(":tutor",$data['tutor']);
			$query->bindParam(":titulo",$data['titulo']);
			$query->bindParam(":descripcion",$data['descripcion']);
			$query->bindParam(":fecha_inicio",$data['fecha_inicio']);
			$query->bindParam(":fecha_final",$data['fecha_final']);
			$query->bindParam(":tiempo",$data['tiempo']);
			$query->bindParam(":estado",$data['estado']);
			$query->execute();
			return $query;
		}

			/*----------  Update Preguntas Model  ----------*/
			public function update_preguntas_model($data){
				$query=self::connect()->prepare("UPDATE preguntas SET pregunta=:pregunta,puntos=:puntos WHERE idevaluacion=:idevaluacion");
				$query->bindParam(":idevaluacion",$data['idevaluacion']);
				$query->bindParam(":pregunta",$data['pregunta']);
				$query->bindParam(":puntos",$data['puntos']);
				$query->execute();
				return $query;
			}
	
			/*----------  Update Respuestas Model  ----------*/
			public function update_respuestas_model($data){
				$query=self::connect()->prepare("UPDATE respuestas SET respuesta=:respuesta,correcta=:correcta WHERE idevaluacion=:idevaluacion and idpreguntas=:idpreguntas");
				$query->bindParam(":idevaluacion",$idevaluacion);
			    $query->bindParam(":idpreguntas",$idpreguntas);
				$query->bindParam(":respuesta",$data['respuesta']);
				$query->bindParam(":correcta",$data['correcta']);
				$query->execute();
				return $query;
			}
	}