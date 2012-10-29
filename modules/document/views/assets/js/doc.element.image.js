var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 


DOC.Element.Image = function(oConfig){
    oConfig = oConfig||{} ; 
    var data = {}, 
        editor = null,
        wrapper_cls = oConfig.wrapper_cls||'image-area' , 
        uid = DOC.Util.uid() ,
        publisher = null, 
        is_editing = false , 
        $dom = null;

    var that = {} ; 

    that.uid = function(){
        return uid ; 
    }; 

    that.html = function(){
        return '<div class="'+wrapper_cls+'">'+editor.getContent()+'</div>' ;
    }; 

    that.is_empty = function(){ //data is null ?
        if(!data.selectedItems){
            return true ; 
        } 
        return false ; 
    }; 

    that.remove = function(){

    };

    that.editor = function($el){ 
        that.turnOnEditor() ; 
        var $image_area = $('<div class="well"><div id="_image_editor"></div><hr/><a class="btn btn-large btn-primary save_btn" >SAVE </a></div>');

        if(that.is_empty()){
            $image_area .appendTo($('#document_body')) ; 
        } else {
            $image_area.insertBefore($el) ; 
            $el.remove() ; 
            $el = null ; 
        } 

        var imageEditor = DOC.ListPanel({
            target_id : '_image_editor',
            url : base_url+'admin/filebox/getImageList' , 
            greetings : '<div style="height:100px;"><strong>이미지를 검색하세요.</strong><p>이미지를 검색하세요.</p></div>',
            item_config :{
                tmpl : '<div class="clearfix"><img src="'+base_url+'{thumbnail_url}" alt="{original_file_name}"/> </div>', 
                item_wrapper_css : 'width:150px;height:150px;overflow:hidden;float:left;margin:10px;',
                display_fields : [{
                    name : 'full_path'
                },{
                    name : 'thumbnail_url' 
                },{
                    name : 'original_file_name'    
                }] ,
                width : 200, 
                height : 200 
            },
            selected_item_config :{
                tmpl : '<div class="clearfix"><img src="'+base_url+'{thumbnail_url}" alt="{original_file_name}"/> </div>', 
                item_wrapper_css : '',
                display_fields : [{
                    name : 'full_path'
                },{
                    name : 'thumbnail_url' 
                },{
                    name : 'original_file_name'    
                }] ,
                width : 200, 
                height : 200 
            },
            display_item_config :{
                tmpl : '<div class="clearfix"><img src="'+base_url+'{large_thumbnail_url}" original_path="'+base_url+'{full_path}" class="img-polaroid" alt="{original_file_name}"/> </div>', 
                item_wrapper_css : '',
                display_fields : [{
                    name : 'full_path'
                },{
                    name : 'large_thumbnail_url' 
                },{
                    name : 'original_file_name'    
                }] ,
                width : 200, 
                height : 200 
            }  
        }) ; 

        editor = imageEditor ; 


        if(!that.is_empty()){
            imageEditor.setSelectedItems(data.selectedItems) ; 
        }; 

        imageEditor.render() ; 

        $image_area.find('.save_btn').click(function(){
            that.offEditor() ; 
            $image_area.find('.save_btn').unbind('click'); 
            $image_area.remove() ; 
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
            that.save() ; 
            $('#twitter_editor').parents('.well').remove() ; 
        } 

        that.turnOffEditor() ; 
    }; 

    that.turnOnEditor = function(){ 
        DOC.paper.sortable('off') ; 
        is_editing = true ; 
    }; 

    that.turnOffEditor = function(){
        DOC.paper.sortable('on') ; 
        is_editing = false ; 
    }; 

    that.setSelectedItems = function(items){
        selected_items = items ; 
    }; 

    that.save = function(){ 
        if(that.is_editing()){ 
            var content = editor.getContent() ; 

	        if(content != ''){
		        var $el = $('<div class="element"' +' id="'+uid+'"><div class="handler"><a clsss="btn"><i class="icon icon-move"></i>&nbsp;</a></div><div class="_editable">'+that.html() +'</div></div>').insertAfter($('#document_body .well')); 
                that.setSelectedItems(editor.getSelectedItems()) ;
		        
		        var _data = {
		            value : content ,
                    selectedItems :editor.getSelectedItems() 
		        }; 
	
		        that.setData(_data) ; 
	            that.editable($el) ; 
                that.mouseover($el) ; 
	        } 
        }
    }; 

    that.mouseover = function($el){
        $el.bind('mouseover',function(){ 
            $(this).addClass('highlight') ;
	    });

        $el.bind('mouseout',function(){ 
            $(this).removeClass('highlight') ; 
	    });
    };

    that.editable = function($el){
        $el.find('._editable').bind('click',function(){ 
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
