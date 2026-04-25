<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class evaluacionformModel extends mainModel{

	/*----------  Data Evaluacion Form -  Model  ----------*/
		public function show_evaluacionform_model($usuario,$code){
			//print_r($code);
			$dateNow=date("Y-m-d");
			$query=self::connect()->prepare("SELECT * FROM evaluacion ev 
			inner join matricula mat on ev.idmateria=mat.idmateria 
			inner join cuenta cuent on mat.Codigo=cuent.Codigo 
			where cuent.Usuario='$usuario' AND ev.idevaluacion not in(select idevaluacion from resultado where usuario='$usuario') AND '$dateNow' BETWEEN ev.fecha_inicio AND ev.fecha_final and ev.estado=1 and ev.idevaluacion= $code");
			$query->execute();
			return $query;
		}
		public function show_preguntasform_model($usuario,$code){
			$dateNow=date("Y-m-d");
			$query=self::connect()->prepare("SELECT * FROM evaluacion ev 
			inner join preguntas pre on ev.idevaluacion=pre.idevaluacion 
			inner join matricula mat on ev.idmateria=mat.idmateria
			inner join cuenta cuent on mat.Codigo=cuent.Codigo
			where cuent.Usuario='$usuario' AND ev.idevaluacion not in(select idevaluacion from resultado where usuario='$usuario') AND '$dateNow' BETWEEN ev.fecha_inicio AND ev.fecha_final and ev.idevaluacion= $code");
			$query->execute();
			return $query;
		}	
		public function show_respuestasform_model($usuario,$code){
			$dateNow=date("Y-m-d");
			$query=self::connect()->prepare("SELECT * FROM evaluacion ev 
			inner join preguntas pre on ev.idevaluacion=pre.idevaluacion 
			inner join respuestas res on res.idevaluacion=ev.idevaluacion and pre.idpreguntas=res.idpreguntas and pre.idevaluacion=res.idevaluacion 
			inner join matricula mat on ev.idmateria=mat.idmateria
			inner join cuenta cuent on mat.Codigo=cuent.Codigo
			where cuent.Usuario='$usuario' AND ev.idevaluacion not in(select idevaluacion from resultado where usuario='$usuario') AND '$dateNow' BETWEEN ev.fecha_inicio AND ev.fecha_final and ev.idevaluacion= $code");
			$query->execute();
			return $query;
		}	
    }
?>