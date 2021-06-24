<?php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DOCUMENT_ROOT . '/functions.php'; //spl_autoload_register

$routes = require_once DOCUMENT_ROOT . '/routes.php';
use \MyProject\classes\Rout;
$obRout = new Rout($routes);
$obRout->start($_REQUEST['page'], $_REQUEST);

//
//require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/views/header.php';
//?>
<!--<div class="welcome">-->
<!--	<img class="welcome-image" src="/resources/images/main.jpg" alt="Усадьба" title="Усадьба">-->
<!--	<div class="advertising">-->
<!--		<h2 class="description-title content">Уютная агроусадьба в живописном месте</h2>-->
<!--		<div class="button-book content"><a href="/">Смотреть номера</a></div>-->
<!--	</div>-->
<!--</div>-->
<?php
//echo '<div>This is first page our hotel`s site.</div>';
//
//
//require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/views/footer.php';
//
