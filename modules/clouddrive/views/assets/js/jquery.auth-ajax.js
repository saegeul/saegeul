$(document).ready(function () {
	// Initialization if the waitingpopup plugin
	$().waitingpopup();
    // open die waitingpopup
	$().waitingpopup('open');
	
	$.ajax({
	       type: "GET",
	       url: "/saegeul/clouddrive/admin/clouddrive/getKtCloudData",
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
							center_markup += "<td><img alt='휴지통' src='/saegeul/modules/clouddrive/views/assets/img/delete_forlder.png'></td>";
						else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "웹 폴더")
							center_markup += "<td><img alt='웹 폴더' src='/saegeul/modules/clouddrive/views/assets/img/web_forlder.png'></td>";
						else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "매직 폴더")
							center_markup += "<td><img alt='매직 폴더' src='/saegeul/modules/clouddrive/views/assets/img/magic_forlder.png'></td>";
						else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "모바일 포토")
							center_markup += "<td><img alt='모바일 포토' src='/saegeul/modules/clouddrive/views/assets/img/mobile_photo_folder.png'></td>";

						center_markup += "<td class='clickFolder' id='" + folders[i].folder_id +"'><a href='javascript:void(0)' style='color: #333333;'>" + folders[i].folder_name + "</a></td>"
									+ "<td></td>"
									+ "<td></td>"
								+ "</tr>"
						
					}
				}
				center_markup += "</tbody>"
					+ "</table>";

				var breadcrumb = "<li class='crumb'><a href='javascript:void(0)' style='color: #333333;'>Ucloud</a> <span class='divider'>/</span></li>";
				
				$("#center_table").html(center_markup);
				$(".breadcrumb").html(breadcrumb);
				setTimeout("$().waitingpopup('close')", data); 
			}
	});
	
	$.ajax({
	       type: "GET",
	       url: "/saegeul/clouddrive/admin/clouddrive/fileBoxList",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=1",
	       error: function() { 
	       	alert("저장된 파일이 없습니다.");
	        },
	       success: function(data){
	    	   var page_count = parseInt(data.pagination.page_count);
	    	   var page = parseInt(data.pagination.page);
	    	   var first_page;
	    	   var last_page;
	    	   var temp
	    	   if(page_count >= 5){
	    		   first_page = page > 3 ? page - 2 : 1;
	    		   last_page = page > 3 ? page + 2 : 5;
	    		   if(last_page > page_count){
	    			   last_page = page_count;
	    			   temp = 5 - (last_page % 5);
	    			   first_page = last_page - (temp + 1);
	    		   }
	    	   }else {
	    		   first_page = 1;
	    		   last_page = page_count;
	    	   }
	    	   
	    	   var markup = "<div style='margin-left:28px;'>&nbsp;all&nbsp;<input type='checkbox' id='all_img_check' style='margin-top:-4px'/>&nbsp;<a href='javascript:void(0)' id='moveUcloud' style='color: #333333;'><i class='icon-upload'></i>MoveUcloud</a></div><br><ul class='thumbnails' style='margin-left: 0px;'>";
	    	   
	    		$.each(data.fileList, function(key,state){
	    			obj = state;
	    			markup += "<li>"
			   			+ "<div align='center' style='height:120px;width:120px;-moz-transition: all 0.2s ease-in-out 0s;border: 1px solid #DDDDDD;border-radius: 4px 4px 4px 4px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);display: block;line-height: 20px;padding: 4px;'><input type='checkbox' class='imgcheck'/>"
		  	   			+ "<img alt='" + obj.file_srl + "' src='" + data.base_url + obj.image_thumb_path + "'>"
		  	   			+ "<div class='caption'><p>" + obj.original_file_name.substring(0, 12) +"</p></div>"
		  	   			+ "</div>";
	    		});
	    		
	    		markup += "</ul>"
					+ "<div class='pagination' align='center' style='margin-left:-10px;'>"
					+ "<ul>"
				for(var i=first_page;i<page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "<li class=active><a href=javascript:void(0)>" + page + "</a></li>"
	    		for(var i=(page + 1);i<=last_page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "</ul></div>";
	    		
			$("#files").html(markup);
			}
	});
});

