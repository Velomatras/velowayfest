<style>
.form-grouphas-error { /* выбираем элементы с классом test и элемент с идентификатором test */
color: red; /* задаем цвет текста */ 
}
/* формируем фон для модального окна */
.modal {
  display: none; /* скрыт по умолчанию */
  /* темный фон при открытии модалки должен быть на всю страницу */
  position: fixed; 
  z-index: 1; /* поверх всех элементов */
  left: 0;
  top: 0;
  width: 100vw; /* полная ширина */
  height: 100vh; /* полная высота */
  background-color: rgba(0,0,0,0.4); /* цвет фона - прозрачный черный */
}

/* само модальное окно с контентом */
.modal-content {
  background-color: #fff;
  /* окно будет находится по центру по горизонтали и с отступом сверху в 100 px */
  margin: 100px auto; 
  padding: 20px;
  width: 50%; 
  font-size: 20px;
  /* разнесем текст и кнопоку по краям окна */
  display: flex;
  justify-content: space-between;
 }

span {
  cursor: pointer;
}
</style> 
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="well">
            <form method="post">
				<input type="hidden" name="formid" value="profile" id="profile">
				
                <table id="authPanelTable" width="600px" border="0" cellspacing="2" cellpadding="2">
					<tr>
		<td class="td_auth_width"><label for="wlpeUserProfileFullName">Имя и фамилия:</label>
                {{$attr['photo'] ?? '/assets/images/noimage.png'}}
                </td>
		<td>
		<input id="fullname" type="text" name="fullname" value="[+fullname.value+]" /></td>
	</tr>
	<tr>
		<td class="td_auth_width"><label for="wlpeUserProfileEmail">Адрес электронной почты:</label></td>
		<td>
		<input id="email" type="text" name="email" value="[+email.value+]" onchange="openModal();"/>
		
		<div class="modal">
    <div class="modal-content">
      <p>Внимание! При изминении e-mail потребуется активация с нового адреса.</p>
      <span onclick="closeModal();">&times</span>
    </div>
  </div>
		<script>
		
const modal = document.getElementsByClassName("modal")[0];
const openModal = () => {
  modal.stylе.displаy = "block";
}
const closeModal = () => {
  modal.stylе.displаy = "none";
}
					
		</script>
		</td>
	</tr>
        <tr><td><a href="{{$site . "/" . $modx->runSnippet('phpthumb', array('input' => $attr['photo'] ?? '/assets/images/noimage.jpg', 'options' => 'q=95, w=200')) }}" >
                    <img src="{{$site . "/" . $modx->runSnippet('phpthumb', array('input' => $attr['photo'] , 'options' => 'q=95, w=200', 'noImage' => '/assets/images/noimage.jpg', 'fltr' => array('bord' => '5|10|10|#ff00ff'))) }}" /></a></td></tr>
	<tr>
		<td class="td_auth_width"><label for="wlpeUserProfileMobile">Номер мобильного телефона:</label></td>
		<td>
		<div class="form-group[+phone.errorClass+][+phone.requiredClass+]">
		<input id="phone" type="text" name="phone" value="[+phone.value+]" />
		[+phone.error+]
				</div></td></tr>
				</table>
				
				<div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block text-center" name="start"><i class="glyphicon glyphicon-user"></i> Сохранить</button>
                </div>
            </form>
        </div><br><br>
		<div> <a href="{{$_SERVER['REQUEST_SCHEME']}}://{{$_SERVER['SERVER_NAME']}}/lk/delete.html">удалить профиль</a></div>
    </div>
</div>