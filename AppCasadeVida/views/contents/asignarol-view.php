<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios Por Rol<small>(CDV)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todos los usuarios registrados en el sistema asignados a su rol, puede editar sus accesos.
	</p>
</div>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>rollist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<?php  
	require_once "./controllers/rolController.php";
	$AsignaRol = new rolController();

    $rol=explode("/", $_GET['views']);

		$dato=$AsignaRol->data_rol_controller("Only",$rol[2]);

    if($dato->rowCount()>0):
        $rows=$dato->fetch();
        
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
	  		<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Roles Por Usuario</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
					<?php
						$page=explode("/", $_GET['views']);
						$UserRol=$rows['idrol'];
						echo $AsignaRol->pagination_asignarol_controller($page[1],150,$UserRol);
					?>
					</div>					
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