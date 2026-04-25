<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-home zmdi-hc-fw"></i> Casas de Vida <small>(Listado)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todas las casas de vida creadas en el sistema, puede actualizar datos o eliminar una Casa de Vida cuando lo desee.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>casasdevida/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
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

	$insCasas = new casasdevidaController();

	if(isset($_POST['casaCode'])){
		echo $insCasas->delete_casasdevida_controller($_POST['casaCode']);
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Casas de Vida</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
						<?php
							$page=explode("/", $_GET['views']);
							//echo $page[1];
							echo $insCasas->pagination_casasdevida_controller($page[1],100);
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
