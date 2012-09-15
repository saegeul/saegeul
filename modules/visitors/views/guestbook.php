
<HTML>
<HEAD>
<TITLE>GuestBook</TITLE>
<meta http-equiv="content-type" content="text/html" charset="utf-8" />

<link rel="stylesheet" type="text/css" href="/saegeul/modules/visitors/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/saegeul/modules/visitors/bootstrap-responsive.css" />
<script language="javascript">
<!--
 function guestbook_write()
 {
  form = document.write;
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
	<form name="write" method="post" action="/saegeul/visitors/write">
	<table style="width:500px; margin-top:10px; padding-bottom:10px;" align="center">
		<tr style = "background-color: #D8D8D8;">
			<td style="padding-top:5px; padding-left:5px;">
				<input type="text" class="input-medium" name="name" placeholder="ID">
				<input type="password" class="input-medium" name="passwd" placeholder="Password">	
			</td>
		</tr>
		<tr>
			<td>
			<div style="padding-top:10px;">
				<textarea style="width:500px; height:150px;" wrap="hard" name="comment"></textarea>
			</div>
			</td>
		</tr>
		<tr>
			<td align="right">
			<input type="button" class="btn btn-small" value="글남기기" onClick="guestbook_write();">
			</td>
		</tr>
	</table>
	
	</form>
	
	<?php 
	
	foreach($result as $row)
	{
		?>
		<table style="width:500px; border-top:" align="center">
		<tr style = "background-color: #D8D8D8;">
			<td style="padding-top:5px; padding-left:5px;">작성자: <? echo $row['NAME']; ?>(<? echo $row['REG_DATE']; ?>)</td>
		</tr>
		<tr>
			<td style="padding-top:5px; padding-bottom:5px;">
				<div style="width:500px; height:100px; padding:10px; border:1px solid #D8D8D8">
					<? echo $row['COMMENT']; ?>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div style="float:right;">
				<form method="post" action="/saegeul/visitors/delete">
						<input type="hidden" name="idx" value= <?=$row["IDX"]?> >
						<input type="submit" value="삭제" class="btn btn-small">
				</form>
				</div>
				<div style="float:right;">
				<form method="post" action="/saegeul/visitors/modify_view">
						<input type="hidden" name="idx" value=<?=$row['IDX']?> >
						<input type="submit" value="수정" class="btn btn-small">
				</form>
				</div>
				
			</td>
		</tr>
		</table>
		
			<?php
	}
	?>
	
</BODY>
</HTML>
