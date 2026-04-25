<!--Autor: Miguel Muñoz -->
<?php
$actionsRequired=true;
 require_once "../models/paisModel.php";   
$paisModel = new paisModel();
if(isset($_POST['pais'])){             
     $id = $_POST['pais'];
     $datosCiudad = $paisModel->traer_dependencias_model($id);
     foreach($datosCiudad as $opciones) {        
         echo '<option value="'.$opciones['idciudad'].'">'.$opciones['nombreciudad'].'</option>';
     }          								  		 						  		 
}