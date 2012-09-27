<form action="setupEmail" method="post" class="form-horizontal" style="margin-top:30px;">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="input01">Site 이름</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_addr" placeholder="your_email@abc.com">
                <p class="help-block">Site 이름</p>
            </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="input02">Site URL</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_pw" placeholder="put your email password">
                <p class="help-block">Site URL을 입력하세요.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="input03">회원가입 가능 </label>
            <div class="controls">
                <select name="email_protocol">
                    <option value="mail">ON</option>
                    <option value="sendmail">OFF</option>
                </select>
                <p class="help-block">회원가입 가능 여부.</p>
            </div>
        </div> 
    </fieldset>
</form>
