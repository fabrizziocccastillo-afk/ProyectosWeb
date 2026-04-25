<?php
$actionsRequired=true;
require_once "../controllers/inscripcionController.php";
$insInscripcion = new inscripcionController();
//$page[1]=1;

/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/

if(isset($_POST['consulta'])){
    $nombreArchivo= $_POST['consulta'];  
    }else{
        $nombreArchivo='';
    }
    
    if(isset($_POST['numeroPagina'])){
        $numeroPagina = $_POST['numeroPagina'];     
        }else{
            $numeroPagina='';
    }
    
    echo $insInscripcion->pagination_Inscripcion_controller($numeroPagina,10,$nombreArchivo);

?>