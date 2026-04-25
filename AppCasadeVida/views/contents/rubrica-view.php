<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-library zmdi-hc-fw"></i> Rubrica <small>(Registro)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de Rubrica, aquí podrás registrar una nueva Rubrica (Los campos marcados con * son obligatorios para registrar una nueva Rubrica).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
		  	<a href="<?php echo SERVERURL; ?>rubrica/" class="btn btn-info">
		  		<i class="zmdi zmdi-plus"></i> Nueva
		  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>rubricalist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 

	$dateNow=date("Y-m-d");
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nueva Rubrica</h3>
				</div>
			  	<div class="panel-body">
				    <form action="<?php echo SERVERURL; ?>ajax/ajaxRubrica.php" method="POST" enctype="multipart/form-data" autocomplete="off" data-form="AddVideo" class="ajaxDataForm">
				    	<fieldset class="full-box">
				    		<legend><i class="zmdi zmdi-library"></i> Datos de Rubrica</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Titulo *</span>
										  	<input class="form-control" type="text" name="titulo" required="">
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<fieldset class="full-box">
							<legend><i class="zmdi zmdi-attachment"></i> Archivos adjuntos</legend>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
				    					<div class="form-group">
											<input type="file" name="attachments[]" multiple="" accept=".jpg, .png, .jpeg, .pdf, .ppt, .pptx, .doc, .docx">
											<div class="input-group">
												<input type="text" readonly="" class="form-control" placeholder="Elija los archivos adjuntos...">
												<span class="input-group-btn input-group-sm">
													<button type="button" class="btn btn-fab btn-fab-mini">
														<i class="zmdi zmdi-attachment-alt"></i>
													</button>
												</span>
											</div>
											<span><small>Tamaño máximo de los archivos adjuntos 5MB. Tipos de archivos permitidos imágenes PNG y JPG, documentos PDF, WORD y POWERPOINT</small></span>
										</div>
				    				</div>
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
					    <div class="full-box form-process"></div>
				    </form>
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
