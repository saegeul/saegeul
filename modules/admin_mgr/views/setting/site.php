<br>
<br>
<div class="content">
	<form action="setting/setupSite" method="post" class="form-horizontal">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="input01">Site 이름</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="site_name"
						placeholder="saegeul">
					<p class="help-block">Site 이름</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input02">Site URL</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="site_url"
						placeholder="http://www.saegeul.com">
					<p class="help-block">Site URL을 입력하세요.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input03">회원가입 가능 </label>
				<div class="controls">
					<select name="join_available">
						<option value="1">ON</option>
						<option value="0">OFF</option>
					</select>
					<p class="help-block">회원가입 가능 여부.</p>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button class="btn">Cancel</button>
			</div>
		</fieldset>
	</form>
</div>
