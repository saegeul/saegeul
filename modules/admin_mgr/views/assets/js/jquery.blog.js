$(document).ready(function() {
	
	$(".modifyData").live('click',function(e) {
		var list_count = $('#inputListCount').val();
		var rss_count = $('#inputRSSCount').val();
		var facebook_id = $('#inputFacebookId').val();
		var comment_count = $('#inputCommentCount').val();
		var comment_width = $('#inputCommentWidth').val();
		var theme = $(':input:radio[name=theme]:checked').val();
		var naverApiKey = $('#inputNaverKey').val();
		$.ajax({
			type : "GET",
			url : "/saegeul/admin_mgr/setting/setBlog",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "list_count=" +list_count + "&rss_count=" + rss_count + "&facebook_id=" +facebook_id + "&comment_count=" + comment_count + "&comment_width=" + comment_width + "&theme=" + theme + "&naverApiKey=" + naverApiKey,
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
	