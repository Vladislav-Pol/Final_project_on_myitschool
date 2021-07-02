<?php

return [
//	['путь страницы', 'название шаблона', 'класс', 'метод', 'заголовок страницы'],
	['/', 'main', '', '', 'Главная сайта'],
	['/about/', 'about', '', '', 'О нас'],
	['/rooms/', 'rooms', '\MyProject\classes\Rooms', 'getRooms', 'Номера'],
	['/room/', 'rooms/detail', '\MyProject\classes\Rooms', 'getRoomDetail', 'Номер'],
	['/gallery/', 'gallery', '', '', 'Галерея'],
	['/contacts/', 'contacts', '', '', 'Контакты'],

	//страницы адмиинистративного раздела
	['/admin/', 'admin', '', ''],
	['/admin/explorer/', 'admin/explorer', '\MyProject\classes\Admin', 'explorer'],
	['/admin/explorer/create_edit/', 'admin/explorer/create_edit', '\MyProject\classes\Admin', 'createEdit'],
	['/admin/explorer/uploadFile/', 'admin/explorer/uploadFile', '\MyProject\classes\Admin', 'uploadFile'],
	['/admin/explorer/delete/', 'admin/explorer', '\MyProject\classes\Admin', 'delete'],
	['/admin/users/', 'admin/users', '\MyProject\classes\AdminUsers', 'users'],
	['/admin/users/edit_user/', 'admin/users/edit_user', '\MyProject\classes\AdminUsers', 'edit_users'],
	['/admin/users/edit/', '', '\MyProject\classes\AdminUsers', 'edit'],

	//авторизация
	['/registration/', 'registration', '', '', 'Регистрация'],
	['/auth/', 'authorization', '', '', 'Авторизация'],
	//POST
	['/registration/new/', '', '\MyProject\classes\User', 'addNewUser'],
	['/auth/login/', '', '\MyProject\classes\User', 'auth'],
	['/logout/', '', '\MyProject\classes\User', 'logout'],
	['/contacts/new_message/', '', '\MyProject\classes\Mail', 'sendContactMessage'],
];
