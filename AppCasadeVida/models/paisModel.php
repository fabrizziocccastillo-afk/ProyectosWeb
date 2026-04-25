<?php
	if($actionsRequired){
		require_once "../core/mainModel.php";
	}else{ 
		require_once "./core/mainModel.php";
	}

	class paisModel extends mainModel{

	/*----------  Data Pais - Ciudad - torre -casa de vida-  Model  ----------*/
		public function show_pais_model(){
			$query=self::connect()->prepare("SELECT idpais,nombrepais FROM pais");
			$query->execute();
			return $query;

		}

		public function traer_dependencias_model($id_pais){
			$query=self::connect()->prepare("SELECT idciudad,nombreciudad FROM ciudad where idpais=$id_pais");
			$query->execute();
			return $query; //->fetchAll();
			//$query->close();
			//$query=null;
		}

		public function show_torre_model(){
			$query=self::connect()->prepare("SELECT idtorre,torre FROM torre where estado=1");
			$query->execute();
			return $query;

		}

		public function show_casadevida_model(){
			$query=self::connect()->prepare("SELECT idcasadevida,casadevida FROM casadevida");
			$query->execute();
			return $query;

		}

		public function traer_casadevida_model($idtorre){
            $query=self::connect()->prepare("SELECT idcasadevida,casadevida FROM casadevida where idtorre=$idtorre");
			$query->execute();
			return $query;

		}

		public function traer_torrexrol_model($usuario){
			$query=self::connect()->prepare("SELECT distinct ca.idtorre,ca.torre 
			FROM torre ca 
			left OUTER join asignacion asg on ca.idtorre=asg.idtorre 
			inner join cuenta cu on asg.codigo=cu.Codigo 
			where cu.Usuario='$usuario' ORDER BY ca.idtorre ASC");

			$query->execute();
			return $query; 
		}

		public function traer_CDVxrol_model($usuario){
			$query=self::connect()->prepare("SELECT distinct ca.idcasadevida,ca.casadevida 
			FROM casadevida ca 
			left OUTER join asignacion asg on ca.idcasadevida=asg.idcasadevida 
			inner join cuenta cu on asg.codigo=cu.Codigo 
			where cu.Usuario='$usuario' AND ca.idtorre IN (SELECT MIN(ca.idtorre)
			FROM torre ca 
			left OUTER join asignacion asg on ca.idtorre=asg.idtorre 
			inner join cuenta cu on asg.codigo=cu.Codigo 
			where cu.Usuario='$usuario') ORDER BY ca.idcasadevida ASC");

			$query->execute();
			return $query; 
		}

		public function show_estadocivil_model(){
			$query=self::connect()->prepare("SELECT idestadocivil,estadocivil FROM estadocivil where estado=1");
			$query->execute();
			return $query;

		}

		public function show_rol_model(){
			$query=self::connect()->prepare("SELECT idrol,rol FROM rol where estado=1");
			$query->execute();
			return $query;

		}
		//show_cargos_model
		public function show_cargos_model(){
			$query=self::connect()->prepare("SELECT idcargo,cargo FROM cargo where estado=1");
			$query->execute();
			return $query;

		}
		public function show_ministerios_model(){
			$query=self::connect()->prepare("SELECT idarea,area FROM area where estado=1");
			$query->execute();
			return $query;

		}

		public function show_predicador_model($usuario){
			$query=self::connect()->prepare("SELECT Codigo, concat_ws(' ', Nombres, Apellidos) as predicador 
			from integrante where idcasadevida in (SELECT MIN(idcasadevida) FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario') and idcargo in(1,2,3,4)");
			$query->execute();
			return $query;

		}

		public function show_discipulo_model($idcasadevida,$usuario,$discipulo){
			$query=self::connect()->prepare("SELECT Codigo, concat_ws(' ', Nombres, Apellidos) as predicador,direccion,telefono,telTrabajo , Email,foto 
			from integrante where idcasadevida in (SELECT idcasadevida FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario' AND asig.idcasadevida=$idcasadevida) and Codigo='$discipulo'");
			$query->execute();
			return $query;

		}

		

		public function show_discipuloList_model($idcasadevida,$usuario){
			$query=self::connect()->prepare("SELECT Codigo, concat_ws(' ', Nombres, Apellidos) as discipulo,direccion,telefono,telTrabajo , Email 
			from integrante where idcasadevida in (SELECT idcasadevida FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario' AND asig.idcasadevida=$idcasadevida)");
			$query->execute();
			return $query;

		}

		public function show_discipuloxCDV_model($usuario){
			$query=self::connect()->prepare("SELECT Codigo, concat_ws(' ', Nombres, Apellidos) as discipulo 
			from integrante where idcasadevida in (SELECT MIN(idcasadevida) FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario')");
			$query->execute();
			return $query;

		}

		public function show_predicadorxCDV_model($idcasadevida,$usuario){
			$query=self::connect()->prepare("SELECT Codigo, concat_ws(' ', Nombres, Apellidos) as predicador,direccion,telefono,telTrabajo , Email 
			from integrante where idcasadevida in (SELECT idcasadevida FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario' AND asig.idcasadevida=$idcasadevida) and idcargo in(1,2,3,4)");
			$query->execute();
			return $query;

		}

		public function show_integrantesCDV_model($usuario){
			$query=self::connect()->prepare("SELECT i.Codigo, concat_ws(' ', i.Nombres, i.Apellidos) as nombres ,i.idcargo, c.cargo
			from integrante i
            inner join cargo c on i.idcargo=c.idcargo
            where i.idcasadevida in (SELECT idcasadevida FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario' AND asig.idcasadevida IN (SELECT MIN(ca.idcasadevida)
			FROM casadevida ca 
			left OUTER join asignacion asg on ca.idcasadevida=asg.idcasadevida 
			inner join cuenta cu on asg.codigo=cu.Codigo 
			where cu.Usuario='$usuario' AND ca.idtorre IN (SELECT MIN(ca.idtorre)
			FROM torre ca 
			left OUTER join asignacion asg on ca.idtorre=asg.idtorre 
			inner join cuenta cu on asg.codigo=cu.Codigo 
			where cu.Usuario='$usuario'))) 
			ORDER BY i.idcargo ");
			$query->execute();
			return $query;
		}
		public function show_integrantesCDV_model2($idcasadevida,$usuario){
			$query=self::connect()->prepare("SELECT i.Codigo, concat_ws(' ', i.Nombres, i.Apellidos) as nombres ,i.idcargo, c.cargo
			from integrante i
            inner join cargo c on i.idcargo=c.idcargo
            where i.idcasadevida in (SELECT idcasadevida FROM asignacion asig inner join cuenta cu on asig.codigo=cu.Codigo WHERE cu.Usuario='$usuario' AND asig.idcasadevida=$idcasadevida) 
			ORDER BY i.idcargo ");
			$query->execute();
			return $query;
		}

	}
?>