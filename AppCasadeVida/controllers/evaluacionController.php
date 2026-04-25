<?php
	if($actionsRequired){
		require_once "../models/evaluacionModel.php";
	}else{ 
		require_once "./models/evaluacionModel.php";
	}

	class evaluacionController extends evaluacionModel{

		/*----------  Add evaluacion Controller  ----------*/
		public function add_evaluacion_controller($dataEvaluacion){
			$materia=$dataEvaluacion['materia'];		
			$query1=self::execute_single_query("SELECT idevaluacion FROM evaluacion WHERE idmateria=$materia and estado=1");
					if($query1->rowCount()<=0){				

						if(self::add_evaluacion_model($dataEvaluacion)){
							$dataAlert=[
								"title"=>"¡Evaluacion Creada con exito!",
								"text"=>"El Evaluacion se creo con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido crear la evaluacion, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"La Evaluacion ya se encuentra creada en la materia seleccionada, por favor elija otra materia",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}			
		}

		/*----------  Add preguntas Controller  ----------*/
		public function add_preguntas_controller(){
			$idevaluacion=self::clean_string($_POST['idevaluacion']);
			$pregunta=self::clean_string($_POST['pregunta']);
			$puntos=self::clean_string($_POST['puntos']);
			
			//$query1=self::execute_single_query("SELECT idevaluacion FROM preguntas WHERE idmateria=$materia");
					//if($query1->rowCount()<=0){						
						$dataPreguntas=[
							"idevaluacion"=>$idevaluacion,
							"pregunta"=>$pregunta,
							"puntos"=>$puntos						
						];

						if(self::add_preguntas_model($dataPreguntas)){
							$dataAlert=[
								"title"=>"Pregunta Creada con exito!",
								"text"=>"La Pregunta se creo con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido crear la Pregunta, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					/*}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"La Evaluacion ya se encuentra creada en la materia seleccionada, por favor elija otra materia",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}*/			
		}
	
        /*----------  Add repuestas Controller  ----------*/
		public function add_respuestas_controller(){
			$idevaluacion=self::clean_string($_POST['idevaluacion']);
			$pregunta=self::clean_string($_POST['pregunta']);
			$puntos=self::clean_string($_POST['puntos']);
			
			//$query1=self::execute_single_query("SELECT idevaluacion FROM preguntas WHERE idmateria=$materia");
					//if($query1->rowCount()<=0){						
						$dataRespuestas=[
							"idevaluacion"=>$idevaluacion,
							"idpreguntas"=>$idpreguntas,
							"respuesta"=>$respuesta,
							"correcta"=>$correcta						
						];

						if(self::add_respuestas_model($dataRespuestas)){
							$dataAlert=[
								"title"=>"Respuesta Creada con exito!",
								"text"=>"Repuesta se Creo con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido crear la Respuesta, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

					/*}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"La Evaluacion ya se encuentra creada en la materia seleccionada, por favor elija otra materia",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}*/			
		}
	



		/*----------  Data Evaluacion Controller  ----------*/
		public function data_evaluacion_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);
			//$materia=self::clean_string($materia);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code,
			];

			if($evaluaciondata=self::data_evaluacion_model($data)){
				return $evaluaciondata;
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
		public function pagination_evaluacion_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT distinct ev.idevaluacion, mat.materia, ev.idmateria, ev.tutor, ev.titulo, ev.fecha_inicio,ev.fecha_final, case ev.estado  when 1 then 'Activa' else 'Inactiva' end as estado FROM evaluacion ev 
			INNER join preguntas pr on ev.idevaluacion=pr.idevaluacion
			INNER join respuestas res on pr.idpreguntas=res.idpreguntas and ev.idevaluacion=res.idevaluacion
			INNER join materia mat on mat.idmateria=ev.idmateria 
				ORDER BY ev.idevaluacion ASC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT distinct ev.idevaluacion, mat.materia, ev.tutor, ev.titulo, ev.fecha_inicio,ev.fecha_final,case ev.estado  when 1 then 'Activa' else 'Inactiva' end as estado FROM evaluacion ev 
			INNER join preguntas pr on ev.idevaluacion=pr.idevaluacion
			INNER join respuestas res on pr.idpreguntas=res.idpreguntas and ev.idevaluacion=res.idevaluacion
			INNER join materia mat on mat.idmateria=ev.idmateria");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Materia</th>
						<th class="text-center">Tutor</th>
						<th class="text-center">Titulo</th>
						<th class="text-center">Fecha Inicio</th>
						<th class="text-center">Fecha Finalizo</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Eliminar</th>
					</tr>
				</thead>
				<tbody>
			';

			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					$table.='
					<tr id="tabla" name="tabla" value="'.$rows['idevaluacion'].'">
						<td>'.$nt.'</td>
						<td>'.$rows['materia'].'</td>
						<td>'.$rows['tutor'].'</td>
						<td>'.$rows['titulo'].'</td>
						<td>'.$rows['fecha_inicio'].'</td>
						<td>'.$rows['fecha_final'].'</td>
						<td>'.$rows['estado'].'</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idevaluacion'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idevaluacion'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="evaluacionCode" value="'.$rows['idevaluacion'].'">
								<input type="hidden" name="evaluacionMateria" value="'.$rows['idmateria'].'">
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
					$table.='<li><a href="'.SERVERURL.'evaluacionlist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'evaluacionlist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'evaluacionlist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'evaluacionlist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}


		/*----------  Delete Evaluacion Controller  ----------*/
		public function delete_evaluacion_controller($code,$materia){
			$code=self::clean_string($code);
			$materia=self::clean_string($materia);

			if(self::delete_evaluacion_model($code,$materia)){
				$dataAlert=[
					"title"=>"Evaluacion eliminada!",
					"text"=>"La Evaluacion ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar la evaluacion por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update evaluacion Controller  ----------*/
		public function update_evaluacion_controller($fechanow){
			$materia=self::clean_string($_POST['materia']);
			$tutor=self::clean_string($_POST['tutor']);
			$titulo=self::clean_string($_POST['titulo']);
			$descripcion=self::clean_string($_POST['descripcion']);
			$fecha_inicio=self::clean_string($_POST['fecha_inicio']);
			$fecha_final=self::clean_string($_POST['fecha_final']);
			$tiempo=self::clean_string($_POST['tiempo']);
			$estado=self::clean_string($_POST['estado']);


			$data=[
				"materia"=>$materia,
				"tutor"=>$tutor,
				"titulo"=>$titulo,
				"descripcion"=>$descripcion,
				"fecha_inicio"=>$fecha_inicio,
				"tiempo"=>$fecha_final,
				"estado"=>$fecha_final		
			];
            
			if(self::update_evaluacion_model($data)){
				$dataAlert=[
					"title"=>"Evlauacion actualizada!",
					"text"=>"Los datos de la Evlauacion fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos de la Evaluacion estudiante, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

		/*----------  Update pregunta Controller  ----------*/
		public function update_preguntas_controller($fechanow){
			$idevaluacion=self::clean_string($_POST['idevaluacion']);
			$pregunta=self::clean_string($_POST['pregunta']);
			$puntos=self::clean_string($_POST['puntos']);

			$data=[
				"idevaluacion"=>$idevaluacion,
				"pregunta"=>$pregunta,
				"titulo"=>$titulo,
				"puntos"=>$puntos
			];
            
			if(self::update_preguntas_model($data)){
				$dataAlert=[
					"title"=>"Pregunta actualizada!",
					"text"=>"Los datos de la Pregunta fue actualizada con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos de la Pregunta, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

		/*----------  Update respuesta Controller  ----------*/
		public function update_respuestas_controller($fechanow){
			$idevaluacion=self::clean_string($_POST['idevaluacion']);
			$idpreguntas=self::clean_string($_POST['idpreguntas']);
			$pregunta=self::clean_string($_POST['pregunta']);
			$puntos=self::clean_string($_POST['puntos']);

			$data=[
				"idevaluacion"=>$idevaluacion,
				"idpreguntas"=>$idpreguntas,
				"pregunta"=>$pregunta,
				"puntos"=>$puntos
			];
            
			if(self::update_respuestas_model($data)){
				$dataAlert=[
					"title"=>"Pregunta actualizada!",
					"text"=>"Los datos de la Pregunta fue actualizada con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos de la Pregunta, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}