<div class="_contents">
	<ul class="sg_document_list">
		<?php foreach($document_list as $key => $document):?>
		<li>
            <div class="item">
                <div class="item_date">
                    <span class="date"><?php echo date("F d Y",strtotime($document->reg_date));?></span>
                </div>
                <div class="item_content">
		            <h6 class="title">
						<a href="<?=base_url()?>blog/read/<?=$document->doc_id?>"><?php echo $document->title; ?> </a>
					</h6>
                    <p class="description">
				        <a href="<?=base_url()?>blog/read/<?=$document->doc_id?>"><?php echo $document->description; ?> </a>
			        </p>
                </div>
            </div> 
		</li>
		<?php endforeach;?>
	</ul>
	<div class="pagination pagination-centered">
	<?php
	if($pagination['page_count'] >= 5){
		$first_page = $pagination['page'] > 3 ? $pagination['page'] - 2 : 1;
		$last_page = $pagination['page'] > 3 ? $pagination['page'] + 2 : 5;
		if($last_page > $pagination['page_count']){
			$last_page = $pagination['page_count'];
			if(($last_page % 5) != 0){
				$temp = 5 - ($last_page % 5);
				$first_page = $last_page - ($temp + 1);
			}else{
				$first_page = $last_page - 4;
			}
		}
	}else{
		$first_page = 1;
		$last_page = $pagination['page_count'];
	}
	?>
	<ul>
		<?php for($i=$first_page ; $i <$pagination['page'];$i++):?>
		<li><a
			href="<?=base_url()?>blog/page/<?=$i?>"><?=$i?>
		</a></li>
		<?php endfor;?>
		<li class="active"><a href="javascript:void(0)"><?=$pagination['page'];?>
		</a></li>
		<?php for($i=$pagination['page']+1 ; $i <= $last_page;$i++):?>
		<li><a
			href="<?=base_url()?>blog/page/<?=$i?>"><?=$i?>
		</a></li>
		<?php endfor;?>
	</ul>
</div>
</div>
