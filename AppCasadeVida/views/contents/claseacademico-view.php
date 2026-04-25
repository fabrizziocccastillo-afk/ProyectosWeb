<?php if($_SESSION['userType']=="Estudiante"): ?>
<?php include "./controllers/paisController.php" ?>
<script type="text/javascript">
    
    	function showContent1(){
		evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
                
                    clasedia.style.display='block';
                    grabacion.style.display='none';
					evalua.style.display='none'
					material.style.display='none';
			        tarea.style.display='none';
			        asistencia.style.display='none';
					nota.style.display='none';
  
        }

        function showContent2(){
		evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
     
            grabacion.style.display='block';
			clasedia.style.display='none';
			evalua.style.display='none'
			material.style.display='none';
			tarea.style.display='none';
			asistencia.style.display='none';
			nota.style.display='none';
        }

		function showContent3(){
		evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
		    evalua.style.display='block'
            grabacion.style.display='none';
			clasedia.style.display='none';
			material.style.display='none';
			tarea.style.display='none';
			asistencia.style.display='none';
			nota.style.display='none';
        }

		function showContent4(){
	    evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
		    material.style.display='block'
		    evalua.style.display='none'
            grabacion.style.display='none';
			clasedia.style.display='none';
			asistencia.style.display='none';
			tarea.style.display='none';
			nota.style.display='none';
        }
		function showContent5(){
		evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
		    asistencia.style.display='block';
		    evalua.style.display='none'
            grabacion.style.display='none';
			clasedia.style.display='none';
			material.style.display='none';
			tarea.style.display='none';
			nota.style.display='none';
        }
		function showContent6(){
		evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
		    tarea.style.display='block'
		    evalua.style.display='none'
            grabacion.style.display='none';
			clasedia.style.display='none';
			asistencia.style.display='none';
			material.style.display='none';
			nota.style.display='none';
        }
		function showContent7(){
		evalua=document.getElementById("evalua");
        clasedia = document.getElementById("clasedia");
        grabacion = document.getElementById("grabacion");
		material=document.getElementById("mat");
		asistencia=document.getElementById("asist");
		tarea=document.getElementById("tar");
		nota=document.getElementById("not");
		    nota.style.display='block'
			tarea.style.display='none'
		    evalua.style.display='none'
            grabacion.style.display='none';
			clasedia.style.display='none';
			asistencia.style.display='none';
			material.style.display='none';
        }
        function handleFiles(files){
         $('#txt').text(files[0].name);  
        }
</script>
<style type="text/css">
.btn1 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #F5F5F5;
    background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6);
    background-repeat: repeat-x;
    border-color: #CCCCCC #CCCCCC #B3B3B3;
    border-image: none;
    border-radius: 4px 4px 4px 4px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #333333;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 0;
    padding: 4px 12px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
}

.btn1:hover, .btn1:focus {
    background-position: 0 -15px;
    color: #333333;
    text-decoration: none;
    transition: background-position 0.1s linear 0s;
}

.fileinput-button {
  position: relative;
  overflow: hidden;
}
.fileinput-button input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  opacity: 0;
  -ms-filter: 'alpha(opacity=0)';
  font-size: 200px;
  direction: ltr;
  cursor: pointer;
}

/* Fixes for IE < 8 */
@media screen\9 {
  .fileinput-button input {
    filter: alpha(opacity=0);
    font-size: 100%;
    height: 100%;
  }
}
</style>
<div class="container-fluid">
	<div class="page-header">
<!--	  <h1 class="text-titles"><i class="zmdi zmdi-layers zmdi-hc-fw"></i> Cursos por Materia</h1>
	
	</div>
	<p class="lead">
	Bienvenido a la sección de Cursos por Materia del estudiante. Acá podrá ver la información de la clase del estudiante registrado en el sistema.

	</p>
	
</div>
-->
<?php 

	require_once "./controllers/videoController.php";
    require_once "./controllers/proyectoController.php";
	$ClasemateriaIns = new videoController();
	$ProyectoIns = new proyectoController();
	//$dateNow=date("Y-m-d H:i:s"); 

	$ClasemateriaIns = new videoController();
	//$dateNow=date("Y-m-d H:i:s"); 
   
      $dateNow=date("Y-m-d");


	if(isset($_POST['procodigo']) && isset($_POST['promateria'])){
		echo $ProyectoIns->add_proyecto_controller();
    }

	$code=explode("/", $_GET['views']);
    //$materia=$code;
	$data=$ClasemateriaIns->data_clasexmateria_controller("Only",$code[1]);
 
		if($data->rowCount()>0):
			$rows=$data->fetch();
           
