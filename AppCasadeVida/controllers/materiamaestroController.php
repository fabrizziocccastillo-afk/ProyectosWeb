<?php
if($actionsRequired){
		require_once "../models/materiamaestroModel.php";
}else{
		require_once "./models/materiamaestroModel.php";   
		}


	
		class materiamaestroController extends materiamaestroModel{

		public function add_materiamaestro_controller(){

			/*echo "<pre>";       
			print_r($_POST);
			echo "</pre>"; 
			exit();*/
						
			//$code=self::clean_string($_POST['code']);
			$foto = "";
			$materia=self::clean_string($_POST['materia']);
			$Tutor=self::clean_string($_POST['tutor']);
			$correo=self::clean_string($_POST['correo']);
			$ciclo=self::clean_string($_POST['ciclo']);
			//$notminaprueba=self::clean_string($_POST['notminaprueba']);
			


						$datausuario=[
                            "materia"=>$materia,
                            "Tutor"=>$Tutor,
                            "correo"=>$correo,
                            "ciclo"=>$ciclo,
							"foto"=>$foto
                        ];

						if(self::add_materiamaestro_model($datausuario)){
							self::foto_materiamaestro_controller();
							$dataAlert=[
								"title"=>"Materia registrada!",
								"text"=>"La materia se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar la materia, por favor intente nuevamente",
								"type"=>"error"
							];
							return self::sweet_alert_single($dataAlert);
						}

			
		
		}

		
				/*----------  Foto usuario Controller  ----------*/
				public function foto_materiamaestro_controller(){
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
								$query=self::connect()->prepare("UPDATE materia SET fotomaestro='$imagen' where  idmateria=(select max(idmateria) from materia)");
								//$query->bindParam(":Codigo",$codigo);
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
									//echo "<script type='text/javascript'>window.location='SERVERURL/usuariolist/';<script>";
								}else{
									$_SESSION['mensaje'] = 'ocurrio un error en el servidor';
									$_SESSION['tipo'] = 'danger';
								}
							}
						}
		
				}

				/*----------  Foto usuario Controller  ----------*/
				public function foto_materiamaestro2_controller($codigo){
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
							$query=self::connect()->prepare("UPDATE materia SET fotomaestro='$imagen' where  idmateria=:Codigo");
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
								//echo "<script type='text/javascript'>window.location='SERVERURL/usuariolist/';<script>";
							}else{
								$_SESSION['mensaje'] = 'ocurrio un error en el servidor';
								$_SESSION['tipo'] = 'danger';
							}
						}
					}
	
			}

		/*----------  Data Update Student Controller  ----------*/
		public function data_materiamaestro_actualiza_adm_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($materiadata=self::data_materiamaestro_actualiza_ADM_model($data)){
				return $materiadata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos de la materia",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

				/*----------  Pagination integrante Controller  ----------*/
		public function pagination_materiamaestro_controller($Pagina,$Registros){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

		
			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT * FROM materia ORDER BY materia ASC LIMIT $Inicio,$Registros");

			
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM materia");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Materia</th>
						<th class="text-center">Tutor</th>
						<th class="text-center">Email</th>
						<th class="text-center">Ciclo</th>
						<th class="text-center">A. Datos</th>
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
						<td>'.$rows['materia'].'</td>
						<td>'.$rows['Tutor'].'</td>
						<td>'.$rows['correo'].'</td>
						<td>'.$rows['ciclo'].'</td>
						<td>
							<a href="'.SERVERURL.'materiainfo/'.$rows['idmateria'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['idmateria'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['idmateria'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="materiaCode" value="'.$rows['idmateria'].'">
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
					$table.='<li><a href="'.SERVERURL.'materialist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'materialist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'materialist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'materialist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		}

		/*----------  Delete integrante Controller  ----------*/
		public function delete_materiamaestro_controller($code){
			$code=self::clean_string($code);

			if(self::delete_materiamaestro_model($code)){
				$dataAlert=[
					"title"=>"Materia eliminada!",
					"text"=>"La Materia ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar La Materia por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

				/*----------  Update integrante Controller  ----------*/
				public function update_materiamaestro_controller(){
					$code=self::clean_string($_POST['code']);
					$materia=self::clean_string($_POST['materia']);
					$Tutor=self::clean_string($_POST['tutor']);
					$correo=self::clean_string($_POST['correo']);
					$ciclo=self::clean_string($_POST['ciclo']);
					$notminaprueba=self::clean_string($_POST['notminaprueba']);
					
		
					$data=[
						"Codigo"=>$code,
						"materia"=>$materia,
						"Tutor"=>$Tutor,
						"correo"=>$correo,
						"ciclo"=>$ciclo,
						"notminaprueba"=>$notminaprueba	
					];
		
					if(self::update_materiamaestro_model($data)){
						$dataAlert=[
							"title"=>"¡Materia actualizado!",
							"text"=>"Los datos de la Materia fueron actualizados con éxito",
							"type"=>"success"
						];
						return self::sweet_alert_single($dataAlert);
					}else{
						$dataAlert=[
							"title"=>"¡Ocurrió un error inesperado!",
							"text"=>"No hemos podido actualizar los datos de la Materia, por favor intente nuevamente",
							"type"=>"error"
						];
						return self::sweet_alert_single($dataAlert);
					}
				}

	}
?>