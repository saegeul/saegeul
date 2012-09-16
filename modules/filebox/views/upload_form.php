<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<title>UploadForm</title>
<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<?echo css_asset('filebox','style.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
<link rel="stylesheet"
	href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
<?echo css_asset('filebox','jquery.fileupload-ui.css')?>
</head>
<body>
	<div class="contents">
		<div class="group" align="center">
			<h2>Drag and DropFile Upload</h2>
		</div>
		<div class="droparea" >
			<p class="dropfiletext">Drop files here</p>
		</div>
		<br>
		<form id="fileupload" action="process" method="POST"
			enctype="multipart/form-data">
			<div class="row fileupload-buttonbar">
				<div class="span7">
					<span class="btn btn-success fileinput-button"> <i
						class="icon-plus icon-white"></i> <span>Add files...</span> <input
						type="file" name="userfile" multiple>
					</span>
					<button type="submit" class="btn btn-primary start">
						<i class="icon-upload icon-white"></i> <span>Start upload</span>
					</button>
					<button type="reset" class="btn btn-warning cancel">
						<i class="icon-ban-circle icon-white"></i> <span>Cancel upload</span>
					</button>
					<button type="button" class="btn btn-danger delete">
						<i class="icon-trash icon-white"></i> <span>Delete</span>
					</button>
					<input type="checkbox" class="toggle">
				</div>
				<div class="span5 fileupload-progress fade">
					<div class="progress progress-success progress-striped active">
						<div class="bar" style="width: 0%;"></div>
					</div>
					<div class="progress-extended">&nbsp;</div>
				</div>
			</div>
			<div class="fileupload-loading"></div>
			<table class="table table-hover">
				<tbody class="files" data-toggle="modal-gallery"
					data-target="#modal-gallery"></tbody>
			</table>
		</form>
	</div>
	<div id="modal-gallery" class="modal modal-gallery hide fade"
		data-filter=":odd">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3 class="modal-title"></h3>
		</div>
		<div class="modal-body">
			<div class="modal-image"></div>
		</div>
	</div>
	<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
	<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
	<script
		src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<?echo js_asset('filebox','js/vendor/jquery.ui.widget.js') ?>
	<script
		src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
	<script
		src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
	<script
		src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
	<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>
	<script
		src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
	<?echo js_asset('filebox','jquery.iframe-transport.js') ?>
	<?echo js_asset('filebox','jquery.fileupload.js') ?>
	<?echo js_asset('filebox','jquery.fileupload-fp.js') ?>
	<?echo js_asset('filebox','jquery.fileupload-ui.js') ?>
	<?echo js_asset('filebox','locale.js') ?>
	<?echo js_asset('filebox','main.js') ?>
	<!--[if gte IE 8]><?echo js_asset('js','cors/jquery.xdr-transport.js') ?><![endif]-->
</body>
</html>
