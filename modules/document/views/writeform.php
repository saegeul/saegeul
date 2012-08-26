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
	$("#choiceArea").click(function() {														//추가
		var tempText = tinyMCE.activeEditor.getContent();	
		tinyMCE.activeEditor.remove();
		$("#"+textAreaWepId).html('<div id="' + textAreaId + '" class="textBox">'+tempText+'</div></div>');
		$('<div class="textAreaWep'+cnt+'"><div id="textBox'+cnt+'" class="textBox"></div></div>').insertBefore("#choiceArea")/*.html(tempText)*/;
		tinyMCE.execCommand('mceAddControl', true, "textBox"+cnt);
                textAreaWepId = "textAreaWep" +cnt;
                textAreaId = "textBox" +cnt;
		//tinyMCE.activeEditor.setContent("");
		cnt++;
		$(".textBox").on("click",function() {
                        tempText = tinyMCE.activeEditor.getContent();
			tinyMCE.activeEditor.remove();
		        $("#"+textAreaWepId).html('<div id="' + textAreaId + '" class="textBox">'+tempText+'</div></div>');
                         textAreaWepId = $(this).parent().attr('id');
                         textAreaId =  $(this).attr('id');
			tinyMCE.execCommand('mceAddControl', true, textAreaId);
		});
		//alert($("#container").html());
	});
	$("#submitBtn").click(function() {
                
                        tempText = tinyMCE.activeEditor.getContent();
			tinyMCE.activeEditor.remove();
		        $("#"+textAreaWepId).html('<div id="' + textAreaId + '" class="textBox">'+tempText+'</div></div>');
		tinyMCE.triggerSave();
		//$("#hiddenTextValue").attr("value",$("#container").html());
		//alert($("#hiddenTextValue").attr("value"));
		alert($("#container").html());
//		$("#textForm").attr('action','./testpage').submit();
	})
});
	
</script>
<form id="textForm" method="POST">
<div id="container">
<div id="textAreaWep"class="textAreaWep">
<div id="textArea" class="textBox"></div>
</div>	
<div id="choiceArea"></div>
</div>
<input type="hidden" id="hiddenTextValue" value="sd" />
<input type="button" id="submitBtn" value="save" />
</form>
