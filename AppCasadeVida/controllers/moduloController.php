<?php
	if($actionsRequired){
		require_once "../models/moduloModel.php";
	}else{ 
		require_once "./models/moduloModel.php";
	}

	class moduloController extends moduloModel{

		/*----------  Add Modulo Controller  ----------*/
		public function add_modulo_controller(){
			$modulo=self::clean_string($_POST['modulo']);
			$nomenclatura=self::clean_string($_POST['modulocorto']);
			$estado=1;

					$query1=self::execute_single_query("SELECT * FROM modulo WHERE modulo=$modulo and estado=1");
					if($query1->rowCount()<=0){						
						$dataModulo=[
							"modulo"=>$modulo,
							"nomenclatura"=>$nomenclatura,
							"estado"=>$estado
							
						];

						if(self::add_modulo_model($dataModulo)){
							$dataAlert=[
								"title"=>"¡Modulo registrado!",
								"text"=>"El Modulo se registro con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el modulo, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El Modulo que acaba de ingresar ya se encuentra registrado en el sistema.. ".$materia." , por favor elija otro modulo",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}			
		}



		/*----------  Data Modulo Controller  ----------*/
		public function data_modulo_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code,
			];

			if($modulodata=self::data_modulo_model($data)){
				return $modulodata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del Modulo",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}



		/*----------  Pagination Student Controller  ----------*/
		public function pagination_modulo_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM modulo where estado=1
				ORDER BY modulo ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM modulo where estado=1");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Modulo</th>
						<th class="text-center">Nombre Corto</th>
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
					<tr id="tabla" name="tabla" value="'.$rows['idmodulo'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['modulo'].'</td>
						<td>'.$rows['nomenclatura'].'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'inscripcioninfo/'.$rows['idmodulo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idmodulo'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idmodulo'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="inscripcionCode" value="'.$rows['idmodulo'].'">
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
					$table.='<li><a href="'.SERVERURL.'modulolist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'modulolist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'modulolist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'modulolist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}


		/*----------  Delete Inscripcion Controller  ----------*/
		public function delete_modulo_controller($code){
			$code=self::clean_string($code);

			if(self::delete_account($code) && self::delete_modulo_model($code)){
				$dataAlert=[
					"title"=>"Modulo Inactivado",
					"text"=>"El Modulo ha sido Inactivado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos Inactivar el modulo por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Modulo Controller  ----------*/
		public function update_modulo_controller($code){
			$modulo=self::clean_string($_POST['modulo']);
			$nomenclatura=self::clean_string($_POST['modulocorto']);

			$data=[
				"idmodulo"=>$code,
                "modulo"=>$modulo,
                "nomenclatura"=>$nomenclatura							
			];
            
			if(self::update_modulo_model($data)){
				$dataAlert=[
					"title"=>"Modulo actualizado!",
					"text"=>"Los datos del Modulo fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del Modulo, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}