<?php if($_SESSION['userType']=="UsuarioCDV"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Listado de Seguimiento <small>(CDV)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de todos los seguimientos de su Casa de Vida registrados en el sistema, puede solo visualizar los registros.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>seguimientoint/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a id="lista" href="<?php echo SERVERURL; ?>seguimientointlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
		</li>
		<!--<div class="search-box">
				   <input type="text" class="search-txt" name="caja_busquedaIntegrante" id="caja_busquedaIntegrante"  placeholder="Search..">
				   <a href="#!" class="search-btn"> 
				   <i class="zmdi zmdi-search"></i>
				   </a> 		                   
		</div>-->
	</ul>
</div>
<br>
<?php  
	require_once "./controllers/integranteController.php";
	$insIntegrante = new integranteController();

/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/

	if(isset($_POST['seguimientointCode'])){

		echo $insIntegrante->delete_seguimientoint_controller($_POST['seguimientointCode']);
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
	  		<div class="panel panel-success">
			  	<div class="panel-heading">
			    	<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> Lista de Seguimiento</h3>
			  	</div>
                <div class="panel-body">
					<div class="table-responsive">
					<?php
						$page=explode("/", $_GET['views']);
                        echo $insIntegrante->pagination_seguimientoint_controller($page[1],25,'');
						//$user=$_SESSION['userName'];
					?>
                    </div>
					<!--<input type="hidden" id="paginaIntegrante" name="paginaIntegrante" value="<?php	//echo $page[1];?>">
					<input type="hidden" id="usuarioInt" name="usuarioInt" value="<?php	//echo $user;?>">
					</div>
					<div id="datosIntegrante" class="table-responsive">
					

					</div>-->							
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