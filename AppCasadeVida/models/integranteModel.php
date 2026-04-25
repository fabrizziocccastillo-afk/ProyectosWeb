<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./core/mainModel.php";
		require_once "./core/configGeneral.php";
	}

	class integranteModel extends mainModel{

		/*----------  Add Integrante Model  ----------*/
		public function add_integrante_model($data){
			$query=self::connect()->prepare("INSERT INTO integrante(Codigo,Nombres,Apellidos,Email,idpais,idciudad,sector,direccion,telefono,iglesia,pertenececda,idtorre,idcasadevida,bautizado,fechaNacimiento,
			lugarNacimiento,idestadocivil,foto,instruccion,profesion,dirTrabajo,telTrabajo,empresa,fechaconversion,fechabautizo,lugarbautizo,cedula, idcargo,idarea,fechainicioservicio, estado,estudios,discipulado) VALUES(:Codigo,:Nombres,:Apellidos,:Email,:pais,:ciudad,:sector,:direccion,:telefono,:iglesia,:pertenececda,:torre,:casadevida,:bautizado,:fechanacimiento,
			:lugarnacimiento,:idestadocivil,:foto,:instruccion,:profesion,:dirtrabajo,:teltrabajo,:empresa,:fechaconversion,:fechabautizo,:lugarbautizo,:cedula,:cargo,:ministerio,:fechainiservicio,:estado,:estudio,:discipulado)");
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
            $query->bindParam(":lugarbautizo",$data['lugarbautizo']);
            $query->bindParam(":cedula",$data['cedula']);
			$query->bindParam(":cargo",$data['cargo']);
			$query->bindParam(":ministerio",$data['ministerio']);
			$query->bindParam(":fechainiservicio",$data['fechainiservicio']);
			$query->bindParam(":estado",$data['estado']);
			$query->bindParam(":estudio",$data['estudio']);
			$query->bindParam(":discipulado",$data['discipulado']);
			
             
			//print_r($query);

			$query->execute();
			return $query;
		}

		/*----------  Add Seguimiento Integrante Model  ----------*/
		public function add_integranteSeguimiento_model($data){
			$query=self::connect()->prepare("INSERT INTO seguimiento(usuarioregistro,fecha,idtorre,idcasadevida,codresponsable,coddiscipulo,asunto,temas,modoreunion,horacita,horaproximareunion,fechaproximareunion,lugar,observacion) VALUES(:usuarioregistro,:fecha,:idtorre,:idcasadevida,:codresponsable,:coddiscipulo,:asunto,:temas,:modoreunion,:horacita,:horaproximareunion,:fechaproximareunion,:lugar,:observacion)");
			$query->bindParam(":usuarioregistro",$data['usuario']);
			$query->bindParam(":fecha",$data['fecha']);
			$query->bindParam(":idtorre",$data['torres']);
			$query->bindParam(":idcasadevida",$data['casavida']);
			$query->bindParam(":codresponsable",$data['predicador']);
			$query->bindParam(":coddiscipulo",$data['discipulo']);
			$query->bindParam(":asunto",$data['asunto']);
			$query->bindParam(":temas",$data['temas']);
			$query->bindParam(":modoreunion",$data['modoreunion']);
			$query->bindParam(":horacita",$data['horacita']);
			$query->bindParam(":horaproximareunion",$data['horaproximareunion']);
			$query->bindParam(":fechaproximareunion",$data['fechaproximareunion']);
			$query->bindParam(":lugar",$data['lugar']);
			$query->bindParam(":observacion",$data['observacion']);

			$query->execute();
			return $query;
		}


		/*----------  Data Student Model  ----------*/
		public function data_integrante_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM integrante");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM integrante a 
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
		public function data_integrante_actualiza_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM integrante");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM integrante a 
												left OUTER join pais b on a.idpais=b.idpais
												left OUTER join ciudad c on b.idpais=c.idpais and a.idciudad=c.idciudad
												left OUTER join torre t on a.idtorre=t.idtorre
												left OUTER join casadevida ca on a.idcasadevida=ca.idcasadevida 
												LEFT OUTER JOIN estadocivil EC on EC.idestadocivil=a.idestadocivil 
												LEFT OUTER JOIN cargo carg on a.idcargo=carg.idcargo
												LEFT OUTER JOIN area ar on a.idarea=ar.idarea
												WHERE Codigo=(select Codigo from cuenta where Usuario=:Codigo)");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}
        
		/*----------  Data Update Student Model  ----------*/
		public function data_integrante_actualiza_ADM_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT Codigo FROM integrante");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT * FROM integrante a 
												left OUTER join pais b on a.idpais=b.idpais
												left OUTER join ciudad c on b.idpais=c.idpais and a.idciudad=c.idciudad
												left OUTER join torre t on a.idtorre=t.idtorre
												left OUTER join casadevida ca on a.idcasadevida=ca.idcasadevida 
												LEFT OUTER JOIN estadocivil EC on EC.idestadocivil=a.idestadocivil 
												LEFT OUTER JOIN cargo carg on a.idcargo=carg.idcargo
												LEFT OUTER JOIN area ar on a.idarea=ar.idarea
												WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;
		}

		public function data_asistencia_info_model($data){
			if($data['Tipo']=="Count"){
				$query=self::connect()->prepare("SELECT * FROM asistenciacdvcab");
			}elseif($data['Tipo']=="Only"){
				$query=self::connect()->prepare("SELECT cab.idasistenciacdvcab,cab.fecha,t.torre ,c.casadevida,concat_ws(' ', i.Nombres, i.Apellidos) as predicador,cab.ofrenda,cab.reunion,cab.observacion, concat_ws(' ', it.Nombres, it.Apellidos) as nombres
												,ca.cargo,det.asistio,det.martes,det.domingo,det.invito,det.vinieron
												FROM asistenciacdvcab cab
												inner join torre t on cab.idtorre=t.idtorre
												inner join casadevida c on cab.idcasadevida=c.idcasadevida 
												inner join integrante i on cab.codpredicador=i.Codigo
												inner join asistenciacdvdet det on cab.idasistenciacdvcab=det.idasistenciacdvcab
												inner join integrante it on det.codintegrante=it.Codigo
												inner join cargo ca on ca.idcargo=det.codcargo
												where cab.idasistenciacdvcab=:Codigo");
				$query->bindParam(":Codigo",$data['Codigo']);
			}
			$query->execute();
			return $query;

		}

		/*----------  Delete Student Model  ----------*/
		public function delete_integrante_model($code){
			$query='';
			$fechafin=date('Y-m-d');
			$estado=1;
			$cadena=self::execute_single_query("SELECT estado FROM integrante WHERE Codigo='$code'");
			if($cadena->rowCount()>0){
				$rows=$cadena->fetchAll();
                $estado=$rows[0];
			}

			//print_r($estado);

			if($estado[0]==1){
				$query=self::connect()->prepare("UPDATE integrante SET estado=0,fechafinservicio='$fechafin' WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$code);
				$query->execute();
		    }else{
				$query=self::connect()->prepare("UPDATE integrante SET estado=1,fechafinservicio='$fechafin' WHERE Codigo=:Codigo");
				$query->bindParam(":Codigo",$code);
				$query->execute();
			}


			return $query;
		}

		/*----------  Elimina Asistencia Integrante Model  ----------*/
		public function delete_asistenciaint_model($code){
            
			$query=self::connect()->prepare("DELETE asiscab.*,asisdet.* FROM `asistenciacdvcab` asiscab
			inner join asistenciacdvdet asisdet on asiscab.idasistenciacdvcab=asisdet.idasistenciacdvcab
			where asiscab.idasistenciacdvcab=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;

		}
        
		/*----------  Elimina Seguimiento Integrante Model  ----------*/
		public function delete_seguimientoint_model($code){
            
			$query=self::connect()->prepare("DELETE FROM seguimiento 
			where idseguimiento=:Codigo");
			$query->bindParam(":Codigo",$code);
			$query->execute();
			return $query;

		}



		/*----------  Update Integrante Model  ----------*/
		public function update_integrante_model($data){
			//var_dump($data);
			//exit();
			$query=self::connect()->prepare("UPDATE integrante SET Nombres=:Nombres,Apellidos=:Apellidos,Email=:Email,direccion=:direccion,telefono=:telefono,idpais=:pais,idciudad=:ciudad,iglesia=:iglesia,pertenececda=:pertenececda,idtorre=:torre,idcasadevida=:casadevida,bautizado=:bautizado,sector=:sector
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
			cedula=:cedula,
			idcargo=:cargo,
			idarea=:ministerio,
			fechainicioservicio=:fechainiservicio,
			fechafinservicio=:fechafinservicio,
			observacion=:observacion,
			estudios=:estudio,
			discipulado=:discipulado
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
			$query->bindParam(":cargo",$data['cargo']);
			$query->bindParam(":ministerio",$data['ministerio']);
			$query->bindParam(":fechainiservicio",$data['fechainiservicio']);
			$query->bindParam(":fechafinservicio",$data['fechafinservicio']);
			$query->bindParam(":observacion",$data['observacion']);
			$query->bindParam(":estudio",$data['estudio']);
			$query->bindParam(":discipulado",$data['discipulado']);
			$query->execute();
			return $query;

			
		}
	}