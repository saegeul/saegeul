var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 

DOC.Element.Image = function(oConfig){
    var data = {}, 
        uid = DOC.Util.uid()
        publisher = null, 
        is_editing = false , 
        $dom = null;

    var that = {} ; 


    that.uid = function() {
        return uid;
    };
    /* Element 객체에 필수적으로 필요한 함수들 */ 

    that.html = function(){
        return  "<div>"+that.save()+"</div>"; 
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
        var $photoArea = $('<div class="well">'
                             + '<div id="contentArea" ></div>'
                             + '<div id="slider" class="ui-slider-horizontal ui-slider" style="margin-top:5px;margin-bottom:5px;width:100%;"></div>'
//pargination start
//pagination end
                             + '<div id="selectArea" style="height:130px;background-color:white;border:1px solid black;"></div>'
                             + '<a class="btn btn-large btn-primary append_btn" > APPEND</a>'
                          + '</div>'
                        );
        $photoArea.appendTo($('#document_body')) ;	

	$.ajax({
	       type: "GET",
	       url: "photoform",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=1",
	       error: function() { 
	       	alert("저장된 파일이 없습니다.");
	        },
	       success: function(data){
	    	   var page_count = parseInt(data.pagination.page_count);
	    	   var page = parseInt(data.pagination.page);
	    	   var first_page;
	    	   var last_page;
	    	   var temp
	    	   if(page_count >= 5){
	    		   first_page = page > 3 ? page - 2 : 1;
	    		   last_page = page > 3 ? page + 2 : 5;
	    		   if(last_page > page_count){
	    			   last_page = page_count;
	    			   temp = 5 - (last_page % 5);
	    			   first_page = last_page - (temp + 1);
	    		   }
	    	   }else {
	    		   first_page = page;
	    		   last_page = page_count;
	    	   }
	    	   
	    	   var markup = "<div style='margin-left:28px;'><ul class='thumbnails' style='margin-left: 0px;'>";
	    	   
	    		$.each(data.fileList, function(key,state){
	    			obj = state;
	    			markup += "<li>"
			   			+ "<div align='center' style='height:120px;width:120px;-moz-transition: all 0.2s ease-in-out 0s;border: 1px solid #DDDDDD;border-radius: 4px 4px 4px 4px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);display: block;line-height: 20px;padding: 4px;'>"
		  	   			+ "<img alt='" + obj.file_srl + "' src='" + data.base_url + obj.image_thumb_path + "'>"
		  	   			+ "</div>";
	    		});
	    		
	    		markup += "</ul>"
					+ "<div class='pagination' align='center' style='margin-left:-10px;'>"
					+ "<ul>"
				for(var i=first_page;i<page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "<li class=active><a href=javascript:void(0)>" + page + "</a></li>"
	    		for(var i=(page + 1);i<=last_page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "</ul></div>";
	    		
	 $('#contentArea').html(markup);   		
			}
	
        });
$(".pageBtn").live('click',function() {
	var page = $(this).find('a').attr('id');
	$.ajax({
		type: "GET",
	       url: "photoform",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=" + page,
	       error: function() { 
	       	alert("저장된 파일이 없습니다.");
	        },
	       success: function(data){
	    	   var page_count = parseInt(data.pagination.page_count);
	    	   var page = parseInt(data.pagination.page);
	    	   var first_page;
	    	   var last_page;
	    	   var temp
	    	   if(page_count >= 5){
	    		   first_page = page > 3 ? page - 2 : 1;
	    		   last_page = page > 3 ? page + 2 : 5;
	    		   if(last_page > page_count){
	    			   last_page = page_count;
	    			   if((last_page % 5) != 0){
	    				   temp = parseInt(5 - (last_page % 5));
	    				   first_page = last_page - (temp + 1);
	    			   }else{
	    				   first_page = last_page - 4;
	    			   }
	    		   }
	    	   }else {
	    		   first_page = page;
	    		   last_page = page_count;
	    	   }
	    	   
	    	   var markup = "<div style='margin-left:28px;'><ul class='thumbnails' style='margin-left: 0px;'>";
	    	   
	    		$.each(data.fileList, function(key,state){
	    			obj = state;
	    			markup += "<li>"
			   			+ "<div align='center' style='height:120px;width:120px;-moz-transition: all 0.2s ease-in-out 0s;border: 1px solid #DDDDDD;border-radius: 4px 4px 4px 4px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);display: block;line-height: 20px;padding: 4px;'>"
		  	   			+ "<img alt='" + obj.file_srl + "' src='" + data.base_url + obj.image_thumb_path + "'>"
		  	   			+ "</div>";
	    		});
	    		
	    		markup += "</ul>"
					+ "<div class='pagination' align='center' style='margin-left:-10px;'>"
					+ "<ul>"
				for(var i=first_page;i<page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "<li class=active><a href=javascript:void(0)>" + page + "</a></li>"
	    		for(var i=(page + 1);i<=last_page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "</ul></div>";
	    		
	 $('#contentArea').html(markup);   		
			}
	});
});



       

      //  markup.find('#selectArea').sortable();

/*
        var jsonimage = "photoform";
        var params = {
            from: 1,
            to: 10
        };

        $.getJSON(jsonimage, params, function(data, status) {

        var $sliderStep = (100 - ( 100 % parseInt(data.total_page - 1))) / parseInt(data.total_page - 1);


        imageInsert(0, data, data.page_view);
//        console.log(data);

        $photoArea.find('#slider').slider({
            range: "min",
            animate: true,
            max : 100,
            min : 0,
            step : $sliderStep,
            slide: function( event, ui ) {
                var record = data.page_view * ( ui.value / $sliderStep ) ; 
                $("#contentArea .img-polaroid").remove();
                imageInsert( record, data, data.page_view);
            }
        });

        });
        function imageInsert(start_record, data, page_view )
        {
            for( var i =  start_record , j = 0 ; j < page_view ; j++,i++ )
            //    console.log(file_url);
            {
                if( i == data.total_record ) break;
                $(function()  {
                    $photoArea.find('#contentArea').append('<img class="img-polaroid" src="/saegeul/'+data.result[i].image_thumb_path+'" value="/saegeul/'+data.result[i].full_path+'" style="margin:1px;width:10%;height:100px;">');          
                    $photoArea.find('#contentArea img').draggable({
         //               connectToSortable: "#selectArea",
                        helper: "clone",
                        scope : "tasks",
                        drag: function(event,ui) {
                            ui.helper.css('width','200px');
                            ui.helper.css('height','200px');
                        }
                    });
       //             $photoArea.find('#contentArea img').mouseenter(function() {    });

                });
                start_record++;
            }
        }   


*/
               $photoArea.find('#selectArea').droppable({
            scope: "tasks",
            accept: ".img-polaroid",
            drop: function(event, ui) {
                var $photo = $('<img src="'+ui.draggable.attr("value")+'" class="img img-polaroid"/ >');
                $photo.appendTo('#selectArea').css('width','12%').css('height','120px');
                $photo.click( function() {
                    $('<div>사진 선택을 해제하시겠습니까?</div>').dialog({
                        resizable: false,
                        height:150,
                        modal: true,
                        buttons: {
                            "delete": function() {
                                $photo.remove(); 
                                $( this ).dialog( "close" );
                            },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    });

                });
            }
        });
       // $photoArea.find('#selectArea').sortable();

        $photoArea.find('.append_btn').click(function(){
            var $photo_record = $("#selectArea img"); 
            var $photo_wrap = $('<div id="'+uid+'"class="photo_wrap" style="text-align:center;margin-top:10px;"></div>').appendTo( $('#document_body') );
            var $photo = "";
            
            var $div_width = $('.photo_wrap').css("width");

            var $height = "auto";
            for( var i = 0 ; i < $photo_record.length ; i++ )
            {
                $photo = $("#selectArea img:eq(0)").css("width","auto").css("height",$height).unbind();
                $photo_wrap.append($photo);
                $height = $('#'+uid+' img:eq(0)').css("height");
            }
        $photo_wrap.bind('click',function(){
                $('<div>사진 제거하시겠습니까?</div>').dialog({
                    resizable: false,
                    height:150,
                    modal: true,
                    buttons: {
                        "delete": function() {
                            $photo_wrap.remove(); 
                            $( this ).dialog( "close" );
                        },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                        }
                    }
                });
        });

            $('#contentArea').parents('.well').remove() ; 
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
            $('#contentArea').parents('.well').remove() ; 
        } 

        that.turnOffEditor() ; 
    }; 

    that.turnOnEditor = function(){ 
        //DOC.paper.sortable('off') ; 
        is_editing = true ; 
    }; 

    that.turnOffEditor = function() { 
        //DOC.paper.sortable('on') ; 
        is_editing = false ; 
    }; 

    that.save = function(){
        var value = $('#'+uid).html();
        return value;

    }; 

    that.mouseover = function($el){
        $el.bind('mouseover',function(){ 
            $(this).addClass('highlight').draggable({handle:".handler",revert:true,revertDuration:300,axis:'y'});
	    });

        $el.bind('mouseout',function(){ 
            $(this).removeClass('highlight') ; 
	    });
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
