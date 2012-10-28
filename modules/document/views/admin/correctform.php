<?echo css_asset('document','style.css') ?>
<?echo js_asset('document','tiny_mce/tiny_mce.js')?>

<div class="_content" >
    <form action ="save"  method="post" id="document_form" class="form-inline" > 
        <input type="text" class="span7"  name="title" value="<?=$document->title;?>"  placeholder="제목을 입력하세요"/> 
        <button type="text" class="btn btn-primary" id="save_btn">저장..</button>
        <input type="hidden" name="content" value="<?=htmlspecialchars($document->content)?>" /> 
        <hr/>
        <textarea style="width:99%;color:#ccc;" name="description"><?=$document->description;?> </textarea>
    </form>
    <div id="document_body" >
        <div id="textArea"> </div>
    </div> 
</div>

<script> 
var loadDocument = function(editor_id,elm,command,user_interface,value){
    var content = $('#document_form [name=content]').val() ; 
    tinyMCE.activeEditor.setContent(content) ; 

    return true ; 
}; 

$(function(){ 

	tinyMCE.init({ 
		mode : "none",
		theme : "advanced",
		skin : "o2k7",
		height:600,
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
		theme_advanced_resizing : true,
        execcommand_callback : "loadDocument" 
	});

    tinyMCE.execCommand('mceAddControl', false, 'textArea');

    $('#document_form').submit(function(){
        $('#document_form').find('[name=content]').val(html) ; 
        }) ; 
    }); 

</script>
