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
<?echo css_asset('auth','jquery.waitingpopup-min.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
<?echo js_asset('auth','jquery.waitingpopup-min.js')?>
<?echo js_asset('auth','jquery.auth-ajax.js')?>
</head>
<script type="text/javascript">
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
		<br> <input type="button" id="deletUcloud" value="delete"> <br>
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
					<tr>
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
						<td onclick="ViewFolder('<?=$folder_id?>')"><?=$folder_name?></td>
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
					<tr id='a'>
						<td><input type="checkbox" class="chcktbl" /></td>
						<td id='<?=$file_id?>'><?=$content_type?></td>
						<td onclick="DownloadFile('<?=$file_id?>','<?=$file_name?>')"><?=$file_name?>
						</td>
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