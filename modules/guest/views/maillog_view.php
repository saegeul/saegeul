<?php $this->load->helper('asset') ?>
<html>
<head>
<title>Mail Log</title>
<meta http-equiv="content-type" content="text/html" charset="utf-8" />

<?echo common_css_asset('bootstrap/css/bootstrap.min.css')?>
<?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>

</head>
<script language="javascript">
function goPage(v_curr_page)
{
    var frm = document.pageForm;
    frm.hdn_curr_page.value = v_curr_page;
    frm.submit();
}
</script>
<body>
<form>
	<table class="table table-striped">
		<thead>
        	<tr>
            	<th></th>
                <th>보낸 사람</th>
                <th>제 목</th>
                <th>날 짜</th>
            </tr>
        </thead>
        <tbody>
     <?php 
     	if($result)
     	{ 
     		foreach($result as $row):?>
        	<tr>
        		<td><?echo $row->id;?></td>
        		<td><?echo $row->usermail;?></td>
        		<td><?echo $row->title;?></td>
        		<td><?echo $row->reg_date;?></td>
        	</tr>
     <?php endforeach;
     	}?>
        </tbody>
	</table>

	<div >
		<p align = "center"> <?=$page_links?></p>
	</div>

</form>
</body>
</html>