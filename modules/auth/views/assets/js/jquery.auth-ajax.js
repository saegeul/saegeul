$(document).ready(function () {
	// Initialization if the waitingpopup plugin
	$().waitingpopup();
    // open die waitingpopup
	$().waitingpopup('open');
	
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/getFolderData",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "",
	       error: function() { 
	        },
	       success: function(data){
				var contact = JSON.parse(data);
				var center_markup = "<table class='table table-hover'>"
					+ "<thead>"
						+ "<tr>"
							+ "<th><input id='check_all' type='checkbox' /></th>"
							+ "<th>종류</th>"
							+ "<th>이름</th>"
							+ "<th>수정날짜</th>"
							+ "<th>크기</th>"
						+ "</tr>"
					+ "</thead>"
					+ "<tbody>";	
							
				if(contact.Folders.length > 0){
					var folders = contact.Folders;
					for(var i=0; i< folders.length; i++){
						center_markup += "<tr>"
							+ "<td><input type='checkbox' class='chcktbl' /></td>";
						if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "휴지통")
							center_markup += "<td><img alt='휴지통' src='/saegeul/modules/auth/views/assets/img/delete_forlder.png'></td>";
						else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "웹 폴더")
							center_markup += "<td><img alt='웹 폴더' src='/saegeul/modules/auth/views/assets/img/web_forlder.png'></td>";
						else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "매직 폴더")
							center_markup += "<td><img alt='매직 폴더' src='/saegeul/modules/auth/views/assets/img/magic_forlder.png'></td>";
						else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "모바일 포토")
							center_markup += "<td><img alt='모바일 포토' src='/saegeul/modules/auth/views/assets/img/mobile_photo_folder.png'></td>";

						center_markup += "<td class='clickFolder' id='" + folders[i].folder_id +"'><a href='javascript:void(0)'>" + folders[i].folder_name + "</a></td>"
									+ "<td></td>"
									+ "<td></td>"
								+ "</tr>"
						
					}
				}
				center_markup += "</tbody>"
					+ "</table>";

				var breadcrumb = "<li class='crumb'><a href='javascript:void(0)'>Ucloud</a> <span class='divider'>/</span></li>";
				
				$("#center_table").html(center_markup);
				$(".breadcrumb").html(breadcrumb);
				setTimeout("$().waitingpopup('close')", data); 
			}
	});

	$.ajax({
	       type: "GET",
	       url: "/saegeul/filebox/getFileList",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=1",
	       error: function() { 
	       	alert("저장된 파일이 없습니다.");
	        },
	       success: function(data){
				json = eval(data);
				
				var markup = "&nbsp;all&nbsp;<input type='checkbox' id='all_img_check'/>&nbsp;<input type='button' value='cloud upload' id='cloud_upload' class='btn'><br><br><ul class='thumbnails'>";
				var page_per_block = 5;
				var prev_page = parseInt(json.page) - 1;
				var next_page = parseInt(json.page) + 1;
				var curt_page = parseInt(json.page);
				var total_page = parseInt(json.total_page);
				var first_page = (parseInt((curt_page-1)/page_per_block) * page_per_block) + 1;
				var last_page = first_page + page_per_block - 1;
				
				if (last_page > total_page)
					last_page = total_page;

		    	$.each(json.result, function(key,state){
		       	obj = state;
		   			markup += "<li class='span2'>"
	  	   			+ "<div><input type='checkbox' class='imgcheck'/>"
	  	   			+ "<img alt='" + obj.name + "' src='" + obj.thumbnail_url + "' class='img-rounded'>"
	  	   			+ "</div>";
	     		});
	    	   markup += "</ul>"
						+ "<div class='pagination' style='text-align: center;'>"
						+ "<ul>"
						+ "<li><a id='1'>&laquo;</a></li>";
				if(curt_page > 1){
					markup += "<li class='pageBtn'>"
						+ "<a id='" + prev_page + "'>prev</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>prev</a>"
						+ "</li>";
				}
				for(var i=first_page;i<=last_page;i++){
					if(curt_page == i) {
						markup += "<li class='active'>"
							+ "<a>" + i + "</a>"
							+ "</li>";
					}else{
						markup += "<li class='pageBtn'>"
							+ "<a id='" + i + "'>" + i + "</a>"
							+ "</li>";
					}
				}
				if(curt_page < parseInt(json.total_page)){
					markup += "<li class='pageBtn'>"
						+ "<a id='" + next_page + "'>next</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>next</a>"
						+ "</li>";	
				}
				markup += "<li class='pageBtn'>"
					+ "<a id='" + total_page + "'>&raquo;</a>"
					+ "</li>"
				+ "</ul>"
				+ "</div>";
				$("#files").html(markup);
				$("#files").hide();
				
			}
	});
});

