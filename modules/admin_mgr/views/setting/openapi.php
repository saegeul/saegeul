<?php $this->load->helper('asset') ?>
<?echo js_asset('admin_mgr','jquery.openapi.js')?>
<div class="_content">
	<div class="well form-inline" style="height: 30px;">
		<input type="text" id="provider" placeholder="Provider" /> <input
			type="text" id="api_key" placeholder="API KEY" /> <input type="text"
			id="secret_key" placeholder="SECRET KEY" />
		<button class="btn btn-primary btnCreateOpenApi">등록</button>
	</div>

	<table class="table table-stripped">
		<thead>
			<tr>
				<th>#</th>
				<th>Provider</th>
				<th>API KEY</th>
				<th>SECRET KEY</th>
				<th>OAuth Token</th>
				<th>OAuth Secret Token</th>
				<th>인증</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($api_key_list as $key => $_api_info):?>
			<tr id="<?php echo $_api_info->openapi_id; ?>">
				<td><?php echo $_api_info->openapi_id; ?></td>
				<td><?php echo $_api_info->provider; ?></td>
				<td><?php echo $_api_info->api_key; ?></td>
				<td><?php echo $_api_info->secret_key; ?></td>
				<td><?php echo $_api_info->oauth_token; ?></td>
				<td><?php echo $_api_info->oauth_secret_token; ?></td>
				<td><a class="btn btn-link btnCheckAuth"
					style='color: #333333;'><i class="icon-user"></i>인증</a> <a
					class="btn btn-link btnEditOpenApi" style='color: #333333;'><i
						class="icon-pencil"></i>Edit</a> <a
					class="btn btn-link btnDeleteOpenApi" style='color: #333333;'><i
						class="icon-trash"></i>Delete</a>
				</td>
			</tr>
			<?php endforeach ;?>
		</tbody>
	</table>
</div>
<div class="modal hide fade" id="openApiModal" style="width: 490px;">
	<div class="modal-header">
		<h3>Edit OpenApi</h3>
	</div>
	<div class="modal-body">
		<div class="form-horizontal" style='margin-left: -60px;'>
			<input type="hidden" id="inputOpenapiId">
			<div class="control-group">
				<label class="control-label">Provider</label>
				<div class="controls">
					<input type="text" id="inputProvider">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">API KEY</label>
				<div class="controls">
					<input type="text" id="inputApiKey">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">SECRET KEY</label>
				<div class="controls">
					<input type="text" id="inputSecretKey">
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Close</a>
		<a href="javascript:void(0)" class="btn btn-primary modifyData">수정</a>
	</div>
</div>
