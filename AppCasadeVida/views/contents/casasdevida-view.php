<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/paisController.php" ?>
<!--Script para la peticion de datos Miguel-->
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-home zmdi-hc-fw"></i> Casas de Vida <small>(Casas)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de casas de vida, aquí podrás registrar nuevas casas (Los campos marcados con * son obligatorios para registrar una casa de vida).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>casasdevida/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>casasdevidalist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/casasdevidaController.php";

	$insCasadevida = new casasdevidaController();
	if(isset($_POST['casa'])){
		echo $insCasadevida->add_casasdevida_controller();
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nueva Casa de Vida</h3>
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
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="casa" value="<?php if(isset($_POST['casa'])){ echo $_POST['casa']; } ?>" required="" maxlength="200">
										</div>
				    				</div>		    							    								    							
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Sector *</label>
										  	<select name="torre" class="form-control">
										  		<?php 
										  			/*if(isset($_POST['torre'])){ 
										  				echo '<option value="'.$_POST['torre'].'">'.$_POST['torre'].' Actual</option>'; 
										  			} */
										  		?>
										  		<option value="">   </option>	
										  		<?php foreach($datosTorre as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idtorre']?>"><?php echo $opciones['torre']?></option>
										  		<?php endforeach ?> 									  	    
									        </select>
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
