<?php $this->load->library('session') ?>
<?php 
// check access token
$oauth_token =  $this->session->userdata('session_kt_ucloud_oauth_token');
$oauth_verifier =  $this->session->userdata('session_kt_ucloud_oauth_verifier');
?>
<div class="admin_sidebar_wrapper">
	<div class=" bs-docs-sidebar">
		<ul class="nav nav-list bs-docs-sidenav affix-top">
			<li <?php if($action=='checkOauth'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/clouddrive/checkOauth"><i
					class="icon-chevron-right"></i>인증 내역 확인</a>
			</li>
			<?php 
			if($oauth_token != null && $oauth_token != ""){
				?>
			<li <?php if($action=='ucloudView'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/clouddrive/ucloudView"><i
					class="icon-chevron-right"></i> KTUcloud</a>
			</li>
			<?php }else{?>
			<li <?php if($action=='ucloudView'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/clouddrive/checkOauth"><i
					class="icon-chevron-right"></i> KT Ucloud</a>
			</li>
			<?php }?>
			<li><a><i class="icon-chevron-right"></i>SK Tcloud</a>
			</li>
		</ul>
	</div>
</div>


