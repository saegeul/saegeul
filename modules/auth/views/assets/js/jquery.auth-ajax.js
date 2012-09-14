$(document).ready(function(){
    $('#check_all').click(function(){
		if(this.checked == false) {
			$('.chcktbl:checked').attr('checked',false);
		} else {
			$('.chcktbl:not(:checked)').attr('checked',true);
		}
    });
    $('#all_img_check').live('click',function() {
    	if(this.checked == false) {
			$('.imgcheck:checked').attr('checked',false);
		} else {
			$('.imgcheck:not(:checked)').attr('checked',true);
		}
    });
    $.ajax({
	       type: "GET",
	       url: "/saegeul/filebox/getFileList",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=1",
	       error: function() { 
	       	alert("error");
	        },
	       success: function(data){
				json = eval(data);
				
				var markup = "all&nbsp;<input type='checkbox' id='all_img_check'/>&nbsp;<input type='button' value='cloud upload' id='cloud_upload' class='btn'><br><br><ul class='thumbnails'>";
				var page_per_block = 5;
				var prev_page = parseInt(json.page) - 1;
				var next_page = parseInt(json.page) + 1;
			
 	       $.each(json.result, function(key,state){
 	       	obj = state;
 	   			markup += "<li class='span2'>"
     	   			+ "<div class='thumbnail'><input type='checkbox' class='imgcheck'/>"
     	   			+ "<img alt='" + obj.name + "' src='" + obj.thumbnail_url + "' class='img-rounded'>"
     	   			+ "</div>";
 	     	});
	    	   markup += "</ul>"
						+ "<div class='pagination' style='text-align: center;'>"
						+ "<ul>";
				if(parseInt(json.page) > 1){
					markup += "<li id='prevBtn'>"
						+ "<a id='" + prev_page + "'>&laquo;</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>&laquo;</a>"
						+ "</li>";
				}
				if(parseInt(json.page) < parseInt(json.total_page)){
					markup += "<li id='nextBtn'>"
						+ "<a id='" + next_page + "'>&raquo;</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>&raquo;</a>"
						+ "</li>";	
				}
				markup += "</ul>"
						+ "</div>";
				$("#files").html(markup);
				$("#files").hide();
				
			}
	});	
});

$("#prevBtn").live('click',function() {
	var url = $(this).find('a').attr('id');
	$.ajax({
	       type: "GET",
	       url: "/saegeul/filebox/getFileList",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=" + url, 
	       error: function() { 
	       	alert("error");
	        },
	        success: function(data){
				json = eval(data);
				
				var markup = "all&nbsp;<input type='checkbox' id='all_img_check'/>&nbsp;<input type='button' value='cloud upload' id='cloud_upload' class='btn'><br><br><ul class='thumbnails'>";
				var page_per_block = 5;
				var prev_page = parseInt(json.page) - 1;
				var next_page = parseInt(json.page) + 1;
			
 	       $.each(json.result, function(key,state){
 	       	obj = state;
 	   			markup += "<li class='span2'>"
     	   			+ "<div class='thumbnail'><input type='checkbox' class='imgcheck'/>"
     	   			+ "<img alt='" + obj.name + "' src='" + obj.thumbnail_url + "' class='img-rounded'>"
     	   			+ "</div>";
 	     	});
	    	   markup += "</ul>"
						+ "<div class='pagination' style='text-align: center;'>"
						+ "<ul>";
	    	   if(parseInt(json.page) > 1){
					markup += "<li id='prevBtn'>"
						+ "<a id='" + prev_page + "'>&laquo;</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>&laquo;</a>"
						+ "</li>";
				}
				if(parseInt(json.page) < parseInt(json.total_page)){
					markup += "<li id='nextBtn'>"
						+ "<a id='" + next_page + "'>&raquo;</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>&raquo;</a>"
						+ "</li>";	
				}
				markup += "</ul>"
						+ "</div>";
				$("#files").html(markup);		
			}
	});
});

$("#nextBtn").live('click',function() {
	var url = $(this).find('a').attr('id');
	$.ajax({
	       type: "GET",
	       url: "/saegeul/filebox/getFileList",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=" + url, 
	       error: function() { 
	       	alert("error");
	        },
	        success: function(data){
				json = eval(data);
				
				var markup = "all&nbsp;<input type='checkbox' id='all_img_check'/>&nbsp;<input type='button' value='cloud upload' id='cloud_upload' class='btn'><br><br><ul class='thumbnails'>";
				var page_per_block = 3;
				var prev_page = parseInt(json.page) - 1;
				var next_page = parseInt(json.page) + 1;
			
 	       $.each(json.result, function(key,state){
 	       	obj = state;
 	   			markup += "<li class='span2'>"
     	   			+ "<div class='thumbnail'><input type='checkbox' class='imgcheck'/>"
     	   			+ "<img alt='" + obj.name + "' src='" + obj.thumbnail_url + "' class='img-rounded'>"
     	   			+ "</div>";
 	     	});
	    	   markup += "</ul>"
						+ "<div class='pagination' style='text-align: center;'>"
						+ "<ul>";
	    	   if(parseInt(json.page) > 1){
					markup += "<li id='prevBtn'>"
						+ "<a id='" + prev_page + "'>&laquo;</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>&laquo;</a>"
						+ "</li>";
				}
				if(parseInt(json.page) < parseInt(json.total_page)){
					markup += "<li id='nextBtn'>"
						+ "<a id='" + next_page + "'>&raquo;</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>&raquo;</a>"
						+ "</li>";	
				}
				markup += "</ul>"
						+ "</div>";
				$("#files").html(markup);		
			}
	});
});

$('#cloud_upload').live('click',function() {
	// Initialization if the waitingpopup plugin
    $().waitingpopup();

    // open die waitingpopup
    $().waitingpopup('open');
    
	var arr = new Array();
	var upload_folder = window.location.href.slice(window.location.href.indexOf('?') + 11).split('&');
	
	$("input[class=imgcheck]").each(function(){
		if($(this).is(':checked')){
			arr[arr.length] = $(this).next('img').attr('alt');				
		}
	});
	var str = JSON.stringify(arr);
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/uploadFile",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "data=" + str + "&upload_folder=" + upload_folder, 
	       error: function() { 
	       	alert("이폴더에서는 업로드 할 수 없습니다.");
	        },
	       success: function(data){
	    	   // call to close the waitingpopup after 3 seconds
	           setTimeout("$().waitingpopup('close')", data);
	           location.reload();
			}
	});
});

$('#deletUcloud').live('click',function() {
	// Initialization if the waitingpopup plugin
    $().waitingpopup();

    // open die waitingpopup
    $().waitingpopup('open');
    
	var arr = new Array();
	var upload_folder = window.location.href.slice(window.location.href.indexOf('?') + 11).split('&');
	$("input[class=chcktbl]").each(function(){
		if($(this).is(':checked')){
			arr[arr.length] = $(this).parent().next('td').attr('id');				
		}
	});
	var str = JSON.stringify(arr);
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/deleteFile",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "data=" + str + "&upload_folder=" + upload_folder, 
	       error: function() { 
	       	alert("이파일을 삭제 할수 없습니다.");
	        },
	       success: function(data){
	    	   
	           // call to close the waitingpopup after 3 seconds
	           setTimeout("$().waitingpopup('close')", data);
	           location.reload();
			}
	});
});