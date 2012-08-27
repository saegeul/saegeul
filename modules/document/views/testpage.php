<?php
$this->load->helper('url'); 
?>
<html>
	<head>
		<title>tinyMCE test Load Page</title>
		
		<script src="<?=base_url()?>modules/document/views/js/tiny_mce/tiny_mce.js"> </script>
		<meta http-equiv="content-type" content="text/html" charset="utf-8" />
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
		<script type="text/javascript">google.load("jquery", "1.3");</script>
		<script type="text/javascript">
		function tinymceLoad(){
	    	tinyMCE.init({
				mode : "textareas",
				editor_selector : "on_tinymce",
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
		}
		</script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript">
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#container").click(function(event){
					createDiv = document.createDiv("div");
				})
				$(".off_tinymce").focus(function(){
					$(this).attr('class','off_tinymce');
					//alert(document.getElementById('container').innerHTML);
					tinymceLoad();
				});
				$("#dd").blur(function(){
					alert("blur");
					alert($(this).attr('class','off_tinymce'));
					alert(document.getElementById('container').innerHTML);
					tinyMCE.activeEditor.remove();
				})
				$("#off_tinymce").click(function(){
					alert("click");
				})
			});
		</script>
	</head>
	<style>
	
	</style>
	<body>
	
<!--  					tinyMCE Load div start	 					-->
		<div id="container"></div>
			<div id="textContainer">
				<textarea id="on_tinymce"class="on_tinymce"></textarea>
				<input type="button" id="dd" value="dd"/>
			</div>
	
	
	
		
		
<!--  					tinyMCE Load div end	 					-->		
		
	</body>
</html>