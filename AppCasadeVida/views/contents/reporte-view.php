<?php if($_SESSION['userType']=="Administrador"): ?>
<?php ob_start();?>
<?php include "./controllers/materiaController.php" ?>
<?php include "./views/inc/scripts.php" ?>
<script type="text/javascript">
$(document).ready(function(){
	var1 = $('#name').val(); //guardamos que tecleaste en el input de usuario
	var2 = $('#materia').val(); //lo mismo que el anterior
	$('#genReporte').click(function(){//en el evento click del boton lo enviamos al servidor para la peticion ajax
		$.ajax({
			url: 'excel-view.php',
			type: 'POST',
			data: {var1, var2}, //son las variables que guardamos
			beforeSend:function(){
				console.log("Se esta procesando tu peticion");
			}
		})
		.done(function(data) {
			console.log(data);						
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

})
</script>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-tv-list zmdi-hc-fw"></i> Asistencia <small>(Listado)</small></h1>
	</div>
	<p class="lead">
		En esta sección puede ver el listado de la asistencia de los estudiantes por cada asignatura o materia, puede Exportar los datos en formato Excel o Pdf cuando lo desee.
	</p>
</div>
<?php
	  $dateNow=date('Y-m-d\TH:i:s');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Lista de Asistencia </h3>
				</div>
			  	<div class="panel-body">
				    <form id="formExcel" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-format-list-bulleted"></i> Formato de Reporte </legend><br>
				    		<div class="container-fluid">
				    			<div class="row">  
	                                <div class="col-xs-12 col-sm-6">
	                                 <div class="form-group label-floating">
						                    <span for="name" class="control-label">Nombre del archivo *</span>
						                    <input class="form-control" type="text" name="name" id="name" placeholder="Nombre del archivo" required="">
                                     </div>
				    				</div> 
                                     <div class="col-xs-12 col-sm-6">
	                                 <div class="form-group label-floating">
						                    <span for="format" class="">Formato *</span>
						                    <select class="form-control" name="format" id="format" class="formato" required="">
						                        <option value="ninguno" selected>Seleccione un formato</option>
						                        <option value="xlsx">EXCEL</option>
						                        <option value="pdf">PDF</option>
						                    </select>
                                      </div>
				    				</div> 
						             <div class="col-xs-12 col-sm-6">
	                                 <div class="form-group label-floating">
                                            <span class="control-label">Materia *</span>
										  	<select name="materia" class="form-control" id="materia" required="">
										  		<?php 
										  			if(isset($_POST['materia'])){ 
										  				echo '<option value="'.$_POST['materia'].'">'.$_POST['materia'].' Actual</option>'; 
										  			} 
										  		?>
										  		<option value="">   </option>	
										  		<?php foreach($datosMateria as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idmateria']?>"><?php echo $opciones['materia']?></option>
										  		<?php endforeach ?> 									  	    
									        </select>
						            </div>
									</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										</div>
				    				</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Fecha Desde *</span>
										  	<input class="form-control" type="datetime-local" value="<?php echo $dateNow ?>" name="fechadesde" id="fechadesde" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Fecha Hasta *</span>
										  	<input class="form-control" type="datetime-local" value="<?php echo $dateNow ?>" name="fechahasta" id="fechahasta" required="" maxlength="30">
										</div>
				    				</div>		  				
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br><br>
					     <p class="text-center">
							<a href="<?php echo SERVERURL; ?>excel/" class="btn btn-info btn-raised zmdi zmdi-download" name="genReporte" id="genReporte"> Descargar</a> 
					    </p>
				    </form>
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
