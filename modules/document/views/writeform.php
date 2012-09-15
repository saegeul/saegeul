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

    
    $(window).scroll( function() {
            $('#contentMenuDiv').css('position','fixed').css('left',contentMenuDivleft);
    });

});
$(window).load(function() {
           contentMenuDivleft =  $('#contentMenuDiv').offset().left;
            $('#contentMenuDiv').hide();
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
            <input type="text" class="text span" placeholder="제목을 입력하세요." />
        </div>

        <div id="content_area" class="">
            <div id="toolBar" class="well" > 
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

    <div id="contentMenuDiv" class="span4" style="background-color:;">
        <div class="well">
            <span><center><h2>Content Box</h2><small>Photo Content</small></center></span>
        </div>
<!--
            <ul class="nav nav-tabs" id="menuTab">
              <li class="active"><a href="#" id="photoBtn" value="photoform"><b>Photo</b></a></li>
              <li><a href="#" id="fileBtn" value="fileform"><b>File</b></a></li>
              <li><a href="#" id="mapBtn" value="mapform"><b>Map</b></a></li>
              <li><a href="#" id="googleBtn" value="googleform"><b>Google</b></a></li>
              <li><a href="#" id="twitterBtn" value="twitterform"><b>Twitter</b></a></li>
              <li><a href="#" id="facebookBtn" value="facebookform"><b>Facebook</b></a></li>
            </ul>
-->
        <div id="contentBox" >
        </div> 
    </div>
</div>
</div>
</body>
