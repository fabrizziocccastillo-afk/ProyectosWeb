<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class InscripcionModel extends mainModel{

		/*----------  Add Inscripcion Model  ----------*/
		public function add_Inscripcion_model($data){
			$query=self::connect()->prepare("INSERT INTO matricula(Codigo,idmateria,fecha,fechamodifica,calificacion,aprobado) VALUES(:Codigo,:materia,:fecha,:fechamodifica,:calificacion,:aprobado)");
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":materia",$data['materia']);
			$query->bindParam(":fecha",$data['fecha']);
			$query->bindParam(":fechamodifica",$data['fechamodifica']);
			$query->bindParam(":calificacion",$data['calificacion']);
			$query->bindParam(":aprobado",$data['aprobado']);
			$query->execute();
			return $query;
			//echo($query);
		}


		/*----------  Data Inscripcion Model  ----------*/
		public function data_Inscripcion_model($data){
			//print_r($data['Tipo']);
			//print_r($data['Codigo']);
			//print_r($data['materia']);
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM matricula");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT idmatricula,	m.Codigo,	m.idmateria,	date(fecha) fecha,	fechamodifica,	calificacion,	calificaciontaller,	calificacionactuacion,	aprobado,	e.Codigo,	Nombres,	Apellidos,	cedula,	Email,	idpais,	idciudad,	sector,	direccion,	telefono,	iglesia,	pertenececda,	idtorre,	idcasadevida,	bautizado,	fechaNacimiento,	lugarNacimiento,	idestadocivil,	foto,	instruccion,	profesion,	dirTrabajo,	telTrabajo,	empresa,	fechaconversion,	fechabautizo,	lugarbautizo,	ma.idmateria,	ma.materia,m.comentario	,ma.notminaprueba			
				                                FROM matricula m 
												inner join estudiante e on m.Codigo=e.Codigo
												inner join materia ma on m.idmateria=ma.idmateria  
												WHERE m.Codigo=:Codigo and m.idmateria=:materia");
				$query->bindParam(":Codigo",$data['Codigo']);
				$query->bindParam(":materia",$data['materia']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete Inscripcion Model  ----------*/
		public function delete_inscripcion_model($code,$materia){
			$query=self::connect()->prepare("DELETE FROM matricula WHERE Codigo=:Codigo and idmateria=:materia");
			$query->bindParam(":Codigo",$code);
			$query->bindParam(":materia",$materia);
			$query->execute();
			return $query;
		}


		/*----------  Update Inscripcion Model  ----------*/
		public function update_inscripcion_model($data){
						print_r($data['estado']);
			$query=self::connect()->prepare("UPDATE matricula SET idmateria=:materia,fechamodifica=:fechamodifica, calificacion=:calificacion, calificaciontaller=:calificaciontaller, calificacionactuacion=:calificacionactuacion,aprobado=:aprobado,comentario=:comentario WHERE Codigo=:Codigo and idmateria=:materia");
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":materia",$data['materia']);
			$query->bindParam(":fechamodifica",$data['fechamodifica']);
			$query->bindParam(":calificacion",$data['calificacion']);
			$query->bindParam(":calificaciontaller",$data['calificaciontaller']);
			$query->bindParam(":calificacionactuacion",$data['calificacionactuacion']);
			$query->bindParam(":aprobado",$data['estado']);
			$query->bindParam(":comentario",$data['comentario']);
	
			$query->execute();
			return $query;
		}
	}