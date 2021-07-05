
<div class="fileMen content">
	<h2>Пользователи</h2>
	<div class="functions">
		<a href="/admin/" class="button">Домой</a>
<!--		<a href="/admin/users/new_user/" class="button">Создать нового пользователя</a>-->
		<button name="save" form="edit_user">Сохранить</button>
		<button name="delete" form="delete_user">Удалить</button>
	</div>
</div>
<div class="main content users">
	<form id="hidden" method="post" action="/admin/users/delete/"><input name="user_id" type="number" value="<?=$arData['edit_user']['id']?>"></form>
	<form class="edit_user form" id="edit_user" action="/admin/users/edit" method="post">
		<fieldset>
			<legend></legend>
			<input type="text" name="id" value="<?=$arData['edit_user']['id']?>" id="hidden" hidden>
			<label>Логин<input type="text" id="login" name="login" placeholder="Логин" value="<?=$arData['edit_user']['login']?>"></label>
			<label>Email<input id="email" type="email" name="email" placeholder="email" value="<?=$arData['edit_user']['email']?>"></label>
			<label>Имя<input type="text" id="name" name="name" placeholder="Имя" value="<?=$arData['edit_user']['name']?>"></label>
			<label>Группа<input type="text" id="groups_" name="groups_" placeholder="Имя" value="<?=$arData['edit_user']['groups_']?>"></label>
		</fieldset>
	</form>
</div>
<?php