$(".pageBtn").live('click',function() {
	var page = $(this).find('a').attr('id');
	$.ajax({
		type: "GET",
	       url: "/saegeul/clouddrive/admin/clouddrive/fileBoxList",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "page=" + page,
	       error: function() { 
	       	alert("저장된 파일이 없습니다.");
	        },
	       success: function(data){
	    	   var page_count = parseInt(data.pagination.page_count);
	    	   var page = parseInt(data.pagination.page);
	    	   var first_page;
	    	   var last_page;
	    	   var temp
	    	   if(page_count >= 5){
	    		   first_page = page > 3 ? page - 2 : 1;
	    		   last_page = page > 3 ? page + 2 : 5;
	    		   if(last_page > page_count){
	    			   last_page = page_count;
	    			   if((last_page % 5) != 0){
	    				   temp = parseInt(5 - (last_page % 5));
	    				   first_page = last_page - (temp + 1);
	    			   }else{
	    				   first_page = last_page - 4;
	    			   }
	    		   }
	    	   }else {
	    		   first_page = 1;
	    		   last_page = page_count;
	    	   }
	    	   
	    	   var markup = "<div style='margin-left:28px;'>&nbsp;all&nbsp;<input type='checkbox' id='all_img_check' style='margin-top:-4px'/>&nbsp;<a href='javascript:void(0)' id='moveUcloud' style='color: #333333;'><i class='icon-upload'></i>MoveUcloud</a></div><br><ul class='thumbnails' style='margin-left: 0px;'>";
	    	   
	    		$.each(data.fileList, function(key,state){
	    			obj = state;
	    			markup += "<li>"
			   			+ "<div align='center' style='height:120px;width:120px;-moz-transition: all 0.2s ease-in-out 0s;border: 1px solid #DDDDDD;border-radius: 4px 4px 4px 4px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);display: block;line-height: 20px;padding: 4px;'><input type='checkbox' class='imgcheck'/>"
		  	   			+ "<img alt='" + obj.file_srl + "' src='" + data.base_url + obj.image_thumb_path + "'>"
		  	   			+ "<div class='caption'><p>" + obj.original_file_name.substring(0, 12) +"</p></div>"
		  	   			+ "</div>";
	    		});
	    		
	    		markup += "</ul>"
					+ "<div class='pagination' align='center' style='margin-left:-10px;'>"
					+ "<ul>"
				for(var i=first_page;i<page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "<li class=active><a href=javascript:void(0)>" + page + "</a></li>"
	    		for(var i=(page + 1);i<=last_page;i++){
					markup += "<li class='pageBtn'>"
					+ "<a id='" + i + "' style='color: #333333;'>" + i + "</a>"
					+ "</li>";
				}
	    		markup += "</ul></div>";
	    		
			$("#files").html(markup);
			}
	});
});

$(".clickFolder").live('click',function(e) {
	var select_folder = $(e.target).closest("td").attr("id");
	var select_folder_name =  $(e.target).closest("td").text();
	var breadcrumb = "<li class='crumb'><a id='"+ select_folder + "' href='javascript:void(0)' style='color: #333333;'>" + select_folder_name + "</a> <span class='divider'>/</span></li>";
	$(breadcrumb).appendTo(".breadcrumb");
	$("input[id=curt_folder]").val(select_folder).change();
	$.ajax({
	       type: "GET",
	       url: "/saegeul/clouddrive/admin/clouddrive/getKtCloudData",
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
					+ "<tbody id='addbody'>";
					
				if(contact.Folders.length > 0){
					var folders = contact.Folders;
					for(var i=0; i< folders.length; i++){
						center_markup += "<tr>"
							+ "<td><input type='checkbox' class='chcktbl' /></td>"
							+ "<td><img alt='폴더' src='/saegeul/modules/clouddrive/views/assets/img/folder.png'></td>"
							+ "<td class='clickFolder' id='" + folders[i].folder_id +"'><a href='javascript:void(0)' style='color: #333333;'>" + folders[i].folder_name + "</a></td>"
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
							+ "<td><img alt='파일' src='/saegeul/modules/clouddrive/views/assets/img/file.png'></td>"
							+ "<td class='downloadFile' id='" + files[i].file_id +"'><a href='javascript:void(0)' style='color: #333333;'>" + temp_name + "</a></td>"
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

$('.crumb').live('click',function(e) {
	var select_folder = $(this).find('a').attr('id');
	if(typeof select_folder == 'undefined')
		select_folder = "";
	$.ajax({
	       type: "GET",
	       url: "/saegeul/clouddrive/admin/clouddrive/getKtCloudData",
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
					+ "<tbody id='addbody'>";
					
				if(contact.Folders.length > 0){
					var folders = contact.Folders;
					for(var i=0; i< folders.length; i++){
						center_markup += "<tr>"
							+ "<td><input type='checkbox' class='chcktbl' /></td>";
							if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "휴지통")
								center_markup += "<td><img alt='휴지통' src='/saegeul/modules/clouddrive/views/assets/img/delete_forlder.png'></td>";
							else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "웹 폴더")
								center_markup += "<td><img alt='웹 폴더' src='/saegeul/modules/clouddrive/views/assets/img/web_forlder.png'></td>";
							else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "매직 폴더")
								center_markup += "<td><img alt='매직 폴더' src='/saegeul/modules/clouddrive/views/assets/img/magic_forlder.png'></td>";
							else if(folders[i].folder_type == "syncFolder" && folders[i].folder_name == "모바일 포토")
								center_markup += "<td><img alt='모바일 포토' src='/saegeul/modules/clouddrive/views/assets/img/mobile_photo_folder.png'></td>";
							else
								center_markup += "<td><img alt='폴더' src='/saegeul/modules/clouddrive/views/assets/img/folder.png'></td>";

							center_markup += "<td class='clickFolder' id='" + folders[i].folder_id +"'><a href='javascript:void(0)' style='color: #333333;'>" + folders[i].folder_name + "</a></td>"
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
								+ "<td><img alt='파일' src='/saegeul/modules/clouddrive/views/assets/img/file.png'></td>"
								+ "<td class='downloadFile' id='" + files[i].file_id +"'><a href='javascript:void(0)'  style='color: #333333;'>" + temp_name + "</a></td>"
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

$('#createFolder').live('click',function() {
	var addFolder = "<tr>"
		+ "<td><input type='checkbox' class='chcktbl' /></td>"
		+ "<td><img alt='폴더' src='/saegeul/modules/clouddrive/views/assets/img/folder.png'></td>"
		+ "<td colspan='3'>"
			+ "<div>"
				+ "<form class='form-inline'>"
					+ "<input type='text' class='addFolderName'>&nbsp;&nbsp;<button class='btn btn-primary createAddFolderBtn' type='button'>폴더생성</button>&nbsp;<button class='btn btn-danger cancleAddFolderBtn' type='button'>취소</button>"
				+ "</form>"
			+ "</div>"
		+ "</td>"	
	+ "</tr>";
	$(addFolder).appendTo("#addbody");
	//
});

$('.createAddFolderBtn').live('click',function(e) {
	var folderName =  $(this).prev().attr('value');
	var upload_folder = $("input[id=curt_folder]").attr("value");
	if(folderName == ""){
		$(this).prev().attr('placeholder','Input Folder Name');
	}else{
		$.ajax({
		       type: "GET",
		       url: "/saegeul/clouddrive/admin/clouddrive/createKtCloudFolder",
		       contentType: "application/json; charset=utf-8",
		       dataType: "json",
		       data: "addFolderName=" + folderName + "&upload_folder=" + upload_folder, 
		       error: function() { 
		       	alert("이폴더에서는 폴더를 생성할 수 없습니다.");
		        },
		       success: function(data){
		    	   // call to close the waitingpopup after 3 seconds
		           setTimeout("$().waitingpopup('close')", data);
		           location.reload();
				}
		});
	}
});

$('#moveUcloud').live('click',function() {
	// Initialization if the waitingpopup plugin
    $().waitingpopup();

    // open die waitingpopup
    $().waitingpopup('open');
    
	var arr = new Array();
	var upload_folder = $("input[id=curt_folder]").attr("value");
	
	if(upload_folder != ""){
		$("input[class=imgcheck]").each(function(){
			if($(this).is(':checked')){
				arr[arr.length] = $(this).next('img').attr('alt');				
			}
		});
		var str = JSON.stringify(arr);
		$.ajax({
		       type: "GET",
		       url: "/saegeul/clouddrive/admin/clouddrive/movefileBoxToKtCloud",
		       contentType: "application/json; charset=utf-8",
		       dataType: "json",
		       data: "data=" + str + "&upload_folder=" + upload_folder, 
		       error: function() { 
		       	alert("이파일은 업로드 할 수 없습니다.");
		        },
		       success: function(data){
		           setTimeout("$().waitingpopup('close')", data);
		           location.reload();
				}
		});
	}else{
		alert("이폴더에서는 업로드 할 수 없습니다.");
		setTimeout("$().waitingpopup('close')");
	}
});

$('#moveFilebox').live('click',function() {
	var arr_id = new Array();
	var arr_name = new Array();
	var upload_folder = $("input[id=curt_folder]").attr("value");
	$("input[class=chcktbl]").each(function(){
		if($(this).is(':checked')){
			arr_id[arr_id.length] = $(this).closest("td").next('td').next('td').attr("id");	
			arr_name[arr_name.length] = $(this).closest("td").next('td').next('td').text();
		}
	});
	var data_id = JSON.stringify(arr_id);
	var data_name = JSON.stringify(arr_name);
	$.ajax({
		type: "GET",
		 url: "/saegeul/clouddrive/admin/clouddrive/moveKtCloudTofileBox",
	    contentType: "application/json; charset=utf-8",
	    dataType: "json",
	    data: "data_id=" + data_id + "&data_name=" + data_name +"&upload_folder=" + upload_folder, 
	    error: function() { 
	    	alert("파일을 이동시키지 못했습니다.");
	     },
	    success: function(data){	    	   
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
	
	document.location.href = "/saegeul/clouddrive/admin/clouddrive/downloadKtCloudFile?file_id=" + file_id + "&file_name=" + file_name;
	setTimeout("$().waitingpopup('close')", 3000); 
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
	       url: "/saegeul/clouddrive/admin/clouddrive/deleteKtCloudData",
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

$('.cancleAddFolderBtn').live('click',function(e) {
	$(e.target).closest('tr').remove();
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