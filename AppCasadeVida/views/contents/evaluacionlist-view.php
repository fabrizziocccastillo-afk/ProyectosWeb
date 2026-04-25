<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios <small>(Administradores)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todos los estudiantes Inscritos en las materias o modulos en el sistema, puede actualizar datos o eliminar un estudiante cuando lo desee.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>evaluacion/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>evaluacionlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php  
	require_once "./controllers/evaluacionController.php";
	$insEvaluacion = new evaluacionController();

	if(isset($_POST['evaluacionCode']) && isset($_POST['evaluacionMateria'])){
		
		echo $insEvaluacion->delete_evaluacion_controller($_POST['evaluacionCode'],$_POST['evaluacionMateria']);
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
	  		<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Evaluaciones</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
						<?php
							$page=explode("/", $_GET['views']);
							echo $insEvaluacion->pagination_evaluacion_controller($page[1],10);
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