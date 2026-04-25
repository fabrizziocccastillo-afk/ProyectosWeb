<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/materiaController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Rol <small>(Registro)</small></h1>
	</div>
	<p class="lead">
		
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>ROL/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
		  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>rollist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 

	$dateNow=date("Y-m-d");
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nuevo Rol</h3>
				</div>
			  	<div class="panel-body">
				    <form  action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset class="full-box">
				    		<!--<legend><i class="zmdi zmdi-videocam"></i> Nuevo Rol</legend>-->
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Nombre *</span>
										  	<input class="form-control" type="text" name="rol" required="">
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
										  <textarea name="descripcion" class="full-box" id="spv-editor"></textarea>
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
