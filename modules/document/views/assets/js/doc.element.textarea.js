var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 

DOC.Element.Textarea = function(oConfig){
    var data = {}, 
        publisher = null, 
        is_editing = false , 
        $dom = null;

    var that = {} ; 

    that.makePublisher = function(){ 
        var publisher = DOC.publisher() ; 
        for( i in publisher){
            if(publisher.hasOwnProperty(i) && typeof publisher[i] ==="function"){ 
                that[i] = publisher[i] ; 
            }
        } 

        return that ; 
    }; 

    /* Element 객체에 필수적으로 필요한 함수들 */ 
    that.is_dirty = function(){ // 객체가 현재 write가 되었는지 체크 
        return true ; 
    }; 

    that.html = function(){
        return  that.getRawValue(); 
    }; 

    that.is_null = function(){
        return data == null ? null : data ; 
    };

    that.is_empty = function(){ //data is null ?
        if(!data.hasOwnProperty('value')){
            return true ; 
        }

        return false ; 
    }; 

    that.remove = function(){

    }; 

    that.editor = function($el){ 
        that.turnOnEditor() ; 
        var $textarea = $('<div class="well"><div id="textArea"></div><hr/><a class="btn btn-large btn-primary btn-block" >SAVE </a></div>');

        if(that.is_empty()){
            $textarea.appendTo($('#document_body')) ; 
        }else{
            $textarea.insertBefore($el) ; 
            $el.remove() ; 
            $el = null ; 
        } 

        tinyMCE.execCommand('mceAddControl', false, 'textArea');

        if(!that.is_empty()){
            tinyMCE.activeEditor.setContent(that.getRawValue()) ; 
        }; 

        $textarea.find('.btn-block').click(function(){
            that.offEditor() ; 
            $textarea.find('.btn-block').unbind('click'); 
            $textarea.remove() ; 
        });  
    }; 

    that.replaceEditor = function($el){ 
        that.editor($el) ; 
    }; 

    that.is_editing = function(val){
        if(val == null) {
            return is_editing ; 
        }else{ 
            is_editing = val ; 
        }
    };

    that.offEditor = function(){ 
        if(that.is_editing()){
            that.save() ; 
            tinyMCE.execCommand('mceRemoveControl', false, 'textArea');
            $('#textArea').parents('.well').remove() ; 
        } 

        that.turnOffEditor() ; 
    }; 

    that.turnOnEditor = function(){ 
        is_editing = true ; 
    }; 

    that.turnOffEditor = function(){
        is_editing = false ; 
    }; 

    that.save = function(){ 
        if(that.is_editing()){ 
            var content = tinyMCE.activeEditor.getContent();	

	        if(content != ''){
		        var $el = $('<div class="textarea">'+content +'</div>').insertAfter($('#document_body .well')); 
		        
		        var _data = {
		            value : content 
		        }; 
	
		        that.setData(_data) ; 
	            that.editable($el) ; 
	        } 
        }
    }; 

    that.editable = function($el){
        $el.bind('click',function(){ 
            DOC.paper.offEditor() ; 
	        that.editor($el); 
	    });
    }; 

    that.getRawValue = function(){
        return data['value'] ; 
    };

    that.setData = function(_data){
        for(var i in _data){
            if(_data.hasOwnProperty(i)){
                data[i] = _data[i] ; 
            }
        }
    } 

    return that ;
}; 
