<?php $this->load->helper('asset') ?>
<?echo css_asset('dashboard','dashboard.css')?>
<?echo js_asset('dashboard','jquery.dashboard.js')?>
<div class="_content">
	<div class="alert alert-success" align="center">
		<b>새글(Saegeul)</b>은 <b>소셜큐레이션</b> / <b>클라우드</b> 환경에 특화된 CMS(Contents
		Management System)입니다.
	</div>
	<div class="box siteCurrentStatus">
        <div style="padding-right:20px;">
		<div class="adminInfo well">
			<h4>관리자 정보<a href="<?=base_url()?>admin_mgr/setting/email"><span class="pull-right label label-info">more</span></a></h4>
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
		<div class="siteInfo well">
			<h4>사이트 정보<a href="<?=base_url()?>admin_mgr/setting/site"><span class="pull-right label label-info">more</span></a></h4>
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
		<div class="emailInfo well">
			<h4>E-mail 정보<a href="<?=base_url()?>admin_mgr/setting/email"><span class="pull-right label label-info">more</span></a></h4>
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
	</div>
	<div class="box moduleDBInfo">
		<h6>모듈별 현황</h6>
		<table class="table table-condensed table-hover">
            <thead>
                <tr> 
                    <th>설치된 모듈 </th>
                    <th>필요 DB테이블 </th>
                    <th>설치여부</th>
                </tr>
            </thead>
			<?php foreach($module as $key => $value) :?>
			<tr>
				<td><?=$value['module_name']?></td>
                <td> </td>
                <td> </td>
			</tr>
			<?php endforeach ;?>
		</table>
	</div>
</div>
