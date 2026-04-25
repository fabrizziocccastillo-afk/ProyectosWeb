$.ajax({
            url:window.location.pathname,
            type:"POST",
            dataType:"json",
            data:{
                action:"totales"
            }
        
        }).done(function(data){
            console.log(data)
        }).fail(function(){
            alert("Fail")
        
        )
        
        }

    )