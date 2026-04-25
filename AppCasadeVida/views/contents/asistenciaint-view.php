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
</script>
<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-assignment-check zmdi-hc-fw"></i> Asistencia(CDV)</h1>
	</div>
	<p class="lead">
    Bienvenido a la sección de Asistencia CDV, aquí podrás registrar la asistencia de sus Integrantes.
	</p>
</div>
<div class="container-fluid">
	<ul class="breadcrumb breadcrumb-tabs">
	  	<li class="active">
	  	<a href="<?php echo SERVERURL; ?>asistenciaint/" class="btn btn-info">
	  		<i class="zmdi zmdi-plus"></i> Nuevo
	  	</a>
	  	</li>
	  	<li>
	  		<a id="lista" href="<?php echo SERVERURL; ?>asistenciaintlist/" class="btn btn-success">
	  			<i class="zmdi zmdi-format-list-bulleted"></i> Lista
	  		</a>
		</li>
	</ul>
</div>
<?php 

    require_once "./controllers/integranteController.php";

	$insIntegrante = new integranteController();

	/*if(isset($_POST['integreanteCode'])){
		echo $insIntegrante->delete_integrante_controller($_POST['integreanteCode']);
	}*/
	if(isset($_POST['usuario'])){
		echo $insIntegrante->add_integranteAsistencia_controller();
	}
$fechahoy=date('Y-m-d');
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Nueva Asistencia</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    		<!--<legend><i class="zmdi zmdi-account-box"></i> Datos personales</legend><br>-->
				    		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['userName']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>FECHA: </td><td><input  type="date" class="sinbordefondo" name="fecha" id="fecha" value="<?php echo $rows['fechahoy'];?>"required ></td>
                                        </tr>
                                        <tr>
                                            <td>TORRE: </td>
                                            <td>
                                                    <select class="sinbordefondo" name="torres" id="torres" onclick="javascript:seleccionTorre()" required="">
													<!--<option value="">-- Seleccione una Torre --</option>-->
													<?php foreach($datosrolxTorre as $opciones): ?>            
													<option value="<?php echo $opciones['idtorre']?>"><?php echo $opciones['torre']?></option>
													<?php endforeach ?> 									  	    
												    </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NOMBRE DE LA CDV: </td>
                                            <td>
                                                    <select class="sinbordefondo" name="casavida" id="casavida" onclick="javascript:seleccionCDV(); javascript:seleccionPredicador();">
                                                        <!--<option value=" ">-- Seleccione una CDV --</option>-->
													<?php foreach($datosrolxCDV as $opciones): ?>            
													<option value="<?php echo $opciones['idcasadevida']?>"><?php echo $opciones['casadevida']?></option>
													<?php endforeach ?> 
                                                    </select>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>NOMBRE PREDICADOR: </td>
                                            <td>
                                            <select class="sinbordefondo" name="predicador" id="predicador" required="" >
											<?php 
                                               $user=$_SESSION['userName'];
                                               $datosPredicador=$paisModel->show_predicador_model($user);                           
                                            ?>	
											<option value="">-- Seleccione Predicador --</option>
											<?php foreach($datosPredicador as $opciones): ?>            
													<option value="<?php echo $opciones['Codigo']?>"><?php echo $opciones['predicador']?></option>
													<?php endforeach ?> 									  	    
											</select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OFRENDA: </td>
                                            <td>
                                                <span>$<input type="number" class="sinbordefondo" name="ofrenda" id="ofrenda" placeholder="Ingrese un valor.." value="0" step="0.001"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TIPO DE REUNION: </td>
                                            <td>
                                                <select name="reunion" class="sinbordefondo" id="reunion" >
                                                <!--<option value="<?php //echo $rows['sector']; ?>"><?php //echo $rows['sector']; ?></option>-->
                                                    <option value="Presencial">Presencial</option>
                                        <option value="Semipresencial">Semipresencial</option>
                                                    <option value="Online">Online</option>
                                                    <option value="No Hubo">No Hubo</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OBSERVACIONES DE LA REUNION: </td>
                                            <td>
                                                <textarea class="sinbordefondo" id="observacion" name="observacion" rows="3" placeholder="Ingrese una Observacion en caso de tenerlo.."></textarea>
                                            </td>
                                        </tr>
                                        
                                    </table>
                                    </div>
								</div>
				    		</div>
						</fieldset>			
						<fieldset>
                        <div class="container-fluid">
				    			<div class="row">
                                <div id="cdv" name="cdv" class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nombres </th>
                                            <th class="text-center">Cargo </th>
                                            <th class="text-center">Asistió CDV</th>
                                            <th class="text-center">Asistió Martes </th>
                                            <th class="text-center">Asistió Domingo </th>
                                            <th class="text-center">Invito </th>
                                            <th class="text-center">Vinieron </th>
                                        </thead>
                                        <tbody>
										<?php 
											      $Inicio=0;
											      $nt=$Inicio+1;
											      foreach($datosIntegrantesCDV as $opciones): 
										?>
                                             <tr>
											     <td><?php echo $nt; ?></td>   
												 <td>
												     <?php echo $opciones['nombres'];?>
												     <input  type="hidden" name="codintegrante[]" id="codintegrante[]" value="<?php echo $opciones['Codigo'];?>">
												</td>
												 <td>
												     <?php echo $opciones['cargo'];?>
													 <input  type="hidden"  name="codcargo[]" id="codcargo[]" value="<?php echo $opciones['idcargo'];?>">
												</td>
												 <td>
													 <select name="asistio[]" class="" id="asistio[]" >
                                                     <option value="Si">Si</option>
                                                     <option value="No">No</option>
                                                     </select>
											     </td>
												 <td>
													 <input type="checkbox" name="martes[]" value="<?php echo $nt; ?>">
												 </td>
												 <td>    
													 <input type="checkbox" name="domingo[]" value="<?php echo $nt; ?>">
												 </td>
												 <td>    
												      <input type="number" class="" name="invito[]" id="invito[]" placeholder="# Invitados" value="0">
												 </td>
												 <td>    
												       <input type="number" class="" name="vinieron[]" id="vinieron[]" placeholder="# Vinieron" value="0">
												 </td>
											 </tr> 
										<?php 
											     $nt++;
											     endforeach; ?>   
                                        </tbody>
                                    </table>
                                    </div>
								</div>
				    		</div>
						</fieldset>
					    <p class="text-center">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar</button>
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