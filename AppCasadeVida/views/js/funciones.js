$(document).ready(function(){
    var i = 0;
    var j = 0;
    var p = 0;
    /*bandera=false;
    bandera2=false;*/
    $('#add').click(function(){
        i++;
        j=0;
        p++;
        //if(!bandera){
        $('#dynamic_field').append('<tr id="row'+i+'">'+
                                    '<td>'+i+'</td><td><input type="text" name="pregunta[]" placeholder="Ingrese la pregunta" class="form-control"></td>'+
                                    '<td><input class="form-control puntos_list" type="number" name="puntos[]" min="0" max="100" step="0" aria-label="Puntos" data-initial-value="0" value="0" required=""><span aria-hidden="true" class="control-label">Puntos</span></td>'+
                                    '<td colspan="2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'+
                                    '</tr>');

        /*   bandera=true;
        }else{
            bandera=false;
        } */       
    });

    $(document).on('click', '.btn_remove', function(){
        var id = $(this).attr('id');
       if(id!="1"){
           $('#row'+ id).remove();
       } 
    });
    
    $('#add2').click(function(){
        j++;
        //p++;
        //if(!bandera2){
        $('#dynamic_field').append('<tr id="row2'+j+'"><td><input type="radio" name="opcion_'+p+'[]" class="form-control" value="'+j+'"></td>'+
                                    '<td><input type="text" name="respuesta_'+p+'[]" placeholder="Ingrese la respuesta" class="form-control"></td>'+
                                    '<td colspan="2"><button type="button" name="remove2" id="'+j+'" class="btn btn-danger btn_remove2">X</button></td>'+
                                    '</tr>');
        /*    bandera2=true;
        }else{
            bandera2=false;
        } */
    });
    
    $(document).on('click', '.btn_remove2', function (){
        var id = $(this).attr('id');
       $('#row2'+ id).remove();
    });

   // return false;

})   
