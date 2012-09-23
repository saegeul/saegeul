var DOC = DOC || {} ; 
DOC.Element = DOC.Element||{} ; 

DOC.Element.Image = function(oConfig){
    var data = {}, 
        publisher = null, 
        is_editing = false , 
        $dom = null;

    var that = {} ; 


    /* Element 객체에 필수적으로 필요한 함수들 */ 

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
        var $photoArea = $('<div class="well"><div id="contentArea" ></div><div id="slider" class="ui-slider-horizontal ui-slider" style="margin-top:5px;margin-bottom:5px;width:100%;"></div><div id="selectArea" style="height:150px;background-color:white;border:1px solid black;"></div><hr/><a class="btn btn-large btn-primary append_btn" > APPEND</a></div>');
        $photoArea.appendTo($('#document_body')) ;


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
                    $photoArea.find('#contentArea').append('<img class="img-polaroid" src="/saegeul/'+data.result[i].file_url+'" style="margin:1px;width:10%;height:100px;">');          
                    $photoArea.find('#contentArea img').draggable({
                        helper: "clone",
                        scope : "tasks"
                    });

                });
                start_record++;
            }
        }
        $photoArea.find('#selectArea').droppable({
            scope: "tasks",
            accept: ".img-polaroid",
            drop: function(event, ui) {
                $('<img src="'+ui.draggable.attr("src")+'" class="img-polaroid"/ >').appendTo(this).css('width','10%').css('height','140px');
            }
        });

        $photoArea.find('#selectArea').sortable();

        $photoArea.find('.append_btn').click(function(){
            var $photo_record = $("#selectArea img"); 
          //  var $photo_div = $('<div style="background-color:red"></div>');
            var $photo = "";
            for( var i = 0 ; i < $photo_record.length ; i++ )
            {
         //       $photo_record.appendTo( $('#document_body') );
                $photo = $("#selectArea img:eq(0)").css("width","auto").css("height","auto");
                $('<div style="text-align:center;margin-top:10px;"></div>').appendTo( $('#document_body') ).append($photo);


            }
           // alert( $photoElement.length );
           // $photoElement.appendTo( $('#document_body') ) ;
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
           // that.save() ; 
            $('#contentArea').parents('.well').remove() ; 
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

    that.save = function(){ 
        if(that.is_editing()){ 
            var content = tinyMCE.activeEditor.getContent();	

	        if(content != ''){
		        var $el = $('<div class="element"><div class="handler"><a clsss="btn"><i class="icon icon-move"></i>&nbsp;</a></div><div class="textarea">'+content +'</div></div>').insertAfter($('#document_body .well')); 
		        
		        var _data = {
		            value : content 
		        }; 
	
		        that.setData(_data) ; 
	            that.editable($el) ; 
                //that.mouseover($el) ; 
	        } 
        }
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
