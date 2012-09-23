<?php $this->load->helper('asset') ?>

<HTML>
<HEAD>
<TITLE>E-mail</TITLE>
<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<body>

	<legend><h2>E-mail</h2></legend>
	<form class="form-horizontal" name="formmail" method="post" action="/saegeul/guest/send">
		<div class="control-group">
			<label class="control-label">Title :</label>
			<div class="controls">
				<input type="text" name="title" placeholder="Subject" style="width:300px;">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Name :</label>
			<div class="controls">
				<input type="text" name="senduser" placeholder="Name" style="width:300px;">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Email :</label>
			<div class="controls">
				<input type="text" name="email" placeholder="E-mail" style="width:300px;">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Request :</label>
			<div class="controls">
				<textarea name="body" rows="5" placeholder="Request" style="width:300px;"></textarea>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary">Submit</button>

				<button tyype="reset" class="btn">Reset</button>
			</div>
		</div>
	</form>

</body>
</HTML>
