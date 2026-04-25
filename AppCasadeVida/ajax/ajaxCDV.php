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
     $datosCDV = $paisModel->show_integrantesCDV_model2($id,$usuario);
     //foreach($datosCDV as $opciones) {  
         
        $table='
        <table class="table text-center">
        <thead>
            <th class="text-center">#</th>
            <th class="text-center">Nombres </th>
            <th class="text-center">Cargo </th>
            <th class="text-center">Asistió CDV</th>
            <th class="text-center">Asistió Martes </th>
            <th class="text-center">Asistió Domingo </th>
            <th class="text-center">Invito </th>
            <th class="text-center">Vinieron </th>
        </thead>
        <tbody>
			';

            $Inicio=0;
            $nt=$Inicio+1;
            foreach($datosCDV as $opciones){

                $table.='
              <tr>
                  <td><?php echo $nt; ?></td>   
                  <td>'.$opciones['nombres'].'
                      <input  type="hidden" name="codintegrante[]" id="codintegrante[]" value="'.$opciones['Codigo'].'>">
                 </td>
                  <td>'.$opciones['cargo'].'<input  type="hidden"  name="codcargo[]" id="codcargo[]" value="'.$opciones['idcargo'].'">
                 </td>
                  <td>
                      <select name="asistio[]" class="" id="asistio[]" >
                      <option value="Si">Si</option>
                      <option value="No">No</option>
                      </select>
                  </td>
                  <td>
                      <input type="checkbox" name="martes[]" value="'.$nt.'">
                  </td>
                  <td> 
                      <input type="checkbox" name="domingo[]" value="'.$nt.'">   
                  </td>
                  <td>    
                       <input type="number" class="" name="invito[]" id="invito[]" placeholder="# Invitados" value="0">
                  </td>
                  <td>    
                        <input type="number" class="" name="vinieron[]" id="vinieron[]" placeholder="# Vinieron" value="0">
                  </td>
              </tr> 
         <?php'; 
                  $nt++;
            }
                   
            $table.='</tbody>
                    </table>';

     //}   
     
     echo $table;
}
?>