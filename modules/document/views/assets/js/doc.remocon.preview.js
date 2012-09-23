DOC.remocon.preview= (function(){
    var status ,
        button_tmpl = '<button class="btn"><i class="icon icon-book"></i> 미리보기</button>',
        button_obj = '' , 
        remocon_panel_body ,
        that = {}  ; 
    
    that.setRemoconBody = function(_remocon_panel_body){
        remocon_panel_body = _remocon_panel_body ;  
    }; 

    that.render = function(){
        button_obj = $(button_tmpl).appendTo($(remocon_panel_body)) ; 
        button_obj.bind('click',function(){
            that.click() ; 
        }); 
    }; 

    that.click = function(){ 
       // alert($('#document_body').html()); 
        DOC.paper.offEditor() ; 
        var preview = DOC.Element.Preview() ; 
        DOC.paper.add(preview) ; 
        preview.editor() ; 
    }; 

    that.trigger = function(){
        that.click() ; 
    };

    return that ; 
})() ;
