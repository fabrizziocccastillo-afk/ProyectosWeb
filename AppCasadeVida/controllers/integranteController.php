<?php
	if($actionsRequired){
		require_once "../models/integranteModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/integranteModel.php";
		require_once "./core/configGeneral.php";
	}
	

	class integranteController extends integranteModel{

		

		/*----------  Add Integrante Controller  ----------*/
		public function add_integrante_controller(){
			//$code=self::clean_string($_POST['code']);			
			$foto="";
			$name=self::clean_string($_POST['name']);
			$lastname=self::clean_string($_POST['lastname']);
			$email=self::clean_string($_POST['email']);
			$direccion=self::clean_string($_POST['direccion']);
			$telefono=self::clean_string($_POST['telefono']);
			$pais=self::clean_string($_POST['pais']);
			$ciudad=self::clean_string($_POST['ciudad']);
			$iglesia=self::clean_string($_POST['iglesia']);
			$pertenececda=self::clean_string($_POST['pertenececda']);
			$torre=self::clean_string($_POST['torres']);
			$casadevida=self::clean_string($_POST['casavida']);
			$bautizado=self::clean_string($_POST['bautizado']);
			$sector=self::clean_string($_POST['sector']);
			$fechanacimiento=self::clean_string($_POST['fecha']);
            $lugarnacimiento=self::clean_string($_POST['lugar']);
            $estadocivil=self::clean_string($_POST['estado']);
            $instruccion=self::clean_string($_POST['instruccion']);
            $profesion=self::clean_string($_POST['profesion']);
            $dirtrabajo=self::clean_string($_POST['dirtrabajo']);
            $teltrabajo=self::clean_string($_POST['teltrabajo']);
            $empresa=self::clean_string($_POST['empresa']);
			$fechaconversion=self::clean_string($_POST['fechaconversion']);
			$fechabautizo=self::clean_string($_POST['fechabautizo']);
			$lugarbautizo=self::clean_string($_POST['lugarbautizo']);
			$cedula=self::clean_string($_POST['cedula']);
			$cargo=self::clean_string($_POST['cargo']);
			$ministerio=self::clean_string($_POST['area']); //fechainiservicio
			$fechainiservicio=self::clean_string($_POST['fechainiservicio']);
			$estudio=self::clean_string($_POST['estudio']);
			$discipulado=self::clean_string($_POST['discipulado']);
			$estado=1;

				
					$query1=self::execute_single_query("SELECT Codigo FROM integrante WHERE cedula='$cedula'");
					if($query1->rowCount()<=0){
						$query2=self::execute_single_query("SELECT Codigo FROM integrante");
						$correlative=($query2->rowCount())+1;

						$code=self::generate_code("IC",7,$correlative);
	
						$dataIntegrante=[
                            "Codigo"=>$code,
                            "Nombres"=>$name,
                            "Apellidos"=>$lastname,
                            "Email"=>$email,
                            "direccion"=>$direccion,
                            "telefono"=>$telefono,
                            "pais"=>$pais,
                            "ciudad"=>$ciudad,
                            "iglesia"=>$iglesia,
                            "pertenececda"=>$pertenececda,
                            "torre"=>$torre,
                            "casadevida"=>$casadevida,
                            "bautizado"=>$bautizado,
                            "sector"=>$sector,
                            "fechanacimiento"=>$fechanacimiento,
                            "lugarnacimiento"=>$lugarnacimiento,
                            "estadocivil"=>$estadocivil,
							"foto"=>$foto,
                            "instruccion"=>$instruccion,
                            "profesion"=>$profesion,
                            "dirtrabajo"=>$dirtrabajo,
                            "teltrabajo"=>$teltrabajo,
                            "empresa"=>$empresa,
                            "fechaconversion"=>$fechaconversion,
                            "fechabautizo"=>$fechabautizo,
                            "lugarbautizo"=>$lugarbautizo,
                            "cedula"=>$cedula,
							"cargo"=>$cargo,
							"ministerio"=>$ministerio,
							"fechainiservicio"=>$fechainiservicio,
							"estado"=>$estado,
							"estudio"=>$estudio,
							"discipulado"=>$discipulado
                        ];

						//if(self::save_account($dataAccount) && self::add_integrante_model($dataintegrante)){
                        if(self::add_integrante_model($dataIntegrante)){
							$dataAlert=[
								"title"=>"¡Integrante registrado!",
								"text"=>"El Integrante se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el Integrante, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El Integrante que acaba de ingresar ya se encuentra registrado en el sistema, por favor elija otro",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}


		}

		public function add_integranteAsistencia_controller(){


				/*echo "<pre>";       
				print_r($_POST);
				echo "</pre>"; 
				exit();*/

			$usuario=self::clean_string($_POST['usuario']);
			$fecha=self::clean_string($_POST['fecha']);
			$torres=self::clean_string($_POST['torres']);
			$casavida=self::clean_string($_POST['casavida']);
			$predicador=self::clean_string($_POST['predicador']);
			$ofrenda=self::clean_string($_POST['ofrenda']);
			$reunion=self::clean_string($_POST['reunion']);
			$observacion=self::clean_string($_POST['observacion']);
			$codintegrante=$_POST['codintegrante'];
			$codcargo=$_POST['codcargo'];
			$asistio=$_POST['asistio'];
			$martes=$_POST['martes'];
			$domingo=$_POST['domingo'];
			$invito=$_POST['invito'];
			$vinieron=$_POST['vinieron'];


             
			$cadena="INSERT INTO asistenciacdvcab(usuarioregistro,fecha,idtorre,idcasadevida,codpredicador,ofrenda,reunion,observacion)values ('".$usuario."','".$fecha."',".$torres.",".$casavida.",'".$predicador."',".$ofrenda.",'".$reunion."','".$observacion."')"; 
			$query=self::execute_single_query($cadena);
            if($query){
			   
				$query1=self::execute_single_query("SELECT max(idasistenciacdvcab) as idasistenciacdvcab FROM asistenciacdvcab WHERE usuarioregistro='$usuario' AND idtorre=$torres and idcasadevida=$casavida");
		    }

			if($query1->rowCount()>0){
				$rows=$query1->fetch();
				$idasistenciacdvcab=$rows['idasistenciacdvcab'];

                for($i=0; $i<count($codintegrante); $i++){
                  
					$cadena2="";
					$valor1=0;
					$valor2=0;
					//if($martes[$i]=$i+1){ $valor1=1;}
					//if($domingo[$i]=$i+1){ $valor2=1;}
					for($j=0; $j<count($martes); $j++){
						if($martes[$j]==$i+1){
							$valor1=1; 
						}
				     }

					for($k=0; $k<count($domingo); $k++){
						if($domingo[$k]==$i+1){
							$valor2=1; 
						}
					}
                    $cadena2="INSERT INTO asistenciacdvdet(idasistenciacdvcab,codintegrante,codcargo,asistio,martes,domingo,invito,vinieron)values (".$idasistenciacdvcab.",'".$codintegrante[$i]."',".$codcargo[$i].",'".$asistio[$i]."',".$valor1.",".$valor2.",".$invito[$i].",".$vinieron[$i].")";
                    $query2=self::execute_single_query($cadena2);
                    //print_r($cadena2);
				}


			}

			if($query2){
				$dataAlert=[
					"title"=>"¡Asistencia registrada!",
					"text"=>"La Asistencia se registro con éxito en el sistema",
					"type"=>"success"
				];
				unset($_POST);
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido registrar la asistencia, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}


		}

		public function add_integranteSeguimiento_controller(){

			    /*echo "<pre>";       
				print_r($_POST);
				echo "</pre>"; 
				exit();*/

				$usuario=self::clean_string($_POST['usuario']);
				$fecha=self::clean_string($_POST['fecha']);
				$torres=self::clean_string($_POST['torres']);
				$casavida=self::clean_string($_POST['casavida']);
				$predicador=self::clean_string($_POST['predicador']);
				$discipulo=self::clean_string($_POST['discipulo']);
				$asunto=self::clean_string($_POST['asunto']);
				$temas=self::clean_string($_POST['temas']);
				$modoreunion=self::clean_string($_POST['modoreunion']);
				$horacita=self::clean_string($_POST['horacita']);
				$horaproximareunion=self::clean_string($_POST['horaproximareunion']);
				$fechaproximareunion=self::clean_string($_POST['fechaproximareunion']);
				$lugar=self::clean_string($_POST['lugar']);
				$observacion=self::clean_string($_POST['observacion']);

				$dataSeguimiento=[
					"usuario"=>$usuario,
					"fecha"=>$fecha,
					"torres"=>$torres,
					"casavida"=>$casavida,
					"predicador"=>$predicador,
					"discipulo"=>$discipulo,
					"asunto"=>$asunto,
					"temas"=>$temas,
					"modoreunion"=>$modoreunion,
					"horacita"=>$horacita,
					"horaproximareunion"=>$horaproximareunion,
					"fechaproximareunion"=>$fechaproximareunion,
					"lugar"=>$lugar,
					"observacion"=>$observacion
				];
				if(self::add_integranteSeguimiento_model($dataSeguimiento)){
					$dataAlert=[
						"title"=>"¡Seguimiento registrado!",
						"text"=>"El ¡Seguimiento se registró con éxito en el sistema",
						"type"=>"success"
					];
					unset($_POST);
					return self::sweet_alert_single($dataAlert);
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"No hemos podido registrar el ¡Seguimiento, por favor intente nuevamente",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}
				/*[usuario] => povedao
				[fecha] => 2021-10-27
				[torres] => 5
				[casavida] => 5
				[predicador] => IC02699251
				[discipulo] => IC02699251
				[telefono] => 045019159
				[asunto] => Discipulado
				[temas] => Adoracion
				[modoreunion] => Llamada
				[horacita] => 17:00
				[horaproximareunion] => 20:00
				[fechaproximareunion] => 2021-12-10
				[lugar] => GUAYAQUIL
				[observacion] => SEGUIMIENTO PRUEBA*/
		}

		public function data_asistencia_info_controller($Type,$Code){

			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($asistenciadata=self::data_asistencia_info_model($data)){
				return $asistenciadata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos de la Asistencia",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}


		}
        
				/*----------  Foto integrante Controller  ----------*/
				public function foto_integrante_controller($codigo){
						$imagen = $_FILES['imagen']['name'];
						//$codigo = $_POST['code'];

						if(isset($imagen) && $imagen != ""){
							$tipo = $_FILES['imagen']['type'];
							$temp  = $_FILES['imagen']['tmp_name'];

							//echo 'Tipo: '.$tipo.'Temp: '.$temp.'imagen: '.$imagen;
							//Tipo: image/jpegTemp: C:\xampp\tmp\phpAEA5.tmpimagen: 20190507_204148.jpg

							if( !((strpos($tipo,'gif') || strpos($tipo,'jpg') || strpos($tipo,'png') || strpos($tipo,'jpeg') || strpos($tipo,'webp')))){
								//$_SESSION['mensaje'] = 'solo se permite archivos jpeg, gif, webp';
								//$_SESSION['tipo'] = 'danger';
								//header('location:../index.php');
								//echo "1";
							}else{
								//echo "2";
								$query=self::connect()->prepare("UPDATE integrante SET foto='$imagen' where  Codigo=:Codigo");
								$query->bindParam(":Codigo",$codigo);
								$query->execute();
								if($query){

									if(is_uploaded_file($temp)){

										$destino="Backend/imagenes/".$imagen;
										$nombrea=$imagen;
										copy($temp,$destino);
		
									}
									//move_uploaded_file('ESCOL/Backend/','imagenes/'.$imagen);   
									//$_SESSION['mensaje'] = 'se ha subido correctamente';
									//$_SESSION['tipo'] = 'success';
									//header('location:../index.php');
									echo "<script type='text/javascript'>window.location='SERVERURL/integrantelist/';<script>";
								}else{
									$_SESSION['mensaje'] = 'ocurrio un error en el servidor';
									$_SESSION['tipo'] = 'danger';
								}
							}
						}
		
				}


		/*----------  Data integrante Controller  ----------*/
		public function data_integrante_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($integrantedata=self::data_integrante_model($data)){
				return $integrantedata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del integrante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}
        

			/*----------  Data Update Student Controller  ----------*/
			public function data_integrante_actualiza_adm_controller($Type,$Code){
				$Type=self::clean_string($Type);
				$Code=self::clean_string($Code);
	
				$data=[
					"Tipo"=>$Type,
					"Codigo"=>$Code
				];
	
				if($studentdata=self::data_integrante_actualiza_ADM_model($data)){
					return $studentdata;
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"No hemos podido seleccionar los datos del usuario",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}
	
			}
		

		/*----------  Pagination integrante Controller  ----------*/
		public function pagination_integrante_controller($Pagina,$Registros,$cadena,$Username){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);
			$Username=self::clean_string($Username);
            //$Username=$_SESSION['userName'];
			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;
			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

            //echo "Hola Controller";
		   if($cadena!=""){ 
				$Datos=self::execute_single_query("SELECT i.*,t.torre,ca.casadevida,c.cargo,cu.Usuario FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username'
				AND (CONCAT(Nombres, ' ', Apellidos) like '%".$cadena."%' 
				or t.torre like '%".$cadena."%' or ca.casadevida like '%".$cadena."%')
				ORDER BY i.idcasadevida ASC LIMIT $Inicio,$Registros");
		    }else{
				$Datos=self::execute_single_query("SELECT i.*,t.torre,ca.casadevida,c.cargo,cu.Usuario FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username'
				ORDER BY i.idcasadevida ASC LIMIT $Inicio,$Registros");
			}

			
			$Datos=$Datos->fetchAll();

			if($cadena!=""){ 

				$Total=self::execute_single_query("SELECT i.*,t.torre,ca.casadevida,c.cargo FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username' AND
				(CONCAT(Nombres, ' ', Apellidos) like '%".$cadena."%' 
				or t.torre like '%".$cadena."%' or ca.casadevida like '%".$cadena."%')
				ORDER BY i.idcasadevida ASC LIMIT $Inicio,$Registros");
   
			}else{
				 
				$Total=self::execute_single_query("SELECT * FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username'");
   
			}

			
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Foto</th>
						<th class="text-center">Nombres</th>
						<th class="text-center">Apellidos</th>
						<th class="text-center">Torre</th>
						<th class="text-center">CDV</th>
						<th class="text-center">Cargo</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Ver</th>
						<th class="text-center">Inactivar</th>
					</tr>
				</thead>
				<tbody>
			';
           
			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					if($rows['estado']==1){
                        $estado="Activo";
                    }else{
						$estado="Inactivo";
					}

						 if($rows['foto']<>''){
							 $cadena='<a href="/CASADEVIDA/Backend/imagenes/'.$rows['foto'].'" target="_blank"><img id="myImg" src="/CASADEVIDA/Backend/imagenes/'.$rows['foto'].'" height="100" width=100 ></a>';
						 }else{
							 $cadena='<img id="myImg" src="/CASADEVIDA/Backend/imagenes/USUARIO.png" height="100" width=100 >';
						 }
					$table.='
					<tr>
						<td>'.$nt.'</td>
						<td>'.$cadena.'</td>
						<td>'.$rows['Nombres'].'</td>
						<td>'.$rows['Apellidos'].'</td>
						<td>'.$rows['torre'].'</td>
						<td>'.$rows['casadevida'].'</td>
						<td>'.$rows['cargo'].'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'integranteinfo/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="'.SERVERURL.'integrantelist/1/'.$rows['Codigo'].'/" class="btn btn-danger btn-raised btn-xs">
							<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['Codigo'].'" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="integranteCode" value="'.$rows['Codigo'].'">
							</form>
						</td>
					</tr>
					';
					$nt++;
				}
			}else{
				$table.='
				<tr>
					<td colspan="5">No hay registros en el sistema</td>
				</tr>
				';
			}

			$table.='
				</tbody>
			</table>
			';

			if($Total>=1){
				$table.='
					<nav class="text-center full-width">
						<ul class="pagination pagination-sm">
				';

				if($Pagina==1){
					$table.='<li class="disabled"><a>«</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'integrantelist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'integrantelist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'integrantelist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'integrantelist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		}

		public function pagination_asistenciaint_controller($Pagina,$Registros,$cadena){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);
            $Username=$_SESSION['userName'];

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

		
			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT cab.idasistenciacdvcab,cab.fecha,t.torre, c.casadevida,(select count(*) from asistenciacdvdet b where b.idasistenciacdvcab=cab.idasistenciacdvcab and b.asistio='si' ) asistieron, 
			(select count(*) from asistenciacdvdet b where b.idasistenciacdvcab=cab.idasistenciacdvcab ) integrantes, cab.reunion
			FROM asistenciacdvcab cab 
			inner join asistenciacdvdet det on cab.idasistenciacdvcab=det.idasistenciacdvcab 
			inner join torre t on cab.idtorre=t.idtorre 
			inner join casadevida c on cab.idcasadevida=c.idcasadevida 
			INNER join asignacion asg on cab.idtorre=asg.idtorre and cab.idcasadevida=asg.idcasadevida 
			inner join cuenta cu on asg.codigo=cu.Codigo where cu.Usuario='$Username' 
			group by cab.idasistenciacdvcab,cab.fecha,t.torre, c.casadevida 
			ORDER BY cab.fecha DESC LIMIT $Inicio,$Registros");

			
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT cab.idasistenciacdvcab,cab.fecha,t.torre, c.casadevida,count(*) personas 
			FROM asistenciacdvcab cab inner join asistenciacdvdet det on cab.idasistenciacdvcab=det.idasistenciacdvcab 
			inner join torre t on cab.idtorre=t.idtorre 
			inner join casadevida c on cab.idcasadevida=c.idcasadevida 
			INNER join asignacion asg on cab.idtorre=asg.idtorre and cab.idcasadevida=asg.idcasadevida
			inner join cuenta cu on asg.codigo=cu.Codigo
			where cu.Usuario='$Username'
			group by cab.idasistenciacdvcab,cab.fecha,t.torre, c.casadevida");

			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Registro</th>
						<th class="text-center">Fecha de Reunion</th>
						<th class="text-center">Torre</th>
						<th class="text-center">CDV</th>
						<th class="text-center">Reunion</th>
						<th class="text-center"># Integrantes</th>
						<th class="text-center"># Asistidos</th>
						<th class="text-center">Ver</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
			';
           
			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					$table.='
					<tr>
						<td>'.$nt.'</td>
						<td>'.$rows['idasistenciacdvcab'].'</td>
						<td>'.$rows['fecha'].'</td>
						<td>'.$rows['torre'].'</td>
						<td>'.$rows['casadevida'].'</td>
						<td>'.$rows['reunion'].'</td>
						<td>'.$rows['integrantes'].'</td>
						<td>'.$rows['asistieron'].'</td>
						<td>
							<a href="'.SERVERURL.'asistenciaintinfo/'.$rows['idasistenciacdvcab'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idasistenciacdvcab'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idasistenciacdvcab'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="asistenciaintCode" value="'.$rows['idasistenciacdvcab'].'">
							</form>
						</td>
					</tr>
					';
					$nt++;
				}
			}else{
				$table.='
				<tr>
					<td colspan="5">No hay registros en el sistema</td>
				</tr>
				';
			}

			$table.='
				</tbody>
			</table>
			';

			if($Total>=1){
				$table.='
					<nav class="text-center full-width">
						<ul class="pagination pagination-sm">
				';

				if($Pagina==1){
					$table.='<li class="disabled"><a>«</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'asistenciaintlist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'usuariolist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'asistenciaintlist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'asistenciaintlist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		} 
		public function pagination_seguimientoint_controller($Pagina,$Registros,$cadena){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);
            $Username=$_SESSION['userName'];

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

		
			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT cab.idseguimiento,cab.fecha,t.torre, c.casadevida, (SELECT CONCAT(Nombres, ' ', Apellidos) 
			FROM `integrante` WHERE Codigo=cab.codresponsable) responsable, (SELECT CONCAT(Nombres, ' ', Apellidos) 
			FROM `integrante` WHERE Codigo=cab.coddiscipulo) discipulo,(SELECT foto 
			FROM `integrante` WHERE Codigo=cab.coddiscipulo) foto, cab.asunto,cab.temas,cab.modoreunion,cab.horacita,cab.lugar,cab.observacion,CONCAT(cab.horaproximareunion, ' ', cab.fechaproximareunion) proximareunion
			FROM seguimiento cab 
			inner join torre t on cab.idtorre=t.idtorre 
			inner join casadevida c on cab.idcasadevida=c.idcasadevida 
			INNER join asignacion asg on cab.idtorre=asg.idtorre and cab.idcasadevida=asg.idcasadevida 
			inner join cuenta cu on asg.codigo=cu.Codigo where cu.Usuario='$Username' 
			group by cab.idseguimiento,cab.fecha,t.torre, c.casadevida 
			ORDER BY cab.fecha DESC LIMIT $Inicio,$Registros");

			
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT cab.idseguimiento,cab.fecha,t.torre, c.casadevida, (SELECT CONCAT(Nombres, ' ', Apellidos) 
			FROM `integrante` WHERE Codigo=cab.codresponsable) responsable, (SELECT CONCAT(Nombres, ' ', Apellidos) 
			FROM `integrante` WHERE Codigo=cab.coddiscipulo) discipulo, cab.asunto,cab.temas,cab.modoreunion,cab.horacita,cab.lugar,cab.observacion,CONCAT(cab.horaproximareunion, ' ', cab.fechaproximareunion) proximareunion
			FROM seguimiento cab 
			inner join torre t on cab.idtorre=t.idtorre 
			inner join casadevida c on cab.idcasadevida=c.idcasadevida 
			INNER join asignacion asg on cab.idtorre=asg.idtorre and cab.idcasadevida=asg.idcasadevida 
			inner join cuenta cu on asg.codigo=cu.Codigo where cu.Usuario='$Username' 
			group by cab.idseguimiento,cab.fecha,t.torre, c.casadevida");

			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Registro</th>
						<th class="text-center">Fecha de Gestion</th>
						<th class="text-center">Torre</th>
						<th class="text-center">CDV</th>
						<th class="text-center">Responsable de la Gestion</th>
						<th class="text-center">Integrante Gestionado</th>
						<th class="text-center">Asuntos</th>
						<th class="text-center">Temas</th>
						<th class="text-center">Modo de Reunion</th>
						<th class="text-center">Hora de la cita</th>
						<th class="text-center">Lugar de la Reunion</th>
						<th class="text-center">Observacion</th>
						<th class="text-center">Proxima Reunion</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
			';
           
			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					if($rows['foto']<>''){
						$foto='<a href="/CASADEVIDA/Backend/imagenes/'.$rows['foto'].'" target="_blank"><img id="myImg" src="/CASADEVIDA/Backend/imagenes/'.$rows['foto'].'" height="100" width=100 ></a>';
					}else{
						$foto='<img id="myImg" src="/CASADEVIDA/Backend/imagenes/USUARIO.png" height="100" width=100 >';
					}
					$table.='
					<tr>
						<td>'.$nt.'</td>
						<td>'.$rows['idseguimiento'].'</td>
						<td>'.$rows['fecha'].'</td>
						<td>'.$rows['torre'].'</td>
						<td>'.$rows['casadevida'].'</td>
						<td>'.$rows['responsable'].'</td>
						<td>'.$foto.' '.$rows['discipulo'].'</td>
						<td>'.$rows['asunto'].'</td>
						<td>'.$rows['temas'].'</td>
						<td>'.$rows['modoreunion'].'</td>
						<td>'.$rows['horacita'].'</td>
						<td>'.$rows['lugar'].'</td>
						<td>'.$rows['observacion'].'</td>
						<td>'.$rows['proximareunion'].'</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idseguimiento'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idseguimiento'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="seguimientointCode" value="'.$rows['idseguimiento'].'">
							</form>
						</td>
					</tr>
					';
					$nt++;
				}
			}else{
				$table.='
				<tr>
					<td colspan="5">No hay registros en el sistema</td>
				</tr>
				';
			}

			$table.='
				</tbody>
			</table>
			';

			if($Total>=1){
				$table.='
					<nav class="text-center full-width">
						<ul class="pagination pagination-sm">
				';

				if($Pagina==1){
					$table.='<li class="disabled"><a>«</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'seguimientointlist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'usuariolist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'seguimientointlist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'seguimientointlist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		} 



		/*----------  Delete integrante Controller  ----------*/
		public function delete_integrante_controller($code){
			$code=self::clean_string($code);

			if(self::delete_integrante_model($code)){
				$dataAlert=[
					"title"=>"¡Integrante Inactivado!",
					"text"=>"El Integrante ha sido Inactivado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos inactivar el Integrante por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		

		/*----------  Delete Asistencia integrante Controller  ----------*/
		public function delete_asistenciaint_controller($code){
			$code=self::clean_string($code);

			if(self::delete_asistenciaint_model($code)){
				$dataAlert=[
					"title"=>"¡Asistencia Eliminada!",
					"text"=>"La Asistencia ha sido Eliminada del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar la asistencia por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		/*----------  Delete Seguimiento integrante Controller  ----------*/
		public function delete_seguimientoint_controller($code){
			$code=self::clean_string($code);

			if(self::delete_seguimientoint_model($code)){
				$dataAlert=[
					"title"=>"¡Seguimiento Eliminado!",
					"text"=>"El Seguimiento ha sido Eliminada del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el seguimiento por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}


		/*----------  Update integrante Controller  ----------*/
		public function update_integrante_controller(){
			$code=self::clean_string($_POST['code']);
			$name=self::clean_string($_POST['name']);
			$lastname=self::clean_string($_POST['lastname']);
			$email=self::clean_string($_POST['email']);
			$direccion=self::clean_string($_POST['direccion']);
			$telefono=self::clean_string($_POST['telefono']);
			$pais=self::clean_string($_POST['pais']);
			$ciudad=self::clean_string($_POST['ciudad']);
			$iglesia=self::clean_string($_POST['iglesia']);
			$pertenececda=self::clean_string($_POST['pertenececda']);
			$torre=self::clean_string($_POST['torres']);
			$casadevida=self::clean_string($_POST['casavida']);
			$bautizado=self::clean_string($_POST['bautizado']);
			$sector=self::clean_string($_POST['sector']);
			$fechanacimiento=self::clean_string($_POST['fecha']);
            $lugarnacimiento=self::clean_string($_POST['lugar']);
            $estadocivil=self::clean_string($_POST['estado']);
            $instruccion=self::clean_string($_POST['instruccion']);
            $profesion=self::clean_string($_POST['profesion']);
            $dirtrabajo=self::clean_string($_POST['dirtrabajo']);
            $teltrabajo=self::clean_string($_POST['teltrabajo']);
            $empresa=self::clean_string($_POST['empresa']);
			$fechaconversion=self::clean_string($_POST['fechaconversion']);
			$fechabautizo=self::clean_string($_POST['fechabautizo']);
			$lugarbautizo=self::clean_string($_POST['lugarbautizo']);
			$cedula=self::clean_string($_POST['cedula']);
			$cargo=self::clean_string($_POST['cargo']);
			$ministerio=self::clean_string($_POST['area']); //fechainiservicio
			$fechainiservicio=self::clean_string($_POST['fechainiservicio']);
			$fechafinservicio=self::clean_string($_POST['fechafinservicio']);
			$observacion=self::clean_string($_POST['observacion']);
			$estudio=self::clean_string($_POST['estudio']);
			$discipulado=self::clean_string($_POST['discipulado']);

			$data=[
				"Codigo"=>$code,
				"Nombres"=>$name,
				"Apellidos"=>$lastname,
				"Email"=>$email,
				"direccion"=>$direccion,
				"telefono"=>$telefono,
				"pais"=>$pais,
				"ciudad"=>$ciudad,
				"iglesia"=>$iglesia,
				"pertenececda"=>$pertenececda,
				"torre"=>$torre,
				"casadevida"=>$casadevida,
				"bautizado"=>$bautizado,
				"sector"=>$sector,
				"fechanacimiento"=>$fechanacimiento,
				"lugarnacimiento"=>$lugarnacimiento,
				"estadocivil"=>$estadocivil,
				"instruccion"=>$instruccion,
				"profesion"=>$profesion,
				"dirtrabajo"=>$dirtrabajo,
				"teltrabajo"=>$teltrabajo,
				"empresa"=>$empresa,
				"fechaconversion"=>$fechaconversion,
				"fechabautizo"=>$fechabautizo,
				"lugarbautizo"=>$lugarbautizo,
				"cedula"=>$cedula,
				"cargo"=>$cargo,
				"ministerio"=>$ministerio,
				"fechainiservicio"=>$fechainiservicio,
				"fechafinservicio"=>$fechafinservicio,
				"observacion"=>$observacion,
				"estudio"=>$estudio,
				"discipulado"=>$discipulado
			];

			if(self::update_integrante_model($data)){
				$dataAlert=[
					"title"=>"¡Integrante actualizado!",
					"text"=>"Los datos del estudiante fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del Integrante, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}
		
		//Nueva Funcion para la data dinamica del Dashboard
		
		private function inicio_fin_semana($fecha){

			$diaInicio = "Friday";
			$diaFin = "Monday";
		
			$strFecha = strtotime($fecha);
		
			$fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
			$fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));
		
			if(date("l",$strFecha)==$diaInicio){
				$fechaInicio= date("Y-m-d",$strFecha);
			}
			if(date("l",$strFecha)==$diaFin){
				$fechaFin= date("Y-m-d",$strFecha);
			}
			return Array("fechaInicio"=>$fechaInicio,"fechaFin"=>$fechaFin);
		}
		
		public function integranteCount(){
			$Username = $_SESSION['userName'];
			
			$porBautizo = self::execute_single_query("SELECT COUNT(*) FROM integrante inte 
													  INNER JOIN torre t ON inte.idtorre=t.idtorre 
			     									  INNER JOIN asignacion asig ON inte.idtorre=asig.idtorre AND inte.idcasadevida = asig.idcasadevida 
													  INNER JOIN cuenta cu ON asig.codigo=cu.Codigo
													  WHERE bautizado = 0 AND cu.Usuario = '$Username' ");
			$porBautizo = $porBautizo->fetchAll();
			

			$discipulos = self::execute_single_query("SELECT COUNT(*) FROM integrante inte 
													  INNER JOIN torre t ON inte.idtorre=t.idtorre 
			     									  INNER JOIN asignacion asig ON inte.idtorre=asig.idtorre AND inte.idcasadevida = asig.idcasadevida 
													  INNER JOIN cuenta cu ON asig.codigo=cu.Codigo 
													  WHERE inte.discipulado = 'Discípulo' AND cu.Usuario = '$Username'");
			$discipulos = $discipulos->fetchAll();
			
			$integrantes = self::execute_single_query("SELECT COUNT(*) FROM integrante inte 
													   INNER JOIN torre t ON inte.idtorre=t.idtorre 
			     									   INNER JOIN asignacion asig ON inte.idtorre=asig.idtorre AND inte.idcasadevida = asig.idcasadevida 
													   INNER JOIN cuenta cu ON asig.codigo=cu.Codigo 
													   WHERE cu.Usuario = '$Username'");
			$integrantes = $integrantes->fetchAll();

			$formMinisterial = self::execute_single_query("SELECT COUNT(*) FROM integrante inte
														   INNER JOIN torre t ON inte.idtorre=t.idtorre 
			     									       INNER JOIN asignacion asig ON inte.idtorre=asig.idtorre AND inte.idcasadevida = asig.idcasadevida 
													   	   INNER JOIN cuenta cu ON asig.codigo=cu.Codigo  
														   WHERE estudios != '' AND cu.Usuario = '$Username'");
			$formMinisterial = $formMinisterial->fetchAll();										   

			$casaVida = self::execute_single_query("SELECT COUNT(*) FROM casadevida casa 
													INNER JOIN torre t ON casa.idtorre=t.idtorre 
			     								    INNER JOIN asignacion asig ON casa.idtorre=asig.idtorre AND casa.idcasadevida = asig.idcasadevida 
													INNER JOIN cuenta cu ON asig.codigo=cu.Codigo
													WHERE cu.Usuario = '$Username' and casa.idtorre !='17' ");
			$casaVida = $casaVida->fetchAll();

			$asisGlob = self::execute_single_query("SELECT COUNT(*) FROM asistenciacdvcab cab  
													INNER JOIN torre t ON cab.idtorre=t.idtorre 
			     								    INNER JOIN asignacion asig ON cab.idtorre=asig.idtorre AND cab.idcasadevida = asig.idcasadevida 
													INNER JOIN cuenta cu ON asig.codigo=cu.Codigo
													WHERE cu.Usuario = '$Username' ");
			$asisGlob = $asisGlob->fetchAll();
			
			//Validar dia actual para ejecutar la consulta o no 
			$dia = new DateTime('W');
			$dia = $dia->format('w');
			
			if($dia == 5 || $dia == 6 || $dia == 0 || $dia == 1){
			    //Buscando asistencia semanal de audiencia/usuario actual
			    $today = date('d-m-Y');
                
                //extrayendo dias viernes y lunes actuales para el periodo de consulta
    			$result = self::inicio_fin_semana($today);
    			$dayIni = $result['fechaInicio'];
    			$dayEnd = $result['fechaFin'];
    			
    			$asisWeek = self::execute_single_query("SELECT COUNT(*) FROM asistenciacdvcab cab  
    												    INNER JOIN torre t ON cab.idtorre=t.idtorre 
    													INNER JOIN asignacion asig ON cab.idtorre=asig.idtorre AND cab.idcasadevida = asig.idcasadevida 
    													INNER JOIN cuenta cu ON asig.codigo=cu.Codigo
    													WHERE cu.Usuario = '{$Username}' AND fecha BETWEEN '{$dayIni}' AND '{$dayEnd}' ");
    			  
    			$asisWeek = $asisWeek->fetchAll();   
    			$asisWeek = $asisWeek[0]['COUNT(*)']; 

			}else{
			    
			    $asisWeek = 0;
			
			}
			
			$seguimiento = self::execute_single_query("SELECT COUNT(*) FROM seguimiento segui
													   INNER JOIN torre t ON segui.idtorre = t.idtorre
													   INNER JOIN asignacion asig ON segui.idtorre = asig.idtorre AND segui.idcasadevida = asig.idcasadevida 
													   INNER JOIN cuenta cu ON asig.codigo = cu.Codigo 
													   WHERE cu.Usuario = '$Username'");

			$seguimiento = $seguimiento->fetchAll();
			
			$servMinisterio = self::execute_single_query("SELECT COUNT(*) FROM integrante inte
														   INNER JOIN torre t ON inte.idtorre=t.idtorre 
			     									       INNER JOIN asignacion asig ON inte.idtorre=asig.idtorre AND inte.idcasadevida = asig.idcasadevida 
													   	   INNER JOIN cuenta cu ON asig.codigo=cu.Codigo  
														   WHERE inte.idarea != 0 AND cu.Usuario = '$Username'");
			$servMinisterio = $servMinisterio->fetchAll();

			
			

			
			$CountDashboard = [
				'porBautizar' => $porBautizo[0]['COUNT(*)'],
				'discipulos' =>  $discipulos[0]['COUNT(*)'],
				'integrantes' => $integrantes[0]['COUNT(*)'],
				'formMinisterial' => $formMinisterial[0]['COUNT(*)'],
				'casasVida' => $casaVida[0]['COUNT(*)'],
				'asisGlob' => $asisGlob[0]['COUNT(*)'],
				'asisWk' => $asisWeek, 
				'seguimiento' => $seguimiento[0]['COUNT(*)'],
				'servMinisterio' => $servMinisterio[0]['COUNT(*)']
			];

			return json_encode($CountDashboard);
			

		}

		public function birthDaysMonth () {
			$Username = $_SESSION['userName'];
			$month = date('m');

			$birthDays = self::execute_single_query("SELECT DISTINCTROW  inte.Nombres, inte.Apellidos, inte.foto, inte.fechaNacimiento FROM integrante inte
														   INNER JOIN torre t ON inte.idtorre=t.idtorre 
			     									       INNER JOIN asignacion asig ON inte.idtorre=asig.idtorre AND inte.idcasadevida = asig.idcasadevida 
													   	   INNER JOIN cuenta cu ON asig.codigo=cu.Codigo  
														   WHERE MONTH(inte.fechaNacimiento) = '$month' AND cu.Usuario = '$Username' ");
			//
			$response = $birthDays->fetchAll();
			return $response;	

			
		}

	}