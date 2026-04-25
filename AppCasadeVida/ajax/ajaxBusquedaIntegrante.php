<?php
$actionsRequired=true;
require_once "../controllers/integranteController.php";
$insIntegrante = new integranteController();
/*echo "<pre>";       
print_r($_POST);
echo "</pre>";
exit();*/
//$Page2=$_POST['pagina'];*/
$Username='';
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


if(isset($_POST['usuario'])){
    $Username=$_POST['usuario'];
}

 
echo $insIntegrante->pagination_integrante_controller($numeroPagina,25,$nombreArchivo,$Username);

?>