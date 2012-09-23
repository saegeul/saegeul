DOC.ListPanel = function(config){
    var url = config.url ,
        uid = DOC.Util.uid(),
        $header ,
        $footer ,
        $body ,
        height = config.height || 350,
        width = config.width || '100%' , 
        cpage = config.cpage || 1 , 
        list_count = config.list_count || 10 , 
        req   ,
        search_req = {} , 
        body_obj = {} , 
        template = '<li><p> </p></li>' ; 
        target_id = config.target_id ; 

    var that = {}; 

    req = { 
        xhrCall:function(param){
            $.getJSON(url,{
                
            },function(data){
                var items = data.items ; 
                $ul = $body.find('ul') ; 
                $ul.html(''); 
                for(var i = 0 ; i < items.length ; i++){ 
                    $('<li>asdfaf </li>').appendTo($body.find('ul')); 
                }
            }); 
        },
        next : function(){
            cpage = cpage+1 ; 

            var data = { 
                page : cpage 
            };

            req.xhrCall( 
                data
                ,function(){
                
                }) ;
            return false ; 
        },
        prev : function(){ 
            if(cpage <=1){
                cpage = 1 ;  
            }else{
                cpage = cpage-1 ; 
            }

            var data = { 
                page : cpage 
            };

            req.xhrCall( 
                data
                ,function(){
                
                }) ; 

            return false ; 
        },
        search : function(){ 
            var data = { 
                search_keyword : search_keyword
            };

            req.xhrCall( 
                data
                ,function(){
                
                }) ;
            return false ; 
        }
    }

    that.render = function(){
        var $el ; 
        var _width = width == '100%' ? '100%' : width+'px';
        var _height = height+'px'; 
        var _body_height = (height-80)+'px';
        $el = $('<div style="width:'+_width+';min-height:'+_height+';background:#fff;padding:4px;border:1px solid #ccc;" id="'+uid+'">'+
            '<div class="_list_panel_header" style="background:#f7f7f7;"><form> </form> '+
            '</div>'+
            '<div class="_list_panel_body" style="min-height:'+_body_height+';"> <ul style="padding:0px;margin:0px;list-style:none;"> </ul>'+
            '</div>'+
            '<div class="_list_panel_footer" style="background:#f7f7f7;"> '+
            '</div>'+
          '</div>'
        ).appendTo($('#'+target_id));

        var header ='<div class="control-group">'+
            '<div class="controls">'+
              '<div class="input-append">'+
                '<input class="span2" id="appendedInputButton" size="16" type="text"><button class="btn" type="button"><i class="icon icon-search"></i> Search</button>'+
              '</div>'+
            '</div>'+
          '</div>' ;

        var footer = '<ul class="pager" style="margin:0px;">'+
            '<li class="previous">'+
                '<a  class="_prev_btn">&larr; Prev </a>'+
            '</li>'+
            '<li class="next">'+
                '<a  class="_next_btn">&rarr; Next </a>'+
            '</li>'+ 
        '</ul>' ; 

        $body = $el.find('._list_panel_body');

        $header = $(header).appendTo($el.find('form')); 
        $footer = $(footer).appendTo($el.find("._list_panel_footer")); 
        that.eventBinding() ; 
    }; 

    that.eventBinding = function(){ 
        $('#'+uid).find('.search_btn').click(function(){ 
            search_keyword = $('#'+uid).find('.search_keyword').val() ; 
            req.search(search_keyword) ; 
        }); 

        $('#'+uid).find('._prev_btn').click(function(){
            req.prev(); 
        }); 

        $('#'+uid).find('._next_btn').click(function(){
            req.next(); 
        }); 
    }; 

    return that ; 
};

DOC.TwitListPanel = function(config){
    var url = config.url ,
        uid = DOC.Util.uid(),
        $header ,
        $footer ,
        $body ,
        height = config.height || 350,
        search_keyword = '' ,
        width = config.width || '100%' , 
        cpage = config.cpage || 1 , 
        list_count = config.list_count || 10 , 
        req   ,
        search_req = {} , 
        body_obj = {} , 
        template = '<li><p> </p></li>' ; 
        target_id = config.target_id ; 

    var that = {}; 

    req = { 
        xhrCall : function(param){
            $.getJSON(url+'?callback=?',{
                q : param.search_keyword, 
                page : cpage 
            },function(data){
                var items = data.results ; 
                cpage = data.page ; 
                $ul = $body.find('ul') ; 
                $ul.html(''); 
                for(var i = 0 ; i < items.length ; i++){ 
                    var tmpl = '<li style="padding-left:50px;" class="clearfix"><div style="margin-left:-50px;float:left;"><img src="{profile_image}"/></div><p>{text}</p><a href="http://www.twitter.com/{username}" target="_blank">by {username2}</a></li>';

                    var html = DOC.Util.printf(tmpl,{
                        profile_image : items[i].profile_image_url,
                        username : items[i].from_user,
                        username2 : items[i].from_user,
                        text : items[i].text
                    }); 
                    
                    $(html).appendTo($body.find('ul')).bind('click',function(){
                        $('#selected_twit').append($(this)) ; 
                    }); 
                }
            }); 
        },

        next : function(){
            cpage = cpage+1 ; 

            var data = { 
                page : cpage , 
                search_keyword : search_keyword
            };

            req.xhrCall( data) ;
            return false ; 
        },

        prev : function(){ 
            if(cpage <=1){
                cpage = 1 ;  
            }else{
                cpage = cpage-1 ; 
            }

            var data = { 
                page : cpage ,
                search_keyword : search_keyword
            };

            req.xhrCall( data) ;
            return false ; 
        },

        search : function(){
            var data = { 
                search_keyword : search_keyword ,
                page : cpage
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
        $el = $('<div style="width:'+_width+';min-height:'+_height+';background:#fff;padding:4px;border:1px solid #ccc;" id="'+uid+'">'+
            '<div class="_list_panel_header" style="background:#f7f7f7;"><form> </form> '+
            '</div>'+
            '<div class="_list_panel_body" style="min-height:'+_body_height+';"> <ul style="padding:0px;margin:0px;list-style:none;"> </ul>'+
            '</div>'+
            '<div class="_list_panel_footer" style="background:#f7f7f7;"> '+
            '</div>'+
          '</div>'
        ).appendTo($('#'+target_id));

        var header ='<div class="control-group">'+
            '<div class="controls">'+
              '<div class="input-append">'+
                '<input class="span2" id="search_keyword" size="16" type="text" class="search_keyword"><button class="btn search_btn" type="button"><i class="icon icon-search"></i> Search</button>'+
              '</div>'+
            '</div>'+
          '</div>' ;

        var footer = '<ul class="pager" style="margin:0px;">'+
            '<li class="previous">'+
                '<a  class="_prev_btn">&larr; Prev </a>'+
            '</li>'+
            '<li class="next">'+
                '<a  class="_next_btn">&rarr; Next </a>'+
            '</li>'+ 
        '</ul>' ; 

        $body = $el.find('._list_panel_body');

        $header = $(header).appendTo($el.find('form')); 
        $footer = $(footer).appendTo($el.find("._list_panel_footer")); 
        that.eventBinding() ; 
    }; 

    that.eventBinding = function(){ 
        $('#'+uid).find('.search_btn').click(function(){ 
            search_keyword = $('#search_keyword').val() ; 
            alert(search_keyword); 

            req.search(search_keyword) ; 
        }); 

        $('#'+uid).find('._prev_btn').click(function(){
            req.prev(); 
        }); 

        $('#'+uid).find('._next_btn').click(function(){
            req.next(); 
        }); 
    }; 

    return that ; 
};
