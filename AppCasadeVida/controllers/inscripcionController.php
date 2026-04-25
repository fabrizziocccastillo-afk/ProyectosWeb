<?php
	if($actionsRequired){
		require_once "../models/inscripcionModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/inscripcionModel.php";
		require_once "./core/configGeneral.php";
	}

	class inscripcionController extends inscripcionModel{

		/*----------  Add Inscipcion Controller  ----------*/
		public function add_Inscripcion_controller(){
			$Codigo=self::clean_string($_POST['codigo']);
			$materia=self::clean_string($_POST['materia']);
			$fecha=self::clean_string($_POST['fecha']);
			$calificacion=self::clean_string($_POST['calificacion']);
			$aprobado=self::clean_string($_POST['aprobado']);
			$fechamodifica=null;


					$query1=self::execute_single_query("SELECT Codigo FROM matricula WHERE Codigo='$Codigo' and idmateria=$materia");
					if($query1->rowCount()<=0){						
						$dataInscripcion=[
							"Codigo"=>$Codigo,
							"materia"=>$materia,
							"fecha"=>$fecha,
							"fechamodifica"=>$fechamodifica,
							"calificacion"=>$calificacion,
							"aprobado"=>$aprobado
							
						];

						if(self::add_Inscripcion_model($dataInscripcion)){
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



		/*----------  Data Student Controller  ----------*/
		public function data_Inscripcion_controller($Type,$Code,$materia){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			$materia=self::clean_string($materia);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code,
				"materia"=>$materia
			];

			if($matriculadata=self::data_Inscripcion_model($data)){
				return $matriculadata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del estudiante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}



		/*----------  Pagination Student Controller  ----------*/
		public function pagination_Inscripcion_controller($Pagina,$Registros,$cadena){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;
            
			if($cadena!=""){ 
							$Datos=self::execute_single_query("SELECT * FROM matricula m 
								inner join estudiante e on m.Codigo=e.Codigo 
								inner join materia ma on m.idmateria=ma.idmateria
								where CONCAT(e.Nombres, ' ', e.Apellidos) like '%".$cadena."%' 
								ORDER BY e.Nombres ASC LIMIT $Inicio,$Registros
							");
			}else{
							$Datos=self::execute_single_query("SELECT * FROM matricula m 
							inner join estudiante e on m.Codigo=e.Codigo 
							inner join materia ma on m.idmateria=ma.idmateria 
							ORDER BY e.Nombres ASC LIMIT $Inicio,$Registros
			");

			}
			$Datos=$Datos->fetchAll();
            
			if($cadena!=""){ 
					$Total=self::execute_single_query("SELECT * FROM matricula m 
														inner join estudiante e on m.Codigo=e.Codigo 
														inner join materia ma on m.idmateria=ma.idmateria 
														WHERE CONCAT(e.Nombres, ' ', e.Apellidos) like '%".$cadena."%' ");
			}else{
					$Total=self::execute_single_query("SELECT * FROM matricula m 
													inner join estudiante e on m.Codigo=e.Codigo 
													inner join materia ma on m.idmateria=ma.idmateria ");

			}
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Nombres</th>
						<th class="text-center">Apellidos</th>
						<th class="text-center">Materia</th>
						<th class="text-center">Calificación</th>
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
					$Calificacionfinal=$rows['calificacion'] + $rows['calificaciontaller'] + $rows['calificacionactuacion'];
					$aprobo=$rows['aprobado'];
					$estado="";
					switch($aprobo) 
					{
					case 0:
						$estado="CURSANDO";
					    break;
					case 1:
						$estado="APROBO";
					    break;
					case 2:
						$estado="REPROBO";
					    break;
					}
					$table.='
					<tr id="tabla" name="tabla" value="'.$rows['idmatricula'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['Nombres'].'</td>
						<td>'.$rows['Apellidos'].'</td>
						<td>'.$rows['materia'].'</td>
						<td>'.$Calificacionfinal.'</td>
						<td>'.$estado.'</td>
						<td>
							<a href="'.SERVERURL.'inscripcioninfo/'.$rows['Codigo'].'/'.$rows['idmateria'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['Codigo'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['Codigo'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="inscripcionCode" value="'.$rows['Codigo'].'">
								<input type="hidden" name="inscripcionMateria" value="'.$rows['idmateria'].'">
						        <input type="hidden" name="inscripcionMatricula" value="'.$rows['idmatricula'].'">

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
					$table.='<li><a href="'.SERVERURL.'inscripcionlist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'inscripcionlist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'inscripcionlist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'inscripcionlist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}


		/*----------  Delete Inscripcion Controller  ----------*/
		public function delete_inscripcion_controller($code, $materia){
			$code=self::clean_string($code);
			$materia=self::clean_string($materia);

			if(self::delete_account($code) && self::delete_inscripcion_model($code,$materia)){
				$dataAlert=[
					"title"=>"Inscripcion eliminada!",
					"text"=>"La Inscripcion ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar la matricula por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Inscripcion Controller  ----------*/
		public function update_Inscripcion_controller($fechanow){
			$code=self::clean_string($_POST['codigo']);
			$materia=self::clean_string($_POST['materia']);
			$fecha=self::clean_string($_POST['fecha']);
			$calificacion=self::clean_string($_POST['calificacion']);
			$calificaciontaller=self::clean_string($_POST['calificaciontaller']);
			$calificacionactuacion=self::clean_string($_POST['calificacionactuacion']);
			$aprobado=self::clean_string($_POST['aprobado']);
			$comentario=self::clean_string($_POST['comentario']);
			$notaminima=self::clean_string($_POST['notaminima']);
			$notafinal=$calificacion + $calificaciontaller + $calificacionactuacion;
			if($notafinal >= $notaminima){
               $estado=1;
			}elseif ($notafinal < $notaminima && $notafinal!=0 ) {
				$estado=2;
			}else{
				$estado=0;

			}

             print_r($estado);

			$data=[
				"Codigo"=>$code,
				"materia"=>$materia,
				"fecha"=>$fecha,
				"fechamodifica"=>$fechanow,
				"calificacion"=>$calificacion,
				"calificaciontaller"=>$calificaciontaller,
				"calificacionactuacion"=>$calificacionactuacion,
				//"aprobado"=>$aprobado,	
				"comentario"=>$comentario,
				"notaminima"=>$notaminima,
				"estado"=>$estado
							
			];
            
			if(self::update_inscripcion_model($data)){
				$dataAlert=[
					"title"=>"¡Inscripción actualizada!",
					"text"=>"Los datos de la Inscripción fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos de la Inscripción estudiante, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}