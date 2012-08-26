<?php
$this->load->helper('url');
$this->load->helper('asset');
?>


<meta
	http-equiv="content-type" content="text/html" charset="utf-8" />
<script
	type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
        google.load("jquery", "1.7.1");
</script>
<?php echo css_asset('document','style.css') ?>
<?php echo js_asset('document','tiny_mce/tiny_mce.js')?>
<script type="text/javascript">
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
	        theme_advanced_toolbar_align : "center",
            theme_advanced_statusbar_location : "none",
            theme_advanced_resizing : true
    });
</script>

<script type="text/javascript">
function submitForm() {
tinyMCE.triggerSave();
document.forms[0].submit();
}
</script>


<script type="text/javascript">
var cnt = 0;
var textAreaWepId = "textAreaWep";
var textAreaId = "textArea";
var tempText = "";
tinyMCE.execCommand('mceAddControl', true, "textArea");


$(document).ready(function(){
    $('.paragraph').live('click',function(){
        var content = tinyMCE.activeEditor.getContent() ; 

        if(content.length > 0){
            $('<div class="paragraph">'+content+'</div>').insertBefore('.well'); 
        } 

        var $this = $(this) ; 
        var html = $this.html() ; 
        $('.well').insertAfter($this) ; 
        $this.remove('');
		tinyMCE.activeEditor.remove();
		tinyMCE.execCommand('mceAddControl', true, 'textArea');
        tinyMCE.activeEditor.setContent(html) ; 
    }); 

    

	$("#add_paragraph_btn").click(function() {
		var tempText = tinyMCE.activeEditor.getContent();	
        tinyMCE.activeEditor.setContent('');	

        $('<div class="paragraph">'+tempText+'</div>').insertBefore('.well') ; 

    });

	$("#submitBtn").click(function() {
                        tempText = tinyMCE.activeEditor.getContent();
			tinyMCE.activeEditor.remove();
		        /*$("#"+textAreaWepId).html('<div id="' + textAreaId + '" class="textBox">'+tempText+'</div></div>');*/
		tinyMCE.triggerSave();
		alert($("#content_area").html());
	})
});
	
</script>

<div>
    <h1><input type="text" class="input-xxlarge" placeholder="제목을 입력하세요." style="font-size:15px;" /> </h1>
</div>

<div id="content_area">

	<div class="well"> 
	    <div id="textArea" class="textBox"></div>
	    <a class="btn btn-large" id="add_paragraph_btn"><i class="icon icon-pencil"></i> 글작성 </a>
	    <a class="btn btn-large"><i class="icon icon-picture"></i> 그림 첨부 </a>
	    <a class="btn btn-large"><i class="icon icon-file"></i> 파일 첨부 </a>
	    <a class="btn btn-large"><i class="icon icon-search"></i> 지도 추가</a>
	    <a class="btn btn-large"><i class="icon icon-search"></i> 구글 검색</a>
	    <a class="btn btn-large"><i class="icon icon-search"></i> 트위터 검색</a>
	    <a class="btn btn-large"><i class="icon icon-search"></i> 페이스북 검색</a>
	</div> 
</div> 


<form id="textForm" method="POST">
</form>

<input type="button" id="submitBtn" value="save" />
