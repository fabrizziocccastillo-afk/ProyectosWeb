<?php if($_SESSION['userType']=="Administrador"): ?>
<?php include "./controllers/paisController.php" ?>
<!--Script para la peticion de datos: Miguel -->
<script type="text/javascript">
	    function seleccionCheck(){
	        torre = document.getElementById("torre");
	        casadevida = document.getElementById("casadevida");
	        //bautizado = document.getElementById("bautizado");
	        check = document.getElementById("si");
	    
	       if (check.checked){
	            torre.style.display='block';
	            casadevida.style.display='block';
	            bautizado.style.display='block';
	        }
	        else { 
	            torre.style.display='none';
	            casadevida.style.display='none';
	            //bautizado.style.display='none';
	            //document.getElementById("bautizo").checked = false;
	        }
        }
		function seleccionCheck2(){
	       // fechaconver = document.getElementById("fechaconv");
	        fechabaut = document.getElementById("fechabaut");
	        lugarbaut = document.getElementById("lugarbaut");
	        check2 = document.getElementById("bautizo");
	    
	       if (check2.checked){
			//fechaconv.style.display='block';
			fechabaut.style.display='block';
			lugarbaut.style.display='block';
	        }
	        else { 
	            //fechaconv.style.display='none';
	            fechabaut.style.display='none';
	            lugarbaut.style.display='none';
	            document.getElementById("bautizo").checked = false;
	        }
        }
		function seleccionCheckPasaporte(){
	        check = document.getElementById("cedula");
			check.max
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

          function seleccionTorre(){
	        var torres = document.getElementById("torres").value;
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxTorres.php",
	            method: "POST",
	            data: {"torres":torres},
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#casavida").attr("disabled",false);
	                $("#casavida").html(respuesta);
	            }
	        });
	       
	      }
</script>
<script type="text/javascript">
		function soloNumeros(e){
			var	check = document.getElementById("pasaporte");
			var cad = document.getElementById("cedula");
			if (!check.checked){
			document.getElementById("cedula").maxLength = 10;	
			var key = window.Event ? e.which : e.keyCode
			return (key >= 48 && key <= 57 || (key==8))
			}else{
				document.getElementById("cedula").maxLength = 15;
			}
		}

		function validar() {
		var	check = document.getElementById("pasaporte");
        var cad = document.getElementById("cedula").value.trim();
        var total = 0;
        var longitud = cad.length;
        var longcheck = longitud - 1;


		if (!check.checked){

			document.getElementById("cedula").maxLength = 10;
	           
					if (longitud < 10 || longitud>10){

						document.getElementById("cedula").value="";
						document.getElementById("salida").innerHTML = ("Cedula Inválida");

						return;

					}

					if (cad !== "" && longitud === 10){
					for(i = 0; i < longcheck; i++){
						if (i%2 === 0) {
						var aux = cad.charAt(i) * 2;
						if (aux > 9) aux -= 9;
						total += aux;
						} else {
						total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
						}
					}

					total = total % 10 ? 10 - total % 10 : 0;

					if (cad.charAt(longitud-1) == total) {
						//document.getElementById("salida").innerHTML = ("Cedula Válida");
						document.getElementById("salida").innerHTML = ("");
					}else{
						document.getElementById("salida").innerHTML = ("Cedula Inválida");
						document.getElementById("cedula").value="";
					}
					}
		          }else{
					document.getElementById("cedula").maxLength = 15;
					document.getElementById("salida").innerHTML = ("");
				  }
			}
			

</script>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-settings zmdi-hc-fw"></i> Datos del Usuario</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de actualización de los datos del Usuario CDV. Usted podrá actualizar la información personal cuando se lo requiera.
	</p>
