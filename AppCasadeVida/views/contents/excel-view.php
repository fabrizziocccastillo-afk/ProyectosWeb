<?php
//require_once "./views/contents/reporte-view.php";
echo "<pre>";       
print_r($_POST['var1']);
echo "</pre>"; 
exit();

header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('pragma: no-cache');
header('Expires: 0');
?>
<table>
<tr>
	<th>Usuario</th>
	<th>Alumno</th>
	<th>Materia</th>
	<th>Entrada</th>
	<th>Salida</th>
	<th>Examen Inicio</th>
	<th>Examen Finalizo</th>
	<th>Calificación</th>
</tr>
<?php
$datosExcel = new accesoController();
$datosExcel=$datosExcel->show_acceso_controller();
foreach($datosExcel as $opciones): ?> 
     <tr> 
		  <td><?php echo $opciones['Usuario']?></td>
		  <td><?php echo $opciones['Nombres'].' '.$opciones['Apellidos']?></td>
		  <td><?php echo $opciones['materia']?></td>
		  <td><?php echo $opciones['Fecha']?></td>
		  <td><?php echo $opciones['FechaCierreAcceso']?></td>
		  <td><?php echo $opciones['fechainicioExamen']?></td>
		  <td><?php echo $opciones['fechafinExamen']?></td>
		  <td><?php echo $opciones['calificacion']?></td>
     </tr>
<?php
endforeach
?>
</table>
<?php
  ob_end_flush();
  ob_end_clean();
?>