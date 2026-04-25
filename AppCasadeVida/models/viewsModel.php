<?php 
	class viewsModel{
		public function get_views_model($views){
			if(
				$views=="home" ||
				$views=="dashboard" ||
				$views=="admin" ||
				$views=="adminlist" ||
				$views=="admininfo" ||
				$views=="account" ||
				$views=="student" ||
				$views=="studentlist" ||
				$views=="studentinfo" ||
				$views=="class" ||
				$views=="classlist" ||
				$views=="classinfo" ||
				$views=="classview" ||
				$views=="videonow" ||
				$views=="videolist" ||
				$views=="search" ||
				$views=="inscripcion" ||
				$views=="inscripcionlist" ||
				$views=="inscripcioninfo" ||
				$views=="excel" ||
				$views=="reporte" ||
				$views=="generar" ||
				$views=="evaluacion" || 
				$views=="evaluacionlist" ||
				$views=="evaluacioninfo" ||
				$views=="evaluacionformulario" ||
				$views=="studentData" ||
				$views=="ROL" || 
				$views=="rollist" ||
				$views=="asignarol" ||
				$views=="rolinfo" ||
				$views=="rolacceso" ||
				$views=="permiso" ||
				$views=="permisolist" ||
				$views=="modulo" ||
				$views=="modulolist" ||
				$views=="usuario" || 
				$views=="usuariolist" || 
				$views=="usuarioinfo" || 
				$views=="integrante" || 
				$views=="integrantelist" || 
				$views=="integranteinfo" || 
				$views=="biblioteca" || 
				$views=="bibliotecalist" || 
				$views=="bibliotecainfo" || 
				$views=="bibliotecadescarga" || 
				$views=="bibliotecaview" ||
				$views=="clasemateria" || 
				$views=="claseacademico" ||
				$views=="clasehistorial" || 
				$views=="materia" || 
				$views=="materialist" ||   
				$views=="materiainfo" ||
				$views=="agenda" ||
				$views=="agendalist" ||
				$views=="agendainfo" ||
                $views=="agendapublicada" ||
				$views=="rubrica" ||
				$views=="rubricalist" ||
				$views=="rubricainfo" ||
                $views=="rubricapublicada" ||
				$views=="asistenciaint" ||
				$views=="asistenciaintlist" ||
				$views=="asistenciaintinfo" ||
				$views=="reporteint" ||
				$views=="reporteintlist" ||
				$views=="seguimientoint" ||
				$views=="seguimientointlist" ||
				$views=="casasdevida" ||
				$views=="casasdevidalist" ||
				$views=="casasdevidainfo" ||
				$views=="torres" ||
				$views=="torreslist" ||
				$views=="torresinfo"



			){
				if(is_file("./views/contents/".$views."-view.php")){
					$contents="./views/contents/".$views."-view.php";
				}else{
					$contents="login";
				}
			}elseif($views=="index"){
				$contents="login";
			}elseif($views=="login"){
				$contents="login";
			}else{
				$contents="login";
			}
			return $contents;
		}
	}