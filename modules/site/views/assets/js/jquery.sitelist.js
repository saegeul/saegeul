$(document).ready(function() {
	$('.create_map').click(function() {
		$('#create_site_modal').modal('show');
	});

	$("input:radio[name=module]").click(function() {
		var radio_val = $(":input:radio[name=module]:checked").val();
		if(radio_val == 1){
			$('.createModule').show();
			$('.createModuleId').show();
			$('.linkModule').hide();
			$('.linkURL').hide();
		}else if(radio_val == 2){
			$('.createModule').show();
			$('.createModuleId').hide();
			$('.linkModule').show();
			$('.linkURL').hide();
		}else{
			$('.createModule').hide();
			$('.createModuleId').hide();
			$('.linkModule').hide();
			$('.linkURL').show();
		}
	});
	
	$('.save_data').click(function() {
		var module_id;
		var module_val;
		var menu_name = $('#inputMenuName').val();
		var module_sel = $(':input:radio[name=module]:checked').val();
		if(module_sel == 1){
			module_val = $('#creatModuleValue').val();
			module_id = $('#inputModuleId').val();
		}else if(module_sel == 2){
			module_val = $('#moduleLink').val();
		}else if(module_sel == 3){
			module_val = $('#inputLinkURL').val();
		}
		
		$.ajax({
			type : "GET",
			url : "/saegeul/site/admin/site/saveMenu",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "menu_name=" + menu_name + "&module_sel=" + module_sel + "&module_val=" + module_val + "&module_id=" + module_id,
			error : function() {
				alert("error");
			},
			success : function(data) {
				$('#inputMenuName').val('');
				$('#creatModuleValue').val('');
				$('#inputModuleId').val('');
				$('#moduleLink').val('');
				$('#inputLinkURL').val('');
				$(':input:radio[name=module]:checked').attr('checked',false);
				location.reload();
			}
		});
	});
	
	$('.btn_append').click(function() {
		alert("aa");
	});
	
	$('.btn_edit').click(function() {
		alert("bb");
	});
	
	$('.btn_delete').click(function() {
		var site_srl = $(this).parent().parent().parent().attr('id');
		$.ajax({
			type : "GET",
			url : "/saegeul/site/admin/site/deleteMenu",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "site_srl=" + site_srl,
			error : function() {
				alert("error");
			},
			success : function(data) {
				location.reload();
			}
		});
	});
});
