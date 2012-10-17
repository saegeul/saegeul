<?php $this->load->helper('asset') ?>
<?echo css_asset('sitemap','sitemap.css')?>
<?echo js_asset('sitemap','jquery.sitemaplist.js')?>
<div class="_content">
	<div class="alert alert-success" align="center">사이트 맵을 작성 하여 주십시오.</div>
	<div style='float: right;'>
		<a class="btn btnCreateMenu"><i class="icon-plus"></i> 메뉴추가</a>
	</div>
	<br>
	<div class="siteMap">
		<br>
		<ul class='nav nav-list' id='siteMap'>
			<?php foreach($siteMapList as $key => $site) :?>
			<li class='menu' id='<?=$site->site_srl;?>'><i class="icon-move"></i>
				<span class="menuInfo"><?=$site->site_name;?> </span> <span
				class="side"> <a class="btn btn-link btnAppendSite"
					style='color: #333333;'><i class="icon-plus"></i>Append</a> <a
					class="btn btn-link btnEditSite hide" style='color: #333333;'><i
						class="icon-pencil"></i>Edit</a> <a
					class="btn btn-link btnDeleteSite" style='color: #333333;'><i
						class="icon-trash"></i>Delete</a>
			</span>
			</li>
			<?php endforeach ;?>
		</ul>
		<br>
	</div>
</div>
<div class="modal hide fade" id="menuModal" style="width: 490px;">
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
						name='module' id='radioCreateModule' class='hide'> <!-- 모듈 생성 -->
					</label> <label class="radio inline"> <input type="radio" value="2"
						name='module' id='radioLinkModule' class='hide'> <!-- 모듈 연결 -->
					</label> <label class="radio inline"> <input type="radio" value="3"
						name='module' id='radioLinkURL'> URL 연결
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
			<div class="control-group parnetId hide">
				<input type="hidden" id='inputParentSrl'>
			</div>
			<div class="control-group linkURL hide">
				<label class="control-label">연결URL</label>
				<div class="controls">
					<input type="text" id="inputLinkURL">
				</div>
			</div>
			<div class="control-group isValid hide">
				<label class="control-label">접근권한</label>
				<div class="controls">
					<label class="radio inline"> <input type="radio" value="Y"
						name='isvalid' id="radioIsValidOk" checked> 접근허용
					</label> <label class="radio inline"> <input type="radio" value="N"
						name='isvalid' id="radioIsValidNo"> 접근불가
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Close</a> <a
			href="javascript:void(0)" class="btn btn-primary saveData hide">저장</a>
		<a href="javascript:void(0)" class="btn btn-primary modifyData hide">수정</a>
		<a href="javascript:void(0)" class="btn btn-primary appendData hide">추가</a>
	</div>
</div>
