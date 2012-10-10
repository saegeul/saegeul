<?php $this->load->helper('asset') ?>
<?echo js_asset('site','jquery.sitelist.js')?>
<div class="content" style='width: 98%;'>
	<br>
	<div style='float: right;'>
		<a class="btn create_map"><i class="icon-plus"></i> 메뉴추가</a>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th></th>
				<th>Manu Name</th>
				<th>Menu Module</th>
				<th style='text-align: center; width: 265px;'>Menu Set</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($siteList as $key => $site) :?>
			<tr id='<?=$site->site_srl?>'>
				<td><?=$site->site_srl?></td>
				<td><?=$site->site_name?></td>
				<td><?=$site->site_module?></td>
				<td>
					<div>
						<a class="btn btn-link btn_append" style='color: #333333;'><i
							class="icon-plus"></i>Append</a> <a class="btn btn-link btn_edit"
							style='color: #333333;'><i class="icon-pencil"></i>Edit</a> <a
							class="btn btn-link btn_delete" style='color: #333333;'><i
							class="icon-trash"></i>Delete</a>
					</div>
				</td>
			</tr>
			<?php endforeach ;?>
		</tbody>
	</table>
</div>
<div class="modal hide fade" id="create_site_modal"
	style="width: 490px;">
	<div class="modal-header">
		<h3>Create Menu</h3>
	</div>
	<div class="modal-body">
		<div class="form-horizontal" style='margin-left: -60px;'>
			<div class="control-group">
				<label class="control-label">메뉴 이름</label>
				<div class="controls">
					<input type="text" id="inputMenuName">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">모듈 또는 URL</label>
				<div class="controls">
					<label class="radio inline"> <input type="radio" value="1"
						name='module'> 모듈 생성
					</label> <label class="radio inline"> <input type="radio" value="2"
						name='module'> 모듈 연결
					</label> <label class="radio inline"> <input type="radio"
						id="LinkURL" value="3" name='module'> URL 연결
					</label>
				</div>
			</div>
			<div class="control-group createModule hide">
				<label class="control-label">모듈</label>
				<div class="controls">
					<select id='creatModuleValue' style='width: 100px; float: left;'>
						<option value='document'>Document</option>
						<option value='file'>File</option>
						<option value='page'>Page</option>
					</select> &nbsp; <select style='width: 210px;'
						class='linkModule hide'>
					</select>
				</div>
			</div>
			<div class="control-group createModuleId hide">
				<label class="control-label">모듈 아이디 생성</label>
				<div class="controls">
					<input type="text" id="inputModuleId">
				</div>
			</div>
			<div class="control-group linkURL hide">
				<label class="control-label">연결URL</label>
				<div class="controls">
					<input type="text" id="inputLinkURL">
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Close</a> <a
			href="javascript:void(0)" class="btn btn-primary save_data">저장</a>
	</div>
</div>
