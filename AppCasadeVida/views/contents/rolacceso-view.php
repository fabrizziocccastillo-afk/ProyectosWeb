<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/paisController.php" ?>
<script type="text/javascript">

       

		//$('.torres')[].checked(function(){ 
			//if (this.checked){

		//		alert($(this).val());
			//}
		
		//});


		
		 /*$("input:checkbox:checked").each(function() {
			  alert($(this).val());
		 });*/

/*function seleccionTorre(){

	alert("Hola mundo...........");

	        
			//alert(document.getElementById('torres[]').value);
			//alert(document.miFormulario.torres[0].value);
	       var torres = document.getElementById('torres[]').value;
			//var check = document.getElementById('torres[]');
			//var casadevida = document.getElementById("casav");
            //alert(torres);
			//document.write("torres");
			//if (check.checked){

			//	alert("Hola hiciste click");
	            //torre.style.display='block';
	            //casadevida.style.display='block';
	            //bautizado.style.display='block';
	        //}
	        //else { 

				//alert("Hola desmarcaste");
	            //torre.style.display='none';
	            //casadevida.style.display='none';
	            //bautizado.style.display='none';
	            //document.getElementById("bautizo").checked = false;
	        //}
	       $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxAsignacionRol.php",
	            method: "POST",
	            data: {"torres":torres},
	            success: function(respuesta){
	            	console.log(respuesta);
	                //$("#cdv").attr("disabled",false);
	                $("#cdv").html(respuesta);
	            }
	        });
	       
	      }*/
</script>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> Rol(Asignación)</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de Asignación de Roles. Acá podrá Asignar roles a los usuarios.
	</p>
</div>
<?php 
	require_once "./controllers/rolController.php";

	$insrol = new rolController();
    
	if(isset($_POST['usuario'])){

		//$codigouser=$_POST['codigo'];
		//$coderol=$_POST['code'];
		//$codigotorre=$_POST['torres'];
		//$codigocdv=$_POST['cdv'];
        
		//for($i=0;$i<count($respuesta);$i++){
		 echo $insrol->add_asignacion_controller();

		//}
			/*echo "<pre>";       
			print_r($_POST);
			echo "</pre>"; 
			exit();*/
    }

    /*if(isset($_POST['idrol']) && isset($_POST['rol'])){
		echo $insrol->update_rol_controller();
	}
    
	if(isset($_POST['rolCode'])){

		echo $insrol->delete_rol_controller($_POST['rolCode']);

	}*/
	$code=explode("/", $_GET['views']);

	$data=$insrol->data_rolacceso_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>rollist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Asignación de Roles</h3>
				</div>
			  	<div class="panel-body">
                  <form name="miFormulario" action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<input type="hidden" name="code" value="<?php echo $rows['idrol']; ?>">
							<input type="hidden" name="codigo" value="<?php echo $rows['Codigo']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
									<div class="col-xs-12 col-sm-4">
                                        <div class="form-group label-floating">
										  	<label class="control-label">Usuario </label>
										  	<input class="form-control" type="text" name="usuario" id="usuario" value="<?php echo $rows['Usuario']; ?>" readonly>
										</div>                                        
				    				</div>
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group label-floating">
										  	<label class="control-label">Nombres </label>
										  	<input class="form-control" type="text" name="nombres" id="nombres" value="<?php echo $rows['Nombres'].' '.$rows['Apellidos']; ?>" readonly>
										</div>                                        
				    				</div>
                                    <div class="col-xs-12 col-sm-4">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Rol </label>
										  	<input class="form-control" type="text" name="rol" id="rol" value="<?php echo $rows['rol']; ?>" readonly>
										</div> 
				    				</div>
                                </div>
                            </div>
				    	</fieldset>
                        <fieldset >
							<div class="container-fluid">
								<div class="row">
									<!--<div id="torre" class="col-xs-12 col-sm-6">-->
									<div id="torre">
									<legend><i class="zmdi zmdi-pin"></i> Sectores </legend>
										  		<?php 
										  			//if(isset($_POST['torre'])){ 
										  			//	echo '<option value="'.$_POST['torre'].'">'.$_POST['torre'].' Actual</option>'; 
										  			//} 
										  		?>
										  		<?php 
												  $contador=0;
												 //$datosCDVxTorre= $paisModel->traer_casadevida_model(); 
												foreach($datosTorre as $opciones): ?>  
												<div class="col-xs-12 col-sm-4">
												<div class="form-group label-floating">
													<!--<input type="hidden" name="torres[]" id="torres[]" value="0" onchange="javascript:seleccionTorre()">					-->
													<br><br>
										  	        <input type="checkbox" id="torres[]"  name="torres[]" value="<?php echo $opciones['idtorre']?>" >  <!--onchange="javascript:seleccionTorre()"> -->
													<label for="ver"><b><?php echo $opciones['torre']?></b></label>
													<br><br>     
										  		<?php 
												 $datosCDVxTorre= $paisModel->traer_casadevida_model($opciones['idtorre']); 
												 foreach($datosCDVxTorre as $opciones2):?>
												 
                                                    <input type="checkbox" name="cdv[]" value="<?php echo $opciones2['idcasadevida']?>"> 
													<label for="cdv"><?php echo $opciones2['casadevida']?></label> 
													<br>
													
                                                 <?php 
												 
												 endforeach;
												   $contador ++;

												 ?>
												 </div>  
												 </div>
												 <?php
                                                     if($contador%3==0):
												 ?>
												 <div class="col-xs-12">
												 </div>
												 <?php 
												   endif;
												endforeach; ?> 
				    				</div>
                                    <!--<div id="casav" style="display:none;" class="col-xs-12 col-sm-4">-->
									<!--<div id="casav" class="col-xs-12 col-sm-4">
									<label class="control-label">Casa de Vida </label>
										  		<?php 
										  			//if(isset($_POST['casadevida'])){ 
										  			//	echo '<option value="'.$_POST['casadevida'].'">'.$_POST['casadevida'].' Actual</option>'; 
										  			//} 
										  		?>
												<br><br>
										  		<?php //foreach($datosCDV as $opciones): ?>   
													<input type="hidden" name="cdv[]" value="0">					
										  	        <input type="checkbox" name="cdv[]" value="<?php //echo $opciones['idcasadevida']?>"> 
													<label for="cdv"><?php //echo $opciones['casadevida']?></label> 
													<br>        
										  		<?php //endforeach ?> 									  	
									</div>-->
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar cambios</button>
					    </p>
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