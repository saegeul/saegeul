$(document).ready(function() {
	
	$(".modifyData").live('click',function(e) {
		var list_count = $('#inputListCount').val();
		var facebook_id = $('#inputFacebookId').val();

		$.ajax({
			type : "GET",
			url : "/saegeul/admin_mgr/setting/setBlog",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "list_count=" +list_count + "&facebook_id=" + facebook_id,
			error : function() {
				alert("error");
			},
			success : function(data) {
				alert("완료 되었습니다.");
				location.reload();
			}
		});
	});
});
	