<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<title>새글</title>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/docs.css')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo common_js_asset('bootstrap/js/bootstrap.min.js') ?> 
<?= $_header_data;?> 
</head>
<body>
    <header class="">

    </header>

	<div class="container">
        <div class="row">
		<?=$_contents;?> 
        </div>
	</div>

    <footer>

    </footer>
</body>
</html>
