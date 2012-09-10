<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo css_asset('auth','style.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
</head>
<script type="text/javascript">

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
function ViewFolder(folder_id)
{
	document.location.href = "/saegeul/auth/getFolder?folder_id=" + folder_id;
}
function DownloadFile(file_id,file_name)
{
	document.location.href = "/saegeul/auth/getFile?file_id=" + file_id + "&file_name=" + file_name;
}
function getFiles(){
	$("#files").slideToggle();
}

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
	var arr = new Array();
	var upload_folder = window.location.href.slice(window.location.href.indexOf('?') + 11).split('&');
	var temp =upload_folder;
	
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
	    	   location.reload();	
			}
	});
});
</script>
<body>
	<?php 
	$temp = json_decode($result);
	?>
	<div id="cloudList">
		<h1 align="center">Cloud List</h1>
		<br>
		<div class="row show-grid">
			<ul class="breadcrumb">
				<li>&nbsp;&nbsp;&nbsp;</li>
				<li><a href="/saegeul/auth/getFolder">Ucloud</a> <span
					class="divider">/</span></li>
			</ul>
		</div>
		<br>
		<form class="bs-docs-example form-search" action="">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><input id="check_all" type="checkbox" /></th>
						<th>종류</th>
						<th>이름</th>
						<th>수정날짜</th>
						<th>크기</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(isset($temp->Folders)){
						foreach ($temp->Folders as $row):

						$folder_name = isset($row->folder_name)?$row->folder_name:"";
						$folder_id = isset($row->folder_id)?$row->folder_id:"";
						$folder_type = isset($row->folder_type)?$row->folder_type:"";
						$device_id = isset($row->device_id)?$row->device_id:"";
						$device_name = isset($row->device_name)?$row->device_name:"";
						?>
					<tr onclick="ViewFolder('<?=$folder_id?>')">
						<td><input type="checkbox" class="chcktbl" /></td>
						<td><?php if($folder_type == "syncFolder" && $folder_name == "휴지통"){?>
							<img alt="휴지통"
							src="/saegeul/modules/auth/views/assets/img/delete_forlder.png">
							<?php }else if($folder_type == "syncFolder" && $folder_name == "웹 폴더"){?>
							<img alt="웹폴더"
							src="/saegeul/modules/auth/views/assets/img/web_forlder.png"> <?php }else if($folder_type == "syncFolder" && $folder_name == "매직 폴더"){?>
							<img alt="매직폴더"
							src="/saegeul/modules/auth/views/assets/img/magic_forlder.png"> <?php }else if($folder_type == "syncFolder" && $folder_name == "모바일 포토"){?>
							<img alt="모바일폴더"
							src="/saegeul/modules/auth/views/assets/img/mobile_photo_folder.png">
							<?php }else if ($folder_type == "folder") {?> <img alt="일반폴더"
							src="/saegeul/modules/auth/views/assets/img/folder.png"> <?php }?>
						</td>
						<td><?=$folder_name?></td>
						<td></td>
						<td></td>
					</tr>
					<?php 
					endforeach;
					}
					if(isset($temp->Files)){
						foreach ($temp->Files as $row):

						$file_name = isset($row->file_name)?$row->file_name:"";
						$file_size = isset($row->file_size)?$row->file_size:"";
						$modify_date = isset($row->modify_date)?$row->modify_date:"";
						$content_type = isset($row->content_type)?$row->content_type:"";
						$presentOnServer = isset($row->presentOnServer)?$row->presentOnServer:"";
						$file_id = isset($row-> file_id)?$row-> file_id:"";
						?>
					<tr onclick="DownloadFile('<?=$file_id?>','<?=$file_name?>')">
						<td><input type="checkbox" class="chcktbl" /></td>
						<td><?=$content_type?></td>
						<td><?=$file_name?></td>
						<td><?=$modify_date?></td>
						<td><?=$file_size?></td>
					</tr>
					<?php 
					endforeach;
					}
					?>
				</tbody>
				<tfoot>
				</tfoot>
			</table>
		</form>
	</div>
	<div id="fileBox">
		<h1 align="center" onclick="getFiles()">FileBox List</h1>
		<div id="files" style="display: none"></div>
	</div>
</body>
</html>