$(".clickFolder").live('click',function(e) {
	var select_folder = $(e.target).closest("td").attr("id");
	var select_folder_name =  $(e.target).closest("td").text();
	var breadcrumb = "<li class='crumb'><a id='"+ select_folder + "' href='javascript:void(0)'>" + select_folder_name + "</a> <span class='divider'>/</span></li>";
	$(breadcrumb).appendTo(".breadcrumb");
	$("input[id=curt_folder]").val(select_folder).change();
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/getFolderData",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "folder_id=" + select_folder,
	       error: function() { 
	        },
	       success: function(data){
				var contact = JSON.parse(data);
				var center_markup = "<table class='table table-hover'>"
						+ "<tr>"
							+ "<th><input id='check_all' type='checkbox' /></th>"
							+ "<th>종류</th>"
							+ "<th>이름</th>"
							+ "<th>수정날짜</th>"
							+ "<th>크기</th>"
						+ "</tr>"
					+ "</thead>"
					+ "<tbody>";
					
				if(contact.Folders.length > 0){
					var folders = contact.Folders;
					for(var i=0; i< folders.length; i++){
						center_markup += "<tr>"
							+ "<td><input type='checkbox' class='chcktbl' /></td>"
							+ "<td><img alt='폴더' src='/saegeul/modules/auth/views/assets/img/folder.png'></td>"
							+ "<td class='clickFolder' id='" + folders[i].folder_id +"'><a href='javascript:void(0)'>" + folders[i].folder_name + "</a></td>"
							+ "<td></td>"
							+ "<td></td>"
						+ "</tr>";
					}
				}
				if(contact.Files.length > 0){
					var files = contact.Files;
					for(var i=0; i< files.length; i++){
						var temp_name = files[i].file_name;
						var temp_modify_date = files[i].modify_date.substring(0, 10);
						center_markup += "<tr>"
							+ "<td><input type='checkbox' class='chcktbl' /></td>"
							+ "<td><img alt='파일' src='/saegeul/modules/auth/views/assets/img/file.png'></td>"
							+ "<td class='downloadFile' id='" + files[i].file_id +"'><a href='javascript:void(0)'>" + temp_name + "</a></td>"
							+ "<td>" + temp_modify_date + "</td>"
							+ "<td>" + files[i].file_size + "</td>"
						+ "</tr>";
					}
				}
				center_markup += "</tbody>"
					+ "</table>";
				$("#center_table").html(center_markup);
	       }
	});
});

$(".pageBtn").live('click',function() {
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
				
				var markup = "&nbsp;all&nbsp;<input type='checkbox' id='all_img_check'/>&nbsp;<input type='button' value='cloud upload' id='cloud_upload' class='btn'><br><br><ul class='thumbnails'>";
				var page_per_block = 5;
				var prev_page = parseInt(json.page) - 1;
				var next_page = parseInt(json.page) + 1;
				var curt_page = parseInt(json.page);
				var total_page = parseInt(json.total_page);
				var first_page = (parseInt((curt_page-1)/page_per_block) * page_per_block) + 1;
				var last_page = first_page + page_per_block - 1;
				
				if (last_page > total_page)
					last_page = total_page;

		    	$.each(json.result, function(key,state){
		       	obj = state;
		   			markup += "<li class='span2'>"
	  	   			+ "<div><input type='checkbox' class='imgcheck'/>"
	  	   			+ "<img alt='" + obj.name + "' src='" + obj.thumbnail_url + "' class='img-rounded'>"
	  	   			+ "</div>";
	     		});
	    	   markup += "</ul>"
						+ "<div class='pagination' style='text-align: center;'>"
						+ "<ul>"
						+ "<li class='pageBtn'><a id='1'>&laquo;</a></li>";
				if(curt_page > 1){
					markup += "<li class='pageBtn'>"
						+ "<a id='" + prev_page + "'>prev</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>prev</a>"
						+ "</li>";
				}
				for(var i=first_page;i<=last_page;i++){
					if(curt_page == i) {
						markup += "<li class='active'>"
							+ "<a>" + i + "</a>"
							+ "</li>";
					}else{
						markup += "<li class='pageBtn'>"
							+ "<a id='" + i + "'>" + i + "</a>"
							+ "</li>";
					}
				}
				if(curt_page < parseInt(json.total_page)){
					markup += "<li class='pageBtn'>"
						+ "<a id='" + next_page + "'>next</a>"
						+ "</li>";
				}else {
					markup += "<li class='disabled'>"
						+ "<a>next</a>"
						+ "</li>";	
				}
				markup += "<li class='pageBtn'>"
					+ "<a id='" + total_page + "'>&raquo;</a>"
					+ "</li>"
				+ "</ul>"
				+ "</div>";
				$("#files").html(markup);
			}
	});
});

