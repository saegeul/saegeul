DOC.ListPanel = function(config){
    var url = config.url ,
        uid = DOC.Util.uid(),
        greetings = config.greetings , 
        $header ,
        $footer ,
        $body ,
        item_config = config.item_config , 
        selected_item_config = config.selected_item_config||item_config,
        display_item_config = config.display_item_config||selected_item_config,
        height = config.height || 350,
        width = config.width || '100%' , 
        cpage = config.cpage || 1 , 
        list_count = config.list_count || 10 , 
        req   ,
        items ,
        selected_items = config.selected_items||[]  , 
        search_keyword = '' , 
        target_id = config.target_id ; 

    var that = {}; 

    that.setItems = function(_items){
        items = _items ; 
    };

    that.getItems = function(){
        return items ; 
    }

    req = { 
        xhrCall:function(param){
            
            $.getJSON(url,param ,function(data){
                that.setItems(data.items) ; 

                var items = that.getItems() ; 
                $ul = $body.find('ul') ; 
                $ul.html(''); 
                var item = null ; 
                var field_name  ;  

                for(var i = 0 ; i < items.length ; i++){ 
                    item = items[i] ; 
                    var fields =  item_config.display_fields ;
                    var obj = {} ; 

                    for(var j = 0 ; j <fields.length ;j++){
                        field_name =fields[j].name ; 
                        obj[field_name] = item[field_name] ; 
                        if(fields[j].data_format){
                            obj[field_name] =fields[j].data_format(item[field_name]) ;  
                        }
                    }

                    var html = DOC.Util.printf(item_config.tmpl,obj); 

                    html = '<li style="'+item_config.item_wrapper_css+'" >'+html+'</li>' ; 

                    (function(m){ 
                        $(html).appendTo($body.find('ul')).bind('click',function(){ 
                            that.selectItem(items[m]) ; 
                        }); 
                    })(i) ; 
                } 
            }); 
        },
        next : function(){
            cpage = cpage+1 ; 

            var data = { 
                search_keyword : search_keyword ,
                page : cpage 
            }; 

            req.xhrCall( data ) ;
            return false ; 
        },
        prev : function(){ 
            if(cpage <=1){
                cpage = 1 ;  
            }else{
                cpage = cpage-1 ; 
            }

            var data = { 
                search_keyword : search_keyword ,
                page : cpage 
            };

            req.xhrCall( data ) ; 

            return false ; 
        },
        search : function(){ 
            var data = { 
                search_keyword : search_keyword
            };


            req.xhrCall(data) ; 
            return false ; 
        }
    }

    that.render = function(){
        var $el ; 
        var _width = width == '100%' ? '100%' : width+'px';
        var _height = height+'px'; 
        var _body_height = (height-80)+'px'; 
        
        var header_html =  '<form style="height:30px;"><div class="pull-right"><div class="input-append"><input class="span2 search_keyword" size="20" type="text"/><button class="btn search_btn" type="submit"><i class="icon icon-search"> </i> Search</button></div></div></form>' ; 

        var pagination_html = '<ul class="pager"><li class="previous"><a href="#" class="_prev_btn">&larr; Prev</a></li><li class="next"><a href="#" class="_next_btn">Next &rarr; </a></li> </ul>' ; 

        $el = $('<div id="'+uid+'"  style="border-radius:5px ;background:#fff;padding:10px;border:1px solid #fefefe;"><div style="padding-left:300px;"><div style="margin-left:-300px;width:280px;float:left;margin-top:60px;"><div class="alert alert-block" style="height:300px;overflow:auto;overflow-x:hidden;"><h4>선택된 아이템</h4><div class="selected_items"><ul class="clearfix simple_list"> </ul> </div></div> </div><div>'+header_html+'<div class="_panel_body" style="overflow:auto;height:370px;overflow-x:hidden;"><ul class="clearfix simple_list"><li><div class="alert alert-info" style="height:300px;">'+greetings +'</div></li></ul></div>'+pagination_html+'</div></div></div>') ; 

        $el.appendTo($('#'+target_id)); 

        $body = $el.find('._panel_body') ; 

        that.eventBinding() ; 

        that.renderSelectedItems() ; 
    }; 

    that.renderSelectedItems = function(selected_items){ 
        var selected_items = that.getSelectedItems() ; 
        var length = selected_items.length ; 

        for(var i = 0 ; i < length ; i++){ 
            that.renderSelectedItem(selected_items[i]) ; 
        }
    } ; 

    that.pushItem = function(item){ 
        selected_items.push(item) ; 
    }

    that.selectItem = function(selected_item){
        that.pushItem(selected_item) ; 
        that.renderSelectedItem(selected_item) ; 
    }; 

    that.renderSelectedItem = function(selected_item){
        var item = selected_item , 
            field_name  ,  
            fields =  selected_item_config.display_fields ,
            obj = {} ; 

        for(var j = 0 ; j <fields.length ;j++){
            field_name =fields[j].name ; 
            obj[field_name] = item[field_name] ; 
            if(fields[j].data_format){
                obj[field_name] =fields[j].data_format(item[field_name]) ;  
            }
        }

        var html = DOC.Util.printf(selected_item_config.tmpl,obj); 

        html = '<li style="'+selected_item_config.item_wrapper_css+'" >'+html+'</li>' ; 

        (function(m){ 
         $(html).appendTo($('#'+uid).find('.selected_items ul')).bind('click',function(){ 
             that.selectItem(items[m]) ; 
             }); 
         })(i) ;
    }; 

    that.getContent = function(){

        var item = null ; 
        var field_name  ;  
        var li_html = '' ;  
        for(var i= 0 ; i < selected_items.length ; i++){
            item = selected_items[i] ; 
            var fields =  display_item_config.display_fields ;
            var obj = {} ; 

            for(var j = 0 ; j <fields.length ;j++){
                field_name =fields[j].name ; 
                obj[field_name] = item[field_name] ; 
                if(fields[j].data_format){
                    obj[field_name] =fields[j].data_format(item[field_name]) ;  
                }
            }

            var html = DOC.Util.printf(display_item_config.tmpl,obj); 


            html = '<li style="'+display_item_config.item_wrapper_css+'" >'+html+'</li>' ; 
            li_html = li_html+html ; 
        }

        return '<ul class="simple_list clearfix"> '+li_html+'</ul>' ; 
    }; 

    that.getSelectedItems = function(){
        return selected_items ; 
    }; 

    that.setSelectedItems = function(items){
        selected_items = items ; 
    }

    that.eventBinding = function(){ 

        $('#'+uid).find('form').submit(function(){
                search_keyword = $('#'+uid).find('.search_keyword').val() ; 
                req.search(search_keyword) ; 
                return false ; 
                }); 

        $('#'+uid).find('._prev_btn').click(function(){
                req.prev(); 
                return false ; 
                }); 

        $('#'+uid).find('._next_btn').click(function(){
                req.next(); 
                return false ; 
                }); 
    }; 

    return that ; 
};
