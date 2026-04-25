<?php if($_SESSION['userType']=="UsuarioCDV"): ?>
<?php include "./controllers/paisController.php" ?>
<!--Script para la peticion de datos: Miguel -->
<script type="text/javascript">
function seleccionTorre(){
	        var torres = document.getElementById("torres").value;
			var parametros = {
					"torres" : torres,
					"usuario" : $('#usuario').val()
				};
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxTorresCDV.php",
	            method: "POST",
	            data: parametros,//{"torres":torres},
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#casavida").attr("disabled",false);
	                $("#casavida").html(respuesta);
	            }
	        });
	       
	      }
function seleccionCDV(){
	        var casavida = document.getElementById("casavida").value;
			var parametros = {
					"casavida" : casavida,
					"usuario" : $('#usuario').val()
				};
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxCDV.php",
	            method: "POST",
	            data: parametros,
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#cdv").attr("disabled",false);
	                $("#cdv").html(respuesta);
	            }
	        });
	       
	      }
		  function seleccionPredicador(){
	        var casavida = document.getElementById("casavida").value;
			var parametros = {
					"casavida" : casavida,
					"usuario" : $('#usuario').val()
				};
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxPredicador.php",
	            method: "POST",
	            data: parametros,
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#predicador").attr("disabled",false);
	                $("#predicador").html(respuesta);
	            }
	        });
	       
	      }
		  function seleccionDiscipulo(){
	        var casavida = document.getElementById("casavida").value;
			var parametros = {
					"casavida" : casavida,
					"usuario" : $('#usuario').val()
				};
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxDiscipulo.php",
	            method: "POST",
	            data: parametros,
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#discipulo").attr("disabled",false);
	                $("#discipulo").html(respuesta);
	            }
	        });
	       
	      }

		  function seleccionDirDiscipulo(){
	        var casavida = document.getElementById("casavida").value;
			var discipulo = document.getElementById("discipulo").value;
			var parametros = {
					"casavida" : casavida,
					"discipulo" : discipulo,
					"usuario" : $('#usuario').val()
				};
	        $.ajax({
	        	url: "/CASADEVIDA/ajax/ajaxDirDiscipulo.php",
	            method: "POST",
	            data: parametros,
	            success: function(respuesta){
	            	//console.log(respuesta);
	                $("#direccion").attr("disabled",false);
	                $("#direccion").html(respuesta);
	            }
	        });
	       
	      }
</script>

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-accounts zmdi-hc-fw"></i> Seguimientos a Integrantes</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de Seguimientos, aqui podras registrar seguimientos de los integrantes de CDV 
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
	</ul>
</div>
<!--<p class="text-center">
	<a href="<?php //echo SERVERURL; ?>seguimientointlist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>-->
<?php 

require_once "./controllers/integranteController.php";

$insIntegrante = new integranteController();

/*if(isset($_POST['integreanteCode'])){
	echo $insIntegrante->delete_integrante_controller($_POST['integreanteCode']);
}*/
if(isset($_POST['usuario'])){
	echo $insIntegrante->add_integranteSeguimiento_controller();
}

