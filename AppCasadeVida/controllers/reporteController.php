<?php
	if($actionsRequired){
		require_once "../models/integranteModel.php";
		require_once "../core/configGeneral.php";
	}else{ 
		require_once "./models/integranteModel.php";
		require_once "./core/configGeneral.php";
	}
	

	class reporteController extends integranteModel{

		
		/*----------  Pagination integrante Controller reportes  ----------*/
		public function pagination_integrante_controller($Pagina,$Registros,$cadena,$Username){
			$Pagina=self::clean_string($Pagina);
			$Registros=self::clean_string($Registros);
			$cadena=self::clean_string($cadena);
			$Username=self::clean_string($Username);
            //$Username=$_SESSION['userName'];
			$Pagina = (isset($Pagina) && $Pagina>0) ? floor($Pagina) : 1;
			$Inicio = ($Pagina>0) ? (($Pagina * $Registros)-$Registros) : 0;

            //echo "Hola Controller";
		   if($cadena!=""){ 
				$Datos=self::execute_single_query("SELECT i.*,t.torre,ca.casadevida,c.cargo,cu.Usuario FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username'
				AND (CONCAT(Nombres, ' ', Apellidos) like '%".$cadena."%' 
				or t.torre like '%".$cadena."%' or ca.casadevida like '%".$cadena."%')
				ORDER BY i.idcasadevida ASC LIMIT $Inicio,$Registros");
		    }else{
				$Datos=self::execute_single_query("SELECT i.*,t.torre,ca.casadevida,c.cargo,cu.Usuario FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username'
				ORDER BY i.idcasadevida ASC LIMIT $Inicio,$Registros");
			}

			
			$Datos=$Datos->fetchAll();

			if($cadena!=""){ 

				$Total=self::execute_single_query("SELECT i.*,t.torre,ca.casadevida,c.cargo FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username' AND
				(CONCAT(Nombres, ' ', Apellidos) like '%".$cadena."%' 
				or t.torre like '%".$cadena."%' or ca.casadevida like '%".$cadena."%')
				ORDER BY i.idcasadevida ASC LIMIT $Inicio,$Registros");
   
			}else{
				 
				$Total=self::execute_single_query("SELECT * FROM integrante i 
				INNER JOIN casadevida ca on i.idcasadevida=ca.idcasadevida 
				inner join torre t on i.idtorre=t.idtorre
				INNER JOIN cargo c ON i.idcargo=c.idcargo
				inner join asignacion asg on i.idtorre=asg.idtorre and i.idcasadevida=asg.idcasadevida
				inner join cuenta cu on asg.codigo=cu.Codigo 
				where cu.Usuario='$Username'");
   
			}

			
			$Total=$Total->rowCount();

			$Npaginas=ceil($Total/$Registros);

			$table='
			<table class="table text-center">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Foto</th>
						<th class="text-center">Nombres</th>
						<th class="text-center">Apellidos</th>
						<th class="text-center">Torre</th>
						<th class="text-center">CDV</th>
						<th class="text-center">Cargo</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Ver</th>
						<th class="text-center">Inactivar</th>
					</tr>
				</thead>
				<tbody>
			';
           
			if($Total>=1){
				$nt=$Inicio+1;
				foreach($Datos as $rows){
					if($rows['estado']==1){
                        $estado="Activo";
                    }else{
						$estado="Inactivo";
					}

						 if($rows['foto']<>''){
							 $cadena='<a href="/CASADEVIDA/Backend/imagenes/'.$rows['foto'].'" target="_blank"><img id="myImg" src="/CASADEVIDA/Backend/imagenes/'.$rows['foto'].'" height="100" width=100 ></a>';
						 }else{
							 $cadena='<img id="myImg" src="/CASADEVIDA/Backend/imagenes/USUARIO.png" height="100" width=100 >';
						 }
					$table.='
					<tr>
						<td>'.$nt.'</td>
						<td>'.$cadena.'</td>
						<td>'.$rows['Nombres'].'</td>
						<td>'.$rows['Apellidos'].'</td>
						<td>'.$rows['torre'].'</td>
						<td>'.$rows['casadevida'].'</td>
						<td>'.$rows['cargo'].'</td>
						<td>'.$estado.'</td>
						<td>

							<a href="'.SERVERURL.'integrantelist/1/'.$rows['Codigo'].'/" class="btn btn-danger btn-raised btn-xs">
							<i class="zmdi zmdi-delete"></i>
							</a>
							<form action="" id="del-'.$rows['Codigo'].'" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="integranteCode" value="'.$rows['Codigo'].'">
							</form>
						</td>
					</tr>
					';
					$nt++;
				}
			}else{
				$table.='
				<tr>
					<td colspan="5">No hay registros en el sistema</td>
				</tr>
				';
			}

			$table.='
				</tbody>
			</table>
			';

			if($Total>=1){
				$table.='
					<nav class="text-center full-width">
						<ul class="pagination pagination-sm">
				';

				if($Pagina==1){
					$table.='<li class="disabled"><a>«</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'reporteintegrantelist/'.($Pagina-1).'/">«</a></li>';
				}

				for($i=1; $i <= $Npaginas; $i++){
					if($Pagina == $i){
						$table.='<li class="active"><a href="'.SERVERURL.'integrantelist/'.$i.'/">'.$i.'</a></li>';
					}else{
						$table.='<li><a href="'.SERVERURL.'reporteintegrantelist/'.$i.'/">'.$i.'</a></li>';
					}
				}

				if($Pagina==$Npaginas){
					$table.='<li class="disabled"><a>»</a></li>';
				}else{
					$table.='<li><a href="'.SERVERURL.'reporteintegrantelist/'.($Pagina+1).'/">»</a></li>';
				}

				$table.='
						</ul>
					</nav>
				';
			}
		

			return $table;
		}

