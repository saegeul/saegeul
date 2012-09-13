<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>


<meta
	http-equiv="Content-Type" content="text/html;charset=utf-8">
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<?php


$login = array(
		'name'	=> 'login',
		'id'	=> 'login',
		'value' => set_value('login'),
		'maxlength'	=> 80,
		'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'size'	=> 30,
);
$remember = array(
		'name'	=> 'remember',
		'id'	=> 'remember',
		'value'	=> 1,
		'checked'	=> set_value('remember'),
		'style' => 'margin:0;padding:0',
);
$captcha = array(
		'name'	=> 'captcha',
		'id'	=> 'captcha',
		'maxlength'	=> 8,
);
?>


<body style="background: #000;">
	<div class="container">
		<div class="hero-unit">
			<h1>
				Login <small>회원가입부터 먼저 하세요.</small>
			</h1>
			<hr />
			<form class="form-horizontal" method="post"
				action="<?=$this->uri->uri_string()?>">

				<div class="control-group">
				<div class="control-label">
					<?php echo form_label($login_label, $login['id']); ?>
					<?php echo form_error($login['name']); ?>
							<?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
							</div>
					<div class="controls">
						<?php echo form_input($login); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
					<?php echo form_label('Password', $password['id']); ?>
					</div>
					<div class="controls">
						<?php echo form_password($password); ?>
						<?php echo form_error($password['name']); ?>
							<?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
					<a href="member/forgot_password">비밀번호 찾기 </a><br>
							<input class='btn btn-success' type='submit' value='LOGIN'> <a
							class="btn btn-info" href="register">회원가입 </a>
					</div>
				</div>








			
			</form>
		</div>
	</div>

</body>
