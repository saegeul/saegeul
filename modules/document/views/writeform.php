<?php
$this->load->helper('url');
$this->load->helper('asset');
?>


<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<?echo css_asset('admin','bootstrap/css/bootstrap.css')?>
<?echo css_asset('admin','bootstrap/css/bootstrap-responsive.css')?>
 
<?php echo css_asset('document','style.css') ?>
<?php echo js_asset('document','tiny_mce/tiny_mce.js')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
 
<script type="text/javascript">
$(document).ready(function() {
        $("#content_area").sortable({
            cancel : ".well",
        });
        $("#contentBox").load('photoform');
});
</script> 

<script type="text/javascript">
var contentMenuDivleft;
var contentMenuDivtop;
$(document).ready(function(){

tinyMCE.init({ 
    		  mode : "none",
        	  theme : "advanced",
            skin : "o2k7",
            skin_variant : "black",
            plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            
            forced_root_block : false,
            force_br_newlines : true,
            force_p_newlines : false,
				 				
            // Theme options
			 theme_advanced_buttons1 : "preview,undo,redo,bold,italic,underline,strikethrough,forecolor,backcolor,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,bullist,numlist,outdent,indent,blockquote,search,charmap",
			 theme_advanced_toolbar_location : "top",
	        theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "none",
            theme_advanced_resizing : true
    });



tinyMCE.execCommand('mceAddControl', false, 'textArea');
$("#styleContentDiv").hide('');
$("#styleControl").hide('');

        $('#add_title_btn').click(function() {
            try {
                var content = tinyMCE.activeEditor.getContent();	
                tinyMCE.activeEditor.setContent('');	

                if(content.length > 0) {
                    $('<div class="alert alert-error"><button type="button" class="close rmBtn" data-dismiss="alert">×</button><div class="paragraph"><h1>'+content+'</h1></div></div>').insertBefore('#toolBar');
                }
            }
            catch(e){
                tinyMCE.execCommand('mceAddControl', false, 'textArea');
            }
        });
        $('#add_subtitle_btn').click(function() {
            try {
                var content = tinyMCE.activeEditor.getContent();	
                tinyMCE.activeEditor.setContent('');	

                if(content.length > 0) {
                    $('<div class="alert alert-error"><button type="button" class="close rmBtn" data-dismiss="alert">×</button><div class="paragraph"><h4>'+content+'</h4></div></div>').insertBefore('#toolBar');
                }
            }
            catch(e){
                tinyMCE.execCommand('mceAddControl', false, 'textArea');
            }
        });
    $('.paragraph').live('click',function(){
            var $this = $(this) ; 
            $('> div',$this).remove();
            var html = $this.html(); 
             
         try {
            var content = tinyMCE.activeEditor.getContent();
            if(content.length > 0){
                    $('<div class="alert alert-block"><button type="button" class="close rmBtn" data-dismiss="alert">×</button><div class="paragraph">'+content+'</div></div>').insertBefore('#toolBar');
             } 
              

            $('#toolBar').insertAfter($this.parent()) ; 
            $this.parent().remove('');
            tinyMCE.activeEditor.remove();
        }
        catch(e) {
            $('#toolBar').insertAfter($this.parent()) ; 
            $this.parent().remove('') ;
        }
            tinyMCE.execCommand('mceAddControl', false, 'textArea');
            tinyMCE.activeEditor.setContent(html) ; 

        }); 
        $('.rmBtn').live('click',function() {
            var $this = $(this);     
            $this.parent().remove('');
        });
        $('.removeParagraphBtn').live('click',function(){
            var $this = $(this);     
            $this.parent().remove('');
        })
        $("#add_paragraph_btn").click(function() {
            try {
                var content = tinyMCE.activeEditor.getContent();	
                tinyMCE.activeEditor.setContent('');	

                if(content.length > 0) {
                    $('<div class="alert alert-block"><button type="button" class="close rmBtn" data-dismiss="alert">×</button><div class="paragraph">'+content+'</div></div>').insertBefore('#toolBar');
                }
            }
            catch(e){
                tinyMCE.execCommand('mceAddControl', false, 'textArea');
            }
        });
        $("#add_photo_btn").click(function() {
            $( "#photoMenuBtn" ).toggle('blind'); 
        });
        $("#fullPhotoBtn").click(function() {
            try {
                var content = tinyMCE.activeEditor.getContent();	
                tinyMCE.activeEditor.setContent('');	

                if(content.length > 0) {
                    }
            }
            catch(e){
                tinyMCE.execCommand('mceAddControl', false, 'textArea');
            }
                    $('<div class="photoDropZon" style="padding:10px;background-color:gray;border:1px solid black;height:400px;"></div>').insertBefore('#toolBar').droppable({
            scope:"tasks", 
            accept:".selectImg",
            drop: function( event, ui ) {
            $(this).html('');
            $("<img src='"+ui.draggable.attr("src")+"'/ >").appendTo(this).css("width","100%").css("height","100%");

            } 
                });

        });
        $("#twoPhotoBtn").click(function() {
            try {
                var content = tinyMCE.activeEditor.getContent();	
                tinyMCE.activeEditor.setContent('');	

                if(content.length > 0) {
                    }
            }
            catch(e){
                tinyMCE.execCommand('mceAddControl', false, 'textArea');
            }
                    $('<div class="container-fluid"><div class="row-fluid"><div class="photoDropZon span6" style="padding:10px;background-color:gray;border:1px solid black;height:400px;"></div><div class="photoDropZon span6" style="padding:10px;background-color:gray;border:1px solid black;height:400px;"></div></div></div>').insertBefore('#toolBar');
            $('.photoDropZon').next().droppable({
            scope:"tasks", 
            accept:".selectImg",
            drop: function( event, ui ) {
            $(this).html('');
            $("<img src='"+ui.draggable.attr("src")+"'/ >").appendTo(this).css("width","100%").css("height","100%");

            } 
                });
            $('.photoDropZon').droppable({
            scope:"tasks", 
            accept:".selectImg",
            drop: function( event, ui ) {
            $(this).html('');
            $("<img src='"+ui.draggable.attr("src")+"'/ >").appendTo(this).css("width","100%").css("height","100%");

            } 
                });
        });


    $("#menuTab a").click(function(e) {
        $("#contentBox").load($(this).attr('value') );
    });
    $("#add_contentMenu_btn").click(function() {
        $( "#contentMenuDiv" ).toggle('slide'); 
    });
    
    $("#content_next_btn").click(function() {
        $("#photoContentDiv").toggle('blind');
        $("#styleContentDiv").toggle('blind');
        $("#contentControl").toggle('blind');
        $("#styleControl").toggle('blind');
    });
    $("#content_preview_btn").click(function() {
        $("#photoContentDiv").toggle('blind');
        $("#styleContentDiv").toggle('blind');
        $("#contentControl").toggle('blind');
       $("#styleControl").toggle('blind');
    });

    $("#selectContentDropZon").droppable({
            scope:"tasks", 
            accept:".selectImg",
            drop: function( event, ui ) {
            $("<img src='"+ui.draggable.attr("src")+"'/ >").appendTo(this).css("width","100px").css("height","100px");
            } 
    });
    $("#styleBox button").click(function() {
    
        alert('click');

    });
    $("#content_finish_btn").click(function() {
             
        var index; //몇번 스타일을 골랐는지 알려주는 index
        var items = $("#selectContentDropZon > img").length; //고른 사진이 몇개인지 알려주는 index
        $( ".ui-selected").each(function() {
            index = $( "#selectable li" ).index( this ); //index 에 고른스타일을 넣느다
        });
//:first - 첫째 요소
//:last - 마지막 요소
//:even - 짝수 요소
//:odd - 홀수 요소
//:eq(n) - n번째 인덱스에 해당하는 요소
//:lt(n) - n번째부터 밑에 있는 모든 요소
//:gt(n) - n번째 보다 위에 있는 모든 요소
        if( index == 0 ) {
            if(items < 1 ) {
                 alert("하나이상의 그림을 고르시오");
            } else {
                var $photo = $("#selectContentDropZon img:first").css("width","100%").css("height","100%");
                $('<div class="photoDropZon" style="padding:10px;background-color:gray;border:1px solid black;height:400px;"></div>').insertBefore('#toolBar').append($photo);
            }
        } else if( index == 1 ) {
            if(items < 2 ) {
                 alert("두개이상의 그림을 고르시오");
            } else {
                var $photo1 = $("#selectContentDropZon img:eq(0)").css("width","50%").css("height","100%");
                var $photo2 = $("#selectContentDropZon img:eq(1)").css("width","50%").css("height","100%");
                $('<div style="background-color:red;"></div>').insertBefore('#toolBar').append($photo1).append($photo2);
            }
        } else if( index == 2 ) {
            if(items < 2 ) {
                 alert("두개이상의 그림을 고르시오");
            } else {
                var $photo1 = $("#selectContentDropZon img:eq(0)").css("width","100%").css("height","100%");
                var $photo2 = $("#selectContentDropZon img:eq(1)").css("width","100%").css("height","100%");
                $('<div style="background-color:red;"></div>').insertBefore('#toolBar').append($photo1).append($photo2);
            }
        } else if( index == 3 ) {
            if(items < 3 ) {
                 alert("세개이상의 그림을 고르시오");
            } else {
                var $photo1 = $("#selectContentDropZon img:eq(0)").css("width","100%").css("height","100%");
                var $photo2 = $("#selectContentDropZon img:eq(1)").css("width","100%").css("height","50%");
                var $photo3 = $("#selectContentDropZon img:eq(2)").css("width","100%").css("height","50%");
                $('<div class="" style="float:left;"><div class="leftcol" style="float:left;width:50%;"></div><div class="rightcol" style="width:50%;float:left;"></div></div>').insertBefore('#toolBar');
                $('.leftcol').append($photo1);
                $('.rightcol').append($photo2).append($photo3);
            }
        } else {
            alert("스타일을 선택하세요");
        }


    });
    $( "#selectable" ).selectable({
         
/*         stop: function() {
                var result = $( "#select-result" ).empty();
                $( ".ui-selected", this ).each(function() {
                    var index = $( "#selectable li" ).index( this );
                    //result.append( " #" + ( index + 1 ) );
                    alert( " #" + ( index + 1 ) );
                });
            }
*/
        });

});

