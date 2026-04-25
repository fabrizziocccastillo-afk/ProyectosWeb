<!--Autor: Miguel Muñoz -->
<?php
$actionsRequired=true;
require_once "../models/paisModel.php";   
$paisModel = new paisModel();
/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; */
//exit();
if(isset($_POST['casavida'])){           
     $id = $_POST['casavida'];
     $usuario = $_POST['usuario'];
     $datosPredicador = $paisModel->show_predicadorxCDV_model($id,$usuario);
     foreach($datosPredicador as $opciones) {        
         echo '<option value="'.$opciones['Codigo'].'">'.$opciones['predicador'].'</option>';
     }          								  		 						  		 
}
?>