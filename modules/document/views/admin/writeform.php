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

<div class="container-fluid">
    <form action ="save"  method="post" id="document_form" >
    <div class="row-fluid"> 
        <div class="span7">
            <input type="text" name="title"  style="width:100%;"/> 
            <input type="hidden" name="content"  style="width:100%;"/> 
        </div>
        <div class="span2">
            <button type="text" class="btn btn-primary" id="save_btn">저장..</button>
        </div>
    </div> 
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
    $('#document_form').submit(function(){
        var html = DOC.paper.html() ;  
        $('#document_form').find('[name=content]').val(encodeURI(html)) ; 

    }); 
     
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
