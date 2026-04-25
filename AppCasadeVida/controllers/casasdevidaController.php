<?php
	if($actionsRequired){
		require_once "../models/casasdevidaModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/casasdevidaModel.php";
		require_once "./core/configGeneral.php";
	}
	
	
	class casasdevidaController extends casasdevidaModel{

		/*----------  Add home Controller  ----------*/
		public function add_casasdevida_controller(){
			$casadevida=self::clean_string($_POST['casa']);
			$torre=self::clean_string($_POST['torre']);
			
					$query1=self::execute_single_query("SELECT casadevida FROM casadevida WHERE idcasadevida='$casadevida'");
					if($query1->rowCount()<=0){
						

						$dataCasadevida=[
							
							"casadevida"=>$casadevida,
							"torre"=>$torre
						];

						if(self::add_casasdevida_model($dataCasadevida)){
							$dataAlert=[
								"title"=>"¡Casa de Vida registrada!",
								"text"=>"La casa de vida se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar la casa de vida, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El nombre de usuario que acaba de ingresar ya se encuentra registrado en el sistema, por favor elija otro",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}
				
			
		}

		/*----------  Data Casas de vida Controller  ----------*/
		public function data_casasdevida_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($casadata=self::data_casasdevida_model($data)){
				return $casadata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos de la casa de vida",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

        /*----------  Pagination Casas de vida Controller  ----------*/
		public function pagination_casasdevida_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT cs.idcasadevida,cs.idtorre,cs.casadevida,t.torre,cs.estado FROM casadevida cs 
                inner join torre t on cs.idtorre=t.idtorre
                where cs.estado=1
				ORDER BY t.torre ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM casadevida where estado=1");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Nombre</th>
						<th class="text-center">Sector</th>
						<th class="text-center">Estado</th>
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
					<tr id="tabla" name="tabla" value="'.$rows['idcasadevida'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['casadevida'].'</td>
						<td>'.$rows['torre'].'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'casasdevidainfo/'.$rows['idcasadevida'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idcasadevida'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idcasadevida'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="casaCode" value="'.$rows['idcasadevida'].'">
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
					$table.='<li><a href="'.SERVERURL.'casasdevidalist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'casasdevidalist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'casasdevidalist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'casasdevidalist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}

		/*----------  Update Casas de vida Controller  ----------*/
		public function update_casasdevida_controller(){
			$code=self::clean_string($_POST['code']);
			$casadevida=self::clean_string($_POST['casa']);
			$torre=self::clean_string($_POST['torres']);
		


			$data=[
				"Codigo"=>$code,
				"casadevida"=>$casadevida,
				"torre"=>$torre			
			];
            
			if(self::update_casasdevida_model($data)){
				$dataAlert=[
					"title"=>"Casa de vida actualizada!",
					"text"=>"Los datos de la casa de vida fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos que ingreso, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

		/*----------  Delete Casas de vida Controller  ----------*/
		public function delete_casasdevida_controller($idcasadevida){

			$code=self::clean_string($idcasadevida);

			if(self::delete_casasdevida_model($code)){
				$dataAlert=[
					"title"=>"Casa de vida eliminado!",
					"text"=>"La Casa de vida ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar la casa de vida por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}
        
				

	}