<?php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DOCUMENT_ROOT . '/functions.php'; //spl_autoload_register

$routes = require_once DOCUMENT_ROOT . '/routes.php';
use \MyProject\classes\Rout;
$obRout = new Rout($routes);

$obRout->start($_REQUEST['page'], $_REQUEST);





require_once DOCUMENT_ROOT . '/tmp/ExplorerModel.php';
// из файла classes/ExplorerModel.php
///////////////////////////////////////

require_once DOCUMENT_ROOT . '/tmp/Users0.php';
//из файла Users0.php
////////////////////////////////////////////