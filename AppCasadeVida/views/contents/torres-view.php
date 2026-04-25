<?php if($_SESSION['userType']=="Administrador"): ?>
<!--Script para la peticion de datos Miguel-->
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-home zmdi-hc-fw"></i> Sector <small>(Registro)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de sector , aquí podrás registrar nuevo sector (Los campos marcados con * son obligatorios para registrar un sector).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>torres/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>torreslist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/torreController.php";

	$insTorre = new torreController();
	if(isset($_POST['torre'])){
		echo $insTorre->add_torre_controller();
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nuevo Sector</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> Datos </legend><br>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombre *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="torre" value="<?php if(isset($_POST['torre'])){ echo $_POST['torre']; } ?>" required="" maxlength="100">
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
