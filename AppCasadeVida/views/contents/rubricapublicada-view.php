<?php if($_SESSION['userType']=="Estudiante"): ?>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-library zmdi-hc-fw"></i> Rubrica</h1>
	</div>
	<p class="lead">
		En esta sección podra ver la rubrica academica de todas las actividades.
	</p>
</div>
<!--<p class="text-center">
	<a href="<?php //echo SERVERURL; ?>rubricapublicada/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Editar Perfil
	</a>
</p>-->
<?php 
	require_once "./controllers/rubricaController.php";

    $rubricaIns = new rubricaController();
    //0UsuarioActualiza = $_SESSION['userName'];

	/*if(isset($_POST['code'])){
		echo $rubricaIns->update_student_controller();
		echo $studerubricaInsntIns->foto_student_controller($_POST['code']);
		echo "<script type='text/javascript'>window.location='SERVERURL/studentData/';<script>";
	}*/

	$data=$rubricaIns->data_rubrica_controller("Count",0);
    
	if($data->rowCount()>0):

		//$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Detalle</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<!--<legend><i class="zmdi zmdi-account-box"></i> Detalle</legend><br>-->
                            <?php  foreach($data as $rows):?>
				    		<input type="hidden" name="code" value="<?php echo $rows['idrubrica']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
								<div class="table-responsive">
                                    <div class="col-xs-12">
								    	<div class="form-group label-floating">
										  	<!--<span class="control-label">Titulo </span> -->
                                              
										  	<!--<input class="form-control" type="text" name="titulopublica" value="<?php //echo $rows['titulo'];?>">-->
                                            <h1 style="font-family:Georgia; color: forestgreen;" class="text-titles"><?php echo $rows['titulo']; ?></h1>
										</div>
				    				</div>
									<div class="col-xs-12">
										   <div class="card-columns">
										   <!--<div class="card" style="width: 18rem;"> -->
										   <img src="../attachments/class/<?php echo $rows['imagen']; ?> " height="500" class="card-img-top"> 
										   <!--</div>-->
										   </div> 
									</div>
								</div>			    				
				    			</div>
				    		</div>
                            <?php endforeach;?>
				    	</fieldset>
					   <!-- <p class="text-center">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar cambios</button>
					    </p>-->
				    </form>
			  	</div>
			</div>
		</div>
	</div>
</div>
<?php 

else: ?>
	<p class="lead text-center">Lo sentimos no hay rubrica por publicar</p>
<?php
		endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>