<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GalleryView - Full Feature Demo</title>

<!-- First, add jQuery (and jQuery UI if using custom easing or animation -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<?php // 절대 주소로 지정 ?>
<!-- Second, add the Timer and Easing plugins -->
<script type="text/javascript" src="/saegeul/modules/gallery/views/assets/js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="/saegeul/modules/gallery/views/assets/js/jquery.easing.1.3.js"></script>

<?php // 절대 주소로 지정 ?>

<!-- Third, add the GalleryView Javascript and CSS files -->
<script type="text/javascript" src="/saegeul/modules/gallery/views/assets/js/jquery.galleryview-3.0-dev.js"></script>
<link type="text/css" rel="stylesheet" href="/saegeul/modules/gallery/views/assets/css/jquery.galleryview-3.0-dev.css" />

<!-- Lastly, call the galleryView() function on your unordered list(s) -->
<script type="text/javascript">
	$(function(){
		$('#myGallery').galleryView({
		transition_speed: 500, 		//INT - duration of panel/frame transition (in milliseconds)
		transition_interval: 4000, 		//INT - delay between panel/frame transitions (in milliseconds)
		easing: 'swing', 				//STRING - easing method to use for animations (jQuery provides 'swing' or 'linear', more available with jQuery UI or Easing plugin)
		show_panels: true, 				//BOOLEAN - flag to show or hide panel portion of gallery
		show_panel_nav: false, 			//BOOLEAN - flag to show or hide panel navigation buttons
		enable_overlays: true, 			//BOOLEAN - flag to show or hide panel overlays
		
		panel_width: 900, 				//INT - width of gallery panel (in pixels)
		panel_height: 500, 				//INT - height of gallery panel (in pixels)
		panel_animation: 'slide', 		//STRING - animation method for panel transitions (crossfade,fade,slide,none)
		panel_scale: 'crop', 			//STRING - cropping option for panel images (crop = scale image and fit to aspect ratio determined by panel_width and panel_height, fit = scale image and preserve original aspect ratio)
		overlay_position: 'bottom', 	//STRING - position of panel overlay (bottom, top)
		pan_images: true,				//BOOLEAN - flag to allow user to grab/drag oversized images within gallery
		pan_style: 'drag',				//STRING - panning method (drag = user clicks and drags image to pan, track = image automatically pans based on mouse position
		pan_smoothness: 15,				//INT - determines smoothness of tracking pan animation (higher number = smoother)
		start_frame: 1, 				//INT - index of panel/frame to show first when gallery loads
		show_filmstrip: true, 			//BOOLEAN - flag to show or hide filmstrip portion of gallery
		show_filmstrip_nav: true, 		//BOOLEAN - flag indicating whether to display navigation buttons
		enable_slideshow: false,			//BOOLEAN - flag indicating whether to display slideshow play/pause button
		autoplay: false,				//BOOLEAN - flag to start slideshow on gallery load
		show_captions: true, 			//BOOLEAN - flag to show or hide frame captions	
		filmstrip_size: 3, 				//INT - number of frames to show in filmstrip-only gallery
		filmstrip_style: 'scroll', 		//STRING - type of filmstrip to use (scroll = display one line of frames, scroll filmstrip if necessary, showall = display multiple rows of frames if necessary)
		filmstrip_position: 'bottom', 	//STRING - position of filmstrip within gallery (bottom, top, left, right)
		frame_width: 164, 				//INT - width of filmstrip frames (in pixels)
		frame_height: 80, 				//INT - width of filmstrip frames (in pixels)
		frame_opacity: 0.5, 			//FLOAT - transparency of non-active frames (1.0 = opaque, 0.0 = transparent)
		frame_scale: 'crop', 			//STRING - cropping option for filmstrip images (same as above)
		frame_gap: 5, 					//INT - spacing between frames within filmstrip (in pixels)
		show_infobar: true,				//BOOLEAN - flag to show or hide infobar
		infobar_opacity: 1				//FLOAT - transparency for info bar
		});
	});
</script>

<style type="text/css">
	body { 
		margin: 2em; 
		font-family: Arial, Helvetica, sans-serif;
	}
	
</style>
</head>

<body>			

	<ul id="myGallery">
		<?php foreach($fileList as $key => $file) :?>
			<li>
						
							
					 <img data-frame="<?=base_url().$file->image_thumb_path;?>" src="<?=base_url().$file->full_path;?>" title="<?=$file->original_file_name?>" data-description="" />
					 
					</li>
			<?php endforeach ;?>
		<?php
			
	/*			foreach($result as $row):
				$fileType = $row->file_type;
				$ext = explode(".", $fileType);
				$ext = strtolower(trim($ext[count($ext)-1]));
		 		if($ext == "image/jpeg" || $ext == "image/JPEG" || $ext == "image/jpg" || $ext == "image/JPG" || $ext == "image/gif" || $ext == "image/GIF" || $ext == "image/png" || $ext == "image/PNG")
				{
					
		*/
		?>
		<!--  
					<li>
						
							
					 <img data-frame="<?//=$row->image_thumb_path?>" src="<?//=$row->full_path?>" title="<?=$row->original_file_name?>" data-description="" />
					 
					</li>
-->
			<?php
			//	}
				
					//endforeach;
			?>
			
					
	</ul>
</body>
</html>
