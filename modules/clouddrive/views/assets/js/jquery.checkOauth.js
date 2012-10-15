$(document).ready(function () {
	$("#creatapi").live('click',function(e) {
		var api_key = $("#apikey").val();
		var secret_key = $("#secretkey").val();
	
		var answer = confirm ('api_key : ' + api_key + ' / secret_key : ' + secret_key + '맞습니까?');
		if(answer){
			location.href="/saegeul/auth/createApi?api_key=" + api_key + "&secretkey=" + secret_key;
		}else{
	   		return false;
		}
	});
	
	$("#oauth").live('click',function(e) {
		location.href="/saegeul/auth/oauth";
	});
	
	$("#clouddrive").live('click',function(e) {
		var oauth_token = $(this).parent().prev().prev().text();
		location.href="/saegeul/admin/clouddrive/ucloudView";
	});
});