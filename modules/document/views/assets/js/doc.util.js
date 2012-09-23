var DOC = DOC || {} ; 
DOC.Util = DOC.Util||{} ; 

DOC.Util.uid = function(){
    var s4 = function(){
        return (((1+Math.random()) * 0x10000) | 0).toString(16).substring(1) ; 
    };

    return (s4()+s4()+'-'+s4()+'-'+s4()+'-'+s4()+'-'+s4()+s4()+s4()) ; 
}; 

DOC.Util.printf = function(str,oParam){ 
    $.each(oParam,function(key,val){ 
        str = str.replace('{'+key+'}',val) ;  
    }); 
    return str ; 
}
