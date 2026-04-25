<!--<link rel="stylesheet" href="<?php //echo SERVERURL; ?>views/css/styles.css">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="">
  <!-- Tempusdominus Bootstrap 4 -->
  <!--<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">-->
  <!-- iCheck -->
  <!--<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">-->
  <!-- JQVMap -->
  <!--<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">-->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo SERVERURL; ?>AdminLTE-3.1.0-rc/dist/css/adminlte.min.css">
  <script src="<?php echo SERVERURL; ?>views/js/ajaxContarCdv.js"></script>
  
  <!-- overlayScrollbars -->
  <!--<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">-->
  <!-- Daterange picker -->
  <!--<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">-->
  <!-- summernote -->
  <!--<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">-->
<div class="page-header">
	<h1 class="text-titles"><i class="zmdi zmdi-home"></i> Bienvenido a la Plataforma de <medium><?php echo COMPANY; ?></medium></h1>
</div>
<!--<div class="full-box" style="margin-bottom: 20px;">-->
	<!--<img src="<?php //echo SERVERURL; ?>views/assets/img/banner.png" alt="<?php //echo COMPANY; ?>" class="img-responsive" style="margin:0 auto;">-->
    <!--nuevo dashboard-->
     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                  <h3 id="asisGlob"></h3>
                <p>Asistencia a Reuniones</p>
                <span><h5 id="asisWeek"></h5>Esta semana</span>
              </div>
              <div class="icon">
                <i class="ion-clipboard"></i>
              </div>
             <!--<a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a> -->
              <a id="Mas Detalle" href="<?php echo SERVERURL; ?>asistenciaintlist/"
              class="info">
	  		<i class="zmdi zmdi-format-list-bulleted"></i> Mas Detalle
	  		</a>
            </div>
          </div>
         <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3 id="casaVida"><sup style="font-size: 20px"></sup></h3>

                <p>Casa de Vida</p>
              </div>
              <div class="icon">
                <i class="ion-home"></i>
              </div>
              <a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3 id="formMinisterial"><sup style="font-size: 20px"></sup></h3>

                <p>Formacion Ministerial</p>
              </div>
              <div class="icon">
                <i class="ion-university"></i>
              </div>
              <a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                
                <h3 id="servMinisterio"><sup style="font-size: 20px"></sup></h3>

                <p>Servicio en Ministerios</p>
              </div>
              <div class="icon">
                <i class="ion-settings"></i>
              </div>
              <a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="porBautizar"><sup style="font-size: 20px"></sup></h3>

                <p>Por Bautizar</p>
              </div>
              <div class="icon">
                <i class="ion-waterdrop"></i>
              </div>
              <a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box box bg-dark">
              <div class="inner">
                <h3 id="discipulado"><sup style="font-size: 20px"></sup></h3>

                <p>Discipulado</p>
              </div>
              <div class="icon">
                <i class="ion-android-walk"></i>
              </div>
              <a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="integrantes"></h3>

                <p>Integrantes</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-people"></i>
              </div>
              <!--<a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>-->
               <a id="Mas Detalle" href="<?php echo SERVERURL; ?>integrantelist/"
              class="info">
	  		<i class="zmdi zmdi-format-list-bulleted"></i> Mas Detalle
	  		</a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              
                <h3 id="segui"></h3>

                <p>Seguimientos</p>
              </div>
              <div class="icon">
                <i class="ion-android-call"></i>
              </div>
             <!-- <a href="#" class="small-box-footer">Mas Detalle <i class="fas fa-arrow-circle-right"></i></a>-->
              <a id="Mas Detalle" href="<?php echo SERVERURL; ?>seguimientointlist/"
              class="info">
	  		<i class="zmdi zmdi-format-list-bulleted"></i> Mas Detalle
	  		</a>
            </div>
          </div>
          <!-- ./col -->
        </div>
    <!--Fin de nuevo sdashboard -->
    <br><br>
    <p class="text-muted" ><i class='fas fa-birthday-cake'></i>
    LISTADO DE CUMPLEA&NtildeEROS DEL MES
    <div class="" id="birthDayByMonth">
        
    </div>
   
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
            <div class="container-fluid px-4">
                           
            </main>  
        </div>
    </div> 
</div>

<script>
    const asisGlob = document.getElementById('asisGlob');
    const casaVida = document.getElementById('casaVida');
    const formMinisterial = document.getElementById('formMinisterial');
    const porBautizar = document.getElementById('porBautizar');
    const discipulado = document.getElementById('discipulado');
    const integrantes = document.getElementById('integrantes');
    const asisWeek = document.getElementById('asisWeek');
    const segui = document.getElementById('segui');
    const servMinisterio = document.getElementById('servMinisterio');
    
    $.ajax({
     type: 'GET',  
     url: 'https://iglesiacasadeavivamiento.com/CASADEVIDA/ajax/ajaxDashboard.php',  
     data: {},
     success: function(response){
        
        let respuesta = JSON.parse(response);
        
        asisGlob.innerHTML = respuesta.asisGlob;
        casaVida.innerHTML = respuesta.casasVida;
        formMinisterial.innerHTML = respuesta.formMinisterial;
        
        porBautizar.innerHTML = respuesta.porBautizar;
        discipulado.innerHTML = respuesta.discipulos;
        integrantes.innerHTML = respuesta.integrantes;
        asisWeek.innerHTML = respuesta.asisWk;
        segui.innerHTML = respuesta.seguimiento;
        servMinisterio.innerHTML = respuesta.servMinisterio;    
     }, 
     error: function (error) {
        console.error(error);
     }
    });

    $.ajax({
        type: 'GET',
        url: 'https://iglesiacasadeavivamiento.com/CASADEVIDA/ajax/ajaxBirthDayByMonth.php',
        data: {},

        success: function (response) {
            
            var res = JSON.parse(response);
            
            if (res.length > 0) {

                var data = '';

                for (let i = 0; i < res.length; i++) {
                    
                    let foto = res[i].foto ? res[i].foto : "USUARIO.png";
                    let bornYear = res[i].fechaNacimiento.substring(0, 4);
                    const fecha = new Date();
                    let yearNow = fecha.getFullYear();
                    let edad = parseFloat(yearNow) - parseFloat(bornYear);
                    
                    const opciones = { weekday: 'long', month: 'short', day: 'numeric' };

                    let dateBorn = new Date( res[i].fechaNacimiento).toLocaleDateString('es-EC', opciones);
                     data += '<div class="row">'+
                                '<div class="col-xl-12">'+
                                    '<div class="card mb-1">'+
                                        '<div class="card-header">'+
                                        '</div>'+
                                        '<div class="card-body">'+
                                            '<p>'+res[i].Nombres+' '+res[i].Apellidos+'<br>'+
                                                '<img id="" src="/CASADEVIDA/Backend/imagenes/'+foto+'" alt="usuario" height="75" width="75">'+
                                                ' <i class="fas fa-calendar"> </i> ' + ' Fecha: '+ dateBorn + ' : ' +
                                                ' Esta Cumpliendo '+edad+' años'+
                                            '</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                }

                document.getElementById('birthDayByMonth').innerHTML = data;

            } else {

                var data = '<div class="row">'+
                                '<div class="col-xl-12">'+
                                    '<div class="card mb-1">'+
                                        '<div class="card-header">'+
                                        '</div>'+
                                        '<div class="card-body">'+
                                            '<p>'+
                                                'No hay cumpleaños en este mes ....'+
                                            '</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                document.getElementById('birthDayByMonth').innerHTML = data;

            } 


        },
        error: function (error) {
            console.error(error);
        }
    });
</script>