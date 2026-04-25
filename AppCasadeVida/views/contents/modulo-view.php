<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/materiaController.php" ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-folder-person zmdi-hc-fw"></i> Modulo <small>(Registro)</small></h1>
	</div>
	<p class="lead">
		
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>modulo/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
		  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>modulolist/" class="btn btn-success">
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
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nuevo Modulo</h3>
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
										  	<input class="form-control" type="text" name="modulo" required="">
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
                                    <span class="control-label">Nombre Corto *</span>
                                    <input class="form-control" type="text" name="modulocorto" required="">
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
