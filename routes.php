<?php

return [
//	['путь страницы', 'название шаблона', 'класс', 'метод', 'заголовок страницы'],
	['/', 'main', '', '', 'Главная сайта'],
	['/rooms/', 'rooms', '\MyProject\classes\Test', 'print'],

	//страницы адмиинистративного раздела
	['/admin/explorer/', 'admin/explorer', '', ''],
	['/admin/explorer/uploadFile/', 'admin/explorer/uploadFile', '', ''],
	['/admin/explorer/', 'admin/explorer', '\MyProject\classes\Test', 'print'],
//	['/admin/users/', 'admin/users', '\MyProject\classes\Test', 'print'],
];
