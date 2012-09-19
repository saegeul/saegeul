<h1>DATABASE  </h1>
<form action="setupDatabase" method="post" >
    <label>DB호스트네임</label>
    <input type="text" name="database_host" placeholder="localhost" value="localhost" />

    <label>DATABASE 이름</label>
    <input type="text" name="database_name" placeholder="type to your database"/>

    <label>DB 아이디</label>
    <input type="text" name="database_user"placeholder="아이디를 입력하세요." />

    <label>DB 패스워드</label>
    <input type="password" name="database_password" placeholder="패스워드를 입력하세요."/>
    <?php if(isset($errors)):?> 
    <div class="alert alert-error">
        <?= $errors; ?>
    </div>
    <?php endif;?>
    <p> 
        <a class="btn " href="<?=base_url()?>install/checkEnvironment"><i class="icon-circle-arrow-left "></i> 이전 단계로... </a>
        <button type="submit" class="btn btn-primary"><i class="icon-circle-arrow-right icon-white"></i> 다음 단계로... </button>
    </p>
</form>


