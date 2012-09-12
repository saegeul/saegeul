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
});
</script> 

<script type="text/javascript">
var cnt = 0;
var textAreaWepId = "textAreaWep";
var textAreaId = "textArea";
var tempText = "";
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
        
    $('.paragraph').live('click',function(){
            var $this = $(this) ; 
            $('> div',$this).remove();
            var html = $this.html(); 
             
         try {
            var content = tinyMCE.activeEditor.getContent();
            if(content.length > 0){
                $('<div class="paragraphWep"></div>').insertBefore('.well').html('<div class="paragraph">'+content+'</div><input type="button" class="removeParagraphBtn" value="X"/>');
              //  $(".paragraph").resizable({ helper :"ui-resizable-helper", alsoResize: ".paragraphWep" });
             } 
              

            $('.well').insertAfter($this.parent()) ; 
            $this.parent().remove('');
            tinyMCE.activeEditor.remove();
        }
        catch(e) {
            $('.well').insertAfter($this.parent()) ; 
            $this.parent().remove('') ;
        }
            tinyMCE.execCommand('mceAddControl', false, 'textArea');
            tinyMCE.activeEditor.setContent(html) ; 

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
                    $('<div class="paragraphWep"></div>').insertBefore('.well').html('<div class="paragraph">'+content+'</div><input type="button" class="removeParagraphBtn" value="X"/>');
                //    $(".paragraph").resizable({ helper: "ui-resizable-helper" });
                }
            }
            catch(e){
                tinyMCE.execCommand('mceAddControl', false, 'textArea');
            }
        });


    $("#add_photo_btn").click(function() {
        try {
	var content = tinyMCE.activeEditor.getContent();	
        tinyMCE.activeEditor.setContent('');	
        tinyMCE.activeEditor.remove();
        if(content.length > 0){
                $('<div class="paragraphWep"></div>').insertBefore('.well').html('<div class="paragraph">'+content+'</div><input type="button" class="removeParagraphBtn" value="X"/>');
               // $(".paragraph").resizable({ helper :"ui-resizable-helper", alsoResize: ".paragraphWep" });
            }
        }
        catch(e) {}
        $("#toggler").load('photoform');
    });
    $("#add_file_btn").click(function() {
        $("#toggler").load('fileform');
    });
    $("#add_map_btn").click(function() {
        $("#toggler").load('mapform');
    });
    $("#add_google_btn").click(function() {
        $("#toggler").load('googleform');
    });
    $("#add_twitter_btn").click(function() {
        $("#toggler").load('twitterform');
    });
    $("#add_facebook_btn").click(function() {
        $("#toggler").load('facebookform');
    });
    $("#submitBtn").click(function() {
        tempText = tinyMCE.activeEditor.getContent();
	tinyMCE.activeEditor.remove();
	tinyMCE.triggerSave();
	alert($("#content_area").html());
    })
});
	
</script>


<div id="content_body">

    <div>
        <h1><input type="text" class="input-xxlarge" placeholder="제목을 입력하세요." /> </h1>
    </div>

    <div id="content_area">

	<div id="well" class="well" > 
	    <div id="textArea" class="textBox"></div>
	    <a class="btn btn-large" id="add_paragraph_btn"><i class="icon icon-pencil"></i> 글작성 </a>
	    <a class="btn btn-large" id="add_photo_btn"><i class="icon icon-picture"></i> 그림 첨부 </a>
	    <a class="btn btn-large" id="add_file_btn"><i class="icon icon-file"></i> 파일 첨부 </a>
	    <a class="btn btn-large" id="add_map_btn"><i class="icon icon-search"></i> 지도 추가</a>
	    <a class="btn btn-large" id="add_google_btn"><i class="icon icon-search"></i> 구글 검색</a>
	    <a class="btn btn-large" id="add_twitter_btn"><i class="icon icon-search"></i> 트위터 검색</a>
	    <a class="btn btn-large" id="add_facebook_btn"><i class="icon icon-search"></i> 페이스북 검색</a>
	</div> 
    </div> 

    <form id="textForm" method="POST">
    </form>

    <div id="toggler">
    </div>

</div>
