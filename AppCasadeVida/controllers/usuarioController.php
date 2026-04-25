<?php
	if($actionsRequired){
		require_once "../models/usuarioModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/usuarioModel.php";
		require_once "./core/configGeneral.php";
	}
	
	

	//const SERVERURL = "http://localhost:82/ESCOL/";

	class usuarioController extends usuarioModel{


		public function add_usuario_controller(){

			/*echo "<pre>";       
			print_r($_POST);
			echo "</pre>"; 
			exit();*/
						
			//$code=self::clean_string($_POST['code']);
			//$foto = "";
			$name=self::clean_string($_POST['name']);
			$lastname=self::clean_string($_POST['lastname']);
			$gender=self::clean_string($_POST['gender']);
			//$email=self::clean_string($_POST['email']);
			//$direccion=self::clean_string($_POST['direccion']);
			$telefono=self::clean_string($_POST['telefono']);
			//$pais=self::clean_string($_POST['pais']);
			//$ciudad=self::clean_string($_POST['ciudad']);
			/*$ciudad= isset($_POST['ciudad']) ? self::clean_string($_POST['ciudad']) : 0;
			$iglesia=self::clean_string($_POST['iglesia']);
			$pertenececda=self::clean_string($_POST['pertenececda']);
			$torre=self::clean_string($_POST['torres']);
			//$casadevida=self::clean_string($_POST['casavida']);
			$casadevida=isset($_POST['casavida']) ? self::clean_string($_POST['casavida']) : 0; //self::clean_string($_POST['casavida']);
			$bautizado=self::clean_string($_POST['bautizado']);
			$sector=self::clean_string($_POST['sector']);
			$fechanacimiento=self::clean_string($_POST['fecha']);
            $lugarnacimiento=self::clean_string($_POST['lugar']);
            $estadocivil=self::clean_string($_POST['estado']);
			//$foto=self::clean_string($_POST['imagen']);
            $instruccion=self::clean_string($_POST['instruccion']);
            $profesion=self::clean_string($_POST['profesion']);
            $dirtrabajo=self::clean_string($_POST['dirtrabajo']);
            $teltrabajo=self::clean_string($_POST['teltrabajo']);
            $empresa=self::clean_string($_POST['empresa']);
			$fechaconversion=self::clean_string($_POST['fechaconversion']);
			$fechabautizo=self::clean_string($_POST['fechabautizo']);
			$lugarbautizo=self::clean_string($_POST['lugarbautizo']);*/
			$cedula=self::clean_string($_POST['cedula']);
			$userrol=self::clean_string($_POST['userrol']);
			$username=self::clean_string($_POST['username']);
			$password1=self::clean_string($_POST['password1']);
			$password2=self::clean_string($_POST['password2']);

			if($password1!="" || $password2!=""){
				if($password1==$password2){
					$query1=self::execute_single_query("SELECT Usuario FROM cuenta WHERE Usuario='$username'");
					if($query1->rowCount()<=0){
						$query2=self::execute_single_query("SELECT id FROM cuenta");
						$correlative=($query2->rowCount())+1;

						$code=self::generate_code("UC",7,$correlative);
						$password1=self::encryption($password1);

						$dataAccount=[
							"Privilegio"=>4,
							"Usuario"=>$username,
							"Clave"=>$password1,
							"Tipo"=>"UsuarioCDV",
							"Genero"=>$gender,
							"Codigo"=>$code,
							"idrol"=>$userrol
						];

						$datausuario=[
                            "Codigo"=>$code,
                            "Nombres"=>$name,
                            "Apellidos"=>$lastname,
                            /*"Email"=>$email,
                            "direccion"=>$direccion,*/
                            "telefono"=>$telefono,
                            /*"pais"=>$pais,
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
							"foto"=>$foto,
                            "instruccion"=>$instruccion,
                            "profesion"=>$profesion,
                            "dirtrabajo"=>$dirtrabajo,
                            "teltrabajo"=>$teltrabajo,
                            "empresa"=>$empresa,
                            "fechaconversion"=>$fechaconversion,
                            "fechabautizo"=>$fechabautizo,
                            "lugarbautizo"=>$lugarbautizo,*/
                            "cedula"=>$cedula
                        ];

						if(self::save_account($dataAccount) && self::add_usuario_model($datausuario)){
							//self::foto_usuario_controller($code);
							$dataAlert=[
								"title"=>"¡Usuario registrado!",
								"text"=>"El usuario se registró con éxito en el sistema",
								"type"=>"success"
							];
							unset($_POST);
							return self::sweet_alert_single($dataAlert);
						}else{
							$dataAlert=[
								"title"=>"¡Ocurrió un error inesperado!",
								"text"=>"No hemos podido registrar el usuario, por favor intente nuevamente",
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

		
				/*----------  Foto usuario Controller  ----------*/
				public function foto_usuario_controller($codigo){
						$imagen = $_FILES['imagen']['name'];
						//$codigo = $_POST['code'];

						if(isset($imagen) && $imagen != ""){
							$tipo = $_FILES['imagen']['type'];
							$temp  = $_FILES['imagen']['tmp_name'];

							if( (strpos($tipo,'gif') || strpos($tipo,'jpg') || strpos($tipo,'png') || strpos($tipo,'jpeg') || strpos($tipo,'webp'))){

							
								//echo "2";
								$query=self::connect()->prepare("UPDATE usuariocdv SET foto='$imagen' where  Codigo=:Codigo");
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
								}
							}
						}
		
				}


		/*----------  Data usuario Controller  ----------*/
		public function data_usuario_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($usuariodata=self::data_usuario_model($data)){
				return $usuariodata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del usuario",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		/*----------  Data Update Student Controller  ----------*/
		public function data_usuario_actualiza_adm_controller($Type,$Code){
			$Type=self::clean_string($Type);
			$Code=self::clean_string($Code);

			$data=[
				"Tipo"=>$Type,
				"Codigo"=>$Code
			];

			if($studentdata=self::data_usuario_actualiza_ADM_model($data)){
				return $studentdata;
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido seleccionar los datos del usuario",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}

		}

		

		/*----------  Pagination usuario Controller  ----------*/
		public function pagination_usuario_controller($Pagina,$Registros,$cadena){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

		
			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("SELECT * FROM usuariocdv a inner join cuenta b on a.Codigo=b.Codigo 
			inner join rol c on b.idrol=c.idrol
			ORDER BY a.Nombres ASC LIMIT $Inicio,$Registros");

			
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM usuariocdv");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Nombres</th>
						<th class="text-center">Apellidos</th>
						<th class="text-center">Telefono</th>
						<th class="text-center">Rol</th>
						<th class="text-center">M. Datos</th>
						<th class="text-center">M. Cuenta</th>
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
						<td>'.$rows['telefono'].'</td>
						<td>'.$rows['rol'].'</td>
						<td>
							<a href="'.SERVERURL.'usuarioinfo/'.$rows['Codigo'].'/" class="btn btn-success btn-raised btn-xs">
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
								<input type="hidden" name="usuarioCode" value="'.$rows['Codigo'].'">
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
					$table.='<li><a href="'.SERVERURL.'usuariolist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'usuariolist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'usuariolist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'usuariolist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		}


		/*----------  Delete usuario Controller  ----------*/
		public function delete_usuario_controller($code){
			$code=self::clean_string($code);

			if(self::delete_usuario_model($code)){
				$dataAlert=[
					"title"=>"¡usuario eliminado!",
					"text"=>"El usuario ha sido eliminado del sistema satisfactoriamente",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No pudimos eliminar el usuario por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}


		/*----------  Update usuario Controller  ----------*/
		public function update_usuario_controller(){
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

			if(self::update_usuario_model($data)){
				$dataAlert=[
					"title"=>"¡Usuario actualizado!",
					"text"=>"Los datos del usuario fueron actualizados con éxito",
					"type"=>"success"
				];
				return self::sweet_alert_single($dataAlert);
			}else{
				$dataAlert=[
					"title"=>"¡Ocurrió un error inesperado!",
					"text"=>"No hemos podido actualizar los datos del usuario, por favor intente nuevamente",
					"type"=>"error"
				];
				return self::sweet_alert_single($dataAlert);
			}
		}

	}