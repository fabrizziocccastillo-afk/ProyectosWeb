<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class studentModel extends mainModel{

		/*----------  Add Student Model  ----------*/
		public function add_student_model($data){
			$query=self::connect()->prepare("INSERT INTO estudiante(Codigo,Nombres,Apellidos,Email,direccion,telefono,idpais,idciudad,iglesia,pertenececda,idtorre,idcasadevida,bautizado) VALUES(:Codigo,:Nombres,:Apellidos,:Email,:direccion,:telefono,:pais,:ciudad,:iglesia,:pertenececda,:torre,:casadevida,:bautizado)");
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":Nombres",$data['Nombres']);
			$query->bindParam(":Apellidos",$data['Apellidos']);
			$query->bindParam(":Email",$data['Email']);
			$query->bindParam(":direccion",$data['direccion']);
			$query->bindParam(":telefono",$data['telefono']);
			$query->bindParam(":pais",$data['pais']);
			$query->bindParam(":ciudad",$data['ciudad']);
			$query->bindParam(":iglesia",$data['iglesia']);
			$query->bindParam(":pertenececda",$data['pertenececda']);
			$query->bindParam(":torre",$data['torre']);
			$query->bindParam(":casadevida",$data['casadevida']);
			$query->bindParam(":bautizado",$data['bautizado']);
			$query->execute();
			return $query;
		}


		/*----------  Data Student Model  ----------*/
		public function data_student_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM estudiante");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM estudiante a 
												left OUTER join pais b on a.idpais=b.idpais
												left OUTER join ciudad c on b.idpais=c.idpais and a.idciudad=c.idciudad
												left OUTER join torre t on a.idtorre=t.idtorre
												left OUTER join casadevida ca on a.idcasadevida=ca.idcasadevida  WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Data Update Student Model  ----------*/
		public function data_student_actualiza_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM estudiante");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM estudiante a 
												left OUTER join pais b on a.idpais=b.idpais
												left OUTER join ciudad c on b.idpais=c.idpais and a.idciudad=c.idciudad
												left OUTER join torre t on a.idtorre=t.idtorre
												left OUTER join casadevida ca on a.idcasadevida=ca.idcasadevida 
												LEFT OUTER JOIN estadocivil EC on EC.idestadocivil=a.idestadocivil 
												WHERE Codigo=(select Codigo from cuenta where Usuario=:Codigo)");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Data Update Student Model  ----------*/
		public function data_student_actualiza_ADM_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM estudiante");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM estudiante a 
												left OUTER join pais b on a.idpais=b.idpais
												left OUTER join ciudad c on b.idpais=c.idpais and a.idciudad=c.idciudad
												left OUTER join torre t on a.idtorre=t.idtorre
												left OUTER join casadevida ca on a.idcasadevida=ca.idcasadevida 
												LEFT OUTER JOIN estadocivil EC on EC.idestadocivil=a.idestadocivil 
												WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}


		/*----------  Delete Student Model  ----------*/
		public function delete_student_model($code){
			$query=self::connect()->prepare("DELETE FROM estudiante WHERE Codigo=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update Student Model  ----------*/
		public function update_student_model($data){
			$query=self::connect()->prepare("UPDATE estudiante SET Nombres=:Nombres,Apellidos=:Apellidos,Email=:Email,direccion=:direccion,telefono=:telefono,idpais=:pais,idciudad=:ciudad,iglesia=:iglesia,pertenececda=:pertenececda,idtorre=:torre,idcasadevida=:casadevida,bautizado=:bautizado,sector=:sector
			,fechaNacimiento=:fechaNacimiento,
			lugarNacimiento=:lugarNacimiento,
			idestadocivil=:estadocivil,
			instruccion=:instruccion,
			profesion=:profesion,
			dirTrabajo=:dirTrabajo,
			telTrabajo=:telTrabajo,
			empresa=:empresa,
			fechaconversion=:fechaconversion,
			fechabautizo=:fechabautizo,
			lugarbautizo=:lugarbautizo,
			cedula=:cedula
			WHERE Codigo=:Codigo");
			$query->bindParam(":Nombres",$data['Nombres']);
			$query->bindParam(":Apellidos",$data['Apellidos']);
			$query->bindParam(":Email",$data['Email']);
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":direccion",$data['direccion']);
			$query->bindParam(":telefono",$data['telefono']);
			$query->bindParam(":pais",$data['pais']);
			$query->bindParam(":ciudad",$data['ciudad']);
			$query->bindParam(":iglesia",$data['iglesia']);
			$query->bindParam(":pertenececda",$data['pertenececda']);
			$query->bindParam(":torre",$data['torre']);
			$query->bindParam(":casadevida",$data['casadevida']);
			$query->bindParam(":bautizado",$data['bautizado']);
			$query->bindParam(":sector",$data['sector']);
			$query->bindParam(":fechaNacimiento",$data['fechanacimiento']);
			$query->bindParam(":lugarNacimiento",$data['lugarnacimiento']);
			$query->bindParam(":estadocivil",$data['estadocivil']);
			$query->bindParam(":instruccion",$data['instruccion']);
			$query->bindParam(":profesion",$data['profesion']);
			$query->bindParam(":dirTrabajo",$data['dirtrabajo']);
			$query->bindParam(":telTrabajo",$data['teltrabajo']);
			$query->bindParam(":empresa",$data['empresa']);
			$query->bindParam(":fechaconversion",$data['fechaconversion']);
			$query->bindParam(":fechabautizo",$data['fechabautizo']);
			$query->bindParam(":lugarbautizo",$data['lugarbautizo']);
			$query->bindParam(":cedula",$data['cedula']);
			$query->execute();
			return $query;

			
		}
	}