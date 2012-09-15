<HTML>
<HEAD>
<TITLE>GuestBook</TITLE>
<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/saegeul/modules/visitors/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/saegeul/modules/visitors/bootstrap-responsive.css" />
<script language="javascript">
<!--
 function guestbook_modify()
 {
  form = document.modify;
  if (form.name.value == "")
  {
   alert("이름 입력 요망");
   form.name.focus();
  }
  else if(form.passwd.value == "")
  {
   alert("비밀번호 입력 요망");
   form.passwd.focus();
  }
  else if(form.comment.value == "")
  {
   alert("내용 입력 요망");
   form.comment.focus();
  }
  else
  {
   form.submit();
  }
 }
-->
</script>
</HEAD>

<BODY>
	<form name="modify" method="post" action="/saegeul/visitors/modify">
	<?php 	foreach($result as $row)	{
		?>

		<input type="hidden" name="idx" value="<?=$row->IDX ?>" >
		<table style="width:500px; margin-top:10px; padding-bottom:10px;" align="center">
		<tr style = "background-color: #D8D8D8;">
			<td style="padding-top:5px; padding-left:5px;">
				<input type="text" class="input-medium" name="name" value="<?= $row->NAME?>">
				<input type="password" class="input-medium" name="passwd" value="<?=$row->PW ?>">	
			</td>
		</tr>
		<tr>
			<td>
			<div style="padding-top:10px;">
				<textarea style="width:500px; height:150px;" wrap="hard" name="comment"><?=$row->COMMENT ?></textarea>
			</div>
			</td>
		</tr>
		<tr>
			<td align="right">
			<input type="button" class="btn btn-small" value="수정하기" onClick="guestbook_modify();">
			</td>
		</tr>
	</table>
		
	<?php }?>
	</form>
</BODY>
</HTML>