<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $arData['title'] ?? "Best site" ?></title>
	<link rel="stylesheet" href="/resources/css/style.css">
	<link rel="stylesheet" href="/resources/css/media.css">
</head>
<body>
<div class="header content">
	<div class="header-nav">
		<div class="logo">
			<a href="/" title="main"><img class="logo-img" src="/resources/images/logo.png" alt="Company logo"></a>
		</div>
		<input type="checkbox" id="burgerCheck">
		<div class="burger_menu">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<ul class="menu">
			<?php foreach ($arData['top_menu'] as $path => $name):?>
				<li class="menu-item"><a href="<?=$path?>" title="<?=$name?>"><?=$name?></a></li>
			<?php endforeach;?>
		</ul>
		<div class="header_tel">
			<p><a href="tel:+375 (29) 000 00 00">Тел. +375(29) 000 00 00</a></p>
		</div>
	</div>
</div>
<main class="content">