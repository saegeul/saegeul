<?php $this->load->helper('asset') ?>
<?echo css_asset('filebox','jqcloud.css')?>
<?echo js_asset('filebox','jqcloud-1.0.1.js')?>
<?echo js_asset('filebox','jquery.tagcloud.js')?>
<div class="_content">
	<div class="alert alert-success" align="center">
		태그를 클릭하시면 태그된 사진을 목록별로 확인 할 수 있습니다.
	</div>
	<div id="tag_cloud" style="height: 350px;"></div>
</div>
