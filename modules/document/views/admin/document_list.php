<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<?php $this->load->helper('form') ?>


<script>
function search_confirm()
{
	if(document.search_form.keyword.value == '')
	{
		alert('검색어를 입력하세요.');
		document.serch_form.keyword.focus();
                return;
        }

        document.search_form.submit();
}

function really_ban(ban_id){
    conf = confirm("정말 탈퇴 시키겠습니까??");
    if(conf){

        location.href=" <?=site_url("/member/admin/member/good_bye?")?>id="+ban_id;
    }

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



<div class="_content">
    <form class="form-search" name="search_form">

                <!-- 검색부분    -->
        <div align="right">
            <select name="key" size="1" class="span2">
                <option value="username"
                    <? if($key == "username") echo "selected"; ?>>글쓴이</option>
                            <option value="doc_id" <? if($key == "doc_id") echo "selected"; ?>>번호</option>
                            <option value="title" <? if($key == "title") echo "selected"; ?>>글제목</option>
                        </select>
                        <div class="input-append">
                                <input type="text" name="keyword" class="span2 search-query"
                                        value="<?//=$keyword?>">
                                <button class="btn" onclick="search_confirm();">
                                        <i class="icon-search"></i>
                                </button>
                        </div>
                </div>

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
<? foreach($result as $row)
{  ?>
                                <tr>
                                        <td style="text-align: center;"><?=$row->doc_id ?></td>
                                        <td style="text-align: center;"><a target="_blank" href="<?=base_url();?>blog/welcome/<?=$row->doc_id;?>"><?=$row->title ?></a></td>
                                        <td style="text-align: center;"><?=$row->username ?></td>
                                        <td style="text-align: center;"><?=$row->reg_date ?></td>
                                        <td style="text-align: center;">0</td>
                                </tr>
<? } ?>
                        </tbody>

                        <tfoot>
                                <tr>
                                        <td colspan="7">

                <div class="pagination" style="text-align:center;">
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
