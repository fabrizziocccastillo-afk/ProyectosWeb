<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-view-agenda zmdi-hc-fw"></i> Agenda <small>(Listado)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todos las Agendas registrados en el sistema, puede actualizar datos o eliminar un Agenda cuando lo desee.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>agenda/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
		  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>agendalist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/agendaController.php";

	$insAgenda = new agendaController();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Agenda</h3>
			  	</div>
			  	<div class="panel-body">
					<div class="table-responsive">
						<?php
							$page=explode("/", $_GET['views']);
							echo $insAgenda->pagination_agenda_controller($page[1],10);
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
