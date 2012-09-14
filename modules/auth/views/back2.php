<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?>
<?echo css_asset('auth','style.css')?>
<?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
<?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
</head>
<script type="text/javascript">
function ViewFolder(folder_id)
{
	$.ajax({
       type: "GET",
       url: "/saegeul/auth/getFolderData",
       contentType: "application/json; charset=utf-8",
       dataType: "json",
       data: "folder_id=" + folder_id,
       error: function() { 
       	alert("error");
        },
       success: function(data){
			var contact = JSON.parse(data);
			if(contact.Folders.length > 0){
				alert(data);
			}
			alert(contact.Folders.length);
		}
	});
}
</script>
<?php 
$temp = json_decode($result);
?>
<body>
	<div id="container">
		<div id="layout_left">
			<ol class="tree">
				<li><label for="Ucloud">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
					<input type="checkbox" id="Ucloud" checked disabled />
					<ol>
						<?php 
						if(isset($temp->Folders)){
							foreach ($temp->Folders as $row):

							$folder_name = isset($row->folder_name)?$row->folder_name:"";
							$folder_id = isset($row->folder_id)?$row->folder_id:"";
							$folder_type = isset($row->folder_type)?$row->folder_type:"";
							$device_id = isset($row->device_id)?$row->device_id:"";
							$device_name = isset($row->device_name)?$row->device_name:"";

							?>
						<li><label for="<?=$folder_name?>"
							onclick="ViewFolder('<?=$folder_id?>')"><?=$folder_name?>
						</label> <input type="checkbox" id="<?=$folder_name?>" />
							<ol id='<?=$folder_id?>'>
							</ol>
						</li>
						<?php
						endforeach;
						}
						?>
					</ol>
				</li>
			</ol>
		</div>
		<div id="layout_center">&nbsp;</div>
		<div id="layout_right">&nbsp;</div>
	</div>
</body>
</html>
