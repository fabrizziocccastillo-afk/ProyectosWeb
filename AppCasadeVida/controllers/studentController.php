<?php
	if($actionsRequired){
		require_once "../models/studentModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/studentModel.php";
		require_once "./core/configGeneral.php";
	}
	
	

	//const SERVERURL = "http://localhost:82/ESCOL/";

	class studentController extends studentModel{

		

		/*----------  Add Student Controller  ----------*/
		public function add_student_controller(){
			$name=self::clean_string($_POST['name']);
			$lastname=self::clean_string($_POST['lastname']);
			$gender=self::clean_string($_POST['gender']);
			$email=self::clean_string($_POST['email']);
			$direccion=self::clean_string($_POST['direccion']);
			$telefono=self::clean_string($_POST['telefono']);
			$pais=self::clean_string($_POST['pais']);
			$ciudad=self::clean_string($_POST['ciudad']);
			$iglesia=self::clean_string($_POST['iglesia']);
			$pertenececda=self::clean_string($_POST['pertenececda']);
			$torre=self::clean_string($_POST['torre']);
			$casadevida=self::clean_string($_POST['casadevida']);
			$bautizado=self::clean_string($_POST['bautizado']);
			$username=self::clean_string($_POST['username']);
			$password1=self::clean_string($_POST['password1']);
			$password2=self::clean_string($_POST['password2']);

			if($password1!="" || $password2!=""){
				if($password1==$password2){
					$query1=self::execute_single_query("SELECT Usuario FROM cuenta WHERE Usuario='$username'");
					if($query1->rowCount()<=0){
						$query2=self::execute_single_query("SELECT id FROM cuenta");
						$correlative=($query2->rowCount())+1;

						$code=self::generate_code("EC",7,$correlative);
						$password1=self::encryption($password1);

						$dataAccount=[
							"Privilegio"=>4,
							"Usuario"=>$username,
							"Clave"=>$password1,
							"Tipo"=>"Estudiante",
							"Genero"=>$gender,
							"Codigo"=>$code
						];

						$dataStudent=[
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
							"bautizado"=>$bautizado
						];

						if(self::save_account($dataAccount) && self::add_student_model($dataStudent)){
							$dataAlert=[
								"title"=>"¡Estudiante registrado!",
								"text"=>"El estudiante se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el estudiante, por favor intente nuevamente",
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
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"Las contraseñas que acabas de ingresar no coinciden",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"Debes de llenar los campos de las contraseñas para registrar el estudiante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}
        
				/*----------  Foto Student Controller  ----------*/
				public function foto_student_controller($codigo){
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
								$query=self::connect()->prepare("UPDATE estudiante SET foto='$imagen' where  Codigo=:Codigo");
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
									echo "<script type='text/javascript'>window.location='SERVERURL/studentData/';<script>";
								}else{
									$_SESSION['mensaje'] = 'ocurrio un error en el servidor';
									$_SESSION['tipo'] = 'danger';
								}
							}
						}
		
				}


		/*----------  Data Student Controller  ----------*/
		public function data_student_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($studentdata=self::data_student_model($data)){
				return $studentdata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del estudiante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		/*----------  Data Update Student Controller  ----------*/
		public function data_student_actualiza_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($studentdata=self::data_student_actualiza_model($data)){
				return $studentdata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del estudiante",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		/*----------  Data Update Student Controller  ----------*/
		public function data_student_actualiza_adm_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($studentdata=self::data_student_actualiza_ADM_model($data)){
				return $studentdata;
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
		public function pagination_student_controller($Pagina,$Registros,$cadena){
			//$Pagina2=self::clean_string($_POST['pagina']);
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);

			print_r($Pagina);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			//echo $Pagina;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			//$Datos=self::execute_single_query("SELECT * FROM estudiante ORDER BY Nombres ASC LIMIT $Inicio,$Registros");


			if($cadena!=""){ 
				      //$Datos=self::execute_single_query("SELECT * FROM estudiante ORDER BY Nombres ASC LIMIT $Inicio,$Registros");
				$Datos=self::execute_single_query("SELECT * FROM estudiante where CONCAT(Nombres, ' ', Apellidos) like '%".$cadena."%' ORDER BY Nombres ASC LIMIT $Inicio,$Registros");
			}else{
				$Datos=self::execute_single_query("SELECT * FROM estudiante ORDER BY Nombres ASC LIMIT $Inicio,$Registros");

			}

			//	$Datos=self::execute_single_query("SELECT * FROM estudiante ORDER BY Nombres ASC LIMIT $Inicio,$Registros");
			//}
			
			$Datos=$Datos->fetchAll();
            if($cadena!=""){ 

			 $Total=self::execute_single_query("SELECT * FROM estudiante where CONCAT(Nombres, ' ', Apellidos) like '%".$cadena."%'");

			}else{
              
			 $Total=self::execute_single_query("SELECT * FROM estudiante");

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
						<th class="text-center">Email</th>
						<th class="text-center">A. Datos</th>
						<th class="text-center">A. Cuenta</th>
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
						<td>'.$rows['Nombres'].'</td>
						<td>'.$rows['Apellidos'].'</td>
						<td>'.$rows['Email'].'</td>
						<td>
							<a href="'.SERVERURL.'studentinfo/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="'.SERVERURL.'account/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
								<i class="zmdi zmdi-refresh"></i>
							</a>
						</td>
						<td>
							<a href="#!" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delete" data-id="del-'.$rows['Codigo'].'">
								<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['Codigo'].'" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="studentCode" value="'.$rows['Codigo'].'">
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
					$table.='<li><a href="'.SERVERURL.'studentlist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'studentlist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'studentlist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'studentlist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		}


		/*----------  Delete Student Controller  ----------*/
		public function delete_student_controller($code){
			$code=self::clean_string($code);

			if(self::delete_account($code) && self::delete_student_model($code)){
				$dataAlert=[
					"title"=>"¡Estudiante eliminado!",
					"text"=>"El estudiante ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el estudiante por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update Student Controller  ----------*/
		public function update_student_controller(){
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
				"cedula"=>$cedula
			];

			if(self::update_student_model($data)){
				$dataAlert=[
					"title"=>"¡Estudiante actualizado!",
					"text"=>"Los datos del estudiante fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del estudiante, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}