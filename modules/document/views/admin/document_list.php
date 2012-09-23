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
/* 
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
*/
?>



<div class="span9">

        <form class="form-search" name="search_form">


                <!-- 검색부분    -->

                <div align="right">
                        <select name="key" size="1" class="span2">
                                <option value="username"
                                <?// if($key == "username") echo "selected"; ?>>회원이름</option>
                                <option value="id" <?// if($key == "id") echo "selected"; ?>>아이디</option>
                                <option value="email" <?// if($key == "email") echo "selected"; ?>>이메일</option>
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
                            <td class="span1" style="text-align: center;"><h4>추천</h4></td>
                            <td class="span1" style="text-align: center;"><h4>조회</h4></td>

                                </tr>
                        </thead>
                        <tbody>
                                <tr>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: center;"></td>
                                </tr>
<?php 
/*

$no=1;
foreach($result as $row)
{
*/
?>

<?php
/*
    if($row->activated == 1){
*/
?>


<?php 
/*
    }
    else{
*/
?>
<?
/*

    }


    if($row->level == 'admin'){
        echo "<td>관리자</td>";
    }
    else {
        echo "<td>사용자</td>";

    }


    if($cur_admin == $row->id)
    {	
*/
?>


<?php
/* 
    }
    else
    {
*/
?>
<?php 
/*
    }
*/
?>



<?php
/*
    $no=$no+1;

}

*/
?>
                        </tbody>

                        <!-- 회원목록   -->


                        <!-- Pagination    -->
                        <tfoot>
                                <tr>
                                        <td colspan="7">
                                                <div class="pagination" style="text-align: center;">
                                                        <ul>
                                                                <li><a href="<?//=$act_url?>/1">First</a></li>
<?php 
/*
if($page>1) {
*/
?>
                                                                <li><a href='<?//=$act_url?>/<?//=$prev_page?>'>&lt</a></li>
<?php 
/*
}
for ($i=$first_page;$i<=$last_page;$i++):
    if($page == $i) {
        $bold_s = "<b>"; $bold_e = "</b>";
    } else {
        $bold_s = ""; $bold_e = "";
    }
*/
?>
                                                                <li><a href="<?//=$act_url?>/<?//=$i?>"><?//=$bold_s?> <?//=$i?> <?//=$bold_e?>
                                                                </a></li>
<?php 
/*
endfor;
if($page < $total_page){
*/
?>
                                                                <li><a href="<?//=$act_url?>/<?//=$next_page?>">&gt</a></li>
<?php 
/*
}
*/
?>
                                                                <li><a href="<?//=$act_url?>/<?//=$total_page?>">Last</a></li>
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
