$(document).ready(function() {
	
	$('.menu').each(function() {
		var parent_site_srl = $(this).attr('id');
		var markup="";
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/sitemap/getChildMenu",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "parent_site_srl=" + parent_site_srl,
			error : function() {
				alert("error");
			},
			success : function(data) {
				$.each(data.list, function(key,state){
	    			obj = state;
	    			markup += "<li class='childMenu' id='" + obj.site_srl + "'><i class='icon-move'></i>" 
							+ "<span class='menuInfo'>" + obj.site_name + "</span>"
							+ "<span class='side'> "
								+ "<a class='btn btn-link btnEditSite' style='color: #333333;'><i class='icon-pencil'></i>Edit</a>"
								+ "<a class='btn btn-link btnDeleteSite' style='color: #333333;'><i class='icon-trash'></i>Delete</a>"
							+ "</span>"
						+ "</li>";
	    		});
				$(markup).insertAfter("#"+parent_site_srl);
			}
		});
	});
	
	$(function() {
		$('#siteMap').sortable({
			change: function(event, ui) {
				//alert($(this).attr('class'));
	        },
			update: function(event, ui) {
				//alert("a");
			}
		});
		$( "#siteMap" ).disableSelection();
	});
	
	$('.btnCreateMenu').click(function() {
		$('#inputMenuName').val('');
		$('#inputLinkURL').val('');
		$(":input:radio[name=module]:checked").attr('checked',false);
		$('#radioIsValidOk').attr('checked','checked');
		$('#radioCreateModule').attr('disabled',false);
		$('.createModule').hide();
		$('.createModuleId').hide();
		$('.linkModule').hide();
		$('.linkURL').hide();
		$('.isValid').hide();
		$('.saveData').show();
		$('.modifyData').hide();
		$('.appendData').hide();
		$('#menuModal').modal('show');
	});

	$("input:radio[name=module]").click(function() {
		var radio_val = $(":input:radio[name=module]:checked").val();
		if(radio_val == 1){
			$('.createModule').show();
			$('.createModuleId').show();
			$('.linkModule').hide();
			$('.linkURL').hide();
			$('.isValid').show();
		}else if(radio_val == 2){
			$('.createModule').show();
			$('.createModuleId').hide();
			$('.linkModule').show();
			$('.linkURL').hide();
			$('.isValid').show();
		}else{
			$('.createModule').hide();
			$('.createModuleId').hide();
			$('.linkModule').hide();
			$('.linkURL').show();
			$('.isValid').show();
		}
	});
	
	$('.saveData').click(function() {
		var moduleId;
		var moduleValue;
		var menuName = $('#inputMenuName').val();
		var moduleOrLinUrl = $(':input:radio[name=module]:checked').val();
		var menuIsValid = $(':input:radio[name=isvalid]:checked').val();
		if(moduleOrLinUrl == 1){
			moduleValue = $('#creatModuleValue').val();
			moduleId = $('#inputModuleId').val();
		}else if(moduleOrLinUrl == 2){
			
		}else if(moduleOrLinUrl == 3){
			moduleValue = $('#inputLinkURL').val();
		}
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/sitemap/saveMenu",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "menuName=" + menuName + "&moduleOrLinUrl=" + moduleOrLinUrl + "&moduleValue=" + moduleValue + "&moduleId=" + moduleId + "&menuIsValid=" + menuIsValid,
			error : function() {
				alert("error");
			},
			success : function(data) {
				$('#inputMenuName').val('');
				$('#creatModuleValue').val('');
				$('#inputModuleId').val('');
				$('#inputLinkURL').val('');
				$(':input:radio[name=module]:checked').attr('checked',false);
				location.reload();
			}
		});
	});

	$('.modifyData').click(function() {
		var moduleId;
		var moduleValue;
		var menuName = $('#inputMenuName').val();
		var moduleOrLinUrl = $(':input:radio[name=module]:checked').val();
		var menuIsValid = $(':input:radio[name=isvalid]:checked').val();
		if(moduleOrLinUrl == 1){
			moduleValue = $('#creatModuleValue').val();
			moduleId = $('#inputModuleId').val();
		}else if(moduleOrLinUrl == 2){
			
		}else if(moduleOrLinUrl == 3){
			moduleValue = $('#inputLinkURL').val();
		}
	});
	
	$('.btnAppendSite').click(function() {
		var site_srl = $(this).parent().parent().attr('id');
		$('#inputParentSrl').val(site_srl);
		$('#inputMenuName').val('');
		$('#inputLinkURL').val('');
		$(":input:radio[name=module]:checked").attr('checked',false);
		$('#radioIsValidOk').attr('checked','checked');
		$('#radioCreateModule').attr('disabled',false);
		$('.createModule').hide();
		$('.createModuleId').hide();
		$('.linkModule').hide();
		$('.linkURL').hide();
		$('.isValid').hide();
		$('.saveData').hide();
		$('.modifyData').hide();
		$('.appendData').show();
		$('#menuModal').modal('show');
	});
	
	$('.appendData').click(function() {
		var site_srl = $('#inputParentSrl').val();
		var moduleId;
		var moduleValue;
		var menuName = $('#inputMenuName').val();
		var moduleOrLinUrl = $(':input:radio[name=module]:checked').val();
		var menuIsValid = $(':input:radio[name=isvalid]:checked').val();
		if(moduleOrLinUrl == 1){
			moduleValue = $('#creatModuleValue').val();
			moduleId = $('#inputModuleId').val();
		}else if(moduleOrLinUrl == 2){
			
		}else if(moduleOrLinUrl == 3){
			moduleValue = $('#inputLinkURL').val();
		}
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/sitemap/saveMenu",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "menuName=" + menuName + "&moduleOrLinUrl=" + moduleOrLinUrl + "&moduleValue=" + moduleValue + "&moduleId=" + moduleId + "&menuIsValid=" + menuIsValid + "&site_srl=" + site_srl,
			error : function() {
				alert("error");
			},
			success : function(data) {
				location.reload();
			}
		});
	});
	
	$('.btnEditSite').live('click',function() {
		var site_srl = $(this).parent().parent().attr('id');
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/sitemap/getMenu",
			contentType : "application/json; charset=utf-8",
			dataType : "json",
			data : "site_srl=" + site_srl,
			error : function() {
				alert("error");
			},
			success : function(data) {
				$('#radioCreateModule').attr('disabled',true);
				if(data.site_module == "link")
				{
					$('#inputMenuName').val(data.site_name);
					$('#inputLinkURL').val(data.site_url);
					$('#radioLinkURL').attr('checked','checked');
					if(data.is_valid == "Y")
						$('#radioIsValidOk').attr('checked','checked');
					else
						$('#radioIsValidNo').attr('checked','checked');
					$('.createModule').hide();
					$('.createModuleId').hide();
					$('.linkModule').hide();
					$('.linkURL').show();
					$('.isValid').show();
					$('.modifyData').show();
					$('.saveData').hide();
					$('.appendData').hide();
					$('#menuModal').modal('show');
				}else{
					$('#inputMenuName').val(data.site_name);
					$('#inputLinkURL').val('');
					$('#radioLinkModule').attr('checked','checked');
					if(data.is_valid == "Y")
						$('#radioIsValidOk').attr('checked','checked');
					else
						$('#radioIsValidNo').attr('checked','checked');
					$('.createModule').show();
					$('.createModuleId').hide();
					$('.linkModule').show();
					$('.linkURL').hide();
					$('.isValid').show();
					$('.modifyData').show();
					$('.saveData').hide();
					$('.appendData').hide();
					$('#menuModal').modal('show');
				}
			}
		});
	});
	
	$('.btnDeleteSite').live('click',function() {
		var site_srl = $(this).parent().parent().attr('id');
		$.ajax({
			type : "GET",
			url : "/saegeul/admin/sitemap/deleteMenu",
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
