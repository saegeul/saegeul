<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<title><?=$site_info->title;?></title>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('bootstrap/css/docs.css')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo common_js_asset('bootstrap/js/bootstrap.min.js') ?> 
<?= $_header_data;?> 
</head>
<body>
    <header class="container">
        <div style="text-align:center;margin-top:70px;margin-bottom:70px;">
            <h1 style=""><a href="<?=base_url()?>blog"><?=$site_info->title;?></a> </h1>
            <small><a href="<?=base_url()?>blog/rss" target="_blank"><?=base_url()?>blog/rss</a></small>
        </div>
        <hr/>
    </header>

	<div class="container">
        <div class="row">
            <div style="padding-left:50px;padding-right:50px;;">
		    <?=$_contents;?> 
            </div>
        </div>
	</div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <footer>

    </footer>
</body>
</html>
