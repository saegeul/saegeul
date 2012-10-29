var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 


DOC.Element.Naver_blog = function(oConfig){
    oConfig = oConfig||{} ; 
    var data = {}, 
        editor = null,
        wrapper_cls = oConfig.wrapper_cls||'alert alert-warning ' , 
        uid = DOC.Util.uid() ,
        publisher = null, 
        is_editing = false , 
        $dom = null;

    var that = {} ; 

    that.uid = function(){
        return uid ; 
    }; 

    that.html = function(){
        return '<div class="'+wrapper_cls+'"><strong>네이버 블로그에서 가져온 글</strong><hr/>'+editor.getContent()+'</div>' ;
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
        var $editor_area = $('<div class="well"><div id="_naver_blog_editor"></div><hr/><a class="btn btn-large btn-primary save_btn" >SAVE </a></div>');

        if(that.is_empty()){
            $editor_area .appendTo($('#document_body')) ; 
        } else {
            $editor_area.insertBefore($el) ; 
            $el.remove() ; 
            $el = null ; 
        } 

        var naver_blogEditor = DOC.ListPanel({
            target_id : '_naver_blog_editor',
            url : base_url+'openapi/naver_api/search' , 
            greetings : '<div style="height:100px;"><strong>네이버 블로그 검색결과를 인용해보세요.</strong><p>검색어를 입력하면 네이버 블로그를 검색할 수 있어요.</p></div>',
            item_config :{
                tmpl : '<div class="clearfix"><div style=""><div><div><a href="{link}" target="_blank">{title}</a></div><p>{description}</p><p style="text-align:right;"><a href="{bloggerlink}" target="_blank"> 출처 : {bloggername}</a></p></div></div></div>', 
                //item_wrapper_css : 'width:150px;height:150px;overflow:hidden;float:left;margin:10px;',
                display_fields : [{
                    name : 'title' 
                },{
                    name : 'link' 
                },{
                    name : 'description' 
                },{
                    name : 'pubDate' 
                },{
                    name : 'bloggername' 
                },{
                    name : 'bloggerlink' 
                }] ,
                width : 200 , 
                height : 200 
            } 
              
        }) ; 

        editor = naver_blogEditor ; 


        if(!that.is_empty()){
            naver_blogEditor.setSelectedItems(data.selectedItems) ; 
        }; 

        naver_blogEditor.render() ; 

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