</div>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>usuariolist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<?php 
	require_once "./controllers/usuarioController.php";

    $usuarioins = new usuarioController();
   // $UsuarioActualiza = $_SESSION['userName'];

	if(isset($_POST['code'])){
		echo $usuarioins->update_usuario_controller();
		echo $usuarioins->foto_usuario_controller($_POST['code']);
		echo "<script type='text/javascript'>window.location='SERVERURL/usuarioinfo/';<script>";
	}
    $code=explode("/", $_GET['views']);
    
	$data=$usuarioins->data_usuario_actualiza_adm_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Actualizar datos</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-account-box"></i> Datos personales</legend><br>
				    		<input type="hidden" name="code" value="<?php echo $rows['Codigo']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
									<div class="col-xs-12 col-sm-6">
										<div>
										<h1 class="text-primary">Foto</h1>
										</div>
										<div>
											<label for="my-input">Seleccione una Foto</label>
											<input id="my-input" type="file" name="imagen">
										</div>
									</div>
									<div class="col-xs-12 col-sm-1">
										   <!--<div class="card-columns">
										   <div class="card"> -->
										   <?php if($rows['foto']<>''): ?> 
										   <img src="/CASADEVIDA/Backend/imagenes/<?php echo $rows['foto']; ?>" height="150" class="card-img-top"> 
										   <?php else: ?> 
											<img src="/CASADEVIDA/Backend/imagenes/USUARIO.png" height="150" class="card-img-top"> 
											<?php endif; ?> 
										   <!--</div>
										   </div> -->
									</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group">
										    <input type="checkbox" id="pasaporte" name="pasaporte" value="1">
											<label for="pasaporte">Pasaporte</label>
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Celula/Pasaporte *</label>
										  	<input class="form-control" type="text" name="cedula" id="cedula" value="<?php echo $rows['cedula']; ?>" required="" onKeyPress="return soloNumeros(event)" onchange="javascript:validar()">
											<label style="color:#FF0000" id="salida"></label>
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<input class="form-control" type="hidden" value="0">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<input class="form-control" type="hidden" value="0">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombres *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="name" value="<?php echo $rows['Nombres']; ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Apellidos *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="lastname" value="<?php echo $rows['Apellidos']; ?>" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Email *</label>
										  	<input class="form-control" type="email" name="email" value="<?php echo $rows['Email']; ?>" required="">
										</div>
				    				</div>
				    				<!--Añadido por MM -->
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Dirección *</label>
										  	<input class="form-control" type="text" name="direccion" value="<?php echo $rows['direccion']; ?>" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
									<label class="control-label">Sector *</label>
									<select name="sector" class="form-control" id="sector" required="">
									<option value="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
										<option value="NORTE">NORTE</option>
										<option value="SUR">SUR</option>
										<option value="CENTRO">CENTRO</option>
										<option value="ESTE">ESTE</option>
										<option value="OESTE">OESTE</option>
										<option value="SUBURBIO">SUBURBIO</option>
										<option value="DAULE">DAULE</option>
										<option value="SAMBORONDON">SAMBORONDON</option>
										<option value="DURAN">DURAN</option>
									</select>
									</div>
									</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Teléfono *</label>
										  	<input class="form-control" type="tel" name="telefono" value="<?php echo $rows['telefono']; ?>" required="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Pais</label>
										  	<select name="pais" class="form-control" id="pais" onchange="javascript:seleccionPais()">								  	
										  	<option value="<?php echo $rows['idpais']; ?>"><?php echo $rows['nombrepais']; ?></option>				  		
										  	    <?php foreach($datosPais as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idpais']?>"><?php echo $opciones['nombrepais']?></option>
										  		  <?php endforeach ?> 						          	
									        </select>
										</div>
				    				</div>				    							    					
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Ciudad</label>
										  	<select name="ciudad" class="form-control" id="ciudad">	
										  	<option value="<?php echo $rows['idciudad']; ?>"><?php echo $rows['nombreciudad']; ?></option>	
									        </select>
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <SPAN class="control-label">Fecha de Nacimiento *</SPAN>
										  	<input class="form-control" type="date" value="<?php echo $rows['fechaNacimiento']; ?>" name="fecha" id="fecha" required="">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <span class="control-label">Lugar de Nacimiento *</span>
										  	<input class="form-control" type="text" name="lugar" id="lugar" value="<?php echo $rows['lugarNacimiento']; ?>" required="">
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Estado Civil *</label>
										  	<select name="estado" class="form-control" id="estado" required="">								  	
										  	<option value="<?php echo $rows['idestadocivil']; ?>"><?php echo $rows['estadocivil']; ?></option>				  		
										  	    <?php foreach($datosEstadoCivil as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idestadocivil']?>"><?php echo $opciones['estadocivil']?></option>
										  		  <?php endforeach ?> 						          	
									        </select>
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <label class="control-label">Instruccion *</label>
										  	<input class="form-control" type="text" name="instruccion" id="instruccion" value="<?php echo $rows['instruccion']; ?>" required="">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <label class="control-label">Profesion *</label>
										  	<input class="form-control" type="text" name="profesion" id="profesion" value="<?php echo $rows['profesion']; ?>" required="">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <label class="control-label">Dir. Trabajo </label>
										  	<input class="form-control" type="text" name="dirtrabajo" id="dirtrabajo" value="<?php echo $rows['dirTrabajo']; ?>">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <label class="control-label">Telf. Trabajo </label>
										  	<input class="form-control" type="text" name="teltrabajo" id="teltrabajo" value="<?php echo $rows['telTrabajo']; ?>">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <label class="control-label">Empresa </label>
										  	<input class="form-control" type="text" name="empresa" id="empresa" value="<?php echo $rows['empresa']; ?>">
										</div>
				    				</div>	
									<div class="col-xs-12">	
									      <legend><i class="zmdi zmdi-account-box"></i> Datos Eclesiasticos</legend>	
									</div>		    							
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Nombre de la Iglesia *</label>
										  	<input class="form-control" type="text" name="iglesia" value="<?php echo $rows['iglesia']; ?>" required="">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										    <input type="hidden" name="pertenececda" value="0">				  
										  	<?php
											     if($rows["pertenececda"]==1){ echo '<input type="checkbox" id="si" name="pertenececda" value="1" checked onchange="javascript:seleccionCheck()">';}else{ echo '<input type="checkbox" id="si" name="pertenececda" value="1" onchange="javascript:seleccionCheck()">';}
										    ?>	
										  	<label for="si">Pertenece a CDA Matriz</label>							 
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<input class="form-control" type="hidden" value="0">
										</div>
				    				</div>	
				    				<?php 
				    				   if($rows['pertenececda']==1){$Estilo='display:block;';}else{$Estilo='display:none;';} 
				    				   echo '<div id="torre" style="'.$Estilo.'" class="col-xs-12 col-sm-6">'
				    				?>
										<div class="form-group label-floating">
										  	<label class="control-label">Torre *</label>
										  	<select name="torres" class="form-control" id="torres" onchange="javascript:seleccionTorre()">
										  		<option value="<?php echo $rows['idtorre']; ?>"><?php echo $rows['torre']; ?></option>	
										  		<?php foreach($datosTorre as $opciones): ?>            
										  		  <option value="<?php echo $opciones['idtorre']?>"><?php echo $opciones['torre']?></option>
										  		<?php endforeach ?> 									  	    
									        </select>
										</div>
				    				</div>
				    				<?php 
				    				   if($rows['pertenececda']==1){$Estilo='display:block;';}else{$Estilo='display:none;';} 
				    				   echo '<div id="casadevida" style="'.$Estilo.'" class="col-xs-12 col-sm-6">'
				    				?>	
										<div class="form-group label-floating">
										  	<label class="control-label">Casa de Vida *</label>
										  	<select name="casavida" class="form-control" id="casavida">	
										  	<option value="<?php echo $rows['idcasadevida']; ?>"><?php echo $rows['casadevida']; ?></option>	
									        </select>
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										    <SPAN class="control-label">Fecha de Conversión *</SPAN>
										  	<input class="form-control" type="date" value="<?php echo $rows['fechaconversion']; ?>" name="fechaconversion" id="fechaconversion" required="">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										    <input type="hidden" name="bautizado" value="0">				  
										  	<?php
											     if($rows["bautizado"]==1){ echo '<input type="checkbox" id="bautizo" name="bautizado" value="1" checked onchange="javascript:seleccionCheck2()">';}else{ echo '<input type="checkbox" id="bautizo" name="bautizado" value="1" onchange="javascript:seleccionCheck2()">';}
										    ?>	
										  	<label for="bautizo">Bautizado</label>							 
										</div>
				    				</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<input class="form-control" type="hidden" value="0">
										</div>
				    				</div>	
									<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<input class="form-control" type="hidden" value="0">
										</div>
				    				</div>	
									<?php 
				    				   if($rows['bautizado']==1){$Estilo='display:block;';}else{$Estilo='display:none;';} 
				    				   echo '<div id="fechabaut" style="'.$Estilo.'" class="col-xs-12 col-sm-6">'
				    				?>	
										<div class="form-group label-floating">
										    <span class="control-label">Fecha de Bautizo </span>
										  	<input class="form-control" type="date" value="<?php echo $rows['fechabautizo']; ?>" name="fechabautizo" id="fechabautizo">
										</div>
				    				</div>
									<?php 
				    				   if($rows['bautizado']==1){$Estilo='display:block;';}else{$Estilo='display:none;';} 
				    				   echo '<div id="lugarbaut" style="'.$Estilo.'" class="col-xs-12 col-sm-6">'
				    				?>	
										<div class="form-group label-floating">
										    <span class="control-label">Lugar de Bautizo </span>
										  	<input class="form-control" type="text" name="lugarbautizo" id="lugarbautizo" value="<?php echo $rows['lugarbautizo']; ?>">
										</div>
				    				</div>			    				
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