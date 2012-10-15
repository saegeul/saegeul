<?php $this->load->helper('asset') ?>
<?echo css_asset('dashboard','dashboard.css')?>
<?echo js_asset('dashboard','jquery.dashboard.js')?>
<div class="_content">
	<div class="alert alert-success" align="center">
		<b>새글(Saegeul)</b>은 <b>소셜큐레이션</b> / <b>클라우드</b> 환경에 특화된 CMS(Contents
		Management System)입니다.
	</div>
	<div class="box siteCurrentStatus">
		<div class="adminInfo">
			<h4>관리자 정보</h4>
			<ul>
				<li>이름 : <?=$admin[0]->username?>
				</li>
				<li>E-Mail : <?=$admin[0]->email?>
				</li>
				<li>등록일 : <?=$admin[0]->created?>
				</li>
			</ul>
		</div>
		<br>
		<div class="siteInfo">
			<h4>사이트 정보</h4>
			<ul>
				<li>이름 : <?=isset($site[0]->title)?$site[0]->title:""?>
				</li>
				<li>URL : <?=isset($site[0]->site_url)?$site[0]->title:""?>
				</li>
				<li>회원가입 가능 여부 : <?=(isset($site[0]->on_register)?$site[0]->on_register:"")==1?"허락":"불가"?>
				</li>
			</ul>
		</div>
		<br>
		<div class="emailInfo">
			<h4>E-mail 정보</h4>
			<ul>
				<li>E-mail 주소 : <?=isset($email[0]->email)?$email[0]->email:""?>
				</li>
				<li>E-mail Protocal : <?=isset($email[0]->email_protocol)?$email[0]->email_protocol:""?>
				</li>
				<li>SMTP Host : <?=isset($email[0]->smtp_host)?$email[0]->smtp_host:""?>
				</li>
				<li>SMTP Port : <?=isset($email[0]->smtp_port)?$email[0]->smtp_port:""?>
				</li>
			</ul>
		</div>
	</div>
	<div class="box moduleDBInfo">
		<h4>모듈별 현황</h4>
		<table class="table table-hover">
			<?php foreach($module as $key => $value) :?>
			<tr>
				<td><?=$value['module_name']?><?php if($value['module_schema'] !=""){?>(<?=$value['module_schema']?>)<?php }?></td>
				<td><?=$value['module_schema_cnt']?></td>
			</tr>
			<?php endforeach ;?>
		</table>
	</div>
</div>