$('#check_all').live('click',function() {
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

$('.crumb').live('click',function(e) {
	var select_folder = $(this).find('a').attr('id');
	if(typeof select_folder == 'undefined')
		select_folder = "";
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/getFolderData",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "folder_id=" + select_folder,
	       error: function() { 
	        },
	       success: function(data){
				var contact = JSON.parse(data);
				var center_markup = "<table class='table table-hover'>"
						+ "<tr>"
							+ "<th><input id='check_all' type='checkbox' /></th>"
							+ "<th>종류</th>"
							+ "<th>이름</th>"
							+ "<th>수정날짜</th>"
							+ "<th>크기</th>"
						+ "</tr>"
					+ "</thead>"
					+ "<tbody>";
					
				if(contact.Folders.length > 0){
					var folders = contact.Folders;
					for(var i=0; i< folders.length; i++){
						center_markup += "<tr>"
							+ "<td><input type='checkbox' class='chcktbl' /></td>";
							if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "휴지통")
								center_markup += "<td><img alt='휴지통' src='/saegeul/modules/auth/views/assets/img/delete_forlder.png'></td>";
							else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "웹 폴더")
								center_markup += "<td><img alt='웹 폴더' src='/saegeul/modules/auth/views/assets/img/web_forlder.png'></td>";
							else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "매직 폴더")
								center_markup += "<td><img alt='매직 폴더' src='/saegeul/modules/auth/views/assets/img/magic_forlder.png'></td>";
							else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "모바일 포토")
								center_markup += "<td><img alt='모바일 포토' src='/saegeul/modules/auth/views/assets/img/mobile_photo_folder.png'></td>";
							else
								center_markup += "<td><img alt='폴더' src='/saegeul/modules/auth/views/assets/img/folder.png'></td>";

							center_markup += "<td class='clickFolder' id='" + folders[i].folder_id +"'><a href='javascript:void(0)'>" + folders[i].folder_name + "</a></td>"
							+ "<td></td>"
							+ "<td></td>"
						+ "</tr>";
					}
				}
				if(typeof contact.Files != 'undefined'){
					if(contact.Files.length > 0){
						var files = contact.Files;
						for(var i=0; i< files.length; i++){
							var temp_name = files[i].file_name;
							var temp_modify_date = files[i].modify_date.substring(0, 10);
							center_markup += "<tr>"
								+ "<td><input type='checkbox' class='chcktbl' /></td>"
								+ "<td><img alt='파일' src='/saegeul/modules/auth/views/assets/img/file.png'></td>"
								+ "<td class='downloadFile' id='" + files[i].file_id +"'><a href='javascript:void(0)'>" + temp_name + "</a></td>"
								+ "<td>" + temp_modify_date + "</td>"
								+ "<td>" + files[i].file_size + "</td>"
							+ "</tr>";
						}
					}
				}
				center_markup += "</tbody>"
					+ "</table>";
				$("#center_table").html(center_markup);

				while($(e.target).parent().next('li').length)
					$(e.target).parent().next('li').remove();
					
	       }
	});
});

$('#deletFile').live('click',function() {
	// Initialization if the waitingpopup plugin
    $().waitingpopup();
    // open die waitingpopup
    $().waitingpopup('open');
    
	var arr = new Array();
	$("input[class=chcktbl]").each(function(){
		if($(this).is(':checked')){
			arr[arr.length] = $(this).closest("td").next('td').next('td').attr("id");			
		}
	});
	var str = JSON.stringify(arr);
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/deleteFile",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "data=" + str, 
	       error: function() { 
	       	alert("폴더는 삭제 할수 없습니다.");
	        },
	       success: function(data){	    	   
	           setTimeout("$().waitingpopup('close')", data);
	           location.reload();
			}
	});
});

$('#cloud_upload').live('click',function() {
	// Initialization if the waitingpopup plugin
    $().waitingpopup();

    // open die waitingpopup
    $().waitingpopup('open');
    
	var arr = new Array();
	var upload_folder = $("input[id=curt_folder]").attr("value");
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

$('.downloadFile').live('click',function() {
	// Initialization if the waitingpopup plugin
	$().waitingpopup();
    // open die waitingpopup
	$().waitingpopup('open');

	var file_id = $(this).closest("td").attr("id");
	var file_name = $(this).closest("td").text();
	
	document.location.href = "/saegeul/auth/getFile?file_id=" + file_id + "&file_name=" + file_name;
	setTimeout("$().waitingpopup('close')", 3000); 
});

$('.getList').live('click',function() {
	$("#files").slideToggle();
});