<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Materias <small>(Lista)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todas las materias registradas en el sistema, puede actualizar datos o eliminar una Materia cuando lo desee.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>materia/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a id="lista" href="<?php echo SERVERURL; ?>materialist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
		  </li>
	</ul>
</div>
<?php  
	require_once "./controllers/materiamaestroController.php";
	$insMateria = new materiamaestroController();

	if(isset($_POST['materiaCode'])){
		echo $insMateria->delete_materiamaestro_controller($_POST['materiaCode']);
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
						echo $insMateria->pagination_materiamaestro_controller($page[1],10);
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