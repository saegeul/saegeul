<br>
<br>
<div class="content">
	<form action="setupEmail" method="post" class="form-horizontal">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="input01">Email Addr</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="email"
					value="<?if($set_info){echo $set_info->email;}?>"
						placeholder="your_email@abc.com">
					<p class="help-block">메일 전송을위해 사용하실 이메일 주소를 적어주세요.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input02">Email Password</label>
				<div class="controls">
					<input type="password" class="input-xlarge" name="smtp_pass"
					value="<?if($set_info){echo $set_info->smtp_pass;}?>"
						placeholder="put your email password">
					<p class="help-block">입력하신 이메일주소의 비밀번호를 입력해주세요.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input03">Mail Protocol</label>
				<div class="controls">
					<select name="email_protocol" default="smtp">
						<option <?if($set_info){if($set_info->email_protocol == "mail"){echo "selected";}}?> value="mail" >Mail</option>
						<option <?if($set_info){if($set_info->email_protocol == "sendmail"){echo "selected";}}?> value="sendmail">SendMail</option>
						<option <?if($set_info){if($set_info->email_protocol == "smtp"){echo "selected";}}?>  value="smtp">SMTP</option>
					</select>
					<p class="help-block">사용하실 이메일 프로토콜을 선택해주세요.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input04">SMTP HOST</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="smtp_host"
					value="<?if($set_info){echo $set_info->smtp_host;}?>">
					<p class="help-block">SMTP HOST를 입력해주세요.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input05">SMTP PORT</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="smtp_port"
					value="<?if($set_info){echo $set_info->smtp_port;}?>">
					<p class="help-block">SMTP PORT를 입력해주세요.</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="input06">Email Library Path</label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="email_lib_path"
					value="<?if($set_info){echo $set_info->email_path;}?>">
					<p class="help-block">이메일 라이브러리가 존재하는 경로를 입력해주세요.</p>
				</div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button class="btn">Cancel</button>
			</div>
		</fieldset>
	</form>
</div>
