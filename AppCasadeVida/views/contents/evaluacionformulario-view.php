<?php if($_SESSION['userType']=="Estudiante"): ?>
<?php require_once "./controllers/evaluacionformController.php"; ?> 	
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios <small>(Estudiantes)</small></h1>
	</div>
	<p class="lead">
		Bienvenido al Formulario de Evaluaciones, Haga Clic en el Boton Empezar, lea cuidadosamente las preguntas y seleccione la respuesta Correcta.
	</p>
</div>
<?php 
	require_once "./controllers/evaluacionformController.php";
	$EvaluacionIns = new evaluacionformController();
	$UsuarioExamen = $_SESSION['userName'];
	$dateNow=date("Y-m-d");
	$dateFin=date("Y-m-d\TH:i:s");
	$code=explode("/", $_GET['views']);
	$data=$EvaluacionIns->data_evaluacionform_Controller($UsuarioExamen,$code[1]);
		if($data->rowCount()>0):
		  $rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i><?php echo $rows['titulo']; ?></h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off" id="form_resultado">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-format-list-bulleted"></i> Formulario de Evaluación</legend><br>
				    		<div class="container-fluid">
				    			<div class="row">				    				
									<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Tutor: </label>
										  	<strong><?php echo $rows['tutor']; ?></strong>
										</div>
				    				</div>
									<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Descripción </label>
											<strong><?php echo $rows['descripcion']; ?></strong>
										</div>
				    				</div>
				    				<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Fecha Exámen: </label>
											<strong><?php echo $dateNow; ?></strong>
										</div>
				    				</div>
									<div class="col-xs-12">
										<div class="form-group">
										    <input type="hidden" name="usuario_ev" value="<?php echo $rows['Usuario']; ?>">
											<input type="hidden" name="codigo_ev" value="<?php echo $rows['Codigo']; ?>">
											<input type="hidden" name="fechainicioExamen" id="fechainicioExamen" value="">									
											<input type="hidden" name="fechafinExamen" id="fechafinExamen" value="<?php echo $dateFin ?>">	
											<input type="hidden" name="idevaluacion" value="<?php echo $rows['idevaluacion']; ?>"> 
											<input type="hidden" name="materia" value="<?php echo $rows['idmateria']; ?>">
											<input type="hidden" name="notamin" value="<?php echo $rows['notamin']; ?>">		
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
						<fieldset>
						<div class="container-fluid">
							<div class="text-center">
							<br/>
							<h2>Tiempo<h2>
							<div class="jumbotron col-md-4 col-md-offset-4">
								<h1 id="Tiempo">00:00:00</h1>
							</div>
							<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<div class="col-md-4">
								<label class="control-label">Horas </label>
									<input class="form-control text-center" type="number" name="hora" id="hora" value="<?php echo $rows['hora']; ?>" min="60" max="60" readonly > 
								</div>
								<div class="col-md-4">
								<label class="control-label">Minutos </label>
									<input class="form-control text-center" type="number" name="minuto" id="minuto" value="<?php echo $rows['minuto']; ?>" min="60" max="60" readonly> 
								</div>
								<div class="col-md-4">
								<label class="control-label">Segundos </label>
									<input class="form-control text-center" type="number" name="segundo" id="segundo" value="<?php echo $rows['segundo']; ?>" min="60" max="60" readonly> 
								</div>
								<div class="col-md-12">
								<br/>
									<button type="button" onclick="Empezar()" class="btn btn-success btn-raised btn-lg btn-block" id="empezar">Empezar</button>
								</div>
							</div>
							</div> 
						</div>
					</fieldset>
						<fieldset>
				    		<div class="container" style="display:none;" id="p">
							<legend><i class="zmdi"></i> Preguntas </legend></br>
				    		  <div class="row col-xs-12">
								<div class="form-group">
										<div class="table-responsive">
										    <table class="table table-primary" id="dynamic_field">
											<?php 
											       $PreguntasIns = new evaluacionformController();
													$UsuarioExamenT = $_SESSION['userName'];
													$dataP=$PreguntasIns->data_preguntasform_Controller($UsuarioExamenT,$code[1]);
													$dataR=$PreguntasIns->data_respuestasform_Controller($UsuarioExamenT,$code[1]);
														if($dataP->rowCount()>0 && $dataR->rowCount()>0):
														$rowsP=$dataP->fetchAll();
														$rowsR=$dataR->fetchAll();
														foreach($rowsP as $valor1):?>            				  		  										  		 	
												<tr>
                                                     <td><?php echo $valor1['pregunta'] ?> * <input type="hidden" name="idpreguntas[]" value="<?php echo $valor1['idpreguntas'] ?>"></td>
													 <td><?php echo $valor1['puntos']?><?php if($valor1['puntos']>1){ echo "Puntos";}else{ echo "Punto";}?></td>
												</tr>
												<?php   foreach($rowsR as $valor2):
												        $idPreguntas1=$valor1['idpreguntas']; 
														$idPreguntas=$valor2['idpreguntas'];
														$idrespuesta=$valor2['idrespuesta'];
														$respuestas=$valor2['respuesta'];
														if($idPreguntas1==$idPreguntas){
														echo '<tr><td colspan="2"><input type="radio" name="opcion_'.$idPreguntas.'[]" value="'.$idrespuesta.'">  '.$respuestas.'</td><input type="hidden" name="idrespuesta[]" value="'.$idrespuesta.'"></tr>';
													    }
												?>
											<?php      endforeach;
											           endforeach;
													   endif;?> 
											</table>
											<!--<?php //include "./views/inc/scripts.php" ?>-->
										</div>
								</div>
							  </div>	
							</div>
						</div>	
						</fieldset>	
					    <p class="text-center" style="display:none;" id="b">
					    	<button id="envia" name="envia" type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Eviar</button>
					    </p>
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php else: 
?>
	<p class="lead text-center">No hay evaluaciones pendientes por realizar</p>
<?php 
    endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>

