<?php
//include('conexion.php');
if($actionsRequired){
  require_once "../core/configGeneral.php";
}else{ 
  require_once "./core/configGeneral.php";
}
if(isset($_POST['Guardar'])){
    $imagen = $_FILES['imagen']['name'];
    $nombre = $_POST['titulo'];
    $codigo = $_POST['code'];

    if(isset($imagen) && $imagen != ""){
        $tipo = $_FILES['imagen']['type'];
        $temp  = $_FILES['imagen']['tmp_name'];

       if( !((strpos($tipo,'gif') || strpos($tipo,'jpeg') || strpos($tipo,'webp')))){
          $_SESSION['mensaje'] = 'solo se permite archivos jpeg, gif, webp';
          $_SESSION['tipo'] = 'danger';
          //header('location:../index.php');
       }else{
         $query=self::connect()->prepare("UPDATE estudiante SET foto='$imagen' where  Codigo=:Codigo");
         $query->bindParam(":Codigo",$codigo);
         $query->execute();
         if($query){
              move_uploaded_file($temp,'imagenes/'.$imagen);   
             $_SESSION['mensaje'] = 'se ha subido correctamente';
             $_SESSION['tipo'] = 'success';
             //header('location:../index.php');
         }else{
             $_SESSION['mensaje'] = 'ocurrio un error en el servidor';
             $_SESSION['tipo'] = 'danger';
         }
       }
    }
}


?>

