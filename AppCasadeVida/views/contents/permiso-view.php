<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/rolController.php" ?>
<?php include "./controllers/moduloController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-key zmdi-hc-fw"></i> Permiso <small>(Registro)</small></h1>
	</div>
	<p class="lead">
		
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>permiso/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
		  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>permisolist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
    $datosRol = new rolController();
	$datosModulo = new moduloController();
	$datosRol = $datosRol ->data_rol_controller('Count','');
	$datosModulo = $datosModulo ->data_modulo_controller('Count',''); 
	$dateNow=date("Y-m-d");
	
?>
<?php 
	require_once "./controllers/permisoController.php";
	$insPermiso = new permisoController();
	if(isset($_POST['rol'])){
	echo $insPermiso->add_permiso_controller();}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nuevo Permiso</h3>
				</div>
			  	<div class="panel-body">
				    <form  action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset class="full-box">
				    		<!--<legend><i class="zmdi zmdi-videocam"></i> Nuevo Rol</legend>-->
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Rol *</span>
										  	<select name="rol" class="form-control" id="rol" required="">
										  	<option value="">   </option>				  		
										  	    <?php foreach($datosRol as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idrol']?>"><?php echo $opciones['rol']?></option>
										  		<?php endforeach ?> 						          	
									        </select>
										</div>
				    				</div>	
												
				    			</div>
				    		</div>
				    	</fieldset>
				    	<fieldset class="full-box">
							<!--<legend><i class="zmdi zmdi-comment-video"></i> Descripción e información adicional</legend>-->
							<div class="container-fluid">
								<div class="row">
								<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Modulo *</span>
										  	<select name="modulo" class="form-control" id="modulo" required="">
										  	<option value="">   </option>				  		
										  	    <?php foreach($datosModulo as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idmodulo']?>"><?php echo $opciones['modulo']?></option>
										  		<?php endforeach ?> 						          	
									        </select>
										</div>
				    				</div>		
								</div>
							</div>
				    	</fieldset>
						<fieldset class="full-box">
							<!--<legend><i class="zmdi zmdi-comment-video"></i> Descripción e información adicional</legend>-->
							<div class="container-fluid">
								<div class="row">
								<div class="col-xs-12 col-sm-6">
								        <div class="form-group label-floating">
										    <input type="hidden" name="ver" value="0">					
										  	<input type="checkbox" id="ver" name="ver" value="1">
										  	<label for="visto">Ver</label>
										</div>
								    	<div class="form-group label-floating">
										    <input type="hidden" name="crear" value="0">					
										  	<input type="checkbox" id="crear" name="crear" value="1">
										  	<label for="creado">Crear</label>
										</div>
										<div class="form-group label-floating">
										    <input type="hidden" name="consultar" value="0">					
										  	<input type="checkbox" id="consultar" name="consultar" value="1">
										  	<label for="consultado">Consultar</label>
										</div>
										<div class="form-group label-floating">
										    <input type="hidden" name="modificar" value="0">					
										  	<input type="checkbox" id="modificar" name="modificar" value="1">
										  	<label for="modificado">Modificar</label>
										</div>
										<div class="form-group label-floating">
										    <input type="hidden" name="eliminar" value="0">					
										  	<input type="checkbox" id="eliminar" name="eliminar" value="1">
										  	<label for="eliminado">Eliminar</label>
										</div>
				    				</div>		
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
					    <div class="full-box form-process"></div>
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
