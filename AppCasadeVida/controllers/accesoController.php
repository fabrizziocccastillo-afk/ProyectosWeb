<?php
if($actionsRequired){
	      require_once "../models/accesoModel.php";
}else{
          require_once "./models/accesoModel.php";   
        }
        
        class accesoController extends accesoModel{
         
           public function show_acceso_controller(){
              
            $nombreArchivo=self::clean_string($_POST['name']);
            $materia=self::clean_string($_POST['materia']);
            $fechadesde=self::clean_string($_POST['fechadesde']);
            $fechahasta=self::clean_string($_POST['fechahasta']);
            $data=[
							"nombreArchivo"=>$nombreArchivo,
							"materia"=>$materia,
							"fechadesde"=>$fechadesde,
							"fechahasta"=>$fechahasta		
						];
               $datosExcel=$datosAcceso->show_acceso_model($data);
               
               return $datosExcel;
           }

        }
?>