<?php
	if($actionsRequired){
		require_once "../models/torreModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/torreModel.php";
		require_once "./core/configGeneral.php";
	}
	
	
	class torreController extends torreModel{

		/*----------  Add home Controller  ----------*/
		public function add_torre_controller(){
			$torre=self::clean_string($_POST['torre']);
			
					$query1=self::execute_single_query("SELECT torre FROM torre WHERE torre='$torre'");
					if($query1->rowCount()<=0){
						

						$dataTorre=[
							
							"torre"=>$torre
						];

						if(self::add_torre_model($dataTorre)){
							$dataAlert=[
								"title"=>"¡Sector registrado!",
								"text"=>"El sector se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el sector, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El sector que acaba de ingresar ya se encuentra registrado en el sistema, por favor elija otro",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}
				
			
		}

		/*----------  Data Torre Controller  ----------*/
		public function data_torre_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($casadata=self::data_torre_model($data)){
				return $casadata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del sector",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

        /*----------  Pagination Torre Controller  ----------*/
		public function pagination_torre_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM torre 
                where estado=1
				ORDER BY torre ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM torre where estado=1");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
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
					<tr id="tabla" name="tabla" value="'.$rows['idtorre'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['torre'].'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'torresinfo/'.$rows['idtorre'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idtorre'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idtorre'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="torreCode" value="'.$rows['idtorre'].'">
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
					$table.='<li><a href="'.SERVERURL.'torreslist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'torreslist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'torreslist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'torreslist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}

		/*----------  Update Torre Controller  ----------*/
		public function update_torre_controller(){
			$code=self::clean_string($_POST['code']);
			$torre=self::clean_string($_POST['torre']);
		
			$data=[
				"Codigo"=>$code,
				"torre"=>$torre			
			];
            
			if(self::update_torre_model($data)){
				$dataAlert=[
					"title"=>"Sector actualizado!",
					"text"=>"Los datos de la sector fueron actualizados con éxito",
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

		/*----------  Delete Torre Controller  ----------*/
		public function delete_torre_controller($idtorre){

			$code=self::clean_string($idtorre);

			if(self::delete_torre_model($code)){
				$dataAlert=[
					"title"=>"Sector eliminado!",
					"text"=>"La Torre ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el sector por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}
        
				

	}