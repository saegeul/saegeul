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
tinyMCE.execCommand('mceAddControl', false, "textArea");
</script>


<script type="text/javascript">
var cnt = 0;
$(document).ready(function(){
	$("#choiceArea").click(function() {
		$('<div id="textBox'+cnt+'" class="textBox"></div>').insertBefore("#choiceArea")/*.html(tinyMCE.get("textArea").getContent());*/
		//tinyMCE.get("textArea").setContent("");
		cnt++;
		$(".textBox").on("click",function() {
			tinyMCE.activeEditor.remove();
			//var tempText = $(this).html();
			//var getId = $(this).attr('id');
			var getId = this.id;
			tinyMCE.execCommand('mceAddControl', false, getId);
			//tinyMCE.get("tinymce").setContent(tempText);
			//$(this).html("");
			//$(this).insertAfter("#textArea");
		});
	});
	$(".textBox").on("click",function() {
		tinyMCE.activeEditor.remove();
		//var tempText = $(this).html();
		//var getId = $(this).attr('id');
		var getId = this.id;
		tinyMCE.execCommand('mceAddControl', false, getId);
		//tinyMCE.get("tinymce").setContent(tempText);
		//$(this).html("");
		//$(this).insertAfter("#textArea");
	});
//		tinyMCE.execCommand('mceAddControl', false, tempDivAreaId);
});
</script>
<div id="container">

<div id="textArea"></div>
	<div id="choiceArea"></div>

</div>