<div class="admin_sidebar_wrapper">
<div class="bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav affix-top">
        <li <?php if($action=='writeform'):?> class="active" <?endif;?>> 
	        <a href="<?=site_url("admin/document/writeform")?>"><i class="icon-chevron-right"></i>새글 작성 </a> 
	    </li>
	    <li <?php if($action=='document_list'):?> class="active" <?endif;?>> 
	        <a href="<?=site_url("admin/document/document_list")?>"><i class="icon-chevron-right"></i>문서목록</a> 
	    </li> 
	    <li> 
	        <a href="<?=site_url("admin/document/recyclebin_list")?>" ><i class="icon-chevron-right"></i>휴지통</a> 
	    </li>
	</ul>
</div>
</div>
