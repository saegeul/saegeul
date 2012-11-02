<div class="admin_sidebar_wrapper">
<div class=" bs-docs-sidebar">
	<ul class="nav nav-list bs-docs-sidenav affix-top">
	    
	    	    <li <?php if($action=='admin_member'):?> class="active" <?endif;?>> 
	    
	        <a href="<?=base_url()?>admin/member/admin_member"><i class="icon-chevron-right"></i>회원관리</a> 
	    </li>
<li <?php if($action=='invite'):?> class="active" <?endif;?>> 	      
  <a href="<?=base_url()?>admin/member/check_emailset"><i class="icon-chevron-right"></i>회원초대</a> 
	    </li>
<li <?php if($action=='change_password'):?> class="active" <?endif;?>> 	    	 
       <a href="<?=base_url()?>admin/member/change_password"><i class="icon-chevron-right"></i>관리자 비밀번호 변경</a> 
	    </li>
	</ul>
</div>
</div>
