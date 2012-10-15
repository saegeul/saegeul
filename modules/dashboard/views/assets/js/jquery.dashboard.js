$(document).ready(function() {
	$('.btnModuleSchemaInfo').live('click',function() {
		if($(this).next().text() != "()")
			$('.moduleSchemaInfo').show();
	});
});