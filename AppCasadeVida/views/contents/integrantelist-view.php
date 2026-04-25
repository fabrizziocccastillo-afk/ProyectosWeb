<?php if($_SESSION['userType']=="UsuarioCDV"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Integrantes <small>(CDV)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todos los Integrantes de su Casa de Vida registrados en el sistema, puede actualizar datos o eliminar un integrante cuando lo desee.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>integrante/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a id="lista" href="<?php echo SERVERURL; ?>integrantelist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
		</li>
		<div class="search-box">
				   <input type="text" class="search-txt" name="caja_busquedaIntegrante" id="caja_busquedaIntegrante"  placeholder="Search..">
				   <a href="#!" class="search-btn"> 
				   <i class="zmdi zmdi-search"></i>
				   </a> 		                   
		</div>
	</ul>
</div>
<br>
<?php  
	require_once "./controllers/integranteController.php";
	$insIntegrante = new integranteController();
	$Inactivo=0;

	$page=explode("/", $_GET['views']);

	/*var_dump(isset($page['2']));

	var_dump(isset($page['1']));

	var_dump(array_key_exists('2', $page));
	var_dump(array_key_exists('1', $page));

	var_export($page);*/

	if(isset($page[2]) and $page[2]!=''){
		$Inactivo=1;
		echo $insIntegrante->delete_integrante_controller($page[2]);
	 }
   if($Inactivo){
	echo "<script type='text/javascript'>window.setTimeout(function(){window.location='".SERVERURL."/integrantelist/'}, 2000)</script>";
	}
	 
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
	  		<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Integrantes</h3>
			  	</div>
                <div class="panel-body">
					<div class="table-responsive">
					<?php
						$page=explode("/", $_GET['views']);
						$user=$_SESSION['userName'];
					?>
					<input type="hidden" id="paginaIntegrante" name="paginaIntegrante" value="<?php	echo $page[1];?>">
					<input type="hidden" id="usuarioInt" name="usuarioInt" value="<?php	echo $user;?>">
					</div>
					<div id="datosIntegrante" class="table-responsive">
						
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