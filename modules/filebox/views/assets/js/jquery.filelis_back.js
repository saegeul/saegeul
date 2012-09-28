function FileModify(filePath, thumbnailPath, fileName, fileType, author,
		regDate, address, isvalid, no, tag, file, downCnt, fold_url) {

	var markup = "<form method='get'>"
			+ "<legend>Image Modify</legend>"
			+ "<dl class='thumbnails'>"
			+ "<dd style='margin-left:37px;height:110px;width:130px;float:left;'>"
			+ "<div align='middle' style='margin: 0px auto; height: 100px; width: 120px; -moz-transition: all 0.2s ease-in-out 0s ; border: 1px solid rgb(221, 221, 221); border-radius: 4px 4px 4px 4px; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.055); display: block; padding: 4px; line-height: 100px;'>"
			+ "<img src="
			+ thumbnailPath
			+ " id=thumb class='img-rounded'>"
			+ "</div>"
			+ "</dd>"
			+ "<dd style='float:right;'>"
			+ "<div>"
			+ "&nbsp;&nbsp;&nbsp;파일 이름 : <INPUT type='text' id='mod_name' name='mod_name' value = "
			+ fileName
			+ ">"
			+ "</div>"
			+ "</dd>"
			+ "<dd style='float:right;'>"
			+ "<div>"
			+ "&nbsp;&nbsp;&nbsp;파일 유형 : <INPUT type='text' id='mod_type' name='mod_type' value = "
			+ fileType
			+ " readonly >"
			+ "</div>"
			+ "</dd>"
			+ "<dd style='float:right;'>"
			+ "<div>"
			+ "&nbsp;&nbsp;&nbsp;올린 사람 : <INPUT type='text' id='mod_author' name='mod_author' value = "
			+ author
			+ " readonly >"
			+ "</div>"
			+ "</dd>"
			+ "</dl>"
			+ "<dl id='tag'>"
			+ "<p>"
			+ "&nbsp;&nbsp;&nbsp;태그 : <input type='text' id='mod_tag' name = 'mod_tag' style='width:140px;' value = '"
			+ tag
			+ "'>"
			+ "&nbsp;&nbsp;<a href='javascript:void(0)' id='add_tag'><i class='icon-tag'></i>태그달기</a>"
			+ "</p>" + "</dl>";
	if (isvalid == "Y") {
		markup += "<dl>"
				+ "<p>"
				+ "&nbsp;&nbsp;&nbsp;접근권한 : <INPUT type='radio' value= 'Y' class='mod_isvalid' name='mod_isvalid' checked> 허용 <INPUT type='radio' value= 'N' class='mod_isvalid' name='mod_isvalid'> 거부"
				+ "</p>" + "</dl>";
	} else {
		markup += "<dl>"
				+ "<p>"
				+ "&nbsp;&nbsp;&nbsp;접근권한 : <INPUT type='radio' value= 'Y' class='mod_isvalid' name='mod_isvalid' > 허용 <INPUT type='radio' value= 'N' class='mod_isvalid' name='mod_isvalid' checked> 거부"
				+ "</p>" + "</dl>";
	}
	markup += "<dl>"
			+ "<p>"
			+ "&nbsp;&nbsp;&nbsp;DownCount : <INPUT type='text' id='mod_down_cnt' value="
			+ downCnt
			+ " name='mod_down_cnt' readonly>"
			+ "</p>"
			+ "</dl>"
			+ "<dl>"
			+ "<p>"
			+ "&nbsp;&nbsp;&nbsp;RegDate : <INPUT type='text' id='mod_redate' value="
			+ regDate
			+ " name='mod_reddate' readonly>"
			+ "</p>"
			+ "</dl>"
			+ "<dl>"
			+ "<p>"
			+ "&nbsp;&nbsp;&nbsp;IP : <INPUT type='text' id='mod_address' value="
			+ address + " name='mod_address' readonly>" + "</p>" + "</dl>"
			+ "</form>";

	$("#dialog-confirm").html(markup).dialog('open');

	$("#dialog-confirm")
			.dialog(
					"option",
					"buttons",
					[
							{
								text : "Download",
								click : function() {
									$
											.ajax({
												type : "GET",
												url : "/saegeul/filebox/getDownCnt",
												contentType : "application/json; charset=utf-8",
												dataType : "json",
												data : "file=" + file,
												error : function() {
													alert("error");
												},
												success : function(data) {
													$(
															"input[name=mod_down_cnt]")
															.val(data.down_cnt)
															.change();
													location.href = "/saegeul/filebox/fileDownload?file="
															+ file;
												}
											});
								}
							},
							{
								text : "Modify",
								click : function() {
									var mod_name = $('#mod_name').attr('value');
									var mod_radio_object = $('.mod_isvalid');
									var mod_tag = $('#mod_tag').attr('value');
									var mod_isvalid;
									for (i = 0; i < mod_radio_object.length; i++)
										if (mod_radio_object[i].checked)
											mod_isvalid = mod_radio_object[i].value;

									$
											.ajax({
												type : "GET",
												url : "/saegeul/filebox/fileModify",
												contentType : "application/json; charset=utf-8",
												dataType : "json",
												data : "mod_name=" + mod_name
														+ "&mod_isvalid="
														+ mod_isvalid
														+ "&mod_no=" + no
														+ "&mod_tag=" + mod_tag,
												error : function() {
													alert("error");
												},
												success : function(data) {
													location.reload();
												}
											});
								}
							},
							{
								text : "Delete",
								click : function() {
									$
											.ajax({
												type : "GET",
												url : "/saegeul/filebox/delete",
												contentType : "application/json; charset=utf-8",
												dataType : "json",
												data : "file=" + file,
												error : function() {
													alert("error");
												},
												success : function(data) {
													location.reload();
												}
											});
								}
							}, {
								text : "Cancle",
								click : function() {
									$(this).dialog("close");
								}
							}

					]);
}
$(document).ready(function() {
	// a workaround for a flaw in the demo system
	// (http://dev.jqueryui.com/ticket/4375), ignore!
	$("#dialog:ui-dialog").dialog("destroy");

	$("#dialog-confirm").dialog({
		resizable : false,
		height : 600,
		width : 500,
		modal : true,
		autoOpen : false,
	});
});
function search_confirm() {
	if (document.search_form.keyword.value == '') {
		alert('검색어를 입력하세요.');
		document.search_form.keyword.focus();
		return;
	}
	document.search_form.submit();
}