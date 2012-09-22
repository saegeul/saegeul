<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>

<script>
function FileModify(filePath,thumbnailPath,fileName,fileType,author,regDate,address,isvalid,no,tag,file,downCnt,fold_url)
{

	var markup = "<form method='get'>"
			+ "<legend>Image Modify</legend>"
		 	+ "<dl class='thumbnails'>"
				+ "<dd style='margin-left:25px;height:110px;width:150px;float:left;'>"
					+ "<div align='middle' style='margin: 0px auto; height: 100px; width: 120px; -moz-transition: all 0.2s ease-in-out 0s ; border: 1px solid rgb(221, 221, 221); border-radius: 4px 4px 4px 4px; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.055); display: block; padding: 4px; line-height: 100px;'>"
						+ "<img src=" + thumbnailPath + " id=thumb class='img-rounded'>"
					+ "</div>"
				+ "</dd>"
				+ "<dd style='float:right;'>"
					+ "<div>"
						+ "&nbsp;&nbsp;&nbsp;파일 이름 : <INPUT type='text' id='mod_name' name='mod_name' value = " + fileName + ">"
					+ "</div>"
				+ "</dd>"
				+ "<dd style='float:right;'>"
					+ "<div>"
						+ "&nbsp;&nbsp;&nbsp;파일 유형 : <INPUT type='text' id='mod_type' name='mod_type' value = " + fileType + " readonly >"
					+ "</div>"
				+ "</dd>"
				+ "<dd style='float:right;'>"
					+ "<div>"
						+ "&nbsp;&nbsp;&nbsp;올린 사람 : <INPUT type='text' id='mod_author' name='mod_author' value = " + author + " readonly >"
					+ "</div>"
				+ "</dd>"
			+ "</dl>"
			+ "<dl id='tag'>"
				+ "<p>"
					+ "&nbsp;&nbsp;&nbsp;태그 : <input type='text' id='mod_tag' name = 'mod_tag' style='width:150px;' value = '" + tag + "'>"
					+  "&nbsp;&nbsp;<a href='javascript:void(0)' id='add_tag'><i class='icon-tag'></i>태그달기</a>"
				+ "</p>"
			+ "</dl>";
		if(isvalid == "Y"){
			markup += "<dl>"
				+ "<p>"
				+ "&nbsp;&nbsp;&nbsp;접근권한 : <INPUT type='radio' value= 'Y' class='mod_isvalid' name='mod_isvalid' checked> 허용 <INPUT type='radio' value= 'N' class='mod_isvalid' name='mod_isvalid'> 거부"
				+ "</p>"
				+ "</dl>";
		}else {
			markup += "<dl>"
				+ "<p>"
				+ "&nbsp;&nbsp;&nbsp;접근권한 : <INPUT type='radio' value= 'Y' class='mod_isvalid' name='mod_isvalid' > 허용 <INPUT type='radio' value= 'N' class='mod_isvalid' name='mod_isvalid' checked> 거부"
				+ "</p>"
				+ "</dl>";
		}
			markup 
			+= "<dl>"
				+ "<p>"
				   + "&nbsp;&nbsp;&nbsp;DownCount : <INPUT type='text' id='mod_down_cnt' value=" + downCnt + " name='mod_down_cnt' readonly>"
				+ "</p>"
			+ "</dl>"
			+ "<dl>"
				+ "<p>"
			   		+ "&nbsp;&nbsp;&nbsp;RegDate : <INPUT type='text' id='mod_redate' value=" + regDate + " name='mod_reddate' readonly>"
				+ "</p>"
			+ "</dl>"
			+ "<dl>"
				+ "<p>"
		   			+ "&nbsp;&nbsp;&nbsp;IP : <INPUT type='text' id='mod_address' value=" + address + " name='mod_address' readonly>"
				+ "</p>"
			+ "</dl>"
		+"</form>";	

	$("#dialog-confirm").html(markup).dialog('open');

	$("#dialog-confirm").dialog("option","buttons",[
	{
		text: "Download",
       click: function() {
    	   $.ajax({
		       type: "GET",
		       url: "/saegeul/filebox/getDownCnt",
		       contentType: "application/json; charset=utf-8",
		       dataType: "json",
		       data: "file=" + file,
		       error: function() { 
		       	alert("error");
		        },
		       success: function(data){
			       $("input[name=mod_down_cnt]").val(data.down_cnt).change();
		    	   location.href="/saegeul/filebox/fileDownload?file="+file;
				}
			});
		}
    },  
    {
		text: "Modify",
       click: function() {
    	   var mod_name = $('#mod_name').attr('value');
    	   var mod_radio_object = $('.mod_isvalid');
    	   var mod_tag = $('#mod_tag').attr('value');
    	   var mod_isvalid;
    	   for(i=0;i<mod_radio_object.length;i++)
    		   if (mod_radio_object[i].checked)
    			   mod_isvalid = mod_radio_object[i].value;
    	   
			$.ajax({
		       type: "GET",
		       url: "/saegeul/filebox/fileModify",
		       contentType: "application/json; charset=utf-8",
		       dataType: "json",
		       data: "mod_name=" + mod_name + "&mod_isvalid=" + mod_isvalid + "&mod_no=" + no + "&mod_tag=" + mod_tag,
		       error: function() { 
		       	alert("error");
		        },
		       success: function(data){
		    	   location.reload();
				}
			});
        }
    },
    {
		text: "Delete",
       click: function() {
			$.ajax({
		       type: "GET",
		       url: "/saegeul/filebox/delete",
		       contentType: "application/json; charset=utf-8",
		       dataType: "json",
		       data: "file=" + file,
		       error: function() { 
		       	alert("error");
		        },
		       success: function(data){
		    	   location.reload();
				}
			});
        }
    },  
    {
		text: "Cancle",
		click: function() { $(this).dialog("close"); }
    }
    
	                                ] );
}
$(document).ready(function() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		height:600,
		width:500,
		modal: true,
		autoOpen : false,
	});
});
function search_confirm()
{
	if(document.search_form.keyword.value == '')
	{
		alert('검색어를 입력하세요.');
		document.search_form.keyword.focus();
		return;
	}
	document.search_form.submit();
}
</script>
<?php 
// 페이징 만들기
$page_per_block = 5;
$prev_page = $page - 1;
$next_page = $page + 1;
$first_page = ((integer)(($page-1)/$page_per_block) * $page_per_block) + 1;
$last_page = $first_page + $page_per_block - 1;
if ($last_page > $total_page)
	$last_page = $total_page;
