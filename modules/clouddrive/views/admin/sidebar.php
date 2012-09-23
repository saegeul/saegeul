<?php $this->load->library('session') ?>
<?php 
// check access token
$oauth_token =  $this->session->userdata('session_kt_ucloud_oauth_token');
$oauth_verifier =  $this->session->userdata('session_kt_ucloud_oauth_verifier');
?>
<div class="span3 bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav affix-top">
		<li><a href="<?=base_url()?>clouddrive/admin/clouddrive/checkOauth"><i
				class="icon-chevron-right"></i>인증 내영 확인</a> 
<?php 
	if($oauth_token != null && $oauth_token != ""){
?>
		<li><a
			href="<?=base_url()?>clouddrive/admin/clouddrive/ucloudView"><i
				class="icon-chevron-right"></i> KTUcloud</a>
		</li>
<?php }else{?>
		<li><a
			href="<?=base_url()?>clouddrive/admin/clouddrive/checkOauth"><i
				class="icon-chevron-right"></i> KT Ucloud</a>
		</li>
<?php }?>
		<li><a><i class="icon-chevron-right"></i>SK Tcloud</a>
		</li>
		<li><a><i class="icon-chevron-right"></i>Google Drive</a>
		</li>
	</ul>
</div>