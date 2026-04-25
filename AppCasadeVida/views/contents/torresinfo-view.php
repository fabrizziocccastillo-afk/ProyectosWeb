<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/paisController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-home zmdi-hc-fw"></i> Sectores</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización de Sectores. Acá podrá actualizar la información de Sector.
	</p>
</div>
<?php 
	require_once "./controllers/torreController.php";

	$instorre = new torreController();

    if(isset($_POST['code']) && isset($_POST['torre'])){
		echo $instorre->update_torre_controller();
	}
    
	$code=explode("/", $_GET['views']);

	$data=$instorre->data_torre_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>torreslist/" class="btn btn-info btn-raised btn-sm">
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
				    		<input type="hidden" name="code" value="<?php echo $rows['idtorre']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombre *</label>
										  	<input class="form-control" type="text" name="torre" id="torre" value="<?php echo $rows['torre']; ?>" required="" >
											<label style="color:#FF0000" id="salida"></label>
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