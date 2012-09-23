<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<?echo css_asset('clouddrive','jquery.waitingpopup-min.css')?>
<?echo css_asset('clouddrive','style.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo js_asset('clouddrive','jquery.waitingpopup-min.js')?>
<?echo js_asset('clouddrive','jquery.auth-ajax.js')?>

<div id="container">
	<div id="layout_center">
		<ul class="breadcrumb"></ul>
		<div id="bntLine" align="right">
			<input type="hidden" id="curt_folder"> <a href="javascript:void(0)"
				id="createFolder" style="color: #333333;"><i
				class="icon-folder-open"></i> CreateFolder</a> <a
				href="javascript:void(0)" id="deletFile" style="color: #333333;"><i
				class="icon-trash"></i> Delete</a> <a href="javascript:void(0)"
				id="moveFilebox" style="color: #333333;"><i class="icon-upload"></i>
				MoveFilebox</a>
		</div>
		<br>
		<div id="center_table"></div>
	</div>
	<div id="layout_right">
		<div id="files"></div>
	</div>
</div>

