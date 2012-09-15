<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KTCloud</title>
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

$(document).ready(function () {
	$.ajax({
	       type: "GET",
	       url: "/saegeul/auth/getFolderData",
	       contentType: "application/json; charset=utf-8",
	       dataType: "json",
	       data: "",
	       error: function() { 
	       	alert("error");
	        },
	       success: function(data){
				var contact = JSON.parse(data);
				var markup = "<ol class='tree'>"
						+ "<li>"
							+ "<label for='Ucloud'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>"
							+ "<input type='checkbox' id='Ucloud' checked disabled />"
							+ "<ol>";
					
				if(contact.Folders.length > 0){
					var folders = contact.Folders;
					for(var i=0; i< folders.length; i++){
						markup += "<li>"
								+ "<label class='clickBtn' for='" + folders[i].folder_name + "'>" + folders[i].folder_name + "</label>"
								+ "<input type='checkbox' id='" + folders[i].folder_name + "' />"
								+ "<ol id='" + folders[i].folder_id + "'>"
								+ "</ol>"
							+ "</li>";
					}
				}
				markup += "</ol>"
					+ "</li>"
				+ "</ol>";
				$("#layout_left").html(markup);
			}
	});
});

$(".clickBtn").live('click',function() {
	alert("ddddd");
})
	
</script>
<?php 
$temp = json_decode($result);
?>
<body>
	<div id="container">
		<div id="layout_left">
			<div id="tree"></div>
		</div>
		<div id="layout_center">&nbsp;</div>
		<div id="layout_right">&nbsp;</div>
	</div>
</body>
</html>
