audio= new Audio("/CASADEVIDA/evaluacionformulario/alarma.mp3");
var cont = 0;
var d = new Date();
function Empezar(){
    if(cont<1){
    var mes = d.getMonth() + 1;
    var n =d.getFullYear()+'-'+mes+'-'+d.getDate()+'T'+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    document.getElementById("fechainicioExamen").value=n;
    audio.pause();
    audio.currentTime=0;
    $("#Tiempo").timer('remove');
    $("#Tiempo").timer({
    countdown:true,
    duration:$('#hora').val()+"hora"+$('#minuto').val()+"minuto"+$('#segundo').val()+"segundo",
    callback:function(){
        //Tiempo Termina
        subir_btn = document.getElementById('envia');
        audio.addEventListener('ended',function(){
            subir_btn.click()=true;
            this.currentTime=0;//loop
            this.play();
        },false);
        audio.play();
    },
    format:'%H:%M:%S'
    });
    }
    cont = cont + 1;
}