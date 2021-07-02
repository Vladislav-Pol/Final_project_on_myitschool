<div class="contacts_head">
	<div class="page_title">
		<h1>Контакты</h1>
	</div>
	<div class="description">Если у вас есть вопросы, пожалуйста, свяжитесь с нами по телефону, электронной почте или заполните контактную форму.  Всегда рады вам!</div>
</div>
<form class="form" id="contact_message" action="#" name="contact_us" method="post">
	<div class="left_half">
		<input class="form_item" id="contact_name" name="name" type="text" placeholder="Имя">
		<input class="form_item" id="contact_email" name="email" type="email" placeholder="Эл. почта">
		<input class="form_item" id="contact_phone" name="telephone" type="tel" placeholder="Телефон">
		<span class="form_item" id="contact_was_send" hidden>Информация отправлена. Спасибо!</span>
	</div><!--
	--><div class="right_half">
		<textarea class="form_item" id="contact_message_text" name="message" placeholder="Добавьте сообщение..."></textarea>
		<button id="btn_send_contact_message" class="form_item button" type="button">Отправить</button>
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
</div>