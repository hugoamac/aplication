$(function(){
    
    $(".add").live("click",function(){
        var div = $("#transacoes");
        var p = $("<p/>");
        var input = $("<input/>",{            
            'type':'text',
            'name':'transacao[]',
            'style':'margin-top:5px',            
        });        
        var link_add = $("<a/>",{            
            'href':'javascript:void(0)',
            'class':'add'            
        }).append('<img src="/images/comuns/add.png" width="25" border="0" style="vertical-align:middle"/>');        
        var link_remove = $("<a/>",{            
            'href':'javascript:void(0)',
            'class':'remove'
        }).append('<img src="/images/comuns/remove.png" width="25" border="0" style="vertical-align:middle"/>');        
        p.append(input);
        p.append(link_add);
        p.append(link_remove);        
        div.append(p);                
    });
    
    $(".remove").live("click",function(){
        
        var self = $(this);
        var p = self.parent("p");
        if($("input[type=hidden]",p).length){            
            var id=$("input[type=hidden]",p).val();            
            $.ajax({                
                url:'processa_ajax.php',
                type:'post',
                data:{
                    'sOP':'ApagarTransacao',
                    'id':id
                },
                dataType:'json',
                success:function(data){                    
                    //console.log(data);
                }
            })
        }
        p.remove();        
    });   
});


