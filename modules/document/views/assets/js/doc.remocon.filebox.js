DOC.remocon.filebox = (function(){
    var status ,
        button_tmpl = '<button class="btn"><i class="icon icon-file"></i>파일</button>',
        button_obj = '' , 
        remocon_panel_body ,
        that = {}  ; 
    
    that.setRemoconBody = function(_remocon_panel_body){
        remocon_panel_body = _remocon_panel_body ;  
    }; 
    that.render = function(){
        button_obj = $(button_tmpl).appendTo($(remocon_panel_body)) ; 
    }; 

    that.bind = function(){

    }; 

    return that ; 
})() ;
