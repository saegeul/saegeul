<?php
$this->load->helper('url');
$this->load->helper('asset');
?>

<?echo css_asset('document','style.css') ?>
<?echo js_asset('document','tiny_mce/tiny_mce.js')?>
<?echo js_asset('document','doc.remocon.js')?>
<?echo js_asset('document','doc.paper.js')?>
<?echo js_asset('document','doc.remocon.textarea.js')?>
<?echo js_asset('document','doc.remocon.youtube.js')?>
<?echo js_asset('document','doc.remocon.image.js')?>
<?echo js_asset('document','doc.remocon.filebox.js')?> 
<?echo js_asset('document','doc.element.textarea.js')?>
<?echo js_asset('document','doc.element.image.js')?>

<div class="container-fluid">
    <div class="row-fluid"> 
        <div class="span7">
            <input type="text"  style="width:100%;"/> 
        </div>
        <div class="span2">
            <a class="btn btn-primary">저장..</a>
        </div>
    </div>
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
        cls : 'well' 
    }); 

    DOC.remocon_panel.add([
        DOC.remocon.textarea , 
        DOC.remocon.youtube,
        DOC.remocon.image ,
        DOC.remocon.filebox
    ]); 

    DOC.remocon_panel.render() ; 
    //DOC.remocon.textarea.trigger(); 

    /*DOC.paper.init('document_body') ; 
    DOC.paper.sortable('on');*/
}); 
</script>
