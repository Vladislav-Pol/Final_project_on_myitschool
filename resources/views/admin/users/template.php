
<div class="fileMen content">
	<h2>Пользователи</h2>
	<div class="functions">
		<a href="/admin/" class="button">Домой</a>
<!--		<a href="/admin/users/new_user/" class="button">Создать нового пользователя</a>-->
	</div>
</div>
<div class="main content users">
	<?php foreach($arData['users'] as $user):?>
		<div class="user_item">
			<a href="/admin/users/edit_user/<?=$user['login']?>"><h3><?=$user['name']?></h3></a>
			<p>ID пользователя: <?=$user['id']?></p>
			<p>Логин пользователя: <?=$user['login']?></p>
			<p>Email пользователя: <?=$user['email']?></p>
			<p>Группа пользователя: <?=$user['groups_']?></p>
		</div>
	<?php endforeach;?>
<!--	<pre>-->
<!--		--><?php //print_r($arData)?>
<!--	</pre>-->


</div>
<?php
