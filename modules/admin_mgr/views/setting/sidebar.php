<div class="admin_sidebar_wrapper">
<div class=" bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav affix-top">
	    <li <?php if($action=='site') echo 'class="active"'; ?>> 
	         <a href="<?=site_url("admin_mgr/setting/site")?>"><i class="icon-chevron-right"></i>Site Setting</a> 
	    </li>
	    <li <?php if($action=='email') echo 'class="active"'; ?>> 
	         <a href="<?=site_url("admin_mgr/setting/email")?>"><i class="icon-chevron-right"></i>Email Setting</a> 
	    </li> 
        <li <?php if($action=='openapi') echo 'class="active"'; ?>> 
	         <a href="<?=site_url("admin_mgr/setting/openapi")?>"><i class="icon-chevron-right"></i>Open API Setting</a> 
	    </li> 
        <li <?php if($action=='dbtable') echo 'class="active"' ;?>> 
	         <a href="<?=site_url("admin_mgr/setting/dbtable")?>"><i class="icon-chevron-right"></i>DB Table Setting</a> 
	    </li>
	    <li <?php if($action=='blog') echo 'class="active"' ;?>> 
	         <a href="<?=site_url("admin_mgr/setting/blog")?>"><i class="icon-chevron-right"></i>Blog Setting</a> 
	    </li> 
	</ul>
</div>
</div>

