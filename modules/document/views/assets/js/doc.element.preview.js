var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 

DOC.Element.Preview = function(oConfig){
    var data = {}, 
        publisher = null, 
        is_editing = false , 
        $dom = null;

    var that = {} ; 

    that.html = function(){
        return  that.getRawValue(); 
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
        var $preview = $('<div id="preview_dialog" title="미리보기"></div>');
        var $html = $('#document_body').html();
        $preview.appendTo($('#document_body')).html( $html  ) ; 
      //  $( "#preview:ui-dialog" ).dialog( "destroy" );

        $( "#preview_dialog" ).dialog({
            modal: true,
            width: "70%",
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    that.offEditor();
                }
            }
        });

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
            $('#preview_dialog').remove() ; 
        } 

        that.turnOffEditor() ; 
    }; 

    that.turnOnEditor = function(){ 
        //DOC.paper.sortable('off') ; 
        is_editing = true ; 
    }; 

    that.turnOffEditor = function(){
        //DOC.paper.sortable('on') ; 
        is_editing = false ; 
    }; 

    that.editable = function($el){
        $el.find('.textarea').bind('click',function(){ 
            DOC.paper.offEditor() ; 
	        that.editor($el); 
	    });
    }; 

    that.removable = function($el){
        $el.bind('mouseover',function(){ 
            //DOC.paper.offEditor() ; 
	        //that.editor($el); 
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
