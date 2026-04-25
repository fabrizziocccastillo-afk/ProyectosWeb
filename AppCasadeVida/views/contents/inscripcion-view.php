<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/materiaController.php" ?>
<?php include "./controllers/alumnonewController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios <small>(Administradores)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de Inscripciones, aquí podrás matricular estudiantes en las materias o modulos asignados (Los campos marcados con * son obligatorios para inscribir un estudiante).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>inscripcion/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>inscripcionlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/inscripcionController.php";
	$insInscripcion = new inscripcionController();
	if(isset($_POST['codigo'])){
	echo $insInscripcion->add_Inscripcion_controller();}
?>
<?php
	$dateNow=date('Y-m-d\TH:i:s');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nueva Inscripcion</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> Datos de la Inscripcion</legend><br>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Estudiante *</label>
										  	<select name="codigo" class="form-control" id="codigo" required="">
										  	<?php 
										  			if(isset($_POST['codigo'])){ 
										  				echo '<option value="'.$_POST['codigo'].'">'.$_POST['codigo'].' Actual</option>'; 
										  			} 
										  	?>
										  	<option value="">   </option>				  		
										  	    <?php foreach($datosAlumnonew as $opciones): ?>            
										  		  <option value="<?php echo $opciones['Codigo']?>"><?php echo $opciones['Nombres']." ".$opciones['Apellidos']?></option>
										  		  <?php endforeach ?> 						          	
									        </select>
										</div>
				    				</div>	   											    				
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Materia *</label>
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
										  	<span class="control-label">Fecha de Registro *</span>
										  	<input class="form-control" type="datetime-local" value="<?php echo $dateNow; ?>" name="fecha" id="fecha" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label"></span>
										  	<input class="form-control" type="hidden" name="calificacion" id="calificacion" min="0" max="100" step="any" value="0" required="">
										</div>
				    				</div>
				    				<div id="aprobado" class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										    <input type="hidden" name="aprobado" value="0">					
										  	<!--<input type="hidden" id="aprobo" name="aprobado" value="1">-->
										  	<span for="aprobo"> </span>						 
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br><br>
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

