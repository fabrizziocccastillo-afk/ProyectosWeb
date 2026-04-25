$(buscar_datosI());
function buscar_datosI(consulta){
  var parametros = {
    "consulta" : consulta,
    "numeroPagina" : $('#pagina2').val()
   };
    $.ajax({
        url: '/CASADEVIDA/ajax/ajaxBusquedaInscripcion.php',
        method: 'POST',
        datatype: 'html', 
        data: parametros, //{consulta: consulta},
    })
    .done(function(respuesta){
      $("#datosI").html(respuesta);   
       console.log(respuesta);
    })
    .fail(function(){
        console.log("error");
    })   
  }
  $(document).on('keyup','#caja_busquedaI', function(){
      var valor = $(this).val();
      if(valor != ""){
        buscar_datosI(valor);
      }else{
        buscar_datosI();
      }
  });