?>
<p class="text-center">
	<a href="<?php echo SERVERURL; ?>clasemateria/" class="btn btn-info btn-raised btn-sm">
		<i class="zmdi zmdi-long-arrow-return"></i> Volver
	</a>
</p>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-success">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i>Detalle</h3>
				</div>
			  	<div class="panel-body">
				    <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
				    	<fieldset>
				    	<!--	<legend><i class="zmdi zmdi-account-box"></i> 
			
				    	
				    	</legend><br>
				    	-->
				    		<input type="hidden" name="code" value="<?php echo $rows['Codigo']; ?>">
				    		<div class="container-fluid">
				    			<div class="row">
								<div id="materia" class="col-xs-12">
										<div class="form-group label-floating">
										<h1 style="font-family:Georgia;" class="text-titles"><?php echo $rows['materia']; ?></h1>
										  <!--	<label class="control-label">Materia *</label>
										  	<select name="materia" class="form-control">
										  		<option value="<?php //echo $rows['idmateria']; ?>"><?php //echo $rows['materia']; ?></option>	
										  		<?php //foreach($datosMateria as $opciones): ?>            
										  		  <option value="<?php //echo $opciones['idmateria']?>"><?php //echo $opciones['materia']?></option>
										  		<?php //endforeach ?> 									  	    
									        </select>-->
										</div>
				    				</div>
				    			<div class="col-xs-12 col-sm-2">
										   <!--<div class="card-columns">
										   <div class="card">  -->
										   <img src="/CASADEVIDA/Backend/imagenes/<?php echo $rows['fotomaestro']; ?>" height="150" class="card-img-top"> 
										   <!--</div>
										   </div> -->
								</div>
				    			 <div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Maestro </label>
										  	
										  	<select name="codigo" class="form-control" id="codigo" >
										    <option value="<?php echo $rows['idmateria']; ?>"><?php echo $rows['Tutor']; ?></option>			  		
										  	    <?php //foreach($datosAlumnonew as $opciones): ?>            
										  		 <!-- <option value="<?php //echo $opciones['Codigo']?>"><?php //echo $opciones['Nombres']." ".$opciones['Apellidos'];?></option>-->
										  		  <?php //endforeach ?>  						          	
									        </select>
									    
										</div>
				    				</div>	
									</fieldset>	
									<fieldset>	   											    				
                                    <div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">

                                        <ul class="list-unstyled full-box">
                                        <li>
                                        <a href="#!" id="clasehoy" onclick="javascript:showContent1()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Clases En Vivo
                                        </a>
                                        </li>
                                        <li>
                                            <a href="#!" id="grabaciones" onclick="javascript:showContent2()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Grabaciones
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#!" id="material" onclick="javascript:showContent4()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Material de Estudio
                                            </a>
                                        </li>
										<li>
                                            <a href="#!" id="asistencia" onclick="javascript:showContent5()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Asistencia
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#!" id="eval" onclick="javascript:showContent3()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Examen
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#!" id="tarea" onclick="javascript:showContent6()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Talleres
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#!" id="nota" onclick="javascript:showContent7()">
                                                <i class="zmdi zmdi-layers zmdi-hc-fw"></i> Notas
                                            </a>
                                        </li>
                                        </ul>
										  	
									    </div>
				    		        </div>
                                    <div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">

                                        <div class="table-responsive">
										    <!--<table class="table table-bordered table_list" id="dynamic_field">-->
                                          <div id="clasedia" style="display:none;">
                                            <?php
                                                   $materia=$rows['idmateria'];
							                      //$page=explode("/", $_GET['views']);
							                      echo $ClasemateriaIns->pagination_video_now_materia_controller(1,12,$dateNow,$materia);
	                                        ?>
                                            </div>

                                            <div id="grabacion" style="display:none;">
                                            <?php
                                               /* require_once "./controllers/videoController.php";

                                                $insVideo = new videoController();
                                                  //$dateNow=date("Y-m-d");
                                                  $materia=$rows['idmateria'];
							                      //$page=explode("/", $_GET['views']);*/
                                                  $materia=$rows['idmateria'];
                                                  
							                      echo $ClasemateriaIns->pagination_video_grabacion_materia_controller(1,12,$materia);
	                                        ?>
                                            </div>

											<div id="evalua" style="display:none;">
                                            <?php
                                               /* require_once "./controllers/videoController.php";

                                                $insVideo = new videoController();
                                                  //$dateNow=date("Y-m-d");
                                                  $materia=$rows['idmateria'];
							                      //$page=explode("/", $_GET['views']);*/
                                                  $materia=$rows['idmateria'];
                                                  
							                      echo $ClasemateriaIns->pagination_video_evalua_materia_controller(1,10,$materia);
	                                        ?>
                                            </div>
                                            <div id="not" style="display:none;">
                                            <?php $notafinal=($rows['calificacion'] + $rows['calificaciontaller'] + $rows['calificacionactuacion']); ?>
                                            
											<span class="control-label">Examen </span>
										  	<input class="form-control" type="number" name="calificacion" min="0" max="100" step="any" value="<?php echo $rows['calificacion']; ?>" readonly>
										    <span class="control-label">Proyecto Final </span>
										  	<input class="form-control" type="number" name="calificaciontaller" min="0" max="100" step="any" value="<?php echo $rows['calificaciontaller']; ?>" readonly>
										  	<span class="control-label">Medición </span>
										  	<input class="form-control" type="number" name="calificacionactuacion" min="0" max="100" step="any" value="<?php echo $rows['calificacionactuacion']; ?>" readonly>
										    <span class="control-label">Promedio </span>
										  	<input class="form-control" type="number" name="notafinal" min="0" max="100" step="any" value="<?php echo round($notafinal,2); ?>" readonly>
										  	<label for="comentarioclase">Comentario del Maestro</label>
										    <textarea class="form-control" id="comentarioclase" name="comentarioclase" rows="3" readonly><?php echo $rows['comentario']; ?></textarea>
										

                                            </div>
											<div id="mat" style="display:none;">
                                             <h3 class="text-titles text-center"><i class="zmdi zmdi-info"></i> Información de la clase</h3>
												   <?php 
													   echo $rows['Descripcion'];
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
											<div id="asist" style="display:none;">
                                            <?php
                                               /* require_once "./controllers/videoController.php";

                                                $insVideo = new videoController();
                                                  //$dateNow=date("Y-m-d");
                                                  $materia=$rows['idmateria'];
							                      //$page=explode("/", $_GET['views']);*/
                                                  //$materia=$rows['idmateria'];
                                                  
							                      //echo $ClasemateriaIns->pagination_video_evalua_materia_controller(1,10,$materia);
							                      $materia=$rows['idmateria'];
												  $CodigoEstudiante=$rows['Codigo'];
                                                  
							                    echo $ClasemateriaIns->pagination_asistencia_controller(1,20,$materia,$CodigoEstudiante);
	                                        ?>
                                            </div>
											<div id="tar" style="display:none;">
                                            <div class="container-fluid">
				    			            <div class="row">								
												<h3>Envio de Talleres:</h3>
												<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
												
													<span class="btn1 fileinput-button">
															<span>Adjuntar Archivo</span>
															<input id="fileupload" type="file" name="files[]" onchange="handleFiles(this.files)" multiple accept="image/*,.pdf">
													</span>
													<div id="txt"></div>
													</div>
													<div>
													<input id="promateria" type="hidden" name="promateria" value="<?php echo $rows['idmateria']; ?>">
													<input id="procodigo" type="hidden" name="procodigo" value="<?php echo $rows['Codigo']; ?>">
													<input id="procorreo" type="hidden" name="procorreo" value="<?php echo $rows['correo']; ?>">
													<input id="estnombre" type="hidden" name="estnombre" value="<?php echo $rows['Nombres']; ?>">
													<input id="estapellido" type="hidden" name="estapellido" value="<?php echo $rows['Apellidos']; ?>">
													</div>
													<br><br>
													   <p class="text-center">
					    	                                <button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Enviar</button>
					                                   </p>
												</form>
                                                <?php
												 require_once "./controllers/proyectoController.php";
												    $Proyectoins= new proyectoController();
													$materia=$rows['idmateria'];
													$codigoal=$rows['Codigo'];
													//$page=explode("/", $_GET['views']);
										   echo $Proyectoins->pagination_proyecto_controller(1,10,$materia,$codigoal);
												?>
														
											</div>
											</div>	
										    </div>

										  	
									    </div>
				    		        </div>
				    			<!--	<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<span class="control-label">Calificacion </span>
										  	<input class="form-control" type="number" name="calificacion" min="0" max="100" step="any" value="<?php //echo ($rows['calificacion'] + $rows['calificaciontaller'] + $rows['calificacionactuacion'])/3; ?>" readonly>
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">	
										<input type="hidden" name="aprobado" value="0" readonly>						
										<?php
											    //if($rows["aprobado"]==1){ echo '<input type="checkbox" id="aprobo" name="aprobado" value="1" checked readonly>';}else{ echo '<input type="checkbox" id="aprobo" name="aprobado" value="1" readonly>';}
											    
										?>	
										<label for="aprobo">Aprobado</label>						 
										</div>
				    				</div>-->			    						    				
				    			</div>
				    		</div>
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
<?php else: ?>
	<p class="lead text-center">Lo sentimos ocurrió un error inesperado</p>
<?php 
		endif;
	else:
		$logout2 = new loginController();
        echo $logout2->login_session_force_destroy_controller(); 
	endif;
?>