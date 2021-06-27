<div class="contacts_head">
	<div class="page_title">
		<h1>Контакты</h1>
	</div>
	<div class="description">Если у вас есть вопросы, пожалуйста, свяжитесь с нами по телефону, электронной почте или заполните контактную форму.  Всегда рады вам!</div>
</div>
<form class="form" action="./" name="contact_us" method="post">
	<div class="left_half">
		<input class="form_item" name="name" type="text" placeholder="Имя">
		<input class="form_item" name="email" type="email" placeholder="Эл. почта">
		<input class="form_item" name="telephone" type="tel" placeholder="Телефон">
		<span class="form_item" hidden>Информация отправлена. Спасибо!</span>
	</div><!--
	--><div class="right_half">
		<textarea class="form_item" name="message" placeholder="Добавьте сообщение..."></textarea>
		<button class="form_item button" type="submit">Отправить</button>
	</div>
</form>
<div class="contact_info">
	<div class="left_half map">
		<h2>Мы на карте</h2>
		<div class="address_map"><?php include DOCUMENT_ROOT . "/resources/includes/address_map.html"?></div>
	</div><!--
	--><div class="right_half address">
		<h2>Адрес</h2>
		<div class="address_text"><?php include DOCUMENT_ROOT . "/resources/includes/address.html"?></div>
	</div>
</div><!--todo сделать обработку формы обратной связи-->