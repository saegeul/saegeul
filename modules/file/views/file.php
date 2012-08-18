</body>
</html>
<head>
<meta charset="utf-8">
<title>jQuery File Upload Demo</title>

<link rel="stylesheet"
	href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
<link rel="stylesheet"
	href="http://blueimp.github.com/Bootstrap-Image-Gallery/bootstrap-image-gallery.min.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/bootstrap-ie6.min.css"><![endif]-->
<link rel="stylesheet"
	href="http://blueimp.github.com/jQuery-File-Upload/jquery.fileupload-ui.css">
<style type="text/css">
body {
	padding-top: 80px;
}
</style>
<meta name="description"
	content="File Upload widget with multiple file selection, drag&amp;drop support, progress bar and preview images for jQuery. Supports cross-domain, chunked and resumable file uploads. Works with any server-side platform (Google App Engine, PHP, Python, Ruby on Rails, Java, etc.) that supports standard HTML form file uploads.">
</head>
<body>
	<div class="container">
		<form id="fileupload" action="file/do_upload" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="span16 fileupload-buttonbar">
					<div class="progressbar fileupload-progressbar fade">
						<div style="width: 0%;"></div>
					</div>
					<span class="btn success fileinput-button"> <span>Add files...</span>
						<input type="file" name="userfile[]" multiple>
					</span>
					<button type="submit" class="btn primary start">Start upload</button>
					<button type="reset" class="btn info cancel">Cancel upload</button>
					<button type="button" class="btn danger delete">Delete selected</button>
					<input type="checkbox" class="toggle">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="span16">
					<table class="zebra-striped">
						<tbody class="files"></tbody>
					</table>
				</div>
			</div>
		</form>

	</div>
	<!-- gallery-loader is the loading animation container -->
	<div id="gallery-loader"></div>
	<!-- gallery-modal is the modal dialog used for the image gallery -->
	<div id="gallery-modal" class="modal hide fade">
		<div class="modal-header">
			<a href="#" class="close">&times;</a>
			<h3 class="title"></h3>
		</div>
		<div class="modal-body"></div>
		<div class="modal-footer">
			<a class="btn primary next">Next</a> <a class="btn info prev">Previous</a>
			<a class="btn success download" target="_blank">Download</a>
		</div>
	</div>
	<script>
var fileUploadErrors = {
    maxFileSize: 'File is too big',
    minFileSize: 'File is too small',
    acceptFileTypes: 'Filetype not allowed',
    maxNumberOfFiles: 'Max number of files exceeded',
    uploadedBytes: 'Uploaded bytes exceed file size',
    emptyResult: 'Empty file upload result'
};

</script>
	<script id="template-upload" type="text/html">
{% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name">{%=file.name%}</td>
        <td class="size">{%=o.formatFileSize(file.size)%}</td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td class="progress"><div class="progressbar"><div style="width:0%;"></div></div></td>
            <td class="start">{% if (!o.options.autoUpload) { %}<button class="btn primary">Start</button>{% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}<button class="btn info">Cancel</button>{% } %}</td>
    </tr>
{% } %}
</script>
	<script id="template-download" type="text/html">
{% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name">{%=file.name%}</td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}">{%=file.name%}</a>
            </td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">Delete</button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}
</script>
	<script
		src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
	<script
		src="http://blueimp.github.com/jQuery-File-Upload/vendor/jquery.ui.widget.js"></script>
	<!-- The Templates and Load Image plugins are included for the FileUpload user interface -->
	<script
		src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
	<script
		src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
	<!-- Bootstrap Modal and Image Gallery are not required, but included for the demo -->
	<script
		src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-modal.min.js"></script>

	<script
		src="http://blueimp.github.com/Bootstrap-Image-Gallery/bootstrap-image-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script
		src="http://blueimp.github.com/jQuery-File-Upload/jquery.iframe-transport.js"></script>
	<script
		src="http://blueimp.github.com/jQuery-File-Upload/jquery.fileupload.js"></script>
	<script
		src="http://blueimp.github.com/jQuery-File-Upload/jquery.fileupload-ui.js"></script>
	<script
		src="http://blueimp.github.com/jQuery-File-Upload/application.js"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
	<!--[if gte IE 8]><script src="http://blueimp.github.com/jQuery-File-Upload/cors/jquery.xdr-transport.js"></script><![endif]-->


</body>
</html>
