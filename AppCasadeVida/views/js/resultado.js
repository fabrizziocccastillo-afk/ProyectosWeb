jQuery(document).on('submit','#form_resultado', function(event){
    event.preventDefault();
        jQuery.ajax({
            url: '/CASADEVIDA/ajax/ajaxResultado.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
        })
        .done(function(respuesta){

            console.log(respuesta);
            if(!respuesta.error){
                swal("¡Su Evaluación fue Enviada!", "La Evaluacion se creo con éxito en el sistema!", "success");
                document.getElementById("form_resultado").reset();
                setTimeout(function(){
                      location.reload();
                }, 5000);
            }else{
                swal("¡Ocurrió un error inesperado!", "No hemos podido crear su Evaluacion, por favor intente nuevamente", "error");
            }
        })
        .fail(function(resp){

            console.log(resp.responseText);
            if(resp.responseText){
                swal("¡Ocurrió un cierre inesperado!", "Comuniquese con el Administrador del sistema", "error");
                document.getElementById("form_resultado").reset();
                setTimeout(function(){
                      location.reload();
                }, 5000);
            }
        })
        /*.always(function(r){
            console.log("complete");
        })*/
   }); 