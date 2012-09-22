DOC.paper = (function(){
    var document_id ; 
    var elements = [] ; 
    var that = {} ; 

    that.init = function(config){ 
        document_id = config.id||'document_body' ; 
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
            console.log('on') ; 
            $('#'+document_id).sortable() ; 
        }else{
            console.log('off') ; 
            $('#'+document_id).sortable('disable') ; 
        }
    }

    that.offEditor = function(){ //현재 켜져있는 에디터를 꺼라.
        for(i = 0 ; i < elements.length; i++){
            elements[i].offEditor() ; 
        } 
    }; 

    that.add = function(obj){ 
        elements.push(obj) ; 
    }; 

    that.update = function(obj){

    }; 

    that.remove = function(obj){

    }; 

    that.render = function(){

    }; 

    return that ; 
})(); 
