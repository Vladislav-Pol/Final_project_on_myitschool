<?php

return [
//	['путь страницы', 'название шаблона', 'класс', 'метод', 'заголовок страницы'],
	['/', 'main', '', '', 'Главная сайта'],
	['/rooms/', 'rooms', '', ''],

	//страницы адмиинистративного раздела
	['/admin/explorer/', 'admin/explorer', '\MyProject\classes\Admin', 'explorer'],
	['/admin/explorer/create_edit', 'admin/explorer/create_edit', '\MyProject\classes\Admin', 'createEdit'],
	['/admin/explorer/uploadFile/', 'admin/explorer/uploadFile', '', ''],
//	['/admin/explorer/', 'admin/explorer', '\MyProject\classes\Admin', ''],
//	['/admin/users/', 'admin/users', '', ''],
];
