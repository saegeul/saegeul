DOC.remocon.textarea = (function(){
    var status ,
        button_tmpl = '<button class="btn"><i class="icon icon-book"></i> 문단</button>',
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
        DOC.paper.offEditor() ; 
        var textarea = DOC.Element.Textarea() ; 
        DOC.paper.add(textarea) ; 
        textarea.editor() ; 
    }; 

    that.trigger = function(){
        that.click() ; 
    };

    return that ; 
})() ;
