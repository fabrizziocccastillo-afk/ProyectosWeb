<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios <small>(CDV)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todos los usuarios registrados en el sistema, puede actualizar datos o eliminar un Usuario cuando lo desee.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>usuario/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a id="lista" href="<?php echo SERVERURL; ?>usuariolist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
		  </li>
	</ul>
</div>
<?php  
	require_once "./controllers/usuarioController.php";
	$insUsuario = new UsuarioController();

	if(isset($_POST['usuarioCode'])){
		echo $insUsuario->delete_usuario_controller($_POST['usuarioCode']);
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
	  		<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Usuarios</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
					<?php
						$page=explode("/", $_GET['views']);
						echo $insUsuario->pagination_usuario_controller($page[1],150,'');
					?>
					</div>					
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