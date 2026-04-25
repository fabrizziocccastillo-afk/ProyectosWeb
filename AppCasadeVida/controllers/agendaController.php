<?php
	if($actionsRequired){
		require_once "../models/agendaModel.php";
	}else{ 
		require_once "./models/agendaModel.php";
	}

	class agendaController extends agendaModel{

		/*----------  Add agenda Controller  ----------*/
		public function add_agenda_controller(){
			$title=self::clean_string($_POST['titulo']);
		//	$teacher=self::clean_string($_POST['teacher']);
        //    $autor=self::clean_string($_POST['autor']);

			$AttMaxSize=5120;
			$AttDir="../attachments/class/";

			$ATC=0;
			$AttFinalName="";
			$AttFinalNameTMP="";
			foreach($_FILES["attachments"]['tmp_name'] as $key => $tmp_name){
				if($_FILES["attachments"]["name"][$key]){

					$AttType=$_FILES['attachments']['type'][$key];
					$AttSize=$_FILES['attachments']['size'][$key];

					if($AttType=="image/jpeg" || $AttType=="image/png" || $AttType=="application/msword" || $AttType=="application/vnd.ms-powerpoint" || $AttType=="application/pdf" || $AttType=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $AttType=="application/vnd.openxmlformats-officedocument.presentationml.presentation"){
						if(($AttSize/1024)<=$AttMaxSize){

							$AttName = str_ireplace(",", "", $_FILES["attachments"]["name"][$key]);
							$AttName = str_ireplace(" ", "_", $_FILES["attachments"]["name"][$key]);
							$finalDir=$AttDir.$AttName;

							if(is_file($finalDir)){
								if($AttFinalNameTMP!=""){
									$delTMP=explode(",", $AttFinalNameTMP);
									foreach ($delTMP as $delFile) {
										$filesAD=$AttDir.$delFile;
										chmod($filesAD, 0777);
										unlink($filesAD);
									}
								}
								$dataAlert=[
									"title"=>"¡Ocurrió un error inesperado!",
									"text"=>"Ya existe un archivo con el nombre <b>".$AttName."</b> registrado en el sistema por favor cambie el nombre del archivo adjunto antes de subirlo",
									"type"=>"error"
								];
								return self::sweet_alert_single($dataAlert);
								exit();
							}else{
								chmod($AttDir, 0777);

								if(move_uploaded_file($_FILES["attachments"]['tmp_name'][$key], $finalDir)){
									if($ATC==0){
										$AttFinalName.=$AttName;
										$AttFinalNameTMP.=$AttName;
										$ATC++;
									}else{
										$AttFinalName.=",".$AttName;
										$AttFinalNameTMP.=$AttName;
									}	
								}else{	
									$dataAlert=[
										"title"=>"¡Ocurrió un error inesperado!",
										"text"=>"No se pudo cargar uno o más de los archivos adjuntos seleccionados",
										"type"=>"error"
									];
									return self::sweet_alert_single($dataAlert);
									exit();
								}
							}
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"El tamaño de uno de los archivos supera el límite de peso máximo que son 5MB",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
							exit();
						}
					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El tipo de formato de uno de los archivo que acaba de seleccionar no esta permitido",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
						exit();
					}
				}
			}

			$query1=self::execute_single_query("SELECT titulo FROM agenda WHERE Titulo='$title'");

			if($query1->rowCount()>=1){
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"El Nombre de la agenda ya se encuentra registrado por favor elija otro",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$data=[
					"Titulo"=>$title,
                    //"Autor"=>$autor,
					//"Tutor"=>$teacher,
					"Adjuntos"=>$AttFinalName
				];
				if(self::add_agenda_model($data)){
					$dataAlert=[
						"title"=>"¡Agenda registrada!",
						"text"=>"La Agenda se registró con éxito en el sistema",
						"type"=>"success"
					];
					return self::sweet_alert_reset($dataAlert);
				}else{
					if($AttFinalName!=""){
						$filesA=explode(",", $AttFinalName);
						foreach ($files as $filesA) {
							chmod($AttDir.$files, 0777);
							unlink($AttDir.$files);	
						}
					}
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"No hemos podido registrar la agenda, por favor intente nuevamente",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}
			}
		}


		/*----------  Pagination Video Controller  ----------*/
		public function pagination_agenda_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM agenda ORDER BY titulo DESC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM agenda");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Titulo</th>
                        <th class="text-center">Fecha de Publicacion</th>
						<th class="text-center">Actualizar</th>
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
						<td>'.$rows['titulo'].'</td>
						<td>'.$rows['fecha_publicacion'].'</td>
						<td>
							<a href="'.SERVERURL.'agendainfo/'.$rows['idagenda'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<form action="'.SERVERURL.'ajax/ajaxAgenda.php" method="POST" enctype="multipart/form-data" autocomplete="off" data-form="DellVideo" class="ajaxDataForm">
								<input type="hidden" name="agendaCode" value="'.$rows['idagenda'].'">
								<button type="submit" class="btn btn-danger btn-raised btn-xs">
									<i class="zmdi zmdi-delete"></i>
								</button>
								<div class="full-box form-process"></div>
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
					$table.='<li><a href="'.SERVERURL.'agendalist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'agendalist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'agendalist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'agendalist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}

		public function pagination_agendadescarga_controller($Pagina,$Registros){

			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM agenda ORDER BY titulo DESC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM agenda");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Titulo</th>
                        <th class="text-center">Autor</th>
						<th class="text-center">Tutor</th>
						<th class="text-center">Ver</th>
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
						<td>'.$rows['Titulo'].'</td>
                        <td>'.$rows['Autor'].'</td>
						<td>'.$rows['Tutor'].'</td>
						<td>
							<a href="'.SERVERURL.'agendaview/'.$rows['idagenda'].'/" class="btn btn-success btn-raised btn-xs">
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
					$table.='<li><a href="'.SERVERURL.'agendadescarga/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'agendadescarga/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'agendadescarga/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'agendadescarga/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;


		}

		
		/*----------  Delete Video Controller  ----------*/
		public function delete_agenda_controller($code){
			$code=self::clean_string($code);
			
			$query1=self::execute_single_query("SELECT Adjuntos FROM agenda WHERE id='$code'");
			$rows=$query1->fetch();

			//$query2=self::execute_single_query("SELECT Adjunto FROM comentarios WHERE id='$code'");
			//$rows2=$query2->fetch();

			if(self::delete_agenda_model($code)){

				//Delete files from Video
				$filesA=explode(",", $rows['Adjuntos']);
				$AttDir="../attachments/class/";
				foreach ($filesA as $AttClass) {
					if($AttClass!=""){
						chmod($AttDir.$AttClass, 0777);
						unlink($AttDir.$AttClass);
					}
				}

				//Delete files from Comments
				$filesA2=explode(",", $rows2['Adjunto']);
				$AttDir2="../attachments/comments/";
				foreach ($filesA2 as $AttClass2) {
					if($AttClass2!=""){
						chmod($AttDir2.$AttClass2, 0777);
						unlink($AttDir2.$AttClass2);
					}
				}


				$dataAlert=[
					"title"=>"¡Libro eliminada!",
					"text"=>"La Agenda ha sido eliminada del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar la Agenda por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Delete Video Attachment Controller  ----------*/
		public function delete_agenda_attachment_controller($code,$name,$urls){
			$code=self::clean_string($_POST['idAtt']);
			$name=$_POST['nameAtt'];

			$AttDir="./attachments/class/";

			chmod($AttDir.$name, 0777);
			if(unlink($AttDir.$name)){
				$query1=self::execute_single_query("SELECT * FROM agenda WHERE idagenda='$code'");
				$rows=$query1->fetch();
				$filesA=explode(",", $rows['imagen']);
				$catt=0;
				$attFinal="";
				foreach ($filesA as $AttClass) {
					if($AttClass!=$name){
						if($catt<=0){
							$attFinal.=$AttClass;
						}else{
							$attFinal.=",".$AttClass;
						}
						$catt++;
					}
				}
				if(self::execute_single_query("UPDATE agenda SET imagen='$attFinal' WHERE idagenda='$code'")){
					$dataAlert=[
						"title"=>"¡Archivo eliminado!",
						"text"=>"El archivo adjunto de la Agenda fue eliminado con éxito",
						"type"=>"success"
					];
					return self::sweet_alert_url_reload($dataAlert,$urls);
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"No pudimos eliminar el archivo adjunto de la Agenda por favor intente nuevamente",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);	
				}
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el archivo adjunto de la Agenda por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Data Video Controller  ----------*/
		public function data_agenda_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"id"=>$Code
			];

			if($agendadata=self::data_agenda_model($data)){
				return $agendadata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos de la Agenda",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Video Controller  ----------*/
		public function update_agenda_controller(){
			$code=self::clean_string($_POST['upid']);
			$title=self::clean_string($_POST['title']);
			$teacher=self::clean_string($_POST['teacher']);
			$autor=self::clean_string($_POST['autor']);

			$AttMaxSize=5120;
			$AttDir="../attachments/class/";

			$ATC=0;
			$AttFinalName="";
			$AttFinalNameTMP="";

			foreach($_FILES["attachments"]['tmp_name'] as $key => $tmp_name){
				if($_FILES["attachments"]["name"][$key]){

					$AttType=$_FILES['attachments']['type'][$key];
					$AttSize=$_FILES['attachments']['size'][$key];

					if($AttType=="image/jpeg" || $AttType=="image/png" || $AttType=="application/msword" || $AttType=="application/vnd.ms-powerpoint" || $AttType=="application/pdf" || $AttType=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $AttType=="application/vnd.openxmlformats-officedocument.presentationml.presentation"){
						if(($AttSize/1024)<=$AttMaxSize){

							$AttName = str_ireplace(",", "", $_FILES["attachments"]["name"][$key]);
							$AttName = str_ireplace(" ", "_", $_FILES["attachments"]["name"][$key]);
							$finalDir=$AttDir.$AttName;

							if(is_file($finalDir)){
								if($AttFinalNameTMP!=""){
									$delTMP=explode(",", $AttFinalNameTMP);
									foreach ($delTMP as $delFile) {
										$filesAD=$AttDir.$delFile;
										chmod($filesAD, 0777);
										unlink($filesAD);
									}
								}
								$dataAlert=[
									"title"=>"¡Ocurrió un error inesperado!",
									"text"=>"Ya existe un archivo con el nombre <b>".$AttName."</b> registrado en el sistema por favor cambie el nombre del archivo adjunto antes de subirlo",
									"type"=>"error"
								];
								return self::sweet_alert_single($dataAlert);
								exit();
							}else{
								chmod($AttDir, 0777);

								if(move_uploaded_file($_FILES["attachments"]['tmp_name'][$key], $finalDir)){
									if($ATC==0){
										$AttFinalName.=$AttName;
										$AttFinalNameTMP.=$AttName;
										$ATC++;
									}else{
										$AttFinalName.=",".$AttName;
										$AttFinalNameTMP.=$AttName;
									}	
								}else{	
									$dataAlert=[
										"title"=>"¡Ocurrió un error inesperado!",
										"text"=>"No se pudo cargar uno o más de los archivos adjuntos seleccionados",
										"type"=>"error"
									];
									return self::sweet_alert_single($dataAlert);
									exit();
								}
							}
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"El tamaño de uno de los archivos supera el límite de peso máximo que son 5MB",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
							exit();
						}
					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"El tipo de formato de uno de los archivo que acaba de seleccionar no esta permitido",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
						exit();
					}
				}
			}

			$query1=self::execute_single_query("SELECT Adjuntos FROM agenda WHERE idagenda='$code'");
			$rows1=$query1->fetch();

			if($rows1['Adjuntos']!=""){
				$finalAtts=$rows1['Adjuntos'].",".$AttFinalName;
			}else{
				$finalAtts=$AttFinalName;
			}

			$data=[
				"id"=>$code,
				"Titulo"=>$title,
				"Autor"=>$autor,
				"Tutor"=>$teacher,
				"Adjuntos"=>$finalAtts
			];

			if(self::update_agenda_model($data)){
				$dataAlert=[
					"title"=>"¡Libro actualizado!",
					"text"=>"Los datos de la Agenda fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos de la Agenda, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}