$fechanow=date('Y-m-d');

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Cabecera de la Gestion</h3>
				</div>
			  	<div class="panel-body">
				  <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                <fieldset>     
                   <legend><i class="zmdi zmdi-account-box"></i> Datos del Seguimiento</legend><br>
				    	
				    		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['userName']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
                                <div class="table-responsive">
                                    <table class="table tablafija">
                                        <tr>
                                            <td>Fecha del Seguimiento: </td><td><input  type="date" class="sinbordefondo" name="fecha" id="fecha" value="<?php echo $fechanow;?>" ></td>
                                        </tr>
                                        <tr>
                                            <td>Torre: </td>
                                            <td>
                                                   <?php //echo $rows['torre']; ?>
                                                   <select class="sinbordefondo" name="torres" id="torres" onclick="javascript:seleccionTorre()" required="">
													<?php foreach($datosrolxTorre as $opciones): ?>            
													<option value="<?php echo $opciones['idtorre']?>"><?php echo $opciones['torre']?></option>
													<?php endforeach ?> 									  	    
												    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Casa de Vida: </td>
                                            <td>
                                            <?php //echo $rows['casadevida']; ?> 
                                                    <select class="sinbordefondo" name="casavida" id="casavida" onclick="javascript:seleccionPredicador(); javascript:seleccionDiscipulo();">
													<?php foreach($datosrolxCDV as $opciones): ?>            
													<option value="<?php echo $opciones['idcasadevida']?>"><?php echo $opciones['casadevida']?></option>
													<?php endforeach ?> 
                                                    </select>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Responsable de la Gestion: </td>
                                            <td>
                                            <select class="sinbordefondo" name="predicador" id="predicador" required="" >
											<?php 
                                               $user=$_SESSION['userName'];
                                               $datosPredicador=$paisModel->show_predicador_model($user);                           
                                            ?>	
											<option value="">-- Seleccione Responsable --</option>
											<?php foreach($datosPredicador as $opciones): ?>            
													<option value="<?php echo $opciones['Codigo']?>"><?php echo $opciones['predicador']?></option>
													<?php endforeach ?> 
											</select>
										</td>
										</tr>
										</table>	
                                        <br>
                <div class="panel-body"> 
                    <legend><i class="zmdi zmdi-account-box"></i> Datos de la Persona a Gestionar</legend><br>
                        <!--<div class="container-fluid">-->
				    		<div class="row">
                                <div class="table-responsive">
								<table class="table tablafija">
								<tr>       
								<td>Nombre de la Persona a Gestionar: </td>
								<td>
								<select class="sinbordefondo" name="discipulo" id="discipulo" onclick="javascript:seleccionDirDiscipulo();" required="" >
								<?php 
								$user=$_SESSION['userName'];
								$datosPredicador=$paisModel->show_discipuloxCDV_model($user);                       
								?>	
								<option value="">-- Seleccione Persona --</option>
								<?php foreach($datosPredicador as $opciones): ?>          
										<option value="<?php echo $opciones['Codigo']?>"><?php echo $opciones['discipulo']?></option>
								<?php endforeach ?>	
								</select>
								</td>
								</tr> 
								</table>
								</div>
								<div id="direccion" class="table-responsive">
								    <table class="table">
                                       </tr>
									   <tr>
                                            <td>Foto: </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td>Direccion: </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Telefono Personal: </td>
                                            <td>
                                            <?php //echo $opciones['telefono'];//echo $rows['observacion']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Telefono Trabajo: </td>
                                            <td>
                                            <?php //echo $opciones['telTrabajo'];//echo $rows['observacion']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Correo: </td>
                                            <td>
                                            <?php //echo $opciones['Email'];//echo $rows['observacion']; ?>
                                            </td>
                                        </tr>
								    </table>
								</div>
	                        </div>
	                    <!--</div>-->
                </div>  
