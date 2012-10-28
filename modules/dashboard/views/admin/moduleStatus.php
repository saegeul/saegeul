<div class="_content">
	<div class="moduleDBInfo">
		<h4>모듈별 현황</h4>
		<table class="table table-condensed table-striped">
			<thead>
				<tr>
					<th>설치된 모듈</th>
					<th>설치된 DB테이블</th>
					<th>설치되지 않은 DB테이블</th>
					<th>설치여부</th>
				</tr>
			</thead>
			<?php foreach($module as $key => $value) :?>
			<tr>
				<td><?=$value['module_name']?></td>
				<td style='color:#468847;'><?=$value['module_schema_installed']?></td>
				<td style='color:#B94A48;'><?=$value['module_schema_not_installed']?></td>
				<td><?=$value['module_schema_installed_cnt']?>/<?=$value['module_schema_all_cnt']?></td>
			</tr>
			<?php endforeach ;?>
		</table>
	</div>
</div>
