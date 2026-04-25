<?php
		if($actionsRequired){
			      require_once "../models/paisModel.php";
		}else{
		          require_once "./models/paisModel.php";   
		        }
		$Username=$_SESSION['userName'];
		$paisModel = new paisModel();
		$datosPais = $paisModel->show_pais_model();
		$datosTorre = $paisModel->show_torre_model();
		$datosCDV = $paisModel->show_casadevida_model();
		$datosrolxTorre= $paisModel->traer_torrexrol_model($Username);
		$datosEstadoCivil = $paisModel->show_estadocivil_model();
		$datosRoles=$paisModel->show_rol_model();
		$datosCargos=$paisModel->show_cargos_model();
		$datosMinisterio=$paisModel->show_ministerios_model();
		$datosIntegrantesCDV=$paisModel->show_integrantesCDV_model($Username);
		$datosrolxCDV= $paisModel->traer_CDVxrol_model($Username);

?>

		
		
        

        


