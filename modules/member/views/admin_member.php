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

function really_ban(ban_id){
conf = confirm("정말 탈퇴 시키겠습니까??");
	if(conf){
		alert("회원을 탈퇴 시켰습니다.");
		location.href=" <?=site_url("/member/good_bye?")?>id="+ban_id;
	}
		
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


	<div class="container-fluid">
		<div class="row-fluid">
			
				<h1>

					<a href="<?=site_url("/member/admin_member")?>">Member List</a>
					<small><p class="text-success">
						회원 관리 모드입니다.
						</p></small>
				
				</h1>
		
			<hr />
			<div id="content_body" class="span10">

				<form class="bs-docs-example form-search" name="search_form">


					<!-- 검색부분    -->	
					<div class="well">
						<div align="right">
							<select name="key" size="1" class="span2">
								<option value="username"
								<? if($key == "username") echo "selected"; ?>>회원이름</option>
								<option value="id" <? if($key == "id") echo "selected"; ?>>아이디</option>
								<option value="email" <? if($key == "email") echo "selected"; ?>>이메일</option>
							</select>
							<div class="input-append">
								<input type="text" name="keyword" class="span8 search-query"
									value="<?=$keyword?>">
								<button class="btn" onclick="search_confirm();">Search</button>
							</div>
						</div>
					</div>
					<!-- 검색부분    -->
					
					
					
					<br> <br>
					
					
					<!-- 회원목록 테이블 시작   -->
					<div class="well">
						<table class="table table-hover">
							
							<!-- 회원목록    -->
							<thead class="row">
								<tr>

									<td class="span1"><h4>번호</h4></td>
									<td class="span1"><h4>ID</h4></td>
									<td class="span1"><h4>Name</h4></td>
									<td class="span1"><h4>E-Mail</h4></td>
									<td class="span1"><h4>권한</h4></td>
									<td class="span1"><h4>Goodbye</h4></td>
									<td class="span1"><h4>Grant Admin</h4></td>

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
									?>

								<td><input type="button" class="btn btn-danger" value="Good_Bye"
									onclick="really_ban(<?=$row->id?>);"></td>
								<td><a href="<?=site_url("/member/admin_set?id=$row->id")?>"><input
										type="button" class="btn btn-success" value="Admin_set"> </a>
								</td>
								<?php 						

								echo "</tr>";

								$no=$no+1;

								}


								?>
							</tbody>
							
							<!-- 회원목록   -->
							
							
							<!-- Pagination    -->
							<tfoot>
								<tr>
									<td colspan="7">
										<div class="pagination" style="text-align: center;">
											<ul>
												<li><a href="<?=$act_url?>/1">First</a></li>
												<?php 
												if($page>1) {
													?>
												<li><a href='<?=$act_url?>/<?=$prev_page?>'>&lt</a></li>
												<?php 
												}
												for ($i=$first_page;$i<=$last_page;$i++):
												if($page == $i) {
													$bold_s = "<b>"; $bold_e = "</b>";
												} else {
													$bold_s = ""; $bold_e = "";
												}
												?>
												<li><a href="<?=$act_url?>/<?=$i?>"><?=$bold_s?> <?=$i?> <?=$bold_e?>
												</a></li>
												<?php 
												endfor;
												if($page < $total_page){
													?>
												<li><a href="<?=$act_url?>/<?=$next_page?>">&gt</a></li>
												<?php 
												}
												?>
												<li><a href="<?=$act_url?>/<?=$total_page?>">Last</a></li>
											</ul>
										</div>
									</td>
								</tr>
							</tfoot>
							<!-- Pagination    -->

						</table>
						<!-- 회원목록 테이블 끝    -->
						
						<hr>

						<!-- 로그아웃 버튼    -->
						<div align="right">
							<a class="btn btn-primary btn-large"
								href="<?=site_url("/member/logout")?>">로그아웃 </a>
						</div>
						<!-- 로그아웃 버튼    -->
						
					</div>



				</form>

			</div>
		</div>

</body>
</html>
