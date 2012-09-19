<?php
$this->load->helper('url');
$this->load->helper('asset');
?>

<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<?echo css_asset('admin','bootstrap/css/bootstrap.css')?>
<?echo css_asset('admin','bootstrap/css/bootstrap-responsive.css')?> 
<?echo css_asset('document','style.css') ?>
<?echo js_asset('document','tiny_mce/tiny_mce.js')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo js_asset('document','doc.remocon.js')?>
<?echo js_asset('document','doc.paper.js')?>
<?echo js_asset('document','doc.remocon.textarea.js')?>
<?echo js_asset('document','doc.remocon.image.js')?>
<?echo js_asset('document','doc.remocon.filebox.js')?>
 
<?echo js_asset('document','doc.element.textarea.js')?>

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
        DOC.remocon.image ,
        DOC.remocon.filebox
    ]); 

    DOC.remocon_panel.render() ; 
}); 
</script>
