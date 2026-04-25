<?php 
$actionsRequired=true;
require_once "../controllers/evaluacionController.php";
$materia=$_POST['materia'];
$usuario=$_POST['usuario_ev'];
$codigo=$_POST['codigo_ev'];
$fechainicioExamen=$_POST['fechainicioExamen'];
$fechafinExamen=date("Y-m-d\TH:i:s");
$idevaluacion=$_POST['idevaluacion'];
$notamin=$_POST['notamin'];
/*echo "<pre>";       
print_r($_POST);
echo "</pre>"; 
exit();*/
if(isset($_POST["idrespuesta"])){
$insEvaluacionModel = new evaluacionModel();
$validaEvaluacion=$insEvaluacionModel->execute_single_query("SELECT idresultado FROM resultado WHERE codigo='$codigo' and idevaluacion=$idevaluacion");
    if($validaEvaluacion->rowCount()<=0){
            $query=$insEvaluacionModel->execute_single_query("SELECT pre.idpreguntas, res.idrespuesta as idrespuestas, pre.puntos FROM preguntas pre INNER JOIN respuestas res on pre.idpreguntas=res.idpreguntas and pre.idevaluacion=res.idevaluacion WHERE pre.idevaluacion=$idevaluacion and res.correcta=1 order by pre.idpreguntas ASC");
            if($query->rowCount()>0){
                $rows=$query->fetchAll();
                foreach ($rows as $opciones){
                    $key=$opciones['idpreguntas'];
                    $keyCorrecta=$opciones['idrespuestas'];
                    $keyPuntos=$opciones['puntos'];
                    $respuesta=$_POST["idrespuesta"];
                    $opcion=$_POST["opcion_$key"];
                    $cadena="";
                    $correcta=0;
                    $cont=0;
                        for($j=0;$j<count($respuesta);$j++){
                        $correcta=0;
                        $respondio=$respuesta[$j];
                            if($opcion[0]==$respondio){
                            $correcta=$opcion[0];
                            if($keyCorrecta==$respondio){
                                $puntaje=$keyPuntos;
                                $cadena="INSERT INTO resultado(idevaluacion,idpreguntas,codigo,usuario,fechainicioExamen,fechafinExamen,idrespuestas,respondio,puntos)values (".$idevaluacion.",".$key.",'".$codigo."','".$usuario."','".$fechainicioExamen."','".$fechafinExamen."',".$keyCorrecta.",".$respondio.",".$puntaje.")"; 
                            }else{
                                $puntaje=0;
                                $cadena="INSERT INTO resultado(idevaluacion,idpreguntas,codigo,usuario,fechainicioExamen,fechafinExamen,idrespuestas,respondio,puntos)values (".$idevaluacion.",".$key.",'".$codigo."','".$usuario."','".$fechainicioExamen."','".$fechafinExamen."',".$keyCorrecta.",".$respondio.",".$puntaje.")"; 
                            }                        
                               
                                $query1=$insEvaluacionModel->execute_single_query($cadena);

                            }
                        
                        }
                }
                    $calificacion="UPDATE matricula
                    SET calificacion = (SELECT sum(puntos)
                    FROM resultado WHERE codigo='$codigo' and idevaluacion=$idevaluacion),
                    /*,aprobado =(SELECT case when sum(puntos)>=$notamin then 1 else 2 end AS aprobado 
                    FROM resultado 
                    WHERE codigo='$codigo' 
                    and idevaluacion=$idevaluacion),*/
                    fechamodifica='$fechafinExamen'
                    WHERE Codigo='$codigo' and idmateria=$materia";
                    $insEvaluacionModel->execute_single_query($calificacion);
            }
            if($query1){
                unset($_POST);
                echo json_encode(array('error'=>false));
            }else{
                echo json_encode(array('error'=>true));
            } 
        }else{
 
            echo "error1";
         }
}else{

    echo "error2";
}
?>