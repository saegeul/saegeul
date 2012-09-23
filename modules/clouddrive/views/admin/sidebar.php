<?php $this->load->library('session') ?>
<?php 
// check access token
$oauth_token =  $this->session->userdata('session_oauth_token');
?>
<div class="span3 bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav affix-top">
		<li class="dropdown-submenu"><a href="#"><i
				class="icon-chevron-right"></i>KT Ucloud</a>
			<ul class="nav nav-list bs-docs-sidenav dropdown-menu">
				<li><a href="<?=base_url()?>clouddrive/admin/clouddrive/checkOauth">인증 내역 확인</a></li>
				<li><a href="<?=base_url()?>clouddrive/admin/clouddrive/ucloudView?oauth_token=<?=$oauth_token?>">Ucloud 사용 하기</a></li>
			</ul></li>
		<li><a><i class="icon-chevron-right"></i>SK Tcloud</a>
		</li>
		<li><a><i class="icon-chevron-right"></i>Google Drive</a>
		</li>
	</ul>
</div>
