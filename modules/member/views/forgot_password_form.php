<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>


<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>

<body style="background:#000;">
    <div class="container">
        <div class="hero-unit">
<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label($login_label, $login['id']); ?></td>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
	</tr>
</table>
<?php echo form_submit('reset', '비밀번호 찾기'); ?>
<?php echo form_close(); ?>
</div>
</div>
</body>