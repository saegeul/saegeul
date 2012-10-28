$(document).ready(function() {
	
	$(".btnCheckAuth").live('click',function(e) {
		var openapi_id = $(this).parent().parent().attr('id');
	});
	
	$(".btnEditOpenApi").live('click',function(e) {
		var openapi_id = $(this).parent().parent().attr('id');
		var row = $(this).parent().parent().get(0);
		$('#inputOpenapiId').val($(row.cells[0]).html());
		$('#inputProvider').val($(row.cells[1]).html());
		$('#inputApiKey').val($(row.cells[2]).html());
		$('#inputSecretKey').val($(row.cells[3]).html());
		$('#openApiModal').modal('show');
	});
	
	$(".modifyData").live('click',function(e) {
		var openapi_id = $('#inputOpenapiId').val();
		var provider = $('#inputProvider').val();
		var api_key = $('#inputApiKey').val();
		var secret_key = $('#inputSecretKey').val();
		
		$.ajax({
			type : "GET",
			url : "/saegeul/admin_mgr/setting/modifyOpenApi",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "openapi_id=" +openapi_id + "&provider=" + provider + "&api_key=" + api_key + "&secret_key=" + secret_key,
			error : function() {
				alert("error");
			},
			success : function(data) {
				location.reload();
			}
		});
	});
	
	$(".btnCreateOpenApi").live('click',function(e) {
		var provider = $("#provider").val();
		var api_key = $("#api_key").val();
		var secret_key = $("#secret_key").val();
		
		$.ajax({
			type : "GET",
			url : "/saegeul/admin_mgr/setting/resisterOpenApi",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "provider=" + provider + "&api_key=" + api_key + "&secret_key=" + secret_key,
			error : function() {
				alert("error");
			},
			success : function(data) {
				 $("#provider").val('');
				 $("#api_key").val('');
				 $("#secret_key").val('');
				location.reload();
			}
		});
	});
	
	$('.btnDeleteOpenApi').live('click',function() {
		var openapi_id = $(this).parent().parent().attr('id');
		$.ajax({
			type : "GET",
			url : "/saegeul/admin_mgr/setting/deleteOpenApi",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "openapi_id=" + openapi_id,
			error : function() {
				alert("error");
			},
			success : function(data) {
				location.reload();
			}
		});
	});
});
