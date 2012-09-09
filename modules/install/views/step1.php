<?php
    $checklist = $checklist ;
    $success = array() ; 
    $is_next = true ;

    foreach($checklist as $key => $check){
        if($check){
            $success[$key] = 'success' ; 
        }else{
            $is_next = false ; 
            $success[$key] = 'error' ; 
        } 
    } 
?>
    <h1>SAEGEUL CONFIGURATION </h1> 
        <p>새글을 설치하려면 아래의 조건들을 확인하세요.  </p>
        <table class="table"> 
            <tbody> 
                <tr class="<?=$success['php_version']?>"> 
                    <td>PHP Version (ver 5.x.x) </td>
                </tr>
                <tr class="<?=$success['permission']?>">
                    <td>파일 퍼미션 </td> 
                </tr>
                <tr class="<?=$success['xml']?>">
                    <td>xml 라이브러리 </td> 
                </tr>
                <tr class="<?=$success['gd']?>">
                    <td>gd 라이브러리 </td> 
                </tr>
            </tbody>

        </table>
        <p> 
            <a class="btn btn-primary" href="<?=base_url().'install/index/step2'?>"><i class="icon-circle-arrow-right icon-white"></i> 다음 단계로...</a>
        </p>
