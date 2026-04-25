$(buscar_datos());
function buscar_datos(consulta){
  var parametros = {
    "consulta" : consulta,
    "numeroPagina" : $('#pagina').val()
   };
    $.ajax({
        url: '/CASADEVIDA/ajax/ajaxBusqueda.php',
        method: 'POST',
        datatype: 'html', 
        data: parametros, //{consulta: consulta},
    })
    .done(function(respuesta){
      $("#datos").html(respuesta);
       console.log(respuesta);
    })
    .fail(function(){
        console.log("error");
    })   
  }
  $(document).on('keyup','#caja_busqueda', function(){
      var valor = $(this).val();
      if(valor != ""){
        buscar_datos(valor);
      }else{
        buscar_datos();
      }
  });

 