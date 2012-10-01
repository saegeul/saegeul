<?php $this->load->helper('asset') ?>
<?echo js_asset('filebox','jquery.filelist.js')?>
<br>
<div class="content">
	<form class="well well-small form-search" name="search_form">
		<div align="left">
			<select name="key" size="1">
				<option value="original_file_name">파일이름</option>
				<option value="username">작성자</option>
				<option value="reg_date">작성날짜</option>
			</select>
			<div class="input-append">
				<input type="text" name="keyword" class="span2 search-query"> <a
					class="btn" href="javascript:search_confirm();"><i
					class="icon-search"></i> </a>
			</div>
		</div>
	</form>
	<table class="table table-hover">
		<thead>
			<tr>
				<th><input type="checkbox" id="all_file_check"/></th>
				<th>filename</th>
				<th>size(KB)</th>
				<th>filetype</th>
				<th>username</th>
				<th><button class="btn btn-small btn-danger delete_all">All Delete</button>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($fileList as $key => $file) :?>
			<tr id='<?=$file->file_srl;?>'>
				<td><label for="check_id"><?=$file->file_srl;?><br /> <input
						type="checkbox" class="file_check" /> </label>
				</td>
				<td>
					<div style="padding-left: 160px;">
						<div style="margin-left: -160px; float: left; width: 150px;">
							<a href='javascript:void(0)' class='file_modify'
								data-id='<?=$file->file_srl;?>'> <img
								src="<?=base_url().$file->image_thumb_path;?>" />
							</a>
						</div>
						<p>
							<a
								href="<?=base_url()?>filebox/admin/filebox/download/<?=$file->file_srl?>"><?=$file->original_file_name;?>
							</a>
						</p>
					</div>
				</td>
				<td><?=$file->file_size_kb;?>
				</td>
				<td><?=$file->file_type;?>
				</td>
				<td><?=$file->username;?>
				</td>
				<td><a class="btn btn-small btn-warning btn_delete">DEL
				</a>
				</td>
			</tr>
			<?php endforeach ;?>
		</tbody>
	</table>
	<div class="modal fade" id="modify_modal">
		<div class="modal-header">
			<h3>File Modify</h3>
		</div>
		<div class="modal-body">
			<dl class='thumbnails' style="width: 480px;">
				<dd>
					<div>
						<INPUT type='hidden' id='mod_file_srl' readonly>
					</div>
				</dd>
				<dd
					style='margin-left: 37px; height: 110px; width: 130px; float: left;'>
					<div align='center'
						style='margin: 0px auto; height: 100px; width: 120px; -moz-transition: all 0.2s ease-in-out 0s; border: 1px solid rgb(221, 221, 221); border-radius: 4px 4px 4px 4px; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.055); display: block; padding: 4px; line-height: 100px;'>
						<img id='mod_img' src="">
					</div>
				</dd>
				<dd style='float: right;'>
					<div>
						파일 이름 : <INPUT type='text' id='mod_name'>
					</div>
				</dd>
				<dd style='float: right;'>
					<div>
						파일 유형 : <INPUT type='text' id='mod_type' readonly>
					</div>
				</dd>
				<dd style='float: right;'>
					<div>
						올린 사람 : <INPUT type='text' id='mod_author' readonly>
					</div>
				</dd>
			</dl>
			<dl>
				<dd>
					<div class="form-inline" style="line-height: 45px;"> 접근 권한 :
						<div class="btn-group" data-toggle="buttons-radio">
							<button type="button" class="btn btn-small" id='mod_isvalid_yes'>허용</button>
							<button type="button" class="btn btn-small" id='mod_isvalid_no'>거부</button>

						</div>
					</div>
				</dd>
				<dd>
					파일 태그 : <INPUT type='text' id='mod_tag'>
				</dd>
				<dd>
					다운 횟수 : <INPUT type='text' id='mod_down_cnt' readonly>
				</dd>
				<dd>
					등록 날짜 : <INPUT type='text' id='mod_reg_date' readonly>
				</dd>
				<dd>
					IP&nbsp;&nbsp;&nbsp; 주소 : <INPUT type='text' id='mod_address'
						readonly>
				</dd>
			</dl>
		</div>
		<div class="modal-footer">
			<a class="btn" data-dismiss="modal">Close</a> <a
				href="javascript:void(0)" class="btn btn-primary save_data">Save
				Changes</a>
		</div>
	</div>
	<div class="pagination pagination-centered">
		<?php
		$first_page = $pagination['page'] - 5 <= 0 ? 1 : $pagination['page'] - 5 ;
		$next_limit =  $pagination['page']+5 < $pagination['page_count'] ? $pagination['page']+5 : $pagination['page_count'] ;
		?>
		<ul>
			<?php for($i=$first_page ; $i <$pagination['page'];$i++):?>
			<li><a href="<?=base_url()?>filebox/admin/filebox/fileList/<?=$i;?>"><?=$i;?>
			</a></li>
			<?php endfor;?>
			<li class="active"><a href="#"><?=$pagination['page'];?> </a></li>
			<?php for($i=$pagination['page']+1 ; $i <=$next_limit;$i++):?>
			<li><a href="<?=base_url()?>filebox/admin/filebox/fileList/<?=$i;?>"><?=$i;?>
			</a></li>
			<?php endfor;?>
		</ul>
	</div>
</div>
