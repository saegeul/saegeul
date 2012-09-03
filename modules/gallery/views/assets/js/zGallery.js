/*
zSlider - A beautiful JQuery Image Slider | by Zeeshan Rasool | www.99points.info 
http://99points.info
All rights reserved by 99points.info
*/
var int;
var zSaveThumbs;
var Autoplay;
var zCurrLeft;
var zCurrRight;

function position( active, key )
{
	var ItemMoved = 0;
	
	switch(active)
	{
		case '1':
			
			if(key == 'right')
			{
			 moveRight();
			 ItemMoved = 1;
			 $('#activeBox').val(2);
			}
			else if(key == 'down')
			{
			moveDown(); 
			ItemMoved = 1;
			$('#activeBox').val(4);
			}	
			else if(key == 'top')
			{
			return;
				
			moveDown(158); 
			ItemMoved = 1;
			$('#activeBox').val(7);
			}
			else if(key == 'left')
			{
			moveRight(150); 
			ItemMoved = 1;
			$('#activeBox').val(3);
			}	
		break;
		case '2':
			if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(3);
			}
			else if(key == 'down')
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(5);
			}	
			else if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(1);
			}	
			else if(key == 'top')
			{
				return;
				moveDown(158); 
				ItemMoved = 1;
				$('#activeBox').val(8);
			}	
		break;
		case '3':
			if(key == 'down')
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(6);
			}	
			else if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(2);
			}	
			else if(key == 'top')
			{
				return;
				moveDown(158); 
				ItemMoved = 1;
				$('#activeBox').val(9);
			}
			else if(key == 'right')
			{
				moveLeft(150);
				ItemMoved = 1;
				$('#activeBox').val(1);
			}
		break;
		case '4':
			if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(5);
			}
			else if(key == 'down' && totalThumbsFirstList == 6)
			{
				moveTop(79); 
				ItemMoved = 1;
				$('#activeBox').val(1);
			}	
			else if(key == 'down' && totalThumbsFirstList > 6)
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(7);
			}
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(1);
			}
			else if(key == 'left')
			{
				moveRight(150); 
				ItemMoved = 1;
				$('#activeBox').val(6);
			}	
		break;
		case '5':
			if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(6);
			}
			else if(key == 'down' && totalThumbsFirstList == 6)
			{
				moveTop(79); 
				ItemMoved = 1;
				$('#activeBox').val(2);
			}	
			else if(key == 'down' && totalThumbsFirstList > 6)
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(8);
			}
			else if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(4);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(2);
			}	
		break;
		case '6':
			if(key == 'down' && totalThumbsFirstList == 6)
			{
				moveTop(79); 
				ItemMoved = 1;
				$('#activeBox').val(3);
			}	
			else if(key == 'down' && totalThumbsFirstList > 6)
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(9);
			}	
			else if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(5);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(3);
			}	
			if(key == 'right')
			{
				moveLeft(150);
				ItemMoved = 1;
				$('#activeBox').val(4);
			}
		break;
		case '7':
			if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(8);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(4);
			}	
			if(key == 'down' && totalThumbsFirstList == 9)
			{
				moveTop(158); 
				ItemMoved = 1;
				$('#activeBox').val(1);
			}	
			if(key == 'down' && totalThumbsFirstList > 9)
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(10);
			}	
			else if(key == 'left')
			{
				moveRight(150); 
				ItemMoved = 1;
				$('#activeBox').val(9);
			}	
		break;
		case '8':
			if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(5);
			}	
			else if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(7);
			}	
			if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(9);
			}	
			if(key == 'down' && totalThumbsFirstList == 9)
			{
				moveTop(158); 
				ItemMoved = 1;
				$('#activeBox').val(2);
			}
			if(key == 'down' && totalThumbsFirstList > 9)
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(11);
			}
			
		break;
		case '9':
			if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(8);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(6);
			}	
			else if(key == 'right')
			{
				moveLeft(150);
				ItemMoved = 1;
				$('#activeBox').val(7);
			}	
			else if(key == 'down' && totalThumbsFirstList == 9)
			{
				moveTop(158); 
				ItemMoved = 1;
				$('#activeBox').val(3);
			}	
			else if(key == 'down' && totalThumbsFirstList > 9)
			{
				moveDown(); 
				ItemMoved = 1;
				$('#activeBox').val(12);
			}
		break;
		case '10':
			if(key == 'left')
			{
				moveRight(150); //moveLeft(150); 
				ItemMoved = 1;
				$('#activeBox').val(12);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(7);
			}	
			else if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(11);
			}	
			else if(key == 'down')
			{
				moveTop(237); 
				ItemMoved = 1;
				$('#activeBox').val(1);
			}	
		break;
		case '11':
			if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(10);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(8);
			}	
			else if(key == 'right')
			{
				moveRight();
				ItemMoved = 1;
				$('#activeBox').val(12);
			}	
			else if(key == 'down')
			{
				moveTop(237); 
				ItemMoved = 1;
				$('#activeBox').val(2);
			}	
		break;
		case '12':
			if(key == 'left')
			{
				moveLeft(); 
				ItemMoved = 1;
				$('#activeBox').val(11);
			}	
			else if(key == 'top')
			{
				moveTop(); 
				ItemMoved = 1;
				$('#activeBox').val(9);
			}	
			else if(key == 'right')
			{
				moveLeft(150);
				ItemMoved = 1;
				$('#activeBox').val(10);
			}	
			else if(key == 'down')
			{
				moveTop(237); 
				ItemMoved = 1;
				$('#activeBox').val(3);
			}	
			
		break;
	}
	
	if(ItemMoved == 1)
	{
		loadImage();
	}
}

