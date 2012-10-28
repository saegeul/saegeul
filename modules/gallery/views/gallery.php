<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>

<?echo js_asset('gallery','jquery.timers-1.2.js')?>
<?echo js_asset('gallery','jquery.easing.1.3.js')?>
<?echo js_asset('gallery','jquery.galleryview-3.0-dev.js')?>
<?echo css_asset('gallery','jquery.galleryview-3.0-dev.css')?>

<!-- Lastly, call the galleryView() function on your unordered list(s) -->
<script type="text/javascript">
$(document).ready(function(){
    $.ajax({
        type: "GET",
            url: "gallery/getPhoto",
            contentType: "application/json; charset=utf-8",
            dataType: "json", 
            data: "page=1",
            //data: "page=1 &key="+key+"&keyword="+keyword,
            error: function() { 
                alert("����� ������ �����ϴ�.");
            },
                success: function(data){
                    var markup = "";
                    $.each(data.fileList, function(key,state){
                        obj = state;
                        markup += "<li><img  data-frame='" + data.base_url + obj.image_thumb_path + "' src='" + data.base_url + obj.full_path + "' title='"+obj.original_file_name+"' data-description='' /></li>";

                    });
                    $('#myGallery').append(markup);   		

                    $('#myGallery').galleryView({
                        transition_speed: 500, 		//INT - duration of panel/frame transition (in milliseconds)
                            transition_interval: 4000, 		//INT - delay between panel/frame transitions (in milliseconds)
                            easing: 'swing', 				//STRING - easing method to use for animations (jQuery provides 'swing' or 'linear', more available with jQuery UI or Easing plugin)
                            show_panels: true, 				//BOOLEAN - flag to show or hide panel portion of gallery
                            show_panel_nav: true, 			//BOOLEAN - flag to show or hide panel navigation buttons
                            enable_overlays: true, 			//BOOLEAN - flag to show or hide panel overlays

                            panel_width: 870, 				//INT - width of gallery panel (in pixels)
                            panel_height: 500, 				//INT - height of gallery panel (in pixels)
                            panel_animation: 'crossfade', 		//STRING - animation method for panel transitions (crossfade,fade,slide,none)
                            panel_scale: 'crop', 			//STRING - cropping option for panel images (crop = scale image and fit to aspect ratio determined by panel_width and panel_height, fit = scale image and preserve original aspect ratio)
                            overlay_position: 'bottom', 	//STRING - position of panel overlay (bottom, top)
                            pan_images: true,				//BOOLEAN - flag to allow user to grab/drag oversized images within gallery
                            pan_style: 'track',				//STRING - panning method (drag = user clicks and drags image to pan, track = image automatically pans based on mouse position
                            pan_smoothness: 15,				//INT - determines smoothness of tracking pan animation (higher number = smoother)
                            start_frame: 1, 				//INT - index of panel/frame to show first when gallery loads
                            show_filmstrip: true, 			//BOOLEAN - flag to show or hide filmstrip portion of gallery
                            show_filmstrip_nav: true, 		//BOOLEAN - flag indicating whether to display navigation buttons
                            enable_slideshow: true,			//BOOLEAN - flag indicating whether to display slideshow play/pause button
                            autoplay: false,				//BOOLEAN - flag to start slideshow on gallery load
                            show_captions: true, 			//BOOLEAN - flag to show or hide frame captions	
                            filmstrip_size: 3, 				//INT - number of frames to show in filmstrip-only gallery
                            filmstrip_style: 'scroll', 		//STRING - type of filmstrip to use (scroll = display one line of frames, scroll filmstrip if necessary, showall = display multiple rows of frames if necessary)
                            filmstrip_position: 'bottom', 	//STRING - position of filmstrip within gallery (bottom, top, left, right)
                            frame_width: 164, 				//INT - width of filmstrip frames (in pixels)
                            frame_height: 80, 				//INT - width of filmstrip frames (in pixels)
                            frame_opacity: 0.5, 			//FLOAT - transparency of non-active frames (1.0 = opaque, 0.0 = transparent)
                            frame_scale: 'crop', 			//STRING - cropping option for filmstrip images (same as above)
                            frame_gap: 2	, 					//INT - spacing between frames within filmstrip (in pixels)
                            show_infobar: true,				//BOOLEAN - flag to show or hide infobar
                            infobar_opacity: 1				//FLOAT - transparency for info bar
                    });
                }
    });
});



</script>
<style type="text/css">
        body { 
                margin: 2em; 
                font-family: Arial, Helvetica, sans-serif;
        }

</style>

<div>
    <ul id="myGallery">
             <!--    <img data-frame="<?//=base_url().$file->image_thumb_path;?>" src="<?//=base_url().$file->full_path;?>" title="<?//=$file->original_file_name?>" data-description="" /> -->
        </ul>
</div>
