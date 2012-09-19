var DOC = DOC || {} ; 
DOC.Publisher = function(){
    var subscribers : {
        any : [] 
    }; 

    var that = {} ; 

    that.on : function(type,fn,context){
        type = type || 'any' ; 
        fn = typeof fn === "function" ? fn : context[fn] ; 

        if(typeof subscribers[type] === "undefined"){ 
            subscribers[type] = [] ; 
        }

        subscribers[type].push({ fn:fn, context:context||this }) ;
    };

    that.off : function(type,fn,context){ 
        that.visitSubscribers('unsubscribe',type, fn, context) ; 
    };

    that.fire : function(type,publication){
        that.visitSubscribers('publish',type, fn, context) ; 
    }; 

    that.visitSubscribers: function(action, type, arg, context){
        var pubtype = type || 'any', 
            observer = subscribers[pubtype],
            i,
            max = observer ? observer.length : 0 ; 

        for(i = 0 ; i < max ; i+=1){ 
            if(action == 'publish'){
                observer[i].fn.call(observer[i].context, arg) ;
            } else {
                if(observer[i].fn === arg && observer[i].context === context){ 
                    observer.splice(i,1) ; 
                } 
            } 
        } 
    }; 

    return that ; 
}; 

