<div class="_content">
	<div class="moduleDBInfo">
		<h4>모듈별 현황</h4>
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>설치된 모듈</th>
					<th>필요 DB테이블</th>
					<th>설치여부</th>
				</tr>
			</thead>
			<?php foreach($module as $key => $value) :?>
			<tr>
				<td><?=$value['module_name']?></td>
				<td><?=$value['module_schema']?></td>
				<td><?=$value['module_schema_is_exists']?>/<?=$value['module_schema_cnt']?></td>
			</tr>
			<?php endforeach ;?>
		</table>
	</div>
</div>
