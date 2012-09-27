<?php $this->load->helper('url') ?>
<?php $this->load->helper('asset') ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>새글</title>
    <?echo common_css_asset('bootstrap/css/bootstrap.css')?>
    <?echo common_css_asset('bootstrap/css/bootstrap-responsive.css')?>
    <?echo common_css_asset('bootstrap/css/docs.css')?>
    <?echo common_css_asset('jquery/css/smoothness/jquery-ui-1.8.22.custom.css')?> <?echo common_js_asset('jquery/js/jquery-1.7.2.min.js')?>
    <?echo common_js_asset('jquery/js/jquery-ui-1.8.22.custom.min.js')?>
    <?echo common_js_asset('bootstrap/js/bootstrap.min.js') ?>
    <?echo common_js_asset('bootstrap/js/bootstrap-responsive.min.js') ?>
</head>
<body> 
<header class="jumbotron subhead">
    <div class="container">
        <h1>SAEGEUL</h1>
        <p class="lead"> Platform for Social Curation </p>
    </div>
</header>

<div class="container">
        <br/>
        <div class="well">
        <h1>Install Complete!!! </h1>
        <ul>
        <?php foreach($result as $key => $row):?>
            <li><strong><?=$key;?></strong>테이블 생성 했습니다.  </li> 
        <?php endforeach;?>
        </ul>
        <hr/>
            <a class="btn btn-primary btn-large" href="<?=base_url()?>member/login"><i class="icon icon-white icon-user"></i> 관리자 로그인 페이지로 이동... </a>
        </div>
    </div>
</div>
</body>
</html>
