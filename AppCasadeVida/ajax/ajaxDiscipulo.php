<!--Autor: Miguel Muñoz -->
<?php
$actionsRequired=true;
require_once "../models/paisModel.php";   
$paisModel = new paisModel();
/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/
if(isset($_POST['casavida'])){           
     $id = $_POST['casavida'];
     $usuario = $_POST['usuario'];
     //$discipulo = $_POST['discipulo'];
     $datosPredicador = $paisModel->show_discipuloList_model($id,$usuario);
     echo '<option value="">-- Seleccione Persona --</option>';
     foreach($datosPredicador as $opciones) {        
         echo '<option value="'.$opciones['Codigo'].'">'.$opciones['discipulo'].'</option>';
     } 
     
}
?>