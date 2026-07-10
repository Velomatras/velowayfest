<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="well">
            <form method="post">
				<input type="hidden" name="formid" value="profile">
                <table id="authPanelTable" width="600px" border="0" cellspacing="2" cellpadding="2">
	<tr>
		<td class="td_auth_width"><label for="wlpeUserProfileFullName">Имя и фамилия:</label></td>
		<td>
		<input id="fullname" type="text" name="fullname" value="{{$attr['fullname']}}" /></td>
	</tr>
	<tr>
		<td class="td_auth_width"><label for="wlpeUserProfileEmail">Адрес электронной почты:</label></td>
		<td>
		<input id="email" type="text" name="email" value="{{$attr['email']}}" />
		[+email.error+]
		</td>
	</tr>
	<tr>
		<td class="td_auth_width"><label for="wlpeUserProfileMobile">Номер мобильного телефона:</label></td>
		<td>
		<input id="phone" type="text" name="phone" value="{{$attr['phone']}}" />
		</td>
					</tr></table>
				
				<div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block text-center" name="start"><i class="glyphicon glyphicon-user"></i> Сохранить</button>
                </div>
            </form>
        </div>
		<div> <a href="[~7~]">удалить профиль</a></div>
    </div>
</div>