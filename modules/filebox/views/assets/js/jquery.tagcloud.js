$(document).ready(function () {
	$.ajax({
		type: "GET",
	    url: "/saegeul/admin/filebox/getTag",
	    contentType: "application/json; charset=utf-8",
	    dataType: "json",
	    data: "data=",
	    error: function() { 
		    
	     },
	    success: function(data){
	    	var jsonArray = [];
	    	json = eval(data);
	    	$.each(json.result, function(key,state){
				obj = state;
				var jsonObject = jQuery.parseJSON('{"text":"' + obj.tag + '","weight": "' + (parseInt(obj.total)) + '", "link" : "' + json.base_url + 'admin/filebox/fileList?search_key=tag&search_keyword='+ obj.tag + '"}');
				jsonArray.push(jsonObject)
			});
	    	$("#tag_cloud").jQCloud(jsonArray);
		}
	});
});