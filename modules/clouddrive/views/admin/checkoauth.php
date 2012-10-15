<?php $this->load->helper('asset') ?>
<?echo js_asset('clouddrive','jquery.checkOauth.js')?>
<div class="_content" >
	<div class="header" align="center">
		<h2>KT Ucloud 인증 내역</h2>
	</div>
	<br>
	<div class="center">
		<form action="">
			<table class="table table-hover" style="text-align: center;">
				<thead>
					<tr>
						<th>출처</th>
						<th>ApiKey</th>
						<th>SecretKey</th>
						<th>AccessToken</th>
						<th>AccessSecret</th>
						<th>인증여부</th>
					</tr>
				</thead>
				<tbody style='font-size: 80%;'>
					<?php 
					if($api_key == "" && $secret_key == ""){
						?>
					<tr>
						<td>Ucloud</td>
						<td><input type="text" class="input-small" id="apikey"
							placeholder="ApiKey"></td>
						<td><input type="text" class="input-small" id="secretkey"
							placeholder="SecretKey"></td>
						<td>X</td>
						<td>X</td>
						<td><button class="btn btn-primary" type="button" id='creatapi'>등록</button>
						</td>
					</tr>
					<?php 
					}else if($oauth_token == "" && $oauth_token_secret == ""){
						?>
					<tr>
						<td>Ucloud</td>
						<td><?=$api_key?></td>
						<td><?=$secret_key?></td>
						<td>X</td>
						<td>X</td>
						<td><button class="btn btn-danger" type="button" id='oauth'>NO</button>
						</td>
					</tr>
					<?php 
					}else{
						?>
					<tr>
						<td>Ucloud</td>
						<td><?=$api_key?></td>
						<td><?=$secret_key?></td>
						<td><?=$oauth_token?></td>
						<td><?=$oauth_token_secret?></td>
						<td><button class="btn btn-success" type="button" id='clouddrive'>OK</button>
						</td>
					</tr>
					<?php 
					}
					?>

				</tbody>
			</table>
		</form>
	</div>
</div>
