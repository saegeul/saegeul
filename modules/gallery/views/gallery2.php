<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GalleryView - Default Demo</title>

<!-- First, add jQuery (and jQuery UI if using custom easing or animation -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

<!-- Second, add the Timer and Easing plugins -->
<script type="text/javascript" src="/saegeul/modules/gallery/views/assets/js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="/saegeul/modules/gallery/views/assets/js/jquery.easing.1.3.js"></script>

<!-- Third, add the GalleryView Javascript and CSS files -->
<script type="text/javascript" src="/saegeul/modules/gallery/views/assets/js/jquery.galleryview-3.0-dev.js"></script>
<link type="text/css" rel="stylesheet" href="/saegeul/modules/gallery/views/assets/css/jquery.galleryview-3.0-dev.css" />

<!-- Lastly, call the galleryView() function on your unordered list(s) -->
<script type="text/javascript">
	$(function(){
		$('#myGallery').galleryView();
	});
</script>
</head>

<body>
	<ul id="myGallery">

		<?php
				foreach($result as $row):
				$fileType = $row->file_type;
				$ext = explode(".", $fileType);
				$ext = strtolower(trim($ext[count($ext)-1]));
				if($ext == "image/jpeg" || $ext == "image/JPEG" || $ext == "image/jpg" || $ext == "image/JPG" || $ext == "image/gif" || $ext == "image/GIF" || $ext == "image/png" || $ext == "image/PNG")
				{
						
			?>
					<li>
					
					 <img data-frame="<?=$row->image_thumb_path?>" src="<?=$row->full_path?>" title="<?=$row->original_file_name?>" data-description="" />
					 
					</li>

			<?php
				}
					endforeach;
			?>
			
			<?php 
			
				
			?>
	
	</ul>
</body>
</html>