function loadImage()
{
	$('#zMainImage #captions').html('').fadeOut();
	$("#zMainImage div.zSpace").html("<img src='load.gif' class='zLoader' />");
	setTimeout("timer()", 800)
}

function timer(p){
	
	var url =  $('#zLi-'+$('#activeBox').val()).find('a').attr('rel');
	var caption =  $('#zLi-'+$('#activeBox').val()).find('a').attr('name');
	
	$('#zMainImage div.zSpace').html('<img src="'+url+'" />'); 
	$('#zMainImage div.zSpace img').hide().fadeIn(600);
	$('#zMainImage #captions').html(caption).fadeIn(600);;
}

function autoPlay()
{
	if($('#Autoplay').val() == 0)
		return;
	
	var active = $('#activeBox').val(); // current state
	
	if($('#clickUsed').val() == 1)
	{
		$('#zThumbs li').css({'padding':'0px','margin':'5px', 'background' : 'url(overlay2.png) top left no-repeat'});
		$('#zOverlay').fadeIn();
	}
		
	if(active < 3)
		var key = 'right';
	else if(active == 3)
		var key = 'down';
	else if( (totalThumbsFirstList== 12 && active == 10) || (totalThumbsFirstList== 6 && active == 4) || (totalThumbsFirstList== 9 && active == 9))
	{
		$('#activeBox').val(1);
		
		if(totalThumbsSecondList > 0)
			zListChange();
		else
			goFirst();
		return;
	}
	else if(active > 9 && active <= 12)
		var key = 'left';
	else if(active == 4)
		var key = 'down';
	else if(active > 3 && active <= 6)
		var key = 'left';
	else if(active > 6 && active < 9)
		var key = 'right';
	else if(active == 9)
		var key = 'down';
	else if(active == 12)
		var key = 'top';
	
	//$('#test').html($('#activeBox').val() + '--'+ key);
	position(active, key);
}

function goFirst(zListChange)
{	
	if($('#clickUsed').val() == 1)
	{
		$('#zThumbs li').css({'padding':'0px','margin':'5px', 'background' : 'url(overlay2.png) top left no-repeat'});
		$('#zOverlay').fadeIn();
	}
	
	var marginLeft  = $('#zOverlay').offset().left;
	var marginTop  = $('#zOverlay').offset().top;

	marginLeft = marginLeft-zCurrLeft;
	marginTop = marginTop-zCurrRight;
	
	$('#zOverlay').animate({
		marginTop: '-='+marginTop,
		marginLeft: '-='+marginLeft,
	  }, 500, function() {
		// Animation Complete.	
	});
	
	clearTime();
	loadImage();
}

function zListChange()
{
	var zCurrentList = $('#zCurrentList').val();
	
	if(zCurrentList == 1)
	{
		$('.first').hide();
		$('.second').fadeIn();	
		$('#zCurrentList').val(0);
		
		zSaveThumbs = totalThumbsFirstList;
		totalThumbsFirstList = totalThumbsSecondList;
		
		$('#activeBox').val(1);
		goFirst(1);
	} 
	else
	{
		$('.second').hide();	
		$('.first').fadeIn();
		$('#zCurrentList').val(1);
		
		totalThumbsFirstList = zSaveThumbs;
		
		$('#activeBox').val(1);
		goFirst(1);
	}	
}

