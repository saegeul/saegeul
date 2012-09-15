<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title><?php echo $site_name; ?>의 새로운 비밀번호 설</title></head>
<body>
<div style="max-width: 800px; margin: 0; padding: 30px 0;">
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="5%"></td>
<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">정
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: black;">새로운 비밀번호 설</h2>
비밀번호를 잊으셨나요?? 괜찮습니다.<br />
새로운 비밀번호를 설정하기 위해서 다음 링크를 클릭해주세요.:<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b><a href="<?php echo site_url('/member/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;">Create a new password</a></b></big><br />
<br />
정제대로 동작 하지 않는다면, 다음 링크를 웹브라우저의 주소창에 복사하여 이동해 주시기 바랍니다:<br />
<nobr><a href="<?php echo site_url('/member/reset_password/'.$user_id.'/'.$new_pass_key); ?>" style="color: #3366cc;"><?php echo site_url('/member/reset_password/'.$user_id.'/'.$new_pass_key); ?></a></nobr><br />
<br />
<br />
이 메일은 <a href="<?php echo site_url(''); ?>" style="color: #3366cc;"><?php echo $site_name; ?></a> 사용자로부터 요청되어 발송된 메일입니다. 
웹사이트의 비밀번호를 재설정하기 위한 단계 이므로 안내를 따라 변경하시면 됩니다. 만약 비밀번호 재설정을 원하지 않으셔서 본 이메일을 무시하신다면 현재의 비밀번호가 유지됩니다.<br />
<br />
<br />
감사합니,<br />
The <?php echo $site_name; ?> Team
</td>
</tr>
</table>
</div>
</body>
</html>