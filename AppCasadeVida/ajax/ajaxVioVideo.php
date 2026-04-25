<?php
$actionsRequired=true;
 require_once "../models/videoModel.php";   
$VioVideoModel = new videoModel();
/*if(isset($_POST['pais'])){             
     $id = $_POST['pais'];
     $datosCiudad = $paisModel->update_viovideo_model($id);
     foreach($datosCiudad as $opciones) {        
         echo '<option value="'.$opciones['idciudad'].'">'.$opciones['nombreciudad'].'</option>';
     }          								  		 						  		 
}*/
?>