$etc = "";
if($key != "" && $keyword != ""){
	$etc = "?key=" . $key . "&keyword=" . $keyword;
}
?>
<div class="span9">
	<form class="form-search" name="search_form"
		action="<?=$act_url?>">
		<div align="right">
			<select name="key" size="1">
				<option value="upload_file_name"
				<? if($key == "upload_file_name") echo "selected"; ?>>파일이름</option>
				<option value="username" <? if($key == "username") echo "selected"; ?>>작성자</option>
				<option value="reg_date"
				<? if($key == "reg_date") echo "selected"; ?>>작성날짜</option>
			</select>
			<div class="input-append">
				<input type="text" name="keyword" class="span2 search-query"
					value="<?=$keyword?>"> <a class="btn"
					href="javascript:search_confirm();"><i class="icon-search"></i> </a>
			</div>
		</div>
		<br>
		<table class="table table-hover">
			<thead>
				<tr>
					<th></th>
					<th colspan="2" style="text-align: center;">Photo</th>
					<th>User</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($result as $row): 
				$no = $row->file_srl;
				$fileName = $row->upload_file_name;
				$fileType = $row->file_type;
				$fileSize = $row->file_size . "(KB)" ;
				$author = $row->username;
				$regDate = $row->reg_date;
				$address = $row->ip_address;
				$isvalid = $row->isvalid;
				$tag = $row->tag;
				$downCnt = $row->down_cnt;
				$source_file_name = $row->source_file_name;
				$img_fold_url = $base_url."filebox/files/img/". date('Ymd', strtotime($row->reg_date));
				$file_fold_url = $base_url."filebox/files/file/". date('Ymd', strtotime($row->reg_date));
				$folder_url = "";
				$filePath = "";
				if(is_file($file_fold_url . "/" . $row->source_file_name)){
					$filePath = $file_fold_url . "/" . $row->source_file_name;
					$folder_url = $file_fold_url;
				}else if(is_file($img_fold_url . "/" . $row->source_file_name)){
					$filePath = $img_fold_url . "/" . $row->source_file_name;
					$folder_url = $img_fold_url;
				}
				$thumbnailPath = $img_fold_url . "/thumbs/" . $row->source_file_name;
				if(($fileType != "image/jpg") && ($fileType != "image/jpeg") && ($fileType != "image/gif") && ($fileType != "image/png"))
					$thumbnailPath = "/saegeul/modules/ucloud/views/assets/img/no_image.png";
				?>
				<tr
					onclick="FileModify('<?=$filePath?>','<?=$thumbnailPath?>','<?=$fileName?>','<?=$fileType?>','<?=$author?>','<?=$regDate?>','<?=$address?>','<?=$isvalid?>','<?=$no?>','<?=$tag?>','<?=$source_file_name?>','<?=$downCnt?>','<?=$folder_url?>')">
					<td><?=$row->file_srl?></td>
					<td>
						<div style="margin-top: 16px;">
							<ul class="thumbnails">
								<li class="span2">
									<div class="thumbnail" align="center">
										<img src="<?= $thumbnailPath?>" class="img-polaroid">
									</div>

								</li>
							</ul>
						</div>
					</td>
					<td>
						<dl style="text-align: left; margin-top: 25px;">
							<dd>
								Upload Name :
								<?=$fileName?>
							</dd>
							<dd>
								Img Type :
								<?=$fileType?>
							</dd>
							<dd>
								Img Size :
								<?=$fileSize?>
							</dd>
						</dl>
					</td>
					<td><div style="margin-top: 45px;">
							<?=$author?>
						</div></td>
					<td><div style="margin-top: 45px;">
							<?=$regDate?>
						</div></td>
				</tr>
				<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="pagination" style="text-align: center;">
							<ul>
								<li><a href="<?=$act_url?>/1<?=$etc?>">&laquo;</a></li>
								<?php 
								if($page>1) {
									?>
								<li><a href="<?=$act_url?>/<?=$prev_page?><?=$etc?>">prev</a></li>
								<?php 
								}else {
									?>
								<li class="active"><a>prev</a></li>
								<?php 
								}
								for ($i=$first_page;$i<=$last_page;$i++):
								if($page == $i) {
									?>
								<li class="active"><a><?=$i?>
								</a></li>
								<?php
								} else {
									?>
								<li><a href="<?=$act_url?>/<?=$i?><?=$etc?>"><?=$i?> </a>
								</li>
								<?php 
								}
								endfor;

								if($page < $total_page) {
									?>
								<li><a href="<?=$act_url?>/<?=$next_page?><?=$etc?>">next</a></li>
								<?php 
								}else {
									?>
								<li class="active"><a>next</a></li>
								<?php 
								}
								?>
								<li><a href="<?=$act_url?>/<?=$total_page?><?=$etc?>">&raquo;</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
	<div id="dialog-confirm"></div>
</div>
