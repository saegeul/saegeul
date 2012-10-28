<?php $this->load->helper('asset') ?>
<?echo js_asset('admin_mgr','jquery.blog.js')?>
<div class="_content form-horizontal">
	<fieldset >
		<div class="control-group">
			<label class="control-label">Blog Number</label>
			<div class="controls">
				<input type="text" id="inputListCount" value="<?=isset($listCount)?$listCount:""?>">
				<p class="help-block">한페이지에 출력할 블로그 갯수를 적어주세요.</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Facebook Id</label>
			<div class="controls">
				<input type="text" id="inputFacebookId" value="<?=isset($facebookId)?$facebookId:""?>">
				<p class="help-block">페이스북 댓글 플러그인 앱아이디를 적어주세요.</p>
			</div>
		</div>
		<div class="form-actions">
			<a href="javascript:void(0)"
				class="btn btn-primary modifyData pull-right">수정</a>
		</div>
	</fieldset>
</div>
