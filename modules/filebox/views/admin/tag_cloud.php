<?echo css_asset('filebox','jqcloud.css')?>
<?echo js_asset('filebox','jqcloud-1.0.1.js')?>
<script type="text/javascript">
/*!
	* Create an array of word objects, each representing a word in the cloud
*/
$(document).ready(function () {
	$.ajax({
		type: "GET",
	    url: "/saegeul/filebox/admin/filebox/getTag",
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
				var jsonObject = jQuery.parseJSON('{"text":"' + obj.tag + '","weight": "' + (parseInt(obj.total)) + '", "link" : "http://localhost/saegeul/filebox/admin/filebox/fileList?key=tag&keyword='+ obj.tag + '"}');
				jsonArray.push(jsonObject)
			});
	    	$("#tag_cloud").jQCloud(jsonArray);
		}
	});
});
</script>
<!-- You should explicitly specify the dimensions of the container element -->
<div id="tag_cloud"
	style="width: 700px; height: 350px;"></div>
