<?php if($_SESSION['userType']=="Administrador"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-library zmdi-hc-fw"></i> Libro</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización de los datos de rubricas. Acá podrá actualizar la información del Libro.
	</p>
</div>
<?php 
	require_once "./controllers/rubricaController.php";

	$insrubrica = new rubricaController();

	$urls=SERVERURL.$_GET['views'];
	if(isset($_POST['idAtt']) && isset($_POST['nameAtt'])){
		echo $insrubrica->delete_rubrica_attachment_controller($_POST['idAtt'],$_POST['nameAtt'],$urls);
	}

	$code=explode("/", $_GET['views']);

	$data=$insrubrica->data_rubrica_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>rubricalist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<?php if($rows['imagen']!=""): ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-attachment"></i> Archivos adjuntos asociados</h3>
				</div>
			  	<div class="panel-body">
			    	<fieldset>
			    		<div class="container-fluid">
			    			<div class="row">
			    				<div class="col-xs-12">
									<table class="table table-striped table-hover ">
										<thead>
											<tr>
												<th>Adjunto</th>
												<th>Eliminar</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$catt=1;
												$attacments=explode(",", $rows['imagen']);
												foreach($attacments as $att): 
											?>
											<tr>
												<td><?php echo $att; ?></td>
												<td>
													<button type="button" class="btn btn-danger btn-raised btn-xs btnFormsAjax" data-action="delatt" data-id="delete-att-<?php $catt; ?>">
														<i class="zmdi zmdi-delete"></i>
													</button>
													<form action="" method="POST" enctype="multipart/form-data" autocomplete="off" id="delete-att-<?php $catt; ?>">
			    										<input type="hidden" name="idAtt" value="<?php echo $rows['idrubrica']; ?>">
			    										<input type="hidden" name="nameAtt" value="<?php echo $att; ?>">
													</form>
												</td>
											</tr>
											<?php 
													$catt++;
												endforeach; 
											?>
										</tbody>
									</table>
			    				</div>
			    			</div>
			    		</div>
			    	</fieldset>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Actualizar datos</h3>
				</div>
			  	<div class="panel-body">
				    <form action="<?php echo SERVERURL; ?>ajax/ajaxRubrica.php" method="POST" enctype="multipart/form-data" autocomplete="off" data-form="UpdateVideo" class="ajaxDataForm">
				    	<input type="hidden" name="upid" value="<?php echo $rows['idrubrica']; ?>">
				    	<fieldset class="full-box">
				    		<legend><i class="zmdi zmdi-videocam"></i> Datos del Libro</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<span class="control-label">Título *</span>
										  	<input class="form-control" type="text" name="title" value="<?php echo $rows['titulo']; ?>" required="">
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<fieldset class="full-box">
							<legend><i class="zmdi zmdi-attachment"></i> Agregar más archivos adjuntos</legend>
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
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar cambios</button>
					    </p>
					    <div class="full-box form-process"></div>
				    </form>
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
	<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>
<?php
		endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>