<form action="setupEmail" method="post" class="form-horizontal" style="margin-top:30px;">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="input01">Email Addr</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_addr" placeholder="your_email@abc.com">
                <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
            </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="input02">Email Password</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_pw" placeholder="put your email password">
                <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="input03">Mail Protocol</label>
            <div class="controls">
                <select name="email_protocol">
                    <option value="mail">Mail</option>
                    <option value="sendmail">SendMail</option>
                    <option value="smtp">SMTP</option>
                </select>
                <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="input04">SMTP HOST</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_smtp_host">
                <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="input05">SMTP PORT</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_smtp_port">
                <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
            </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="input06">email library path</label>
            <div class="controls">
                <input type="text" class="input-xlarge" name="email_lib_path">
                <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
            </div>
        </div> 
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button class="btn">Cancel</button>
        </div>
    </fieldset>
</form>
