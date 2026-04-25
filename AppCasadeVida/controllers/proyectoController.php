<?php
	if($actionsRequired){
		require_once "../models/proyectoModel.php";
	}else{ 
		require_once "./models/proyectoModel.php";
	}

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class proyectoController extends proyectoModel{

		/*----------  Add proyecto Controller  ----------*/
		public function add_proyecto_controller(){

			//$correo=self::clean_string($_POST['procorreo']);
         //ini_set("SMTP",);
            /*echo "<pre>";       
            print_r($correo);
            echo "</pre>"; 
            exit();*/

            $nombreProyecto = $_FILES['files']['name'];
			$nombreProyectoTMP = $_FILES['files']['tmp_name'];
		 	$materia=self::clean_string($_POST['promateria']);
			$codigo=self::clean_string($_POST['procodigo']);
            $correo=self::clean_string($_POST['procorreo']);
			$nombreEstudiante=self::clean_string($_POST['estnombre']);
			$apellidoEstudiante=self::clean_string($_POST['estapellido']);
            $asunto_proyecto="Proyecto Final";
            $mensaje_mail="Adjunto Proyecto final..";
            $cabecera="From: Miguel Muñoz<miguelmhmc@gmail.com>";
			$file = $nombreProyecto[0];
			$estado= 1;

			$data=[
				"nombre"=>$nombreProyecto[0],
				"materia"=>$materia,
				"codigo"=>$codigo,
				"estado"=>$estado
			];

			
			require 'PHPMailer/Exception.php';
			require 'PHPMailer/PHPMailer.php';
			require 'PHPMailer/SMTP.php';
    
			//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer(true);

			try {


				$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
				);
				//Server settings
				$mail->SMTPDebug = 0;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->CharSet = 'UTF-8';
				$mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
				//$mail->Host = 'academycem.com';//'academycem.com';//'smtp.gmail.com';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true; 
				$mail->Username   = 'miguelmhmc@gmail.com'; 
				$mail->Password   = '7237MIKE';                                   //Enable SMTP authentication
				//$mail->Username   = 'estudiante@academycem.com';//'miguelmhmc@gmail.com';                     //SMTP username
				//$mail->Password   = 'alumn@sInfo'; //'7237MIKE';                               //SMTP password
				$mail->SMTPSecure = 'ssl';//PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				$mail->Port       = 465;//465; //465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

				//Recipients
				$mail->setFrom('miguelmhmc@gmail.com', 'Info ACADEMY');
				//$mail->setFrom('estudiante@academycem.com','Adm. ACADEMY');
				$correoMaestro=self::execute_single_query("
				SELECT * FROM materia where idmateria=$materia 
				");
				$correoMaestro=$correoMaestro->fetchAll();
				foreach($correoMaestro as $rows){
				$mail->addAddress($rows['correo']);
				}
				//$mail->setFrom('miguelmhmc@gmail.com', 'Info ACADEMY');
				//$mail->addAddress('miguelmhmc@hotmail.com','Miguel Muñoz');     //Add a recipient
				//$mail->addAddress('fabu_castillo@hotmail.com', 'Fabricio Castillo');               //Name is optional
				//$mail->addReplyTo('info@example.com', 'Information');
				//$mail->addCC('cc@example.com');
				//$mail->addBCC('bcc@example.com');

				//Attachments
				//Ruta del archivo adjunto
			    $mail->addAttachment($nombreProyectoTMP[0],$nombreProyecto[0]);
				//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

				//Content
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = 'Envio Proyecto Final';
				$mail->Body    = "Estudiante: ".$nombreEstudiante." ".$apellidoEstudiante." <br><br> Gracias Por su atención le saluda <b>ACADEMY!</b>";
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$mail->send();
				//echo 'Mensaje Enviado con exito..';

				if(self::add_proyecto_model($data)){
                $dataAlert=[
					"title"=>"¡Envio registrado!",
					"text"=>"Envio se registró con éxito en el sistema",
					"type"=>"success"
				];
				return self::sweet_alert_reset($dataAlert);
				}else{
					$dataAlert=[
						"title"=>"¡Ocurrió un error inesperado!",
						"text"=>"No hemos podido registrar el envio, por favor intente nuevamente",
						"type"=>"error"
					];
					return self::sweet_alert_single($dataAlert);
				}

			    } catch (Exception $e) {
				   echo "Mensaje de Error: {$mail->ErrorInfo}";
                    $estado=0;
				    //if(self::add_proyecto_model($data)){
					$dataAlert=[
						"title"=>"¡Envio registrado Con error!",
						"text"=>"Envio se registró con error en el sistema",
						"type"=>"error"
					];
					return self::sweet_alert_reset($dataAlert);
				   // }

			    }


				
				
		}


		/*----------  Pagination proyecto Controller  ----------*/
		public function pagination_proyecto_controller($Pagina,$Registros,$materia,$codigo){
            //print_r($Pagina);
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);

			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;

			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

			$Datos=self::execute_single_query("
				SELECT * FROM proyectos where idmateria=$materia and codigo='$codigo' ORDER BY fechaenvio DESC LIMIT $Inicio,$Registros
			");
			$Datos=$Datos->fetchAll();

			$Total=self::execute_single_query("SELECT * FROM proyectos where idmateria=$materia and codigo='$codigo' ");
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Fecha de Envio</th>
                        <th class="text-center">Nombre del Proyeco</th>
						<th class="text-center">Estado del Proyecto</th>
					</tr>
				</thead>
				<tbody>
			';

			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
                    if($rows['estado']=1){
                        $estado="Enviado";
                    }else{
						$estado="No Enviado";
					}
					$table.='
					<tr>
						<td>'.$nt.'</td>
						<td>'.$rows['fechaenvio'].'</td>
						<td>'.$rows['nombreproyecto'].'</td>
                        <td>'.$estado.'</td>
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
					$table.='<li><a href="'.SERVERURL.'claseacademico/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'claseacademico/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'claseacademico/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'claseacademico/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}

			return $table;
		}

		

	}