<!--</div> 
</fieldset>		
<fieldset>-->
	<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">				    
			 <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Detalle de la Gestion</h3>
			 </div>
                        <div class="container-fluid">
				    			<div class="row">
                                <div id="cdv" name="cdv" class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Asunto </th>
                                            <th class="text-center">Temas </th>
                                            <th class="text-center">Modo de Reunion</th>
                                            <th class="text-center">Hora de la Cita</th>
											<th class="text-center">Lugar de la Reunion </th>
                                            <th class="text-center">Observacion </th>
											<th class="text-center">Proxima Reunion </th>
											
                                        </thead>
                                        <tbody>
										<?php 
											      $Inicio=0;
											      $nt=$Inicio+1;
												  //$datosIntegrantesCDV=$integranteins->data_asistencia_info_controller("Only",$rows['idasistenciacdvcab']);
											     //foreach($datosIntegrantesCDV as $opciones): 
										?>
                                             <tr>
											     <td><?php echo $nt; ?></td>   
												<td>
                                                     <?php //echo $opciones['nombres']; ?>
             <!--</div>-->
						            <select name="asunto" class="sinbordefondo" id="asunto" ><?php //echo $rows['asunto']; ?></option>
										<option value="Ninguno">--Seleccione uno--</option>
										<option value="Discipulado">Discipulado</option>
										<option value="Visitacion">Visitacion</option>
										<option value="llamada">Llamada</option>
										<option value="Seguimiento">Seguimiento</option>
										<option value="Asignacion">Asignacion</option>
									</select>
								<!-- 	</div>
									</div>-->
												</td>
												 <td>
                                                     <?php //echo $opciones['cargo']; ?>
                                        <select name="temas" class="sinbordefondo" id="temas" ><?php //echo $rows['temas']; ?></option>
										<option value="Ninguno">--Seleccione uno--</option>
										<option value="1. Cristo en Nosotros">1. Cristo en Nosotros</option>
										<option value="2. Luz en la Oscuridad">2. Luz en la Oscuridad</option>
										<option value="3. Radical">3. Radical</option>
										<option value="4. Paternidad">4. Paternidad</option>
										<option value="5. La Gracia">5. La Gracia</option>
										<option value="6. Amigo Fiel">6. Amigo Fiel</option>
										<option value="7. Sanidad Interior">7. Sanidad Interior</option>
										<option value="8. Pecado">8. Pecado</option>
										<option value="9. Santidad">9. Santidad</option>
										<option value="10. Identidad">10. Identidad</option>
										<option value="11. El Cuerpo de Cristo">11. El Cuerpo de Cristo</option>
										<option value="12. Adversarios del Corazon">12. Adversarios del Corazon</option>
										<option value="13. Adversarios del Corazon II">13. Adversarios del Corazon II</option>
										<option value="14. Proposito">14. Proposito</option>
										<option value="15. Guerra Espiritual">15. Guerra Espiritual</option>
										<option value="16. Intimidad">16. Intimidad</option>
										<option value="17. Vida Devocional">17. Vida Devocional</option>
										<option value="18. Animo">18. Animo</option>
										<option value="19. Gratitud">19. Gratitud</option>
										<option value="20. Adoracion">20. Adoracion</option>	
										<option value="21. Permanece">21. Permanece</option>
									</select>
								<!-- 	</div>
									</div>-->
												</td>
												 <td>
                                                     <?php //echo $opciones['asistio']; ?>
						                <select name="modoreunion" class="sinbordefondo" id="modoreunion" ><?php //echo $rows['modo reunion']; ?></option>
										<option value="Ninguno">--Seleccione uno--</option>
										<option value="Llamada">Llamada</option>
										<option value="Video Conferencia">Video Conferencia</option>
										<option value="Presencial">Presecial</option>
									    </select>
								<!-- 	</div>
									</div>-->
						<td>
                                                     <?php //if($opciones['martes']==1): ?>
											 <input type="time" name="horacita" value="<?php //echo $opciones['martes']; ?>" checked>
                                                     <?php //else: ?>
                                                     <?php //endif; ?>
												 </td>
											  <td>    
												 <input type="text" class="sinbordefondo" name="lugar" value=""  placeholder="Ingrese un Lugar..">
                                                      <?php //echo $opciones['vinieron']; ?>
                                            <!-- <input type="text" nam-->
											  </td>
												 <td>  
												 <textarea class="sinbordefondo" id="observacion" name="observacion" rows="3" placeholder="Ingrese una Observación en caso de tenerlo.."></textarea>  
												 
                                                      <?php //echo $opciones['invito']; ?>
                                            <!--<input type="text" name-->
										    </td>
											<td>    
                                                     <?php //if($opciones['domingo']==1): ?>
											<input type="time" name="horaproximareunion" value="<?php //echo $opciones['domingo']; ?>" checked>
                                                     <?php //else: ?>
                                                     <input type="date" name="fechaproximareunion" value="<?php //echo $opciones['domingo']; ?>">
                                                     <?php //endif; ?>
											</td>
											 </tr> 
										<?php 
											     $nt++;
											     //endforeach; ?>   
                                        </tbody>
                                    </table>
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
<?php //else: ?>
	<!--<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>-->
<?php
		//endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>