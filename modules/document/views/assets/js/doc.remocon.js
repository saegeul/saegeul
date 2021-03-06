var DOC = DOC||{} ;
DOC.remocon = {} ; 

/* remocon_panel 
 * author : jaehee@saegeul.com
 * description : document의 버튼들을 모아서 컨트롤 하는 객체. 
 * */

DOC.remocon_panel = (function($,global){
    var oConfig = { 
            id : '',
            cls : '',
            remocon_panel_body :  '', 
            css : ''
        } , 
        remocons = [] ; 
    
    var that = {} ; 

    that.init = function(config){
        that.attr('id',config.id) ; 
        that.attr('cls',config.cls) ; 
        that.attr('css',config.css) ; 

        if(config.items){ 
            for(var i = 0 ; i < config.items.length ; i++){
                var o = { 
                    btn_tmpl : config.items[i].btn_tmpl,
                    Element : config.items[i].Element
                } ; 

                that.add(DOC.Remocon(o)) ; 
            }
        }

        
        return that ; 
    }; 


    that.add = function(_remocons){ 
        if(_remocons instanceof Array){
            for(var i = 0 ; i < _remocons.length ; i++){ 
                remocons.push(_remocons[i]); 
            }
        } else if(typeof _remocons == 'object'){ 
            remocons.push(_remocons) ; 
        }
    }; 

    that.attr = function(key,value){
        if(value == undefined){
            return oConfig[key]  ;
        } 
        
        oConfig[key] = value ; 

        return oConfig[key] ; 
    }; 

    that.render = function(){
        var cls = that.attr('cls') ; 
        var id = that.attr('id') ; 
        
        var remocon_body = that.attr('remocon_body') ; 

        if(!remocon_body){
            remocon_panel_body = $('<div class="remocon_panel_body '+cls+'"></div>').appendTo($('#'+id)) ; 
            that.attr('remocon_body',remocon_panel_body); 
        }

        for(var i = 0 ; i < remocons.length ; i++){ 
            remocons[i].setRemoconBody(remocon_panel_body) ; 
            remocons[i].render(); 
        }
    }; 

    return that ; 

})(jQuery,window); 

tinyMCE.init({ 
    mode : "none",
    theme : "advanced",
    skin : "o2k7",
    height:300,
    skin_variant : "black",
    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template", 
    forced_root_block : false,
    force_br_newlines : true,
    force_p_newlines : false,
				 				
            // Theme options
    theme_advanced_buttons1 : "preview,undo,redo,bold,italic,underline,strikethrough,forecolor,backcolor,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,bullist,numlist,outdent,indent,blockquote,search,charmap",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "none",
    theme_advanced_resizing : true
});

DOC.Remocon = function(oConfig){
    var status ,
        button_tmpl = oConfig.btn_tmpl, 
        button_obj = '' , 
        remocon_panel_body ,
        Element = oConfig.Element ; 

    var that = {} ; 

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
        var el = Element() ; 
        DOC.paper.add(el) ; 
        el.editor() ; 
    }; 

    that.trigger = function(){
        that.click() ; 
    }; 

    return that ; 
}; 
