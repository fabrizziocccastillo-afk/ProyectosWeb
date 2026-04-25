<?php 
$actionsRequired=true;
require_once "../controllers/contadorController.php";
$action=$_POST['action'];
if(isset($_POST["action"])){
$insEvaluacionModel = new contadorDashModel();
$validaEvaluacion=$insEvaluacionModel->contadores($action);
echo  json_encode($validaEvaluacion);
}else{
    $data=array();
    $data["error"]="error1";
    echo  json_encode($data);
}
?>