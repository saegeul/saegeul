<br>
<br>
<div class="content">
	<form action="<?=base_url()?>admin_mgr/setting/setupSite" method="post" class="form-horizontal">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="input01">Site Name</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="site_name"
					value="<?if($set_info){echo $set_info->title;}?>"
}
						placeholder="saegeul">
					<p class="help-block">Input Site Name</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input02">Site URL</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="site_url"
						value="<?if($set_info){echo $set_info->site_url;}?>"
						placeholder="http://www.saegeul.com">
					<p class="help-block">Input Site URL</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input03">On/Off Register</label>
				<div class="controls">
					<select name="join_available" >
						<option <?if($set_info){if($set_info->on_register == "1"){echo "selected";}}?> value="1">ON</option>
						<option <?if($set_info){if($set_info->on_register == "0"){echo "selected";}}?> value="0">OFF</option>
					</select>
					<p class="help-block">Select On or Off</p>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button class="btn">Cancel</button>
			</div>
		</fieldset>
	</form>
</div>
