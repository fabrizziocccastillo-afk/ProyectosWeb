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
	  	<a href="<?php echo SERVERURL; ?>inscripcion/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>inscripcionlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
		  </li>
		  <div class="search-box">
				   <input type="text" class="search-txt" name="caja_busquedaI" id="caja_busquedaI"  placeholder="Search..">
				   <a href="#!" class="search-btn"> 
				   <i class="zmdi zmdi-search"></i>
				   </a> 		                   
		  </div>
	</ul>
</div>
<?php  
	require_once "./controllers/inscripcionController.php";
	$insInscripcion = new inscripcionController();

	if(isset($_POST['inscripcionCode']) && isset($_POST['inscripcionMateria'])){
		
		echo $insInscripcion->delete_inscripcion_controller($_POST['inscripcionCode'],$_POST['inscripcionMateria']);
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
	  		<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Estudiantes</h3>
			  	</div>
			  	<div class="panel-body">
				   <div id="datosI1" class="table-responsive">
					<?php
						$page=explode("/", $_GET['views']); 
					?>
					<input type="hidden" id="pagina2" name="pagina2" value="<?php echo $page[1];?>">
					</div>	
					<div id="datosI" class="table-responsive">
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