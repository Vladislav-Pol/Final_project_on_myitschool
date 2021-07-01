<div class="registration">
	<h1>Регистрация</h1>
	<form class="registration form" id="registration" action="/registration/new" method="post" >
		<fieldset>
			<legend></legend>
			<label>Введите логин<input type="text" id="login" name="login" placeholder="Логин" value="User01"></label>
			<label>Введите пароль<input type="password" id="password" name="password" placeholder="Пароль"
										value="!Q2w3e"></label>
			<label>Подтвердите пароль<input type="password" id="confirm_password" name="confirm_password"
											placeholder="Пароль" value="!Q2w3e"></label>
			<label>Введите email<input id="email" type="email" name="email" placeholder="email" value="mail@mail.mail"></label>
			<label>Введите имя<input type="text" id="name" name="name" placeholder="Имя" value="Пользователь"></label>
			<input type="button" id="btn_registration" name="registration" value="Зарегистрироваться">
		</fieldset>
	</form>
	<a href="/auth/">Войти</a>
</div>