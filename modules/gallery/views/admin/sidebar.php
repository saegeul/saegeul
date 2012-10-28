<div class="admin_sidebar_wrapper">
	<div class=" bs-docs-sidebar">
		<ul class="nav nav-list bs-docs-sidenav affix-top">
			<li <?php if($action=='uploadForm'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/filebox/uploadForm"><i
					class="icon-chevron-right"></i>파일 업로드</a>
			</li>
			<li <?php if($action=='fileList'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/filebox/fileList"><i
					class="icon-chevron-right"></i>파일목록</a>
			</li>
			<li <?php if($action=='tagCloud'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/filebox/tagCloud"><i
					class="icon-chevron-right"></i>태그클라우드</a>
			</li>
			<li <?php if($action=='gallery'):?> class="active" <?endif;?>><a
				href="<?=base_url()?>admin/gallery/showGallery"><i
					class="icon-chevron-right"></i>갤러리</a>
			</li>			
		</ul>
	</div>
</div>

