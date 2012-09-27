<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<?echo js_asset('filebox','jquery.filelist.js')?>
<?php 
// 페이징 만들기
$page_per_block = 5;
$prev_page = $page - 1;
$next_page = $page + 1;
$first_page = ((integer)(($page-1)/$page_per_block) * $page_per_block) + 1;
$last_page = $first_page + $page_per_block - 1;
if ($last_page > $total_page)
	$last_page = $total_page;
$etc = "";
if($key != "" && $keyword != ""){
	$etc = "?key=" . $key . "&keyword=" . $keyword;
}
?>
<div class="span9">
	<form class="form-search" name="search_form"
		action="<?=$act_url?>">
		<div align="right">
			<select name="key" size="1">
				<option value="upload_file_name"
				<? if($key == "upload_file_name") echo "selected"; ?>>파일이름</option>
				<option value="username" <? if($key == "username") echo "selected"; ?>>작성자</option>
				<option value="reg_date"
				<? if($key == "reg_date") echo "selected"; ?>>작성날짜</option>
			</select>
			<div class="input-append">
				<input type="text" name="keyword" class="span2 search-query"
					value="<?=$keyword?>"> <a class="btn"
					href="javascript:search_confirm();"><i class="icon-search"></i> </a>
			</div>
		</div>
		<br>
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th colspan="2" style="text-align: center;">Photo</th>
					<th>User</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($result as $row): 
				$no = $row->file_srl;
				$fileName = $row->upload_file_name;
				$fileType = $row->file_type;
				$fileSize = $row->file_size . "(KB)" ;
				$author = $row->username;
				$regDate = $row->reg_date;
				$address = $row->ip_address;
				$isvalid = $row->isvalid;
				$tag = $row->tag;
				$downCnt = $row->down_cnt;
				$source_file_name = $row->source_file_name;
				$img_fold_url = $base_url."filebox/files/img/". date('Ymd', strtotime($row->reg_date));
				$file_fold_url = $base_url."filebox/files/file/". date('Ymd', strtotime($row->reg_date));
				$folder_url = "";
				$filePath = "";
				if(is_file($file_fold_url . "/" . $row->source_file_name)){
					$filePath = $file_fold_url . "/" . $row->source_file_name;
					$folder_url = $file_fold_url;
				}else if(is_file($img_fold_url . "/" . $row->source_file_name)){
					$filePath = $img_fold_url . "/" . $row->source_file_name;
					$folder_url = $img_fold_url;
				}
				
				
				$exts = explode(".",$source_file_name) ;
				$file_thumb_name = $exts[0];
				$file_thumb_type = $exts[1];				

				$thumbnailPath = $img_fold_url . "/thumbs/" . $file_thumb_name . "_110*90" . "." .$file_thumb_type;
				
				if(($fileType != "image/jpg") && ($fileType != "image/JPG") && ($fileType != "image/jpeg") && ($fileType != "image/JPEG") && ($fileType != "image/gif") && ($fileType != "image/GIF") && ($fileType != "image/png") && ($fileType != "image/PNG"))
					$thumbnailPath = "/saegeul/modules/clouddrive/views/assets/img/no_image.png";
				?>
				<tr
					onclick="FileModify('<?=$filePath?>','<?=$thumbnailPath?>','<?=$fileName?>','<?=$fileType?>','<?=$author?>','<?=$regDate?>','<?=$address?>','<?=$isvalid?>','<?=$no?>','<?=$tag?>','<?=$source_file_name?>','<?=$downCnt?>','<?=$folder_url?>')">
					<td><?=$row->file_srl?></td>
					<td>
						<div style="margin-top: 16px;">
							<ul class="thumbnails">
								<li class="span2">
									<div class="thumbnail" align="center">
										<img src="<?= $thumbnailPath?>" class="img-polaroid">
									</div>

								</li>
							</ul>
						</div>
					</td>
					<td>
						<dl style="text-align: left; margin-top: 25px;">
							<dd>
								Upload Name :
								<?=$fileName?>
							</dd>
							<dd>
								Img Type :
								<?=$fileType?>
							</dd>
							<dd>
								Img Size :
								<?=$fileSize?>
							</dd>
						</dl>
					</td>
					<td><div style="margin-top: 45px;">
							<?=$author?>
						</div></td>
					<td><div style="margin-top: 45px;">
							<?=$regDate?>
						</div></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="pagination" style="text-align: center;">
							<ul>
								<li><a href="<?=$act_url?>/1<?=$etc?>">&laquo;</a></li>
								<?php 
								if($page>1) {
									?>
								<li><a href="<?=$act_url?>/<?=$prev_page?><?=$etc?>">prev</a></li>
								<?php 
								}else {
									?>
								<li class="active"><a>prev</a></li>
								<?php 
								}
								for ($i=$first_page;$i<=$last_page;$i++):
								if($page == $i) {
									?>
								<li class="active"><a><?=$i?>
								</a></li>
								<?php
								} else {
									?>
								<li><a href="<?=$act_url?>/<?=$i?><?=$etc?>"><?=$i?> </a>
								</li>
								<?php 
								}
								endfor;

								if($page < $total_page) {
									?>
								<li><a href="<?=$act_url?>/<?=$next_page?><?=$etc?>">next</a></li>
								<?php 
								}else {
									?>
								<li class="active"><a>next</a></li>
								<?php 
								}
								?>
								<li><a href="<?=$act_url?>/<?=$total_page?><?=$etc?>">&raquo;</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
	<div id="dialog-confirm"></div>
</div>
