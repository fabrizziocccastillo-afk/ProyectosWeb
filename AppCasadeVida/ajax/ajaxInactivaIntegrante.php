<?php
$actionsRequired=true;
require_once "../controllers/integranteController.php";
$insIntegrante = new integranteController();
/*echo "<pre>";       
print_r($_POST);
echo "</pre>";
exit();*/
//$Page2=$_POST['pagina'];*/


if(isset($_POST['integranteCode'])):

    echo $insIntegrante->delete_integrante_controller($_POST['integranteCode']);
    //$ruta='<script type="text/javascript">window.location="'.SERVERURL.'"integrantelist/";</script>';
    //echo $ruta;

?>
<script type='text/javascript'>
    window.location='SERVERURL/integrantelist/';
</script>
<?php
 endif;
?>



