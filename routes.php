<?php

return [
//	['путь страницы', 'название шаблона', 'класс', 'метод', 'заголовок страницы'],
	['/', 'main', '', '', 'Главная сайта'],
	['/about/', 'about', '', '', 'О нас'],
	['/rooms/', 'rooms', '\MyProject\classes\Rooms', 'getRooms', 'Номера'],
	['/room/', 'rooms/detail', '\MyProject\classes\Rooms', 'getRoomDetail', 'Номер'],
	['/gallery/', 'gallery', '', '', 'Галерея'],
	['/contacts/', 'contacts', '', 'Контакты'],

	//страницы адмиинистративного раздела
	['/admin/explorer/', 'admin/explorer', '\MyProject\classes\Admin', 'explorer'],
	['/admin/explorer/create_edit/', 'admin/explorer/create_edit', '\MyProject\classes\Admin', 'createEdit'],
	['/admin/explorer/uploadFile/', 'admin/explorer/uploadFile', '\MyProject\classes\Admin', 'uploadFile'],
//	['/admin/explorer/', 'admin/explorer', '\MyProject\classes\Admin', ''],
//	['/admin/users/', 'admin/users', '', ''],

	//авторизация
	['/registration/', 'registration', '', ''],
	['/auth/', 'authorization', '', ''],
	//POST
	['/registration/new/', 'registration/new', '\MyProject\classes\User', 'addNewUser'],
	['/auth/login/', 'auth/login', '\MyProject\classes\User', 'auth'],//todo
	['/logout/', '', '\MyProject\classes\User', 'logout'],
];
