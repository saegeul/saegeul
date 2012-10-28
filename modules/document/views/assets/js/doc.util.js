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
};

DOC.Util.autolink = function(str){ 
    var protocol_re = '(https?|ftp|news|telnet|irc|mms)://';
    var domain_re   = '(?:[\\w\\-]+\\.)+(?:[a-z]+)';
    var max_255_re  = '(?:1[0-9]{2}|2[0-4][0-9]|25[0-5]|[1-9]?[0-9])';
    var ip_re       = '(?:'+max_255_re+'\\.){3}'+max_255_re;
    var port_re     = '(?::([0-9]+))?';
    var user_re     = '(?:/~[\\w-]+)?';
    var path_re     = '((?:/[\\w!"$-/:-@]+)*)';
    var hash_re     = '(?:#([\\w!-@]+))?';

    var url_regex = new RegExp('('+protocol_re+'('+domain_re+'|'+ip_re+'|localhost'+')'+port_re+user_re+path_re+hash_re+')', 'ig');

    var content = str ; 

    content = content.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    content = content.replace(url_regex, '<a href="$1" target="_blank">$1</a>');

    return content ; 
}
