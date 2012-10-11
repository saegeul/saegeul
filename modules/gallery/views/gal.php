<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>

<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>Gallery</title>

<?echo js_asset('gallery','jquery-1.3.2.js') ?>
<?echo js_asset('gallery','jquery.galleriffic.js') ?>
<?echo js_asset('gallery','jquery.opacityrollover.js') ?>
<?echo css_asset('gallery','basic.css')?>
<?echo css_asset('gallery','galleriffic-2.css')?>

<script type="text/javascript">
			document.write('<style>.noscript { display: none; }</style>');
		</script>
</head>
<body>
	<div id="page">
		<div id="container">
			<h1>Gallery</h1>

			<!-- Start Advanced Gallery Html Containers -->
			<div id="gallery" class="content">
				<div id="controls" class="controls"></div>
				<div class="slideshow-container">
					<div id="loading" class="loader"></div>
					<div id="slideshow" class="slideshow"></div>
				</div>
				<div id="caption" class="caption-container"></div>
			</div>
			<div id="thumbs" class="navigation">
				<ul class="thumbs noscript">
				<?php
				foreach($result as $row):
				?>
					<li>
					<a class="thumb" href="<?=$row->full_path?>" title="<?=$row->original_file_name?>"> 
						<img src="<?=$row->image_thumb_path?>" alt="<?=$row->original_file_name?>" />
					</a>
					</li>

				<?php
				endforeach;
				?>
				</ul>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	<script type="text/javascript">
			jQuery(document).ready(function($) {

			
				
				// We only want these styles applied when javascript is enabled
				$('div.navigation').css({'width' : '300px', 'float' : 'left'});
				$('div.content').css('display', 'block');

				// Initially set opacity on thumbs and add
				// additional styling for hover effect on thumbs
				var onMouseOutOpacity = 0.67;
				$('#thumbs ul.thumbs li').opacityrollover({
					mouseOutOpacity:   onMouseOutOpacity,
					mouseOverOpacity:  1.0,
					fadeSpeed:         'fast',
					exemptionSelector: '.selected'
				});
				
				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs').galleriffic({
					delay:                     2500,
					numThumbs:                 15,
					preloadAhead:              10,
					enableTopPager:            true,
					enableBottomPager:         true,
					maxPagesToShow:            7,
					imageContainerSel:         '#slideshow',
					controlsContainerSel:      '#controls',
					captionContainerSel:       '#caption',
					loadingContainerSel:       '#loading',
					renderSSControls:          true,
					renderNavControls:         true,
					playLinkText:              'Play Slideshow',
					pauseLinkText:             'Pause Slideshow',
					prevLinkText:              '&lsaquo; Previous Photo',
					nextLinkText:              'Next Photo &rsaquo;',
					nextPageLinkText:          'Next &rsaquo;',
					prevPageLinkText:          '&lsaquo; Prev',
					enableHistory:             false,
					autoStart:                 false,
					syncTransitions:           true,
					defaultTransitionDuration: 900,
					onSlideChange:             function(prevIndex, nextIndex) {
						// 'this' refers to the gallery, which is an extension of $('#thumbs')
						this.find('ul.thumbs').children()
							.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
							.eq(nextIndex).fadeTo('fast', 1.0);
					},
					onPageTransitionOut:       function(callback) {
						this.fadeTo('fast', 0.0, callback);
					},
					onPageTransitionIn:        function() {
						this.fadeTo('fast', 1.0);
					}
				});
			});
		</script>
</body>
</html>
