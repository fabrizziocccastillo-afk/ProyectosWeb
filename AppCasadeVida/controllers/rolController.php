<?php
	if($actionsRequired){
		require_once "../models/rolModel.php";
	}else{ 
		require_once "./models/rolModel.php";
	}

	class rolController extends rolModel{

		/*----------  Add Rol Controller  ----------*/
		public function add_rol_controller(){
			$rol=self::clean_string($_POST['rol']);
			$descripcion=self::clean_string($_POST['descripcion']);
			$estado=1;

					$query1=self::execute_single_query("SELECT idrol FROM rol WHERE idrol=$rol and estado=1");
					if($query1->rowCount()<=0){						
						$dataRol=[
							"rol"=>$rol,
							"descripcion"=>$descripcion,
							"estado"=>$estado
							
						];

						if(self::add_Rol_model($dataRol)){
							$dataAlert=[
								"title"=>"¡Estudiante matriculado!",
								"text"=>"El estudiante se matriculó con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido matricular el estudiante, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El Estudiante que acaba de matricular ya se encuentra inscrito en la materia ".$materia." , por favor elija otra materia",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}			
		}

		/*----------  Add Rol Controller  ----------*/
		public function add_asignacion_controller(){

			   //$codigouser=$_POST['codigo'];
		       //$coderol=$_POST['code'];
		       //$codigotorre=$_POST['torres'];
		       //$codigocdv=$_POST['cdv'];

			/*echo "<pre>";       
			print_r($_POST);
			echo "</pre>"; 
			exit();*/

			$codigouser=self::clean_string($_POST['codigo']);
			$coderol=self::clean_string($_POST['code']);
			$codigotorre=$_POST['torres'];
			$codigocdv=$_POST['cdv'];
			
            for($i=0;$i<count($codigotorre);$i++){

				for($j=0;$j<count($codigocdv);$j++){
		        
				$cadena="INSERT INTO asignacion(codigo,idrol,idtorre,idcasadevida)values ('".$codigouser."',".$coderol.",".$codigotorre[$i].",".$codigocdv[$j].")"; 
				$query=self::execute_single_query($cadena);
				   //print_r($cadena);
				}
		     }
					//$query1=self::execute_single_query("SELECT idrol FROM rol WHERE idrol=$rol and estado=1");
									
					//	$dataRol=[
					//		"rol"=>$rol,
					//		"descripcion"=>$descripcion,
					//		"estado"=>$estado
							
					//	];

						if($query){
							$dataAlert=[
								"title"=>"¡Usuario asignado!",
								"text"=>"El Usuario se asigno con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido asignar el usuario, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					
		}



		/*----------  Data Rol Controller  ----------*/
		public function data_rol_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($roldata=self::data_rol_model($data)){
				return $roldata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del rol",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		/*----------  Data Rol Controller  ----------*/
		public function data_rolacceso_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($roldata=self::data_rolacceso_model($data)){
				return $roldata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del rol",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}



		/*----------  Pagination Rol Controller  ----------*/
		public function pagination_rol_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM rol where estado=1
				ORDER BY rol ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM rol where estado=1 ");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Rol</th>
						<th class="text-center">Descripcion</th>
						<th class="text-center">Estado</th>
                        <th class="text-center">Asignar Rol</th>
						<th class="text-center">Modificar</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
			';

			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					$estadoAct=$rows['estado'];
					$estado="";
					switch($estadoAct) 
					{
					case 0:
						$estado="INACTIVO";
					    break;
					case 1:
						$estado="ACTIVO";
					    break;
					}
					$table.='
					<tr id="tabla" name="tabla" value="'.$rows['idrol'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['rol'].'</td>
						<td>'.$rows['descripcion'].'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'asignarol/1/'.$rows['idrol'].'/" class="btn btn-primary btn-raised btn-xs">
								<i class="zmdi zmdi-key"></i>
							</a>
					    </td>
						<td>
							<a href="'.SERVERURL.'rolinfo/'.$rows['idrol'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idrol'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idrol'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="rolCode" value="'.$rows['idrol'].'">
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
					$table.='<li><a href="'.SERVERURL.'rollist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'rollist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'rollist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'rollist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}

		/*----------  Pagination Rol Controller  ----------*/
		public function pagination_asignarol_controller($Pagina,$Registros,$rol){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$rol=self::clean_string($rol);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT * FROM usuariocdv u inner join cuenta c on c.Codigo=u.Codigo INNER join rol r on c.idrol=r.idrol where r.idrol =$rol and r.estado=1
				ORDER BY c.usuario ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM usuariocdv u inner join cuenta c on c.Codigo=u.Codigo INNER join rol r on c.idrol=r.idrol where r.idrol =$rol and r.estado=1");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Usuario</th>
						<th class="text-center">Nombres</th>
						<th class="text-center">Rol</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Editar</th>
					</tr>
				</thead>
				<tbody>
			';

			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					$estadoAct=$rows['estado'];
					$estado="";
					switch($estadoAct) 
					{
					case 0:
						$estado="INACTIVO";
					    break;
					case 1:
						$estado="ACTIVO";
					    break;
					}
					$table.='
					<tr id="tabla" name="tabla" value="'.$rows['idrol'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['Usuario'].'</td>
						<td>'.$rows['Nombres'].' '.$rows['Apellidos'].'</td>
						<td>'.$rows['rol'].'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'rolacceso/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
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
					$table.='<li><a href="'.SERVERURL.'asignarol/'.($Pagina-1).'/">«</a></li>';
				}
				//$rows['idrol']
				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'asignarol/'.$i.'/'.$rows['idrol'].'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'asignarol/'.$i.'/'.$rows['idrol'].'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'asignarol/'.($Pagina+1).'/'.$rows['idrol'].'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}



		/*----------  Delete Rol Controller  ----------*/
		public function delete_rol_controller($idrol){
			$code=self::clean_string($idrol);
			//$materia=self::clean_string($materia);

			if(self::delete_Rol_model($code)){
				$dataAlert=[
					"title"=>"Rol eliminado!",
					"text"=>"La Rol ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el rol por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Rol Controller  ----------*/
		public function update_rol_controller(){
			$code=self::clean_string($_POST['code']);
			$rol=self::clean_string($_POST['rol']);
			$descripcion=self::clean_string($_POST['descripcion']);
		


			$data=[
				"Codigo"=>$code,
				"rol"=>$rol,
				"descripcion"=>$descripcion			
			];
            
			if(self::update_Rol_model($data)){
				$dataAlert=[
					"title"=>"Rol actualizado!",
					"text"=>"Los datos del Rol fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del Rol, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}