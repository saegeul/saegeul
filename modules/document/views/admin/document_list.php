<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<?php $this->load->helper('form') ?>
<?echo js_asset('document','jquery.documentlist.js')?>



<div class="_content">
     <form class="well well-small form-search" name="search_form">

                <!-- 검색부분    -->
        <div align="right">
	    <select name="search_key" size="1">
                <option value="username"
                <? if($search_key == "username") echo "selected"; ?>>글쓴이</option>
                            <option value="doc_id" <? if($search_key == "doc_id") echo "selected"; ?>>번호</option>
                            <option value="title" <? if($search_key == "title") echo "selected"; ?>>글제목</option>
                        </select>
                        <div class="input-append">
                                <input type="text" name="search_keyword" class="span2 search-query"
					value="<?=$search_keyword?>" class="span2 search-query"> <a
					class="btn search_btn"><i class="icon-search"></i> </a>
                        </div>
                </div>
        </form>
                <!-- 검색부분    -->

                <br>




                <!-- 회원목록 테이블 시작   -->

                <table class="table table-hover">

                        <!-- 회원목록    -->
                        <thead class="row">
                                <tr>

                            <td class="span1" style="text-align: center;"><h4>번호</h4></td>
                            <td class="span4" style="text-align: center;"><h4>제목</h4></td>
                            <td class="span1" style="text-align: center;"><h4>글쓴이</h4></td>
                            <td class="span1" style="text-align: center;"><h4>등록일</h4></td>
                            <td class="span1" style="text-align: center;"><h4>조회수</h4></td>

                                </tr>
                        </thead>
                        <tbody>
<?php foreach($fileList as $key => $file) :?>
                                <tr>
                                        <td style="text-align: center;"><?=$file->doc_id ?></td>
                                        <td style="text-align: center;"><a target="_blank" href="<?=base_url();?>blog/welcome/<?=$file->doc_id;?>"><?=$file->title ?></a></td>
                                        <td style="text-align: center;"><?=$file->username ?></td>
                                        <td style="text-align: center;"><?=$file->reg_date ?></td>
                                        <td style="text-align: center;">0</td>
                                </tr>
<?php endforeach ;?>
                        </tbody>

                        <tfoot>
                                <tr>
                                        <td colspan="7">

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


                                       </td>
                                </tr>
                        </tfoot>
                        <!-- Pagination    -->

                </table>
                <!-- 회원목록 테이블 끝    -->



                <!-- 로그아웃 버튼   
                                                <div align="right">
                                                        <a class="btn btn-primary btn-large"
                                                                href="<?//=site_url("/member/logout")?>">로그아웃 </a>
                                                </div>
                                                -- 로그아웃 버튼    -->





        </form>

</div>