</script>
<body>
<div class="container-fluid">
<div class="row-fluid">
<div id="content_body" class="span8">

<!--
<div class="container-fluid" style="background-color:black;">
<div class="row-fluid" style="background-color:blue;">
<div class="photoDropZon span6" style="background-color:red;">
</div>
<div class="photoDropZon span6" style="background-color:green;">
</div>
</div>
</div>
-->

        <div class="well">
            <span><center><h1><b>New Write</h1></b></center><br /></span> 
            <input type="text" class="text span12" placeholder="제목을 입력하세요." />
        </div>
        <div id="content_area" class="">
            <div id="toolBar" class="well" > 

<!-- 포토 컨텐츠 시작 -->
                <div id="photoContentDiv" class="" style="background-color:green;">
                     <div class="well">
                          <span><center><h2>Content Box</h2><small>Photo Content</small></center></span>
                     </div>
                          <div id="contentBox" style="height:400px;" >
                     </div> 
                </div>
<!-- 포토컨텐츠 끝 -->



                <div id="styleContentDiv" style="background-color:;height:;">
                     <div class="well">
                          <span><center><h2>Style Box</h2></center></span>
                     </div>

                    <div id="styleBox" style="height:200px;background-color:;">
                        <ol id="selectable"  >
                            <li class="ui-widget-content"><a>1</a></li>
                            <li class="ui-widget-content"><a>2</a></li>
                            <li class="ui-widget-content"><a>3</a></li>
                            <li class="ui-widget-content"><a>4</a></li>
                        </ol>
                    </div>
                </div>
                <div id="selectContentDiv" style="background-color:;height:;">
                     <div class="well">
                          <span><center><h2>Select Box</h2></center></span>
                     </div>

    <div id="selectContentDropZon" style="height:200px;background-color:red;"class="" >
            
                    </div>
                </div>

                    <div id="contentControl" style="height:100px;background-color:yellow;">
                        <span>사진을 드래그 해!!!!</span>                
                        <button id="content_next_btn" class="btn btn-inverse" type="button">NEXT</button>
                    </div>

                    <div id="styleControl" style="height:100px;background-color:yellow;">
                        <button id="content_preview_btn" class="btn btn-inverse" type="button">PREVIEW</button>
                        <button id="content_finish_btn" class="btn btn-inverse" type="button">FINISH</button>
                    </div>


                <div id="textArea" class="textBox"></div>
                <br />
                    <button id="add_title_btn" class="btn btn-inverse" type="button">제목추가</button>
                    <button id="add_subtitle_btn" class="btn btn-inverse" type="button">주제추가</button>
                    <button id="add_paragraph_btn" class="btn btn-inverse" type="button">단락추가</button>
                    <button id="add_photo_btn" class="btn btn-inverse" type="button">사진추가</button>
                    <button id="add_contentMenu_btn" class="btn btn-inverse" type="button">Content추가</button>
                <p id="photoMenuBtn" hidden="true">
                <br />
                    <button id="fullPhotoBtn" class="btn" type="button">Full</button>
                    <button id="twoPhotoBtn" class="btn" type="button">two</button>
                    <button id="" class="btn" type="button">three</button>
                </p> 
            </div>
        </div> 
        <form id="textForm" method="POST">
        </form>
    </div>

  </div>
</div>
</body>
