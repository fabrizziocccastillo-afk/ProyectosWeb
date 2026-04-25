<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/materiaController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios <small>(Administradores)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de Evaluaciones, aquí podrás crear preguntas y respuestas para el examen de los estudiantes por materia (Los campos marcados con * son obligatorios para la evaluacion).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>evaluacion/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>evaluacionlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php
	$dateNow=date('Y-m-d');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nueva Evaluacion</h3>
				</div>
			  	<div class="panel-body">
				    <form method="POST" enctype="multipart/form-data" autocomplete="off" id="form_evaluacion">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-format-list-bulleted"></i> Formulario de Evaluacion</legend><br>
				    		<div class="container-fluid">
				    			<div class="row">									    				
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Materia *</span>
										  	<select name="materia" class="form-control" id="materia" required="">
										  		<?php 
										  			if(isset($_POST['materia'])){ 
										  				echo '<option value="'.$_POST['materia'].'">'.$_POST['materia'].' Actual</option>'; 
										  			} 
										  		?>
										  		<option value="">   </option>	
										  		<?php foreach($datosMateria as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idmateria']?>"><?php echo $opciones['materia']?></option>
										  		<?php endforeach ?> 									  	    
									        </select>
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Tutor *</span>
										  	<input class="form-control" type="text" name="tutor" id="tutor" value="<?php if(isset($_POST['tutor'])){ echo $_POST['tutor']; } ?>" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Titulo *</span>
										  	<input class="form-control" type="text" name="titulo" id="titulo" value="<?php if(isset($_POST['titulo'])){ echo $_POST['titulo']; } ?>" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Nota Mínima Aprueba *</span>
										  	<input class="form-control" type="number" name="notamin" id="notamin" value="0" min="0" max="100" required="">
										</div>
				    				</div>
									<fieldset class="full-box">
									<div class="container-fluid">
										<div class="row">
										<legend><i class="zmdi zmdi-comment-list"></i> Descripción e información adicional</legend>
											<div class="col-xs-12">
												<textarea name="descripcion" class="full-box" id="spv-editor"></textarea>
											</div>
										</div>
									</div>
								    </fieldset>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Fecha Inicio *</span>
										  	<input class="form-control" type="date" value="<?php echo $dateNow; ?>" name="fecha_inicio" id="fecha_inicio" required="" maxlength="30">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Fecha Final *</span>
										  	<input class="form-control" type="date" value="<?php echo $dateNow; ?>" name="fecha_final" id="fecha_final" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-4">
										<div class="form-group label-floating">
										  	<span class="control-label">Tiempo *</span><br></br>
										  	Horas:<input class="form-control" type="number" name="h" id="h" value="0" min="0" max="60" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-4">
										<div class="form-group label-floating">
										  	<span class="control-label"></span><br></br>
											Minutos:<input class="form-control" type="number" name="m" id="m" value="0" min="0" max="60" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-4">
										<div class="form-group label-floating">
										  	<span class="control-label"></span><br></br>
											Segundos:<input class="form-control" type="number" name="s" id="s" value="0" min="0" max="60" required="">
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br><br>
						<fieldset>
						<legend><i class="zmdi"></i>Preguntas </legend><br>
				    		<div class="container">	
				    		  <div class="row col-xs-12">
								<div class="form-group">
										<div class="table-responsive">
										    <table class="table table-bordered table_list" id="dynamic_field">
												<tr>
													<td colspan="2"><button type="button" name="add" id="add" class="btn btn-primary zmdi zmdi-plus">Pregunta </button></td>
													<td colspan="2"><button type="button" name="add2" id="add2" class="btn btn-success zmdi zmdi-plus">Opciones </button></td>
												</tr>
											</table>
										</div>
								</div>
							  </div>	
							</div>
						</div>	
						</fieldset>	
					    <p class="text-center">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php 
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>

