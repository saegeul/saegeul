<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>새글</title>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>

</head>
<h1>welcome</h1>

<ul class="nav nav-pills">

	<li><a href="member/admin_member">회원관리 </a></li>
	<?php echo "<br>"?>
	<li><a href="member/change_password"> 관리자 비밀번호 변경 </a></li>
	<?php echo "<br>"?>
	<li><a href="member/do_invite">초대 </a></li>
	<?php echo "<br>"?>

</ul>





<a class="btn btn-primary btn-large" href="member/logout">로그아웃 </a>
<body>

</body>
</html>
