

function getDataContadores(){
    $.ajax({
        url:'/CASADEVIDA/ajax/ajaxContadoresDash.php',
        type:"POST",
        data:{
            "action":"contar_casa_de_vida"
        },
        dataType:'json'
    }).done(function(data){
        console.log("data server",data)
    }).fail(function(a,b,c){
        console.log("error",a)
    })
}

$(function(){
    getDataContadores();
})