<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/paisController.php" ?>
<!--Script para la peticion de datos Miguel-->
<script type="text/javascript">
    
    	function showContent(){
        torre = document.getElementById("torre");
        casadevida = document.getElementById("casadevida");
        bautizado = document.getElementById("bautizado");
        check = document.getElementById("si");
        if (check.checked) {
            torre.style.display='block';
            casadevida.style.display='block';
            bautizado.style.display='block';
        }
        else { 
            torre.style.display='none';
            casadevida.style.display='none';
            bautizado.style.display='none';
            document.getElementById("bautizo").checked = false;
        }
    }

	      function seleccionPais(){
	        var pais = document.getElementById("pais").value;
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxPaises.php",
	            method: "POST",
	            data: {"pais":pais},
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#ciudad").attr("disabled",false);
	                $("#ciudad").html(respuesta);
	            }
	        });
	       
	      }
</script>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-face zmdi-hc-fw"></i> Usuarios <small>(Estudiantes)</small></h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de estudiantes, aquí podrás registrar nuevos estudiantes (Los campos marcados con * son obligatorios para registrar un estudiante).
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>student/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a href="<?php echo SERVERURL; ?>studentlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
	  	</li>
	</ul>
</div>
<?php 
	require_once "./controllers/studentController.php";

	$insStudent = new studentController();
	if(isset($_POST['name']) && isset($_POST['username'])){
		echo $insStudent->add_student_controller();
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> Nuevo Estudiante</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> Datos personales</legend><br>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombres *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="name" value="<?php if(isset($_POST['name'])){ echo $_POST['name']; } ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Apellidos *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="lastname" value="<?php if(isset($_POST['lastname'])){ echo $_POST['lastname']; } ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Email</label>
										  	<input class="form-control" type="email" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
										</div>
				    				</div>
				    				<!--Añadido por MM -->
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Dirección *</label>
										  	<input class="form-control" type="text" name="direccion" value="<?php if(isset($_POST['direccion'])){ echo $_POST['direccion']; } ?>">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Teléfono *</label>
										  	<input class="form-control" type="tel" name="telefono" value="<?php if(isset($_POST['telefono'])){ echo $_POST['telefono']; } ?>">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Pais</label>
										  	<select name="pais" class="form-control" id="pais" onchange="javascript:seleccionPais()">
										  	<?php 
										  			if(isset($_POST['pais'])){ 
										  				echo '<option value="'.$_POST['pais'].'">'.$_POST['pais'].' Actual</option>'; 
										  			} 
										  	?>
										  	<option value="">   </option>				  		
										  	    <?php foreach($datosPais as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idpais']?>"><?php echo $opciones['nombrepais']?></option>
										  		  <?php endforeach ?> 						          	
									        </select>
										</div>
				    				</div>				    							    					
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Ciudad</label>
										  	<select name="ciudad" class="form-control" id="ciudad" disabled>
										  	<?php 
										  			if(isset($_POST['ciudad'])){ 
										  				echo '<option value="'.$_POST['ciudad'].'">'.$_POST['ciudad'].' Actual</option>'; 
										  			} 
										  	?>
										  	<option value="0">   </option>	
									        </select>
										</div>
				    				</div>					    							
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Nombre de la Iglesia *</label>
										  	<input class="form-control" type="text" name="iglesia" value="<?php if(isset($_POST['iglesia'])){ echo $_POST['iglesia']; } ?>">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										    <input type="hidden" name="pertenececda" value="0">					
										  	<input type="checkbox" id="si" name="pertenececda" value="1" onchange="javascript:showContent()">
										  	<label for="si">Pertenece a CDA</label>							 
										</div>
				    				</div>
				    				<div id="torre" style="display:none;" class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Torre *</label>
										  	<select name="torre" class="form-control">
										  		<?php 
										  			if(isset($_POST['torre'])){ 
										  				echo '<option value="'.$_POST['torre'].'">'.$_POST['torre'].' Actual</option>'; 
										  			} 
										  		?>
										  		<option value="">   </option>	
										  		<?php foreach($datosTorre as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idtorre']?>"><?php echo $opciones['torre']?></option>
										  		<?php endforeach ?> 									  	    
									        </select>
										</div>
				    				</div>
				    				<div id="casadevida" style="display:none;" class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Casa de Vida *</label>
										  	<select name="casadevida" class="form-control">
										  		<?php 
										  			if(isset($_POST['casadevida'])){ 
										  				echo '<option value="'.$_POST['casadevida'].'">'.$_POST['casadevida'].' Actual</option>'; 
										  			} 
										  		?>
										  		<option value="">   </option>	
										  		<?php foreach($datosCDV as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idcasadevida']?>"><?php echo $opciones['casadevida']?></option>
										  		<?php endforeach ?> 										  	
									        </select>
										</div>
				    				</div>				
				    				<div id="bautizado" style="display:none;" class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										    <input type="hidden" name="bautizado" value="0">					
										  	<input type="checkbox" id="bautizo" name="bautizado" value="1">
										  	<label for="bautizo">Bautizado</label>						 
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
				    	<br><br>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-key"></i> Datos de la cuenta</legend><br>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
							    		<div class="form-group label-floating">
										  	<label class="control-label">Nombre de usuario *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ]{1,15}" class="form-control" type="text" name="username" value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>" required="" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Genero</label>
										  	<select name="gender" class="form-control">
										  		<?php 
										  			if(isset($_POST['gender'])){ 
										  				echo '<option value="'.$_POST['gender'].'">'.$_POST['gender'].' Actual</option>'; 
										  			} 
										  		?>
									          	<option value="Masculino">Masculino</option>
									          	<option value="Femenino">Femenino</option>
									        </select>
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Contraseña *</label>
										  	<input class="form-control" type="password" name="password1" value="<?php if(isset($_POST['password1'])){ echo $_POST['password1']; } ?>" required="" maxlength="70">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Repita la contraseña *</label>
										  	<input class="form-control" type="password" name="password2" value="<?php if(isset($_POST['password2'])){ echo $_POST['password2']; } ?>" required="" maxlength="70">
										</div>
				    				</div>
								</div>
							</div>
				    	</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
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
