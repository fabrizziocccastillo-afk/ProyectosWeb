<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Rol</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización del Rol. Acá podrá actualizar la información del Rol.
	</p>
</div>
<?php 
	require_once "./controllers/rolController.php";

	$insrol = new rolController();

    if(isset($_POST['idrol']) && isset($_POST['rol'])){
		echo $insrol->update_rol_controller();
	}
    
	$code=explode("/", $_GET['views']);

	$data=$insrol->data_rol_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>rollist/" class="btn btn-info btn-raised btn-sm">
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
				    		<input type="hidden" name="code" value="<?php echo $rows['idrol']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombre *</label>
										  	<input class="form-control" type="text" name="rol" id="rol" value="<?php echo $rows['rol']; ?>" required="" >
											<label style="color:#FF0000" id="salida"></label>
										</div>
				    				</div>
								</div>
				    		</div>
				    	</fieldset>
                        <fieldset class="full-box">
							<legend><i class="zmdi zmdi-account"></i> Descripción e información adicional</legend>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										  <textarea name="descripcion" class="full-box" id="spv-editor"><?php echo $rows['descripcion']; ?></textarea>
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