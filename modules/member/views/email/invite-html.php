<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<html>
<head><title> <?php echo $site_name; ?>에 오신것을 환영합니다!</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;"><?php echo $site_name; ?>에 오신것을 환영합니다!</h2>
<?php echo $site_name; ?>에서 당신을 초대하였습니다. 메일 하단에 당신의 가입정보가 명시되어 있습니다. 보안에 유의하여 보관해 주시기 바랍니다.<br />
당신의 이메일 주소가 유효한지 확인하여 활성화 하기 위해서 다음 링크를 클릭해 주시기 바랍니다.:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/member/activate/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;">이메일 인증 및 활성화 하기...</a></b></big><br />
<br />
Link 제대로 동작 하지 않는다면, 다음 링크를 웹브라우저의 주소창에 복사하여 이동해 주시기 바랍니다:<br />

<nobr><a href="<?php echo site_url('/member/activate/'.$user_id.'/'.$new_email_key); ?>" style="color: #3366cc;"><?php echo site_url('/member/activate/'.$user_id.'/'.$new_email_key); ?></a></nobr><br />
<br />
<?php echo $activation_period; ?> 시간 내에 이메일 인증을 해주시기 바랍니다.  그렇지 않으면 당신의 이메일인증은 유효하지 않게 되며, 재등록을 하셔야 합니다.<br />
<br />
<br />
<h1>아래의 정보를 이용하여 로그인 하신 후에</h1><br>
<h1>'반드시' 비밀번호를 변경해주시기 바랍니다.</h1>
<br><br>
<?php if (strlen($username) > 0) { ?>Your username: <?php echo $username; ?><br /><?php } ?>
Your email address: <?php echo $email; ?><br />
Your password: <?php echo $password; ?><br />

<br />
<br />


Have fun!<br />
The <?php echo $site_name; ?> Team
</td>
</tr>
</table>
</div>
</body>
</html>