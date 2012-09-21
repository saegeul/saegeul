<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KTCloud</title>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo css_asset('ucloud','jquery.waitingpopup-min.css')?>
<?echo css_asset('ucloud','style.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo js_asset('ucloud','jquery.waitingpopup-min.js')?>
<?echo js_asset('ucloud','jquery.auth-ajax.js')?>
</head>
<body>
	<div id="container" style="margin-top:-30px;">
		<div id="layout_center">
			<br> <br>
			<h1 align="center">Cloud List</h1>
			<br>
			<ul class="breadcrumb"></ul>
			<div id="bntLine" align="right">
				<input type="hidden" id="curt_folder">
				<a href="javascript:void(0)" id="createFile" style="color: #333333;"><i class="icon-folder-open"></i>
				CreateFolder</a>
				<a href="javascript:void(0)" id="deletFile" style="color: #333333;"><i class="icon-trash"></i>
					Delete</a>
				<a href="javascript:void(0)" id="moveFilebox" style="color: #333333;"><i class="icon-upload"></i>
					MoveFilebox</a>
			</div>
			<br>
			<div id="center_table"></div>
		</div>
		<br>
		<br>
		<div id="layout_right">
			<h1 align="center" class="getList"><a style="color: #333333;" href="javascript:void(0)">FileBox List</a></h1>
			<div id="files" style="display: none"></div>
		</div>
	</div>
</body>
</html>
