<!--Autor: Miguel Muñoz -->
<?php
$actionsRequired=true;
require_once "../models/paisModel.php";   
$paisModel = new paisModel();
$table='';
/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/
//$discipulo = $_POST['discipulo'];
//echo $discipulo
//var_dump($_POST);
if(isset($_POST['casavida'])){           
     $id = $_POST['casavida'];
     $usuario = $_POST['usuario'];
     $discipulo = $_POST['discipulo'];
     $datosDiscipulo = $paisModel->show_discipulo_model($id,$usuario,$discipulo);
     foreach($datosDiscipulo as $opciones) { 
         
        if($opciones['foto']<>''){
            $table='<table class="table tablafija"><tr><td>Foto: </td><td><img id="myImg" src="/CASADEVIDA/Backend/imagenes/'.$opciones['foto'].'" height="100" width=100 ></td></tr>';
        }else{
            $table='<table class="table tablafija"><tr><td>Foto: </td><td><img id="myImg" src="/CASADEVIDA/Backend/imagenes/USUARIO.png" height="100" width=100 ></td></tr>';
        }

        $table.='<tr><td>Direccion: </td><td>'.$opciones['direccion'].'</td></tr>'; 
        $table.='<tr><td>Telefono Personal: </td><td>'.$opciones['telefono'].'</td></tr>';  
        $table.='<tr><td>Telefono Trabajo: </td><td>'.$opciones['telTrabajo'].'</td></tr>';  
        $table.='<tr><td>Correo: </td><td>'.$opciones['Email'].'</td></tr></table>';  
     }
    if ($table!=''){
        echo  $table;
    }else{
        $table= '<table class="table"><tr><td>Foto: </td><td></td></tr>';
        $table.='<tr><td>Direccion: </td><td></td></tr>'; 
        $table.='<tr><td>Telefono Personal: </td><td></td></tr>';  
        $table.='<tr><td>Telefono Trabajo: </td><td></td></tr>';  
        $table.='<tr><td>Correo: </td><td></td></tr></table>'; 
        echo  $table;
    }
     
     
}
?>