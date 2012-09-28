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
				<th><input type="checkbox" /></th>
				<th>filename</th>
				<th>size(KB)</th>
				<th>filetype</th>
				<th>username</th>
				<th><button class="btn btn-small btn-danger deleteall">All Delete</button>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($fileList as $key => $file) :?>
			<tr>
				<td><label for="check_id"><?=$file->file_srl;?><br /> <input
						type="checkbox" name="check_id" /> </label>
				</td>
				<td>
					<div style="padding-left: 160px;">
						<div style="margin-left: -160px; float: left; width: 150px;">
							<a href="#modify_modal" data-toggle="modal"> <img
								src="<?=base_url().$file->image_thumb_path;?>" />
							</a>
							<div class="modal fade" id="modify_modal">
								<div class="modal-header">
									<h3>File Modify</h3>
								</div>
								<div class="modal-body">
									<dl class='thumbnails' style="width: 480px;">
										<dd
											style='margin-left: 37px; height: 110px; width: 130px; float: left;'>
											<div align='center'
												style='margin: 0px auto; height: 100px; width: 120px; -moz-transition: all 0.2s ease-in-out 0s; border: 1px solid rgb(221, 221, 221); border-radius: 4px 4px 4px 4px; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.055); display: block; padding: 4px; line-height: 100px;'>
												<img src="<?=base_url().$file->image_thumb_path;?>">
											</div>
										</dd>
										<dd style='float: right;'>
											<div>
												파일 이름 : <INPUT type='text' id='mod_name' name='mod_name'
													value='<?=$file->username;?>'>
											</div>
										</dd>
										<dd style='float: right;'>
											<div>
												파일 유형 : <INPUT type='text' id='mod_type' name='mod_type'
													value='<?=$file->file_type;?>' readonly>
											</div>
										</dd>
										<dd style='float: right;'>
											<div>
												올린 사람 : <INPUT type='text' id='mod_author' name='mod_author'
													value='<?=$file->username;?>' readonly>
											</div>
										</dd>
									</dl>
									<dl>
										<dd>
											파일 태그 : <input type='text' id='mod_tag' name='mod_tag'
												value='<?=$file->tag;?>'>
										</dd>
										<?php 
										if ($file->isvalid == "Y"){
											?>
										<dd>
										<label class="form-inline">
											접근 권한 : <INPUT type='radio' value='Y' class='mod_isvalid'
												name='mod_isvalid' checked> 허용 <INPUT type='radio' value='N'
												class='mod_isvalid' name='mod_isvalid'> 거부
										</label>
										</dd>
										<?php 
										}else{
											?>
										<dd>
											<INPUT type='radio' value='Y' class='mod_isvalid'
												name='mod_isvalid'> 허용 <INPUT type='radio' value='N'
												class='mod_isvalid' name='mod_isvalid' checked> 거부
										</dd>
										<?php 
										}
										?>
										<dd>
											다운 횟수 : <INPUT type='text' id='mod_down_cnt'
												value='<?=$file->down_cnt;?>'>
										</dd>
										<dd>
											등록 날짜 : <INPUT type='text' id='mod_redate'
												value='<?=$file->reg_date;?>' readonly>
										</dd>
										<dd>
											IP&nbsp;&nbsp;&nbsp; 주소 : <INPUT type='text' id='mod_address'
												value='<?=$file->ip_address;?>' readonly>
										</dd>
									</dl>
								</div>
								<div class="modal-footer">
									<a href="#" class="btn" data-dismiss="modal">Close</a> <a
										href="#" class="btn btn-primary">Save Changes</a>
								</div>
							</div>
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
				<td><a class="btn btn-small btn-warning"
					href="<?=base_url()?>filebox/admin/filebox/delete/<?=$file->file_srl;?>">DEL
				</a>
				</td>
			</tr>
			<?php endforeach ;?>
		</tbody>
	</table>
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
