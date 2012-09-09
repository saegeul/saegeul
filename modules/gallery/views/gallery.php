<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gallery</title>
<meta name="keywords" http-equiv="keywords" content="" />
<meta name="description" http-equiv="description" content="" />
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="pngfix.js"></script>
<![endif]-->
<?echo js_asset('gallery','jquery.js') ?>
<?echo js_asset('gallery','jquery.livequery.js') ?>
<!-- Slider Params -->
<script>
var Interval = 6000;
var totalThumbsFirstList = 12;
var totalThumbsSecondList = 6;
</script>
<?echo js_asset('gallery','zGallery.js') ?>
<?echo css_asset('gallery','zGallery.css')?>
<?echo css_asset('gallery','style.css')?>
</head>
<body>
	<br />
	<div align="center">
		<h2>Gallery</h2>
		<div id="outer">
			<!-- start zGallery-->
			<div id="zBackground">
				<div id="zGalleryArea">
					<!-- main left image -->
					<div id="zMainImage">
						<div class=zSpace>
							<img src="images/1.jpg" alt="" />
						</div>
						<!-- <label style="font-family:Tahoma, Geneva, sans-serif; font-size:11px; position:relative; top:-4px; color:#FFF">Created By: Zeeshan Rasool  -  www.99Points.info</label>-->
						<div id="captions">1- Lorem Ipsum is simply dummy text of the
							printing and typesetting industry. Lorem Ipsum has been the
							industry's standard dummy text ever since the 1500s.</div>
					</div>
					<!-- thumbs -->
					<div id="zThumbs">
						<!-- first list must add class first-->
						<ul class="first">
							<?php foreach ($files as $row): ?>
							<li id="zLi-1"><a href="javascript:;" rel="images/1.jpg"
								name="1- Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="<?=$row->thumbnail_url?>" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-2"><a href="javascript:;" rel="images/2.jpg"
								name="2 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/2_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-3"><a href="javascript:;" rel="images/3.jpg"
								name="3 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/3_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-4"><a href="javascript:;" rel="images/4.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/4_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-5"><a href="javascript:;" rel="images/5.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/5_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-6"><a href="javascript:;" rel="images/6.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/6_thumb.jpg" alt="" class="zImages" /> </a>
							</li>

							<li id="zLi-7"><a href="javascript:;" rel="images/7.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/7_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-8"><a href="javascript:;" rel="images/8.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/8_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-9"><a href="javascript:;" rel="images/9.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/9_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-10"><a href="javascript:;" rel="images/7.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/7_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-11"><a href="javascript:;" rel="images/8.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/8_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<li id="zLi-12"><a href="javascript:;" rel="images/9.jpg"
								name="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."><img
									src="images/9_thumb.jpg" alt="" class="zImages" /> </a>
							</li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
</div>
</body>
</html>
