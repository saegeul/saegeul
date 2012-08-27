<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>새글</title>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<SCRIPT>  
function search_confirm()
{
	if(document.search_form.keyword.value == '')
	{
		alert('검색어를 입력하세요.');
		document.search_form.keyword.focus();
		return;
	}
	document.search_form.submit();
}
</SCRIPT>
</head>
<?php 
// 페이징 만들기
$page_per_block = 5;
$prev_page = $page - 1;
$next_page = $page + 1;
$first_page = ((integer)(($page-1)/$page_per_block) * $page_per_block) + 1;
$last_page = $first_page + $page_per_block - 1;
if ($last_page > $total_page)
	$last_page = $total_page;
?>
<body>
	<h1 align="center">Upload List</h1>
	<br>
	<form class="bs-docs-example form-search" name="search_form" method="post" action="<?=$act_url?>">
		<div align="right">
			<select name="key" size="1" class="span2">
				<option value="upload_img_name"
				<? if($key == "upload_img_name") echo "selected"; ?>>파일이름</option>
				<option value="sid" <? if($key == "sid") echo "selected"; ?>>작성자</option>
				<option value="reg_date"
				<? if($key == "reg_date") echo "selected"; ?>>작성날짜</option>
			</select>
			<div class="input-prepend">
				<input type="text" name="keyword" class="span2 search-query"
					value="<?=$keyword?>"> <INPUT class="btn" type=button value="Search"
					onclick="search_confirm();">
			</div>
		</div>
		<br>
		<div class="bs-docs-example">
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
					<?php foreach ($result as $row): ?>
					<tr>
						<td><?=$row->img_srl?></td>
						<td><img
							src="<?=$base_url?>filebox/files/img/<?=date ('Ymd', strtotime($row->reg_date))?>/thumbs/<?=$row->source_img_name?>"
							class="img-polaroid">
						</td>
						<td>
							<dl style="text-align: left;">
								<dd>
									Down Name :
									<?=$row->source_img_name?>
								</dd>
								<dd>
									Upload Name :
									<?=$row->upload_img_name?>
								</dd>
								<dd>
									Img Type :
									<?=$row->img_type?>
								</dd>
								<dd>
									Img Size :
									<?=$row->img_size?>
								</dd>
							</dl>
						</td>
						<td><?=$row->sid?></td>
						<td><?=$row->reg_date?></td>
					</tr>
					<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<div style="text-align: center;">
								<a href="<?=$act_url?>/1">[맨앞]</a>
								<?php 
								if($page>1) {
									?>
								<a href='<?=$act_url?>/<?=$prev_page?>'>◀</a>
								<?php 
								}
								for ($i=$first_page;$i<=$last_page;$i++):
								if($page == $i) {
									$bold_s = "<b>"; $bold_e = "</b>";
								} else {
									$bold_s = ""; $bold_e = "";
								}
								?>
								<a href="<?=$act_url?>/<?=$i?>"><?=$bold_s?> <?=$i?> <?=$bold_e?>
								</a>
								<?php 
								endfor;
								if($page < $total_page){
									?>
								<a href="<?=$act_url?>/<?=$next_page?>">▶</a>
								<?php 
								}
								?>
								<a href="<?=$act_url?>/<?=$total_page?>">[맨뒤]</a>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</form>
</body>
</html>
