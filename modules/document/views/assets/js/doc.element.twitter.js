var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 

DOC.Element.Twitter = function(oConfig){
    oConfig = oConfig||{} ; 
    var data = {}, 
        editor = null,
        wrapper_cls = oConfig.wrapper_cls||'alert alert-warning' , 
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
        var $twitter_area = $('<div class="well"><div id="twitter_editor"></div><hr/><a class="btn btn-large btn-primary save_btn" >SAVE </a></div>');

        if(that.is_empty()){
            $twitter_area .appendTo($('#document_body')) ; 
        } else {
            $twitter_area.insertBefore($el) ; 
            $el.remove() ; 
            $el = null ; 
        } 

        var twitEditor = DOC.ListPanel({
            target_id : 'twitter_editor',
            url : base_url+'openapi/twitter_api/search' , 
            greetings : '<div style="height:100px;"><strong>트위터 글을 인용해보세요.</strong><p>트위터 상에 올라온 글들을 인용하고, 발행해보세요. 검색하고 한번의 클릭이면 됩니다. </p></div>',
            //li_css : '',
            item_config :{
                tmpl : '<div class="clearfix"><div style="padding-left:70px;"><div style="margin-left:-70px ;float:left ;"><a href="http://www.twitter.com/{from_user}" target="_blank"><img src="{profile_image_url}"/></a></div><div><p>{text}</p><p>{created_at}</p></div></div></div>', 
                display_fields : [{
                    name : 'text', 
                    data_format : DOC.Util.autolink
                },{
                   name : 'profile_image_url' 
                },{
                   name : 'created_at' 
                },{
                   name : 'from_user' 
                }] ,
                width : 200, 
                height : 200 
            },
            selected_item_config :{
                tmpl : '<div class="clearfix"><div style="padding-left:70px;"><div style="margin-left:-70px ;float:left ;"><a href="http://www.twitter.com/{from_user}" target="_blank"><img src="{profile_image_url}"/></a></div><div><p>{text}</p><p>{created_at}</p></div></div></div>', 
                display_fields : [{
                    name : 'text', 
                    data_format : DOC.Util.autolink
                },{
                   name : 'profile_image_url' 
                },{
                   name : 'created_at' 
                },{
                   name : 'from_user' 
                }] ,
                width : 200, 
                height : 200 
            } 
        }) ; 

        editor = twitEditor ; 


        if(!that.is_empty()){
            twitEditor.setSelectedItems(data.selectedItems) ; 
        }; 

        twitEditor.render() ; 

        $twitter_area.find('.save_btn').click(function(){
            that.offEditor() ; 
            $twitter_area.find('.save_btn').unbind('click'); 
            $twitter_area.remove() ; 
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
