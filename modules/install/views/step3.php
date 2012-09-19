<h1>관리자 설정  </h1>
<form action="setupAdmin" method="post" >
    <label>관리자 email</label>
    <input type="text" name="email" placeholder="type to your email. ex)saegeul@gmail.com" />

    <label>관리자 패스워드</label>
    <input type="password" name="password" placeholder="영문/숫자 혼용" />

    <label>패스워드 확인</label>
    <input type="password" name="confirm_password" />

    <label>관리자 ID</label>
    <input type="text" name="username"  placeholder="관리자 아이디를 입력하세요." />

    <?php if(isset($errors)):?> 
    <div class="alert alert-error">
        <?= $errors; ?>
    </div>
    <?php endif;?>
    <div> 

        <a class="btn " href="<?=base_url()?>install/checkDatabase"><i class="icon-circle-arrow-left "></i> 이전 단계로... </a>
        <button class="btn btn-primary"><i class="icon-ok icon-white"></i> OK...</button>
    </div>
</form>
