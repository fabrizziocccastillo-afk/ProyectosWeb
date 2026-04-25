<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class usuarioModel extends mainModel{

		/*----------  Add usuario Model  ----------*/
		public function add_usuario_model($data){
			$query=self::connect()->prepare("INSERT INTO usuariocdv(Codigo,Nombres,Apellidos,telefono,cedula
			/*Email,direccion,idpais,idciudad,iglesia,pertenececda,idtorre,idcasadevida,bautizado,sector,fechaNacimiento,
			lugarNacimiento,idestadocivil,foto,instruccion,profesion,dirTrabajo,telTrabajo,empresa,fechaconversion,fechabautizo,lugarbautizo*/
			) VALUES(:Codigo,:Nombres,:Apellidos,:telefono,
			/*,:Email,:direccion,:pais,:ciudad,:iglesia,:pertenececda,:torre,:casadevida,:bautizado,:sector,:fechanacimiento,
			:lugarnacimiento,:idestadocivil,:foto,:instruccion,:profesion,:dirtrabajo,:teltrabajo,:empresa,:fechaconversion,:fechabautizo,:lugarbautizo,*/
			:cedula)");
			$query->bindParam(":Codigo",$data['Codigo']);
			$query->bindParam(":Nombres",$data['Nombres']);
			$query->bindParam(":Apellidos",$data['Apellidos']);
			//$query->bindParam(":Email",$data['Email']);
			//$query->bindParam(":direccion",$data['direccion']);
			$query->bindParam(":telefono",$data['telefono']);
			/*$query->bindParam(":pais",$data['pais']);
			$query->bindParam(":ciudad",$data['ciudad']);
			$query->bindParam(":iglesia",$data['iglesia']);
			$query->bindParam(":pertenececda",$data['pertenececda']);
			$query->bindParam(":torre",$data['torre']);
			$query->bindParam(":casadevida",$data['casadevida']);
			$query->bindParam(":bautizado",$data['bautizado']);
			$query->bindParam(":sector",$data['sector']);
            $query->bindParam(":fechanacimiento",$data['fechanacimiento']);
            $query->bindParam(":lugarnacimiento",$data['lugarnacimiento']);
            $query->bindParam(":idestadocivil",$data['estadocivil']);
			$query->bindParam(":foto",$data['foto']);
            $query->bindParam(":instruccion",$data['instruccion']);
            $query->bindParam(":profesion",$data['profesion']);
            $query->bindParam(":dirtrabajo",$data['dirtrabajo']);
            $query->bindParam(":teltrabajo",$data['teltrabajo']);
            $query->bindParam(":empresa",$data['empresa']);
            $query->bindParam(":fechaconversion",$data['fechaconversion']);
            $query->bindParam(":fechabautizo",$data['fechabautizo']);
            $query->bindParam(":lugarbautizo",$data['lugarbautizo']);*/
            $query->bindParam(":cedula",$data['cedula']);
		

			//print_r($data);
			$query->execute();
			return $query;
		}


		/*----------  Data usuario Model  ----------*/
		public function data_usuario_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM usuariocdv");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM usuariocdv a 
												left OUTER join pais b on a.idpais=b.idpais
												left OUTER join ciudad c on b.idpais=c.idpais and a.idciudad=c.idciudad
												left OUTER join torre t on a.idtorre=t.idtorre
												left OUTER join casadevida ca on a.idcasadevida=ca.idcasadevida  WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		/*----------  Data Update usuario Model  ----------*/
		public function data_usuario_actualiza_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM usuariocdv");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM usuariocdv a 
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
		public function data_usuario_actualiza_ADM_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM usuariocdv");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM usuariocdv a 
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


		/*----------  Delete usuario Model  ----------*/
		public function delete_usuario_model($code){
			$query=self::connect()->prepare("DELETE u.*,c.* FROM usuariocdv u inner join cuenta c on c.Codigo=u.Codigo
			where u.Codigo =:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;
		}


		/*----------  Update usuario Model  ----------*/
		public function update_usuario_model($data){
			$query=self::connect()->prepare("UPDATE usuariocdv SET Nombres=:Nombres,Apellidos=:Apellidos,Email=:Email,direccion=:direccion,telefono=:telefono,idpais=:pais,idciudad=:ciudad,iglesia=:iglesia,pertenececda=:pertenececda,idtorre=:torre,idcasadevida=:casadevida,bautizado=:bautizado,sector=:sector
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