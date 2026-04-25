<?php if($_SESSION['userType']=="UsuarioCDV"): ?>
<?php include "./controllers/paisController.php" ?>
<!--Script para la peticion de datos: Miguel -->

<div class="container-fluid">
	<div class="page-header">
	  <h1 class="text-titles"><i class="zmdi zmdi-settings zmdi-hc-fw"></i> Datos Asistencia</h1>
	</div>
	<p class="lead">
		Bienvenido a la sección de datos de asistencia CDV. 
	</p>
</div>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>asistenciaintlist/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<?php 
	require_once "./controllers/integranteController.php";

    $integranteins = new integranteController();
   // $UsuarioActualiza = $_SESSION['userName'];

	/*if(isset($_POST['code'])){
		echo $integranteins->update_integrante_controller();
		echo $integranteins->foto_integrante_controller($_POST['code']);
		echo "<script type='text/javascript'>window.location='SERVERURL/integranteinfo/';<script>";
	}*/
    $code=explode("/", $_GET['views']);
    
	$data=$integranteins->data_asistencia_info_controller("Only",$code[1]);
	if($data->rowCount()>0):
		$rows=$data->fetch();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> Datos Asistencia</h3>
				</div>
			  	<div class="panel-body">
                    <fieldset>     
                    <!--<legend><i class="zmdi zmdi-account-box"></i> Datos personales</legend><br>-->
				    		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['userName']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>FECHA: </td><td><input  type="text" class="sinbordefondo" name="fecha" id="fecha" value="<?php echo $rows['fecha'];?>" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>TORRE: </td>
                                            <td>
                                                   <?php echo $rows['torre']; ?>
                                                   <!-- <select class="sinbordefondo" name="torres" id="torres" onclick="javascript:seleccionTorre()" required="">
													<?php //foreach($datosrolxTorre as $opciones): ?>            
													<option value="<?php //echo $opciones['idtorre']?>"><?php //echo $opciones['torre']?></option>
													<?php //endforeach ?> 									  	    
												    </select>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NOMBRE DE LA CDV: </td>
                                            <td>
                                            <?php echo $rows['casadevida']; ?> 
                                                    <!--<select class="sinbordefondo" name="casavida" id="casavida" onclick="javascript:seleccionCDV(); javascript:seleccionPredicador();">
													<?php //foreach($datosrolxCDV as $opciones): ?>            
													<option value="<?php //echo $opciones['idcasadevida']?>"><?php //echo //$opciones['casadevida']?></option>
													<?php //endforeach ?> 
                                                    </select>-->
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>NOMBRE PREDICADOR: </td>
                                            <td>
                                            <?php echo $rows['predicador']; ?>
                                            <!--<select class="sinbordefondo" name="predicador" id="predicador" required="" >
											<?php 
                                               //$user=$_SESSION['userName'];
                                               //$datosPredicador=$paisModel->show_predicador_model($user);                           
                                            ?>	
											<option value="">-- Seleccione Predicador --</option>
											<?php //foreach($datosPredicador as $opciones): ?>            
													<option value="<?php //echo $opciones['Codigo']?>"><?php //echo $opciones['predicador']?></option>
													<?php //endforeach ?> 									  	    
											</select>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OFRENDA: </td>
                                            <td>
                                                <?php echo $rows['ofrenda']; ?>
                                                <!--<span>$<input type="number" class="sinbordefondo" name="ofrenda" id="ofrenda"  value="0"></span>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>REUNION: </td>
                                            <td>
                                               <?php echo $rows['reunion']; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>OBSERVACION: </td>
                                            <td>
                                            <?php echo $rows['observacion']; ?>
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
												  $datosIntegrantesCDV=$integranteins->data_asistencia_info_controller("Only",$rows['idasistenciacdvcab']);
											     foreach($datosIntegrantesCDV as $opciones): 
										?>
                                             <tr>
											     <td><?php echo $nt; ?></td>   
												 <td>
                                                     <?php echo $opciones['nombres']; ?>
												</td>
												 <td>
                                                     <?php echo $opciones['cargo']; ?>
												</td>
												 <td>
                                                     <?php echo $opciones['asistio']; ?>
											     </td>
												 <td>
                                                     <?php if($opciones['martes']==1): ?>
													 <input type="checkbox" name="martes[]" value="<?php echo $opciones['martes']; ?>" checked>
                                                     <?php else: ?>
                                                     <input type="checkbox" name="martes[]" value="<?php echo $opciones['martes']; ?>">
                                                     <?php endif; ?>
												 </td>
												 <td>    
                                                     <?php if($opciones['domingo']==1): ?>
													 <input type="checkbox" name="domingo[]" value="<?php echo $opciones['domingo']; ?>" checked>
                                                     <?php else: ?>
                                                     <input type="checkbox" name="domingo[]" value="<?php echo $opciones['domingo']; ?>">
                                                     <?php endif; ?>
												 </td>
												 <td>    
                                                      <?php echo $opciones['invito']; ?>
												 </td>
												 <td>    
                                                      <?php echo $opciones['vinieron']; ?>
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
				    <!--<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<p class="text-center">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Guardar cambios</button>
					    </p>
				    </form>-->
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