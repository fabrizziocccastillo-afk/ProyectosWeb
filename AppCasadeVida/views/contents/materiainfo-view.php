<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Datos de Materia</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización de Materias. Usted podrá actualizar la información cuando se lo requiera.
	</p>
</div>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>materialist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<?php 
	require_once "./controllers/materiamaestroController.php";

    $materiains = new materiamaestroController();
   // $UsuarioActualiza = $_SESSION['userName'];

	if(isset($_POST['code'])){
		echo $materiains->update_materiamaestro_controller();
		echo $materiains->foto_materiamaestro2_controller($_POST['code']);
		echo "<script type='text/javascript'>window.location='SERVERURL/materiainfo/';<script>";
	}
    $code=explode("/", $_GET['views']);
    
	$data=$materiains->data_materiamaestro_actualiza_adm_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Detalle</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-book"></i> Datos Materia</legend><br>
				    		<input type="hidden" name="code" value="<?php echo $rows['idmateria']; ?>">
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
										   <div class="card-columns">
										   <div class="card">  
										   <img src="/CASADEVIDA/Backend/imagenes/<?php echo $rows['fotomaestro']; ?>" height="150" class="card-img-top"> 
										   </div>
										   </div> 
									</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Materia *</label>
										  	<input class="form-control" type="text" name="materia" value="<?php echo $rows['materia']; ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Tutor *</label>
										  	<input class="form-control" type="text" name="tutor" value="<?php echo $rows['Tutor']; ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Email *</label>
										  	<input class="form-control" type="email" name="correo" value="<?php echo $rows['correo']; ?>" required="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Ciclo *</label>
										  	<input class="form-control" type="number" name="ciclo" value="<?php echo $rows['ciclo']; ?>" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Nota Mínima Aprueba *</span>
										  	<input class="form-control" type="number" name="notminaprueba" id="notminaprueba" value="<?php echo $rows['notminaprueba']; ?>" min="0" max="100" required="">
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