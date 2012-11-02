<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<?php $this->load->helper('form') ?>
<?echo js_asset('document','jquery.documentlist.js')?>



<div class="_content">
    <form class="well well-small form-search" name="search_form">
                <!-- 검색부분    -->
        <div align="right">
	        <select name="search_key" size="1">
                <option value="username" <? if($search_key == "username") echo "selected"; ?>>글쓴이</option>
                <option value="doc_id" <? if($search_key == "doc_id") echo "selected"; ?>>번호</option>
                <option value="title" <? if($search_key == "title") echo "selected"; ?>>글제목</option>
            </select>
            <div class="input-append">
                <input type="text" name="search_keyword" class="span2 search-query" value="<?=$search_keyword?>" class="span2 search-query"> 
                <a class="btn search_btn"><i class="icon-search"></i> </a>
            </div>
        </div>
    </form> <!-- 검색부분    -->
    <br>
    
    <table class="table table-hover table-stripped"> 
        <thead class="row">
            <tr>
                <th class="span1" >번호</th>
                <th class="span4" >제목</th>
                <th class="span1" >글쓴이</th>
                <th class="span1" >등록일</th>
                <th class="span1" >조회수</th>
                <th class="span1" ></th>
                <th class="span1" ></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($document_list as $key => $doc) :?>
            <tr>
                <td style="text-align:center;"><?=$doc->doc_id ?></td>
                <td><a target="_blank" href="<?=base_url();?>blog/read/<?=$doc->doc_id;?>"><?=$doc->title ?></a></td>
                <td><?=$doc->username ?></td>
                <td><?=$doc->reg_date ?></td>
                <td style="text-algin:right;">0</td>
                <td><a class="btn btn-info btn-small" href="<?=base_url()?>admin/document/correctform/<?=$doc->doc_id?>" value="<?=$doc->doc_id?>" >수정</button> </td>
                <td><button class="btn btn-warning btn-small trash_btn" value="<?=$doc->doc_id?>">휴지통</button> </td> 
            </tr>
        <?php endforeach ;?>
        </tbody> 
    </table>
               
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
				href="<?=base_url()?>document/admin/document/document_list/<?=$i?>/?search_key=<?=$search_key?>&search_keyword=<?=$search_keyword?>"><?=$i?>
			</a></li>
			<?php endfor;?>
			<li class="active"><a href="javascript:void(0)"><?=$pagination['page'];?>
			</a></li>
			<?php for($i=$pagination['page']+1 ; $i <= $last_page;$i++):?>
			<li><a
				href="<?=base_url()?>document/admin/document/document_list/<?=$i?>/?search_key=<?=$search_key?>&search_keyword=<?=$search_keyword?>"><?=$i?>
			</a></li>
			<?php endfor;?>
		</ul>
	</div>
</div>


<!-- Modal -->
<div class="modal hide fade" id="recycleModal" style="top:400px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" >×</button>
    <h3 id="myModalLabel">알림</h3>
  </div>
  <div class="modal-body">
    <p> 휴지통으로 이동하시겠습니까?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal">Close</button>
    <button id="recycle" class="btn btn-primary"> Ok </button>
  </div>
</div>

