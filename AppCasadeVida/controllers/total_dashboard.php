<?php
$actionsRequired=true;
require_once "../controllers/studentController.php";
$insStudent = new studentController();
/*echo "<pre>";       
print_r($_POST);
echo "</pre>";*/ 
//exit();
//$Page2=$_POST['pagina'];*/

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

echo $insStudent->pagination_student_controller($numeroPagina,10,$nombreArchivo);




?>