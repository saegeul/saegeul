$(document).ready(function(){
    var $numImage ;
    var $imageSrl = 1;
    var $totalImage;
    var $divWidthSize = parseInt( $( '#myCarousel' ).innerWidth() ); 
    var $divHeightSize = parseInt( $( '#myCarousel' ).innerHeight() ); 
    $.ajax({
        type: "GET",
            url: "gallery/getPhoto",
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            data: "page=1",
            error: function() { 
                alert("저장된 파일이 없습니다.");
            },
                success: function(data){
                    var markup = "";
                    $.each(data.fileList, function(key,state){
                        obj = state;
                        var marginLeft =( parseInt($divWidthSize) - obj.image_width ) / 2;
                        var marginTop = ( parseInt($divHeightSize) - obj.image_height) /2;
                        if( marginTop < 0 ) { marginTop = 0 };
                        if( marginLeft< 0 ) { marginLeft = 0 };
                        if( obj.image_width > $divWidthSize ) {
                            var width = $divWidthSize; 
                        } else {
                            var width = obj.image_width;
                        }

                        if(obj.image_height > $divHeightSize ) {
                            var height = $divHeightSize-10;
                        } else {
                            var height = obj.image_height;
                        }
                        if(markup == "" ) {
                            markup = "<div class='active item' value='"+$imageSrl+"' ><img src='" + data.base_url + obj.full_path + "' style='height:"+height+"px;width:"+ width +"px;margin-left:"+ marginLeft +"px;margin-top:"+ marginTop +"px' /></div>";
                        } else {
                            markup = "<div class='item' value='"+$imageSrl+"' ><img src='" + data.base_url + obj.full_path + "' style='height:"+height+"px;width:"+ width +"px;margin-left:"+ marginLeft +"px;margin-top:"+ marginTop +"px' /></div>";
                        }
                        $imageSrl++;
                        $('.carousel-inner').append(markup);   		
                    });
                        $totalImage = data.pagination.total_rows;
                        $numImage = $('.carousel-inner > div').length;
                }
    });

    $('.right').click(function() {
        if( ($numImage -  $('.carousel-inner').find('.active').attr('value') ) == 4 ) {
            $.ajax({
                type: "GET",
                    url: "gallery/getPhoto",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json", 
                    data: "page="+($numImage/10+1),
                    error: function() { 
                        alert("저장된 파일이 없습니다.");
                    },
                        success: function(data){
                            var markup = "";
                            $.each(data.fileList, function(key,state){
                                obj = state;
                                var marginLeft =( parseInt($divWidthSize) - obj.image_width ) / 2;
                                var marginTop = ( parseInt($divHeightSize) - obj.image_height) /2;
                                if( marginTop < 0 ) { marginTop = 0 };
                                if( marginLeft< 0 ) { marginLeft = 0 };
                                if( obj.image_width > $divWidthSize ) {
                                    var width = $divWidthSize; 
                                } else {
                                    var width = obj.image_width;
                                }

                                if(obj.image_height > $divHeightSize ) {
                                    var height = $divHeightSize -10;
                                } else {
                                    var height = obj.image_height;
                                }
                                markup = "<div class='item' value='"+$imageSrl+"' ><img src='" + data.base_url + obj.full_path + "' style='height:"+height+"px;width:"+ width +"px;margin-left:"+ marginLeft +"px;margin-top:"+ marginTop +"px' /></div>";
                                    $imageSrl++;
                            $('.carousel-inner').append(markup);   		
                            });
                            $numImage = $('.carousel-inner > div').length;
                        }
            });


        }
    });

});

