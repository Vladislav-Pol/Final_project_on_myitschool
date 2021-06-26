<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $arData['title'] ?? "Best site" ?></title>
	<link rel="stylesheet" href="/resources/css/style.css">
</head>
<body>

<div class="header content">
	<a name="top"></a>
	<div class="header-nav">
		<div class="logo">
			<a href="#top" title="top"><img class="logo-img" src="/resources/images/logo.png" alt="Company logo"></a>
		</div>
		<ul class="menu">
			<?php $arMenu = include (DOCUMENT_ROOT . '/resources/includes/top_menu.php')?>
			<?php foreach ($arMenu as $path => $name):?>
				<li class="menu-item"><a href="<?=$path?>" title="<?=$name?>"><?=$name?></a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<main class="content">