<?php
	if($actionsRequired){
		require_once "../models/permisoModel.php";
	}else{ 
		require_once "./models/permisoModel.php";
	}

	class permisoController extends permisoModel{

		/*----------  Add Permiso Controller  ----------*/
		public function add_permiso_controller(){
			$rol=self::clean_string($_POST['rol']);
			$modulo=self::clean_string($_POST['modulo']);
            $ver=self::clean_string($_POST['ver']);
            $crear=self::clean_string($_POST['crear']);
            $consultar=self::clean_string($_POST['consultar']);
            $modificar=self::clean_string($_POST['modificar']);
            $eliminar=self::clean_string($_POST['eliminar']);
            $estado=1;

		/*	echo "<pre>";       
			print_r($_POST);
			echo "</pre>"; 
			exit();*/

					$query1=self::execute_single_query("SELECT * FROM permisos WHERE idrol=$rol and idpermiso=$modulo and estado=1");
					if($query1->rowCount()<=0){						
						$dataModulo=[
                            "rol"=>$rol,
							"modulo"=>$modulo,
							"ver"=>$ver,
                            "crear"=>$crear,
                            "consultar"=>$consultar,
                            "modificar"=>$modificar,
                            "eliminar"=>$eliminar,
							"estado"=>$estado							
						];

						if(self::add_permiso_model($dataModulo)){
							$dataAlert=[
								"title"=>"¡Permiso registrado!",
								"text"=>"El Permiso se registro con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el permiso, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El Permiso que acaba de ingresar ya se encuentra registrado en el sistema.. , por favor elija otro Permiso",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}			
		}



		/*----------  Data Permiso Controller  ----------*/
		public function data_permiso_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code,
			];

			if($modulodata=self::data_permiso_model($data)){
				return $modulodata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del Permiso",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}



		/*----------  Pagination Permiso Controller  ----------*/
		public function pagination_permiso_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT a.idpermiso,b.rol,c.modulo,a.ver,a.crear,a.consultar,a.modificar,a.eliminar,a.estado
            FROM permisos a
            inner join rol b on a.idrol=b.idrol
            inner join modulo c on a.idmodulo=c.idmodulo
            where a.estado=1
			ORDER BY c.modulo ASC LIMIT $Inicio,$Registros");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM permisos where estado=1");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Rol</th>
						<th class="text-center">Modulo</th>
						<th class="text-center">Ver</th>
                        <th class="text-center">Crear</th>
                        <th class="text-center">Consultar</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                        <th class="text-center">Estado</th>
						<th class="text-center">A. Datos</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
			';

			if($Total>=1){
				$nt=$Inicio+1;
 				foreach($Datos as $rows){
                    $verAct=$rows['ver'];
					$ver="";
					switch($verAct) 
					{
					case 0:
						$ver="NO";
					    break;
					case 1:
						$ver="SI";
					    break;
					}
                    $crearAct=$rows['crear'];
                        $crear="";
                        switch($crearAct) 
                        {
                        case 0:
                            $crear="NO";
                            break;
                        case 1:
                            $crear="SI";
                            break;
                        }
                        $consultarAct=$rows['consultar'];
                        $consultar="";
                        switch($consultarAct) 
                        {
                        case 0:
                            $consultar="NO";
                            break;
                        case 1:
                            $consultar="SI";
                            break;
                        }
                        $modificarAct=$rows['modificar'];
                        $modificar="";
                        switch($modificarAct) 
                        {
                        case 0:
                            $modificar="NO";
                            break;
                        case 1:
                            $modificar="SI";
                            break;
                        }
                        $eliminarAct=$rows['eliminar'];
                        $eliminar="";
                        switch($eliminarAct) 
                        {
                        case 0:
                            $eliminar="NO";
                            break;
                        case 1:
                            $eliminar="SI";
                            break;
                        }
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
					<tr id="tabla" name="tabla" value="'.$rows['idpermiso'].'">
						<td>'.$nt.'</td>
                        <td>'.$rows['rol'].'</td>
						<td>'.$rows['modulo'].'</td>
						<td>'.$ver.'</td>
                        <td>'.$crear.'</td>
                        <td>'.$consultar.'</td>
                        <td>'.$modificar.'</td>
                        <td>'.$eliminar.'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'inscripcioninfo/'.$rows['idpermiso'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idpermiso'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idpermiso'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="inscripcionCode" value="'.$rows['idpermiso'].'">
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
					$table.='<li><a href="'.SERVERURL.'permisolist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'permisolist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'permisolist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'permisolist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}


		/*----------  Delete Permiso Controller  ----------*/
		public function delete_permiso_controller($code){
			$code=self::clean_string($code);

			if(self::delete_account($code) && self::delete_permiso_model($code)){
				$dataAlert=[
					"title"=>"Permiso Inactivado",
					"text"=>"El Permiso ha sido Inactivado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos Inactivar el permiso por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Modulo Controller  ----------*/
		public function update_permiso_controller($code){
            $rol=self::clean_string($_POST['rol']);
			$modulo=self::clean_string($_POST['modulo']);


			$data=[
				"idpermiso"=>$code,
                "modulo"=>$modulo,
                "rol"=>$rol							
			];
            
			if(self::update_permiso_model($data)){
				$dataAlert=[
					"title"=>"Permiso actualizado!",
					"text"=>"Los datos del Permiso fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del Permiso, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}