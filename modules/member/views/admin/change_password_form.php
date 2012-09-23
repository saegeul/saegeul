<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>


<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

<?php
$old_password = array(
	'name'	=> 'old_password',
	'id'	=> 'old_password',
	'value' => set_value('old_password'),
	'size' 	=> 30,
);
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
?>

<h4>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp비밀번호를 변경해주세요.</h4> 
            <hr/>

<?php echo form_open($this->uri->uri_string()); ?>
<div class="span9">
	<div class="row">

		<div class="span2" style="float:left;"><?php echo form_label('Old Password', $old_password['id']); ?></div>
		<div class="span3"><?php echo form_password($old_password); ?></div>
		<div class="span4" style="color: red;"><?php echo form_error($old_password['name']); ?><?php echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; ?></div>
	</div>
	<div class="row">
		<div class="span2" style="float:left;"><?php echo form_label('New Password', $new_password['id']); ?></div>
		<div class="span3"><?php echo form_password($new_password); ?></div>
		<div class="span4" style="color: red;"><?php echo form_error($new_password['name']); ?><?php echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:''; ?></div>
	</div>
	<div class="row">
		<div class="span2" style="float:left;"><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?></div>
		<div class="span3"><?php echo form_password($confirm_new_password); ?></div>
		<div class="span4" style="color: red;"><?php echo form_error($confirm_new_password['name']); ?><?php echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:''; ?></div>
	</div>





<?php //echo form_submit('change', '비밀번호 변경하기'); ?>
<input type="submit" class="btn btn-success" value="비밀번호 변경하기">
<?php echo form_close(); ?>
</div>

