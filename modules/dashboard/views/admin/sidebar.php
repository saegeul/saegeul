<div class="admin_sidebar_wrapper">
    <div class=" bs-docs-sidebar">
		<ul class="nav nav-list bs-docs-sidenav affix-top">
        <li <?php if($action=='siteCurrentStatus'):?> class="active" <?endif;?>> 
				<a href="<?=site_url("admin/dashboard/siteCurrentStatus")?>"><i class="icon-chevron-right"></i>사이트현황</a> 
			</li>
        <li <?php if($action=='moduleCurrentStatus'):?> class="active" <?endif;?>> 
				<a href="<?=site_url("admin/dashboard/moduleCurrentStatus")?>"><i class="icon-chevron-right"></i>설치모듈 현황</a> 
			</li>
		</ul>
    </div>
</div>

