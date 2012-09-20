<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<?php $this->load->helper('form') ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>새글</title>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>

<script>
function search_confirm()
{
	if(document.search_form.keyword.value == '')
	{
		alert('검색어를 입력하세요.');
		document.serch_form.keyword.focus();
		return;
	}

	document.search_form.submit();
}


</script>

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
$etc = "";
if($key != "" && $keyword != ""){
	$etc = "?key=" . $key . "&keyword=" . $keyword;
}
?>
<body>
	<form class="bs-docs-example form-search" name="search_form">

		<h1 align="center">Member List</h1>
		<br>

		<div class="container">
			<table class="table table-hover">
				<thead>
					<tr>

						<td><h4>번호</h4></td>
						<td><h4>ID</h4></td>
						<td><h4>Name</h4></td>
						<td><h4>E-Mail</h4></td>
						<td><h4>권한</h4></td>
						<td><h4>goodbye</h4></td>
						<td><h4>grant admin</h4></td>

					</tr>
				</thead>
				<tbody>
					<?php 


					$no=1;
					foreach($result as $row)
					{
						echo "<tr>";
						echo "<td>".$no."</td>";
						echo "<td>".$row->id."</td>";
						echo "<td>".$row->username."</td>";
						echo "<td>".$row->email."</td>";
						if($row->level == 'admin'){
							echo "<td>관리자</td>";
						}
						else {
							echo "<td>사용자</td>";

						}

						echo " <td><a href=' ".site_url("/member/good_bye?id=$row->id")."'>".form_button('btn_goodbye','Goodbye')."</a></td>";
						echo " <td><a href=' ".site_url("/member/admin_set?id=$row->id")."'>".form_button('btn_grant','Admin_Set')."</a></td>";
						echo "</tr>";

						$no=$no+1;

					}


					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7">
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
			<div align="right">
				<select name="key" size="1" class="span2">
					<option value="username"
					<? if($key == "username") echo "selected"; ?>>회원이름</option>
					<option value="id" <? if($key == "id") echo "selected"; ?>>아이디</option>
					<option value="email" <? if($key == "email") echo "selected"; ?>>이메일</option>
				</select>
				<div class="input-append">
					<input type="text" name="keyword" class="span2 search-query"
						value="<?=$keyword?>">
					<button class="btn" onclick="search_confirm();">Search</button>
				</div>
			</div>
		</div>

		<a class="btn btn-primary btn-large" href="member/logout">로그아웃 </a>

	</form>
</body>
</html>
