jQuery(document).on('submit','#form_evaluacion', function(event){
    event.preventDefault();
    //event.stopPropagation();
        jQuery.ajax({
            url: '/CASADEVIDA/ajax/ajaxEvaluacion.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
        })
        .done(function(respuesta){

            console.log(respuesta);
            if(!respuesta.error){
                swal("¡Evaluacion fue Creada!", "La Evaluacion se creo con éxito en el sistema!", "success");
                document.getElementById("form_evaluacion").reset();
                setTimeout(function(){
                    location.reload();
              }, 5000);
            }else{
                swal("¡Ocurrió un error inesperado!", "No hemos podido crear la Evaluacion, por favor intente nuevamente", "error");
            }
        })
        .fail(function(resp){

            console.log(resp.responseText);
            //swal("¡Ocurrió un error inesperado!", "La Evaluacion ya se encuentra creada en la materia seleccionada, por favor elija otra materia", "error");
        })
       
   }); 


/*$( document ).ready(function() {

    /*$('#btnEnviar').on('click',function(){
        $('#form_evaluacion').submit();
        return false;
    });

    $('#form_evaluacion').on('submit',function(event){
        print_r("HOLA");
        event.preventDefault();
        //event.stopImmediatePropagation();
        jQuery.ajax({
            url: '/CASADEVIDA/ajax/ajaxEvaluacion.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),

            success: function(respuesta){

                console.log(respuesta);
                if(!respuesta.error){
                    swal("¡Evaluacion fue Creada!", "La Evaluacion se creo con éxito en el sistema!", "success");
                    document.getElementById("form_evaluacion").reset();
                    setTimeout(function(){
                        location.reload();
                  }, 5000);
                }else{
                    swal("¡Ocurrió un error inesperado!", "No hemos podido crear la Evaluacion, por favor intente nuevamente", "error");
                }
            },
            error: function(resp){
    
                console.log(resp.responseText);
                //swal("¡Ocurrió un error inesperado!", "La Evaluacion ya se encuentra creada en la materia seleccionada, por favor elija otra materia", "error");
            }
        })
        
    });
});*/



   