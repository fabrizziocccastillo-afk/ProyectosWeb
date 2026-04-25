<!--Autor: Miguel Muñoz -->
<?php
$actionsRequired=true;
 require_once "../models/torreModel.php";   
$torreModel = new torreModel();
if(isset($_POST['torres'])){           
     $id = $_POST['torres'];
     $datosCasadevida = $torreModel->traer_dependencias_torre_model($id);
     foreach($datosCasadevida as $opciones) {        
         echo '<option value="'.$opciones['idcasadevida'].'">'.$opciones['casadevida'].'</option>';
     }          								  		 						  		 
}
?>