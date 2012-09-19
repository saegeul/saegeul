<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>새글</title>
    <?echo css_asset('admin','bootstrap/css/bootstrap.css')?>
    <?echo css_asset('admin','bootstrap/css/bootstrap-responsive.css')?>
    <?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
    <?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
    <?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
    <?echo js_asset('admin','bootstrap/js/bootstrap.min.js') ?>
</head>
<body>
    <div class="navbar navbar-inverse ">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" style="color:#fff;font-weight:bold;"><?echo img_asset('admin','saegeul_logo.png')?> </a>
                <ul class="nav"> 
                    <li <?php if($this->uri->segment(2)=='dashboard'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/dashboard">Dashboard</a>
                    </li>
                    <li <?php if($this->uri->segment(2)=='dashboard'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/dashboard">WEB Builder</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='webzine'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/document/writeform">Member </a>
                    </li>
                    <li <?php if($this->uri->segment(2)=='webzine'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/document/writeform">Layout </a>
                    </li>
                    <li <?php if($this->uri->segment(2)=='webzine'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/document/writeform">Document</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='webzine'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/document/writeform">Cloud Drive</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='webzine'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/document/writeform">Archaive</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='template'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>index.php/admin/file/uploadform">File</a>
                    </li>
                    <li> 
                        <div class="btn-group">
                            <button class="btn btn-primary" ><i class="icon-plus icon-white"></i>&nbsp;NEW</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" ><span class="caret"></span></button>
                            <ul class="dropdown-menu"> 
                                <li><a><i class="icon-plus"></i> DOCUMENT</a></li>
                                <li><a><i class="icon-plus"></i> FILE</a></li>
                                <li><a><i class="icon-plus"></i> PAGE</a></li>
                            </ul> 
                        </div>
                    </li>
                </ul> 
            </div>
        </div>
    </div> 
    <div class="container">
