var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 


DOC.Element.Youtube = function(oConfig){
    oConfig = oConfig||{} ; 
    var data = {}, 
        editor = null,
        wrapper_cls = oConfig.wrapper_cls||'youtube-area' , 
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
        var $editor_area = $('<div class="well"><div id="_youtube_editor"></div><hr/><a class="btn btn-large btn-primary save_btn" >SAVE </a></div>');

        if(that.is_empty()){
            $editor_area .appendTo($('#document_body')) ; 
        } else {
            $editor_area.insertBefore($el) ; 
            $el.remove() ; 
            $el = null ; 
        } 

        var youtubeEditor = DOC.ListPanel({
            target_id : '_youtube_editor',
            url : base_url+'openapi/youtube_api/search' , 
            greetings : '<div style="height:100px;"><strong>유튜브 영상을 검색하세요.</strong><p>내가 필요한 영상을 검색하세요.</p></div>',
            item_config :{
                tmpl : '<div class="clearfix"><div style="padding-left:200px;"><div style="margin-left:-200px;float:left;margin-right:20px;width:200px;"><img style="width:100%;" src="{thumbnail_url}" /> </div><div><h4>{title} </h4><p>{description} </p> </div></div></div>', 
                //item_wrapper_css : 'width:150px;height:150px;overflow:hidden;float:left;margin:10px;',
                display_fields : [{
                    name : 'thumbnail_url' 
                },{
                    name : 'description' 
                },{
                    name : 'title' 
                }] ,
                width : 200 , 
                height : 200 
            },
            selected_item_config :{
                tmpl : '<div class="clearfix"><img src="{thumbnail_url}" /> </div>', 
                //item_wrapper_css : 'width:150px;height:150px;overflow:hidden;float:left;margin:10px;',
                display_fields : [{
                    name : 'thumbnail_url' 
                }] ,
                width : 200, 
                height : 200  
            },
            display_item_config :{
                tmpl : '<div class="clearfix"><div class="img-polaroid" style="width:480px;margin:0 auto;padding:20px;padding-bottom:20px;"><img src="{thumbnail_url}"   /><h6>{title}</h6><div><a target="_blank" href="{youtube_link}">Youtube 바로가기 </a> </div> </div> </div>', 
                //item_wrapper_css : 'width:150px;height:150px;overflow:hidden;float:left;margin:10px;',
                display_fields : [{
                    name : 'thumbnail_url' 
                },{
                    name : 'title' 
                },{
                    name : 'youtube_link' 
                }] ,
                width : 200, 
                height : 200  
            }  
        }) ; 

        editor = youtubeEditor ; 


        if(!that.is_empty()){
            youtubeEditor.setSelectedItems(data.selectedItems) ; 
        }; 

        youtubeEditor.render() ; 

        $editor_area.find('.save_btn').click(function(){
            that.offEditor() ; 
            $editor_area.find('.save_btn').unbind('click'); 
            $editor_area.remove() ; 
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
