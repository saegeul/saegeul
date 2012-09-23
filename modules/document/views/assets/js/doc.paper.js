DOC.paper = (function(){
    var document_id ; 
    var elements = [] ; 
    var that = {} ; 

    that.init = function(config){ 
        document_id = config.id||'document_body' ; 
    }; 

    that.getPaperId = function(){
        return document_id ; 
    }; 

    that.getElementPosition = function(id){
        for(i = 0 ; i < elements.length; i++){
            if(elements[i].uid() == id){ 
                return i ; 
            } 
        }

        return -1 ; 
    }; 

    that.popById = function(id){
        var position  = that.getElementPosition(id) ;
        var popEl = null ; 

        if(position != -1){ 
            popEl = elements[position] ; 
            elements.splice(position,1); 
        } 

        return popEl ; 
    }; 

    that.getElementById = function(id){
        for(i = 0 ; i < elements.length; i++){
            if(elements[i].uid() == id){ 
                return elements[i] ; 
            } 
        }

        return null ; 
    }; 
        
    that.getElement = function(obj){
        for(i = 0 ; i < elements.length; i++){
            if(obj.equal(elements[i])){ 
                return elements[i] ; 
            } 
        } 

        return null; 
    };

    that.sortable = function(turnon){
        if(turnon == 'on'){
            $('#'+document_id).sortable('enable') ; 
        }else if(turnon =='off'){
            $('#'+document_id).sortable('disable') ; 
        }else{ 
            $('#'+document_id).sortable({ 
                update : function(e,ui){ 
                    var $element =$(e.srcElement).parents('.element') ;
                    var el_id = $element.attr('id') ; 
                    var a = that.popById(el_id); 
                    var index = $('#document_body .element').index($element) ;
                    that.add(a,index); 
                }
            }) ; 
        }
    };

    that.reArrange = function(){

    }; 

    that.offEditor = function(){ //현재 켜져있는 에디터를 꺼라.
        for(i = 0 ; i < elements.length; i++){
            elements[i].offEditor() ; 
        } 
    }; 

    that.html = function(){ 
        var html = '' ; 
        for(i = 0 ; i < elements.length; i++){
            html = html+elements[i].html() ; 
        } 

        return html ; 
    }; 

    that.add = function(obj,position){ 
        if(position == null){
            elements.push(obj) ; 
        } else {
            elements.splice(position,0,obj) ; 
        } 
    }; 

    that.debug = function(){
        for(var i = 0 ; i < elements.length ; i++){ 
            console.log(elements[i].uid());   
        }
    };

    that.update = function(obj){

    }; 

    that.remove = function(obj){

    }; 

    that.render = function(){

    }; 

    return that ; 
})(); 
