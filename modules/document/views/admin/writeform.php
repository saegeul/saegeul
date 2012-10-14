<?php
$this->load->helper('url');
$this->load->helper('asset');
?>

<?echo css_asset('document','style.css') ?>
<?echo js_asset('document','tiny_mce/tiny_mce.js')?>
<?echo js_asset('document','doc.util.js')?>
<?echo js_asset('document','doc.remocon.js')?>
<?echo js_asset('document','doc.paper.js')?>
<?echo js_asset('document','doc.listpanel.js')?>
<?echo js_asset('document','doc.element.html.js')?>
<?echo js_asset('document','doc.element.twitter.js')?>
<?echo js_asset('document','doc.element.textarea.js')?>
<?echo js_asset('document','doc.element.image.js')?>

<div class="_content" >
    <form action ="save"  method="post" id="document_form" class="form-inline" > 
        <input type="text" class="span7"  name="title" placeholder="제목을 입력하세요"/> 
        <button type="text" class="btn btn-primary" id="save_btn">저장..</button>
        <input type="hidden" name="content" /> 
    </form>
    <div id="document_body" >

    </div>
    <div class="row-fluid"> 
        <div id="remocon">

        </div> 
    </div>
</div>

<script> 
$(function(){ 
    DOC.remocon_panel.init({
        id : 'remocon' ,
        cls : 'well' ,
        items : [
            {
                btn_tmpl : '<button class="btn"><i class="icon icon-book"></i> 문단</button>', 
                Element : DOC.Element.Textarea 
            },{
                btn_tmpl : '<button class="btn"><i class="icon icon-book"></i> HTML</button>', 
                Element : DOC.Element.HTML 
            },{
                btn_tmpl : '<button class="btn"><i class="icon icon-book"></i> Image</button>', 
                Element : DOC.Element.Image 
            },{
                btn_tmpl : '<button class="btn"><i class="icon icon-book"></i> Twitter</button>', 
                Element : DOC.Element.Twitter 
            }
        ]
    }); 


    DOC.remocon_panel.render() ; 
    //DOC.remocon_panel.trigger(''); 

    DOC.paper.init('document_body') ; 
    DOC.paper.sortable();
}); 
</script>
