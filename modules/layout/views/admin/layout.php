<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<title>새글</title>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/docs.css')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo common_js_asset('bootstrap/js/bootstrap.min.js') ?>
</head>
<body>
	<div class="navbar">
		<div class="navbar-inner navbar-fixed-top">
			<div>
				<a class="brand" style="color: #ddd; font-weight: bold;"> <span style="color:#898989;">Saegeul</span> <small>for social curation</small>
				</a>
				<ul class="nav">
					<li <?php if($this->uri->segment(2)=='template'):?> class="active"
					<?php endif;?>><a
						href="<?=base_url()?>admin/sitemap/siteMap">SiteMap</a>
					</li>
					<li <?php if($this->uri->segment(2)=='dashboard'):?> class="active"
					<?php endif;?>><a href="<?=base_url()?>admin/dashboard">Dashboard</a>
					</li> 
					<li <?php if($this->uri->segment(2)=='member'):?> class="active"
					<?php endif;?>><a
						href="<?=base_url()?>admin/member/admin_member">Member </a>
					</li>
					<li <?php if($this->uri->segment(2)=='document'):?> class="active"
					<?php endif;?>><a
						href="<?=base_url()?>admin/document/document_list">Document</a>
					</li>
					<li <?php if($this->uri->segment(2)=='clouddrive'):?> class="active"
					<?php endif;?>><a
						href="<?=base_url()?>admin/clouddrive/checkOauth">Cloud Drive</a>
					</li>
					<li <?php if($this->uri->segment(2)=='webzine'):?> class="active"
					<?php endif;?>><a
						href="<?=base_url()?>admin/document/writeform">Page</a>
					</li>
					<li <?php if($this->uri->segment(2)=='filebox'):?> class="active"
					<?php endif;?>><a
						href="<?=base_url()?>admin/filebox/fileList">File</a>
					</li>
					<li <?php if($this->uri->segment(2)=='setting'):?> class="active"
					<?php endif;?>><a href="<?=base_url()?>admin/setting">Setting</a>
					</li>
					<li>
						<div class="btn-group">
							<button class="btn btn-primary">
								<i class="icon-plus icon-white"></i>&nbsp;NEW
							</button>
							<button class="btn btn-primary dropdown-toggle"
								data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="<?=base_url()?>document/admin/document/writeform"><i
										class="icon-plus"></i> DOCUMENT</a></li>
								<li><a href="<?=base_url()?>filebox/admin/filebox/uploadForm"><i
										class="icon-plus"></i> FILE</a></li>
								<li><a href="<?=base_url()?>page/admin/page/createPage"><i
										class="icon-plus"></i> PAGE</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="body_wrapper">
		<?=$_contents;?>
	</div>
	<!-- end of .container -->
	<footer> </footer>
</body>
</html>