function clearTime()
{
	clearInterval(int);
	int = setInterval("autoPlay()",Interval);	
}

$(document).ready(function() 
{
	if(totalThumbsSecondList > 0)
		var next = '<div class="zNextPrev" id="zNextPrevButton">&nbsp;</div>';
	else
		var next = '';
	
	var controls = '<div id="zControls">'+next+'<div id="zStopButton" title="Play/Paus" class="zStop">&nbsp;</div></div>';
	$('#zThumbs').append(controls);
	
	var hidden = '<div id="zOverlay"></div><input type="hidden" value="1" id="activeBox" /><input type="hidden" value="0" id="clickUsed" /><input type="hidden" value="1" id="Autoplay" /><input type="hidden" value="1" id="zCurrentList" />';
	
	$('#zThumbs').prepend(hidden);
	
	zCurrLeft  = $('#zOverlay').offset().left;
	zCurrRight = $('#zOverlay').offset().top;
	
	$('#zNextPrevButton').click(function(e) {
		
		setTimeout('zListChange();',500);
								   
	 });	
	
	$('#zStopButton').click(function(e) {
	   
	   var Autoplay = $('#Autoplay').val();
	   if(Autoplay == 1)
	   {
			$('#Autoplay').val(0);
			
			$('#zStopButton').removeClass('zStop');
			$('#zStopButton').addClass('zStopClicked');
	   }
		else
			$('#Autoplay').val(1);
			
    });
	
	$('#activeBox').val(1);
	$('#clickUsed').val(0);
	$('#zCurrentList').val(1);
	
	int = setInterval("autoPlay()",Interval);	
	
	$(document).keydown(function(e) {
			
		var active = $('#activeBox').val(); 
		$('#zOverlay').fadeIn();
		
		if($('#clickUsed').val() == 1)
			$('#zThumbs li').css({'padding':'0px','margin':'5px', 'background' : 'url(overlay2.png) top left no-repeat'});
		
		switch(e.keyCode)
		{
			case 37:
			  clearTime();
			  position(active, 'left');
			  break;
			case 38:
			  clearTime();
			  position(active, 'top');
			  break;
			case 39:
			  clearTime();
			  position(active, 'right');
			  break;
			case 40:
			  clearTime();
			  position(active, 'down');
			  break;
		}
	});
	
	$('#zThumbs li').livequery("click", function(e){
		
		var ID =  $(this).attr('id').replace('zLi-','');	
		$('#zOverlay').hide();
		
		$('#clickUsed').val(1);
		
		$('#zThumbs li').css({'padding':'0px','margin':'5px', 'background' : 'url(overlay2.png) top left no-repeat'});
		$(this).css({'padding':'5px','margin':'0px','background':'url(overlay.png) top left no-repeat'}).fadeIn();
		
		$('#zMainImage #captions').html('').fadeOut();
		$("#zMainImage div.zSpace").html("<img src='load.gif' class='zLoader' />");
		
		var url =  $(this).find('a').attr('rel');	
		var caption =  $(this).find('a').attr('name');		
		
		setTimeout("$('#zMainImage div.zSpace').html('<img src="+url+" />');$('#zMainImage div.zSpace img').hide().fadeIn(600);", 800)
		
		$('#zMainImage #captions').html(caption).fadeIn(600);;
		clearTime();
		
		return;
	});	
});	

function moveRight(pos)
{
	if(!pos)pos=75;  
	$('#zOverlay').animate({
		marginLeft: '+='+pos,
	  }, 500, function() {
		// Animation complete.
	});	
}

function moveLeft(pos)
{
	if(!pos)pos=75;
	$('#zOverlay').animate({
		marginLeft: '-='+pos,
	  }, 500, function() {
		// Animation complete.
	});	
}

function moveTop(pos)
{
	if(!pos)pos=80;
	$('#zOverlay').animate({
		marginTop: '-='+pos,
	  }, 500, function() {
		// Animation complete.
	});	
}

function moveDown(pos)
{
	if(!pos)pos=80;
	$('#zOverlay').animate({
		marginTop: '+='+pos,
	  }, 500, function() {
		// Animation complete.
	});	
}

$(document).ready(function(){
						   
  $(window).focus(function() { $('#Autoplay').val(1); });
  $(window).blur(function() { $('#Autoplay').val(0); });
  
});

