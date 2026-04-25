<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book-image zmdi-hc-fw"></i> Materia <small>(Estudiantes)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de creacion de la Materia, aquí podrás registrar nuevas materias (Los campos marcados con * son obligatorios para registrar una materia).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>materia/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>materialist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/materiamaestroController.php";

	$insMateria = new materiamaestroController();
	if(isset($_POST['materia']) && isset($_POST['tutor'])){
		echo $insMateria->add_materiamaestro_controller();
		//echo $studentIns->foto_materiamaestro_controller();
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Detalle</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-book"></i> Datos Materia</legend><br>
				    		<div class="container-fluid">
				    			<div class="row">
                                  <div class="col-xs-12 col-sm-6">
										<div>
										<h1 class="text-primary">Subir Foto</h1>
										</div>
										<div>
											<label for="my-input">Seleccione una Foto</label>
											<input id="my-input" type="file" name="imagen">
										</div>
									</div>
									<div class="col-xs-12 col-sm-1">
										   <!--<div class="card-columns">
										   <div class="card">  -->
										   <img src="/CASADEVIDA/Backend/imagenes/USUARIO2.png" height="150" class="card-img-top"> 
										   <!--</div>
										   </div>-->
									</div>

				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Materia *</label>
										  	<input class="form-control" type="text" name="materia" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Tutor *</label>
										  	<input class="form-control" type="text" name="tutor" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Email</label>
										  	<input class="form-control" type="email" name="correo" >
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Ciclo *</label>
										  	<input class="form-control" type="number" name="ciclo" >
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
