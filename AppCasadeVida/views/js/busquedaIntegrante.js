$(buscar_datosInt());
function buscar_datosInt(consulta){
  var parametros = {
    "consulta" : consulta,
    "numeroPagina" : $('#paginaIntegrante').val(),
    "usuario" : $('#usuarioInt').val()
   };
    $.ajax({
        url: '/CASADEVIDA/ajax/ajaxBusquedaIntegrante.php',
        method: 'POST',
        datatype: 'html', 
        data: parametros, //{consulta: consulta},
    })
    .done(function(respuesta){
      $("#datosIntegrante").html(respuesta);
       console.log(respuesta);
    })
    .fail(function(){
        console.log("error");
    })   
  }
  $(document).on('keyup','#caja_busquedaIntegrante', function(){
      var valor = $(this).val();
      if(valor != ""){
        buscar_datosInt(valor);
      }else{
        buscar_datosInt();
      }
  });

 