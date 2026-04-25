<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class accesoModel extends mainModel{

	/*----------  Data acceso -  Model  ----------*/
		public function show_acceso_model($dataReporte){
			$now=date('Y-m-d H:i:s');
		$query=self::connect()->prepare("SELECT lo.Usuario, lo.Codigo, lo.Fecha,lo.FechaCierreAcceso,es.Nombres,es.Apellidos,mat.materia,exm.fechainicioExamen,exm.fechafinExamen,ma.calificacion 
		FROM logs lo LEFT OUTER join estudiante es on lo.Codigo=es.Codigo LEFT OUTER join matricula ma on ma.Codigo=es.Codigo 
		LEFT OUTER join materia mat on mat.idmateria=ma.idmateria  
		LEFT OUTER join (SELECT DISTINCT ev.idevaluacion,ev.idmateria,res.codigo,res.fechainicioExamen, res.fechafinExamen 
		FROM evaluacion ev INNER JOIN resultado res on ev.idevaluacion=res.idevaluacion) exm on exm.codigo=lo.Codigo AND exm.idmateria=ma.idmateria and exm.codigo=ma.Codigo and date(exm.fechainicioExamen)=date(lo.Fecha)
		where mat.materia=:materia AND lo.Fecha BETWEEN :fechadesde AND :fechahasta
		order by lo.Fecha, es.Nombres asc
		");
			$query->bindParam(":materia",$dataReporte['materia']);
			$query->bindParam(":fechadesde",$dataReporte['fechadesde']);
			$query->bindParam(":fechahasta",$dataReporte['fechahasta']);

			$query->execute();
			return $query->fetchAll();
			$query->close();
			$query=null;
		}	
	}
?>