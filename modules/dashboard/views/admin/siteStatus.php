<?php $this->load->helper('asset') ?>
<?echo css_asset('dashboard','dashboard.css')?>
<?echo js_asset('dashboard','jquery.dashboard.js')?>
<div class="_content">
	<div class="alert alert-success" align="center">
		<b>새글(Saegeul)</b>은 <b>소셜큐레이션</b> / <b>클라우드</b> 환경에 특화된 CMS(Contents
		Management System)입니다.
	</div>
	<div class="box siteCurrentStatus">
		<div style="padding-right: 20px;">
			<div class="adminInfo well">
				<h4>
					관리자 정보<a href="<?=base_url()?>admin_mgr/setting/email"><span
						class="pull-right label label-info">more</span> </a>
				</h4>
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
				<h4>
					사이트 정보<a href="<?=base_url()?>admin_mgr/setting/site"><span
						class="pull-right label label-info">more</span> </a>
				</h4>
				<ul>
					<li>이름 : <?=isset($site[0]->title)?$site[0]->title:""?>
					</li>
					<li>URL : <?=isset($site[0]->site_url)?$site[0]->site_url:""?>
					</li>
					<li>회원가입 가능 여부 : <?=(isset($site[0]->on_register)?$site[0]->on_register:"")==1?"허락":"불가"?>
					</li>
				</ul>
			</div>
			<br>
			<div class="emailInfo well">
				<h4>
					E-mail 정보<a href="<?=base_url()?>admin_mgr/setting/email"><span
						class="pull-right label label-info">more</span> </a>
				</h4>
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
	<div class="box documentCurrentStatus">
		<div style="padding-right: 20px;">
			<div class="newDocumentInfo well">
				<h4>
					최신글<a href="<?=base_url()?>admin/document/document_list"><span
						class="pull-right label label-info">more</span> </a>
				</h4>
				<table class="table table-condensed table-hover">
					<tbody>
						<?php foreach($recentDoc as $key => $rec) :?>
						<tr>
							<td style="padding-top: 7px;padding-bottom: 7px;"><?=$rec->title?> <br>
								<div style="margin-top: 5px;font-size:0.9em;color:#aaa;">
									by
									<?=$rec->username?>
									<div class="pull-right">
										<?=$rec->reg_date?>
									</div>
								</div>
							</td>
						</tr>
						<?php endforeach ;?>
					</tbody>
				</table>
			</div>
			<br>
			<div class="popularDocumentInfo well">
				<h4>
					인기글<a href="<?=base_url()?>admin/document/document_list"><span
						class="pull-right label label-info">more</span> </a>
				</h4>
				<table class="table table-condensed table-hover">
					<tbody>
						<?php foreach($hitDoc as $key => $hit) :?>
						<tr>
							<td style="padding-top: 7px;padding-bottom: 7px;"><?=$hit->title?> <br>
								<div style="margin-top: 5px;font-size:0.9em;color:#aaa;">
									by
									<?=$hit->username?>
									<div class="pull-right">
										<?=$hit->reg_date?>
									</div>
								</div>
							</td>
						</tr>
						<?php endforeach ;?>
					</tbody>
				</table>
			</div>
			<br>
			<div class="trackBackDocumenInfo well">
				<h4>
					트랙백글<a href="<?=base_url()?>"><span
						class="pull-right label label-info">more</span> </a>
				</h4>
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th>제목</th>
							<th>작성자</th>
							<th>등록일</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
