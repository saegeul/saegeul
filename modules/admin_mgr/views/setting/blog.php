<?php $this->load->helper('asset') ?>
<?echo js_asset('admin_mgr','jquery.blog.js')?>
<div class="_content form-horizontal">
	<fieldset >
		<legend>Blog</legend>
		<div class="control-group">
			<label class="control-label">Blog Number</label>
			<div class="controls">
				<input type="text" id="inputListCount" value="<?=isset($listCount)?$listCount:""?>">
				<p class="help-block">한페이지에 출력할 블로그 갯수를 적어주세요.</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">RSS Number</label>
			<div class="controls">
				<input type="text" id="inputRSSCount" value="<?=isset($rssCount)?$rssCount:""?>">
				<p class="help-block">RSS 발행 갯수를 적어주세요.</p>
			</div>
		</div>
		<legend>FaceBook</legend>
		<div class="control-group">
			<label class="control-label">App Id</label>
			<div class="controls">
				<input type="text" id="inputFacebookId" value="<?=isset($facebookId)?$facebookId:""?>">
				<p class="help-block">페이스북 댓글 플러그인 앱아이디를 적어주세요.</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Comment Number</label>
			<div class="controls">
				<input type="text" id="inputCommentCount" value="<?=isset($commentCount)?$commentCount:""?>">
				<p class="help-block">페이스북 코멘트 출력 수를 적어주세요.</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Comment Width</label>
			<div class="controls">
				<input type="text" id="inputCommentWidth" value="<?=isset($commentWidth)?$commentWidth:""?>">
				<p class="help-block">페이스북 코멘트 넓이를 적어주세요.</p>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Theme</label>
			<div class="controls">
				<label class="radio inline"> <input type="radio" value="dark"
						name='theme'<?php if((isset($theme)?$theme:"")=="dark"){?>checked<?php }?>> 다크
					</label> <label class="radio inline"> <input type="radio" value="light"
						name='theme'<?php if((isset($theme)?$theme:"")!="dark"){?>checked<?php }?>> 라이트
					</label>
				<p class="help-block" style="margin-top:10px;">페이스북 테마를 선택하세요.</p>
			</div>
		</div>
		<legend>Naver</legend>
		<div class="control-group">
			<label class="control-label">API KEY</label>
			<div class="controls">
				<input type="text" id="inputNaverKey" value="<?=isset($naverApiKey)?$naverApiKey:""?>">
				<p class="help-block">네이버 API 키를 적어주세요.</p>
			</div>
		</div>
		<div class="form-actions">
			<a href="javascript:void(0)"
				class="btn btn-primary modifyData pull-right">수정</a>
		</div>
	</fieldset>
</div>
