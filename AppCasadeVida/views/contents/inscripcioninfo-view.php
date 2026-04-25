<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/paisController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-settings zmdi-hc-fw"></i> Datos del estudiante</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización de los datos de los estudiantes. Acá podrá actualizar la información personal de los estudiantes registrados en el sistema.
	</p>
</div>
<?php 
	require_once "./controllers/inscripcionController.php";

	$InscripcionIns = new inscripcionController();
	$dateNow=date("Y-m-d H:i:s"); 

	if(isset($_POST['codigo']) && isset($_POST['materia'])){
		echo $InscripcionIns->update_inscripcion_controller($dateNow);
    }

	$code=explode("/", $_GET['views']);
	// echo $code[2];
	$data=$InscripcionIns->data_inscripcion_controller("Only",$code[1],$code[2]);
 
		if($data->rowCount()>0):
			$rows=$data->fetch();
?>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>inscripcionlist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Actualizar datos</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> Datos de Inscripcion</legend><br>
				    		<input type="hidden" name="code" value="<?php echo $rows['Codigo']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
				    			 <div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Estudiante</label>
										  	<select name="codigo" class="form-control" id="codigo" >
										    <option value="<?php echo $rows['Codigo']; ?>"><?php echo $rows['Nombres']." ".$rows['Apellidos']; ?></option>			  		
										  	    <?php foreach($datosAlumnonew as $opciones): ?>            
										  		  <option value="<?php echo $opciones['Codigo']?>"><?php echo $opciones['Nombres']." ".$opciones['Apellidos'];?></option>
										  		  <?php endforeach ?>  						          	
									        </select>
										</div>
				    				</div>	   											    				
				    				<div id="materia" class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Materia *</label>
										  	<select name="materia" class="form-control">
										  		<option value="<?php echo $rows['idmateria']; ?>"><?php echo $rows['materia']; ?></option>	
										  		<?php foreach($datosMateria as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idmateria']?>"><?php echo $opciones['materia']?></option>
										  		<?php endforeach ?> 									  	    
									        </select>
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Fecha de Registro *</span>
										  	<input class="form-control" type="date" value="<?php echo $rows['fecha']; ?>" name="fecha" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Calificacion </span>
										  	<input class="form-control" type="number" name="calificacion" min="0" max="100" step="any" value="<?php echo $rows['calificacion']; ?>">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Calificacion Taller o Trabajo </span>
										  	<input class="form-control" type="number" name="calificaciontaller" min="0" max="100" step="any" value="<?php echo $rows['calificaciontaller']; ?>">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Calificacion Autoevaluacion o Actuación </span>
										  	<input class="form-control" type="number" name="calificacionactuacion" min="0" max="100" step="any" value="<?php echo $rows['calificacionactuacion']; ?>">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
									<div class="form-group" >
										<label for="comentario">Comentario</label>
										<textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Escriba un comentario.."><?php echo $rows['comentario']; ?></textarea>
									</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										<input type="hidden" name="aprobado" value="0" readonly>						
										<?php
											    if($rows["aprobado"]==1){ echo '<input type="checkbox" id="aprobo" name="aprobado" value="1" checked readonly>';}else{ echo '<input type="checkbox" id="aprobo" name="aprobado" value="1" readonly>';}
											    
										?>	
										<label for="aprobo">Aprobado</label>
										<input type="hidden" name="notaminima" value="<?php echo $rows['notminaprueba']; ?>">								 
										</div>
				    				</div>					    						    				
				    			</div>
				    		</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar cambios</button>
					    </p>
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>
<?php 
		endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>