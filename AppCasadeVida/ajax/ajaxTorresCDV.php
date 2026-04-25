<!--Autor: Miguel Muñoz -->
<?php
$actionsRequired=true;
 require_once "../models/torreModel.php";   
$torreModel = new torreModel();
/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/
if(isset($_POST['torres'])){           
     $id = $_POST['torres'];
     $usuario = $_POST['usuario'];
     $datosCasadevida = $torreModel->traer_torre_CDV_model($id,$usuario);
     foreach($datosCasadevida as $opciones) {        
         echo '<option value="'.$opciones['idcasadevida'].'">'.$opciones['casadevida'].'</option>';
     }          								  		 						  		 
}
?>