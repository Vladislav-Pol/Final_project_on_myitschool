<?php
//if(!isset($_REQUEST['path']))
//	header('Location: ./');
//?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/resources/css/style_admin.css">
<!--	<link rel="stylesheet" href="/resources/css/media_admin.css">-->
	<title><?= isset($_GET["id"]) ? $arPages[$_GET["id"]]["name"] : "Treehouse" ?></title>
</head>
<body>
<div class="header content">
	<div class="logo"><a href="/">Мой сайт</a></div>
	<ul class="nav">
		<li><a href="/admin/explorer">Файловая стуктура сайта</a></li>
		<li><a href="/admin/users">Пользователи</a></li>
	</ul>
	<a href="./?logout" class="transform">Выйти</a>
</div>