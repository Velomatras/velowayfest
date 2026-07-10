<style>
.formreg {
  display: grid;
  grid-template-columns: 120px 250px auto;
  grid-auto-rows: minmax(40px, auto);
  grid-column-gap: 10px;
  align: center;
}
.form-control {
	width: 250px;
}
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="well">
            <form method="post">
			<div class="formreg">
			                <input type="hidden" name="formid" value="register">
				<div class="form-group[+username.errorClass+][+username.requiredClass+]">
                    <label for="username">* Ник</label></div>
                       <div> <input type="text" class="form-control" id="email" placeholder="Ник" name="username" value="[+username.value+]"></div>
                       <div> [+username.error+]
                </div>
                <div class="form-group[+fullname.errorClass+][+fullname.requiredClass+]">
                    <label for="fullname">* Фамилия Имя</label></div>
                        <div><input type="text" class="form-control" id="fullname" placeholder="Имя" name="fullname" value="[+fullname.value+]"></div>
                       <div> [+fullname.error+]
                </div>
                <div class="form-group[+email.errorClass+][+email.requiredClass+]">
                    <label for="email">* Email</label></div>
                        <div><input type="text" class="form-control" id="email" placeholder="Email" name="email" value="[+email.value+]"></div>
                        <div>[+email.error+]
                </div>
                                   
                        <div class="form-group[+password.errorClass+][+password.requiredClass+]">
                          <label for="password">* Пароль</label></div>
                               <div> <input type="password" class="form-control" id="password" placeholder="Пароль" name="password" value=""></div>
                              <div>  [+password.error+]
                        </div>
                    
                                            <div class="form-group[+repeatPassword.errorClass+][+repeatPassword.requiredClass+]">
                            <label for="repeatPassword">* Повторите пароль</label></div>
                        <div><input type="password" class="form-control" id="repeatPassword" placeholder="Повторите пароль" name="repeatPassword" value=""></div>
                         <div>       [+repeatPassword.error+]
                        </div>
                    
                </div>
				<div class="form-group[+vericode.errorClass+][+vericode.requiredClass+]">
                    <label for="vericode" class="col-sm-2 control-label">* Введите код для проверки</label>
                    <div class="col-sm-10">
                        <div><img src="[+captcha+]" alt="Введите число"></div>
                        <input type="text" class="form-control" id="vericode" name="vericode" value="">
                        [+vericode.error+]
                    </div>
                
                [+form.messages+]
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block text-center"><i class="glyphicon glyphicon-user"></i> Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
</div>