<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-accounts-alt zmdi-hc-fw"></i> Roles <small>(Listado)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todas los Roles Creados en el sistema, puede Asignar permisos , actualizar datos o eliminar un Rol cuando lo desee.
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
	require_once "./controllers/rolController.php";

	$insRol = new rolController();

	if(isset($_POST['rolCode'])){

		echo $insrol->delete_rol_controller($_POST['rolCode']);

	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Roles</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
						<?php
							$page=explode("/", $_GET['views']);
							//echo $page[1];
							echo $insRol->pagination_rol_controller($page[1],10);
						?>
					</div>
			  	</div>
			</div>
		</div>
	</div>
</div>
<br><br>
<?php 
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>
