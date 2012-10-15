$(document).ready(function (e) {
	// file modify popup
	$(".file_modify").click(function() {
		var file_srl = $(this).data('id');
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/filebox/getFile",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "file_srl=" + file_srl,
			error : function() {
				alert("error");
			},
			success : function(data) {
				$('#mod_file_srl').attr('value', data.file_srl);
				$('#mod_img').attr('src', data.base_url + data.image_thumb_path);
				$('#mod_name').attr('value',data.original_file_name);
				$('#mod_type').attr('value',data.file_type);
				$('#mod_author').attr('value',data.username);
				if(data.isvalid == 'Y'){
					$('#mod_isvalid_yes').attr('class','btn btn-small active');
					$('#mod_isvalid_no').attr('class','btn btn-small');
				}else{
					$('#mod_isvalid_yes').attr('class','btn btn-small');
					$('#mod_isvalid_no').attr('class','btn btn-small active');
				}
				$('#mod_tag').attr('value',data.tag);
				$('#mod_down_cnt').attr('value',data.down_cnt);
				$('#mod_reg_date').attr('value',data.reg_date);
				$('#mod_address').attr('value',data.ip_address);
				$('#modify_modal').modal('show');
			}
		});
	});
	
	// save file modify data
	$(".save_data").click(function(e) {
		var file_srl = $('#mod_file_srl').attr('value');
		var original_file_name = $('#mod_name').attr('value');
		var isvalid = ($('.active').attr('id')=='mod_isvalid_yes')?'Y':'N';
		var tag = $('#mod_tag').attr('value');
		
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/filebox/modify",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "file_srl=" + file_srl + "&original_file_name=" + original_file_name + "&isvalid=" + isvalid + "&tag=" + tag,
			error : function() {
				alert("error");
			},
			success : function(data) {
				location.reload();
			}
		});
	});
	
	// all file select
	$('#all_file_check').click(function(e) {
		if(this.checked == false) {
			$('.file_check:checked').attr('checked',false);
		} else {
			$('.file_check:not(:checked)').attr('checked',true);
		}
	});
	
	$('.delete_all').click(function(e) {
		$("input[class=file_check]").each(function(){
			if($(this).is(':checked')){
				var file_srl = $(this).closest("td").text();
				$.ajax({
					type : "GET",
					url : "/saegeul/admin/filebox/delete",
					contentType : "application/json; charset=utf-8",
					dataType : "json",
					data : "file_srl=" + file_srl,
					error : function() {
						//alert("error");
					},
					success : function(data) {
						$('.file_check:checked').attr('checked',false);
						location.reload();
					}
				});
			}
		});
	});
	
	$('.btn_delete').click(function(e) {
		var file_srl = $(this).parent().parent().attr('id');
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/filebox/delete",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "file_srl=" + file_srl,
			error : function() {
				alert("error");
			},
			success : function(data) {
				location.reload();
			}
		});
	});
	
	$(".search_btn").click(function() {
		document.search_form.submit();
	});
});