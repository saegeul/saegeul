DOC.paper = (function(){

    var elements = [] ;

    var that = {} ; 
        
    that.getElement = function(obj){
        for(i = 0 ; i < elements.length; i++){
            if(obj.equal(elements[i])){ 
                return elements[i] ; 
            } 
        } 

        return null; 
    };

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
