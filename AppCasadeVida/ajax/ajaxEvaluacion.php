<?php 
$actionsRequired=true;
require_once "../controllers/evaluacionController.php";
$materia=$_POST['materia'];
$tutor=$_POST['tutor'];
$titulo=$_POST['titulo'];
$notamin=$_POST['notamin'];
$descripcion=$_POST['descripcion'];
$fecha_inicio=$_POST['fecha_inicio'];
$fecha_final=$_POST['fecha_final'];
$h=$_POST['h'];
$m=$_POST['m'];
$s=$_POST['s'];
$estado=1;
$dataEvaluacion=[
    "materia"=>$materia,
    "tutor"=>$tutor,
    "titulo"=>$titulo,
    "notamin"=>$notamin,
    "descripcion"=>$descripcion,
    "fecha_inicio"=>$fecha_inicio,
    "fecha_final"=>$fecha_final,
    "h"=>$h,
    "m"=>$m,
    "s"=>$s,
    "estado"=>$estado							
];
/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/
$pregunta=$_POST['pregunta'];
$puntos=$_POST['puntos'];
if(isset($_POST['opcion_1'])){
$insEvaluacion = new evaluacionController();
$insEvaluacionModel = new evaluacionModel();
$validaEvaluacion=$insEvaluacionModel->execute_single_query("SELECT idevaluacion FROM evaluacion WHERE idmateria=$materia AND estado=$estado");
    if($validaEvaluacion->rowCount()<=0){
        $insEvaluacion->add_evaluacion_model($dataEvaluacion); 
        $query=$insEvaluacionModel->execute_single_query("SELECT max(idevaluacion) as idevaluacion FROM evaluacion WHERE idmateria=$materia AND estado=$estado");
        if($query->rowCount()>0){
            $rows=$query->fetch();
            $idEvaluacion=$rows['idevaluacion'];
                for($i=0; $i<count($pregunta); $i++){
                    $cadena="";
                    $cadena="INSERT INTO preguntas(idevaluacion,pregunta,puntos)values (".$idEvaluacion.",'".$pregunta[$i]."',".$puntos[$i].")";
                    $query1=$insEvaluacionModel->execute_single_query($cadena);
                }
           if($query1){
             $query2=$insEvaluacionModel->execute_single_query("SELECT idpreguntas FROM preguntas WHERE idevaluacion=$idEvaluacion order by idpreguntas ASC");
                            if($query2->rowCount()>0){
                                $rows2=$query2->fetchAll();
                                $key1=0;
                                foreach ($rows2 as $opciones){
                                    $key1=$key1+1;
                                    $key=$opciones['idpreguntas'];
                                    $respuesta=$_POST["respuesta_$key1"];
                                    $opcion=$_POST["opcion_$key1"];
                                    $cadena1="";
                                    $correcta=0;
                                    for($j=0;$j<count($respuesta);$j++){
                                    $correcta=0;
                                        if($opcion[0]==$j+1){
                                            $correcta=1;
                                        }
                                        $cadena1="INSERT INTO respuestas(idevaluacion,idpreguntas,respuesta,correcta)values (".$idEvaluacion.",".$key.",'".$respuesta[$j]."',".$correcta.")"; 
                                        $query3=$insEvaluacionModel->execute_single_query($cadena1);
                                    }
                                }
                            }
                if($query3){
                    unset($_POST);
                    echo json_encode(array('error'=>false));
                }else{
                    echo "error1";
                    echo json_encode(array('error'=>true));
                } 
            }
        }   
    }else{
        echo "error2";
        echo json_encode(array('error'=>true));  
    }
}else{
    echo "error3";
    echo json_encode(array('error'=>true));  
}
?>