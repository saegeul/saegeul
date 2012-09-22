<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<script type="text/javascript">
$("#oauth").live('click',function(e) {
	location.href="/saegeul/auth/oauth";
});

$("#clouddrive").live('click',function(e) {
	var oauth_token = $(this).parent().prev().prev().text();
	location.href="/saegeul/clouddrive/admin/clouddrive/ucloudView?oauth_token=K8hhHsYGB5ka8yI7aZoF";
});
</script>
<div class="span9" align="center">
	<div class="header">
		<h2>KT Ucloud 인증 내역</h2>
	</div>
	<br>
	<div class="center">
		<form action="">
			<table class="table table-hover" style="text-align: center;">
				<thead>
					<tr>
						<th>출처</th>
						<th>AccessToken</th>
						<th>AccessSecret</th>
						<th>인증여부</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if($oauth_token != "" && $oauth_token_secret != ""){
						?>
					<tr>
						<td>Ucloud</td>
						<td><?=$oauth_token?></td>
						<td><?=$oauth_token_secret?></td>
						<td><button class="btn btn-success" type="button" id='clouddrive'>OK</button></td>
					</tr>
					<?php 
					}else {
						?>
					<tr>
						<td>Ucloud</td>
						<td>X</td>
						<td>X</td>
						<td><button class="btn btn-danger" type="button" id='oauth'>NO</button></td>
					</tr>
					<?php 
					}
					?>
				</tbody>
			</table>
		</form>
	</div>
</div>
