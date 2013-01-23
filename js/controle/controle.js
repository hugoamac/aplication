
$(function(){
    
    if($(".Apagar").length){
        
        $(".Apagar").click(function(){
           
            if(confirm("você tê certeza que deseja apagar este registro?")){
                return true;
            }
            
            return false;
        });
    }
    
    if($(".Form").length){
        $.validator.messages.required = "";
        $(".Form").validate({
            
            onKeyup:false,
            errorContainer:$("p.alerta"),
            invalidHandler: function(e, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var mensagem = errors == 1 ? "Por favor preencha o campo em destaque.":"Os "+errors+" campos abaixo devem ser preenchidos. ";
                 
                    $("p.alerta").html(mensagem).show();
                } else {
                    $("p.alerta").hide();
                }
            }                        
        });
    }
    if($(".data").length){
        
        $(".data").mask("99/99/9999");
        $(".data").datepicker({
            showOn: "button",
            buttonImage: "/images/comuns/icon-calendar.png",
            buttonImageOnly: true,
            dateFormat:'dd/mm/yy'
        });
        $(".data").css({
            'width' :'100px'
           
        });
        
    }
    
})

