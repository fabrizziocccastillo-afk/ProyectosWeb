<?php 
	require_once "./controllers/bibliotecaController.php";
	//require_once "./controllers/commentController.php";

	$insBiblioteca = new bibliotecaController();
	//$insComment = new commentController();

	$dateNow=date("Y-m-d");
	$urls=SERVERURL.$_GET['views'];



	$code=explode("/", $_GET['views']);

	$data=$insBiblioteca->data_biblioteca_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-videocam zmdi-hc-fw"></i> <small><?php echo $rows['Titulo']; ?></small></h1>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<p class="text-mutted"><i class="zmdi zmdi-star-circle"></i> TÍTULO O TEMA: <strong><?php echo $rows['Titulo']; ?></strong></p>
            <p class="text-mutted"><i class="zmdi zmdi-acount"></i> AUTOR: <strong><?php echo $rows['Autor']; ?></strong></p>
			<p class="text-mutted"><i class="zmdi zmdi-face"></i> TUTOR O DOCENTE: <strong><?php echo $rows['Tutor']; ?></strong></p>
			<div class="full-box thumbnail" style="padding: 10px;">
				<h3 class="text-titles text-center"><i class="zmdi zmdi-info"></i> Información Adjuntos</h3>
				<?php 
					//echo $rows['Descripcion'];
					if($rows['Adjuntos']!=""):
				?>
				<br>
				<h4 class="text-titles text-center"><i class="zmdi zmdi-cloud-download"></i> Archivos para descargar</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Archivo</th>
							<th>Descargar</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$attachment=explode(",", $rows['Adjuntos']);
							foreach ($attachment as $files):
								echo '
								<tr>
									<td>'.$files.'</td>
									<td>
										<a href="'.SERVERURL.'attachments/class/'.$files.'" download="'.$files.'" class="btn btn-primary"><i class="zmdi zmdi-download"></i></a>
									</td>
								</tr>
								';
							endforeach;
						?>
					</tbody>
				</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-videocam zmdi-hc-fw"></i> Libro</h1>
	</div>
</div>
<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>
<?php endif; ?>