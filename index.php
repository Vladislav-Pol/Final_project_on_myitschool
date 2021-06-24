<?php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DOCUMENT_ROOT . '/functions.php'; //spl_autoload_register

$routes = require_once DOCUMENT_ROOT . '/routes.php';
use \MyProject\classes\Rout;
$obRout = new Rout($routes);

$obRout->start($_REQUEST['page'], $_REQUEST);


//из файла datd.php
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('BD_PATH', DOCUMENT_ROOT . '/bd/products.json');
define('USERS_PATH', DOCUMENT_ROOT . '/bd/users.json');
define('TIME_ACTUAL_DB', '1200');
$arOptions = [
	CURLOPT_URL => "https://fakestoreapi.com/products",
	CURLOPT_RETURNTRANSFER => true,
];
$arMenu = [
	'/' => 'Главная',
	'/catalog/' => 'Каталог',
	'/cart/' => 'Корзина',
	//'#' => 'Контакты',
];

use \MyProject\classes\DB;
//require_once DOCUMENT_ROOT . '/classes/DB.php';
//require_once 'functions.php';

if (isset($_REQUEST['logout']))
	logout();

$userAuth = checkAuth();
$userGroups = ($_SESSION['user']['groups']) ?? [];

if ($userAuth) {
	if (in_array('admin', $userGroups)) {
		$arMenu['/admin'] = 'Админка';
	}
	$arMenu['./?logout'] = 'Выйти';
} else {
	$arMenu['/auth'] = 'Авторизоваться';
}

if (isset($_COOKIE['cart'])) {
	$cartData = unserialize($_COOKIE['cart']);
}
if (intval($_GET['del']))
	delFromCart($cartData, $_GET['del']);
if (intval($_GET['add']))
	addToCart($cartData, $_GET['add']);
$cartCount = getCartCount($cartData);
$cartCost = getCartCost($cartData);
////////////////////////////////////////

// из файла classes/ExplorerModel.php
class ExplorerModel
{
	//Проверка возможности изменять элемент
	public static function canEdit($element)
	{
		if (is_dir($element) &&
			substr($element, -2) != "..") // Запрет изменения родительского каталога
			return 'dir';

		if (is_file($element) &&
			array_key_exists("." . pathinfo($element, PATHINFO_EXTENSION), FILE_TYPE))
			return 'file';

		return false;
	}

//получение даты создания
	public static function getFileDate($file)
	{
		if (file_exists($file))
			return date("m.d.Y H:i:s", filectime($file));
		return "";
	}

//Получение размера файла
	public static function getFileSize($file): string
	{
		if (is_dir($file))
			return "";
		$size = filesize($file) / 1024; // Размер файла в КБ
		if ($size > 1024 - 1) {
			$size /= 1024; // Размер файла в МБ
			return round($size, 2) . " МБ";
		} else
			return round($size, 2) . " КБ";
	}

// --- Обрезка лишних символов в пути ---
	public static function cleanPath($path = "")
	{
		$preg = '/\/[^\/]*\/\.{2}$|\/\.$|^\/\.\.$/';
		$path = preg_replace($preg, "", $path);
		return $path;
	}

// --- Создание нового каталога ---
	public static function createNewFolder($path, $NewDirName)
	{
		$newPath = $path . $NewDirName;
		if (!file_exists($newPath))
			mkdir($newPath);
	}

// --- Создание нового файла ---
	public static function createNewFile($path, $newFileName, $extension, $newFileContent)
	{
		$newFilePath = $path . $newFileName . $extension;
		if (!file_exists($newFilePath)) {
			$fd = fopen($newFilePath, "w");
			fwrite($fd, $newFileContent);
			fclose($fd);
		}
	}

// --- Переименование каталога ---
	public static function renameFolder($oldElementName, $newElementName)
	{
		if (file_exists($oldElementName) && !file_exists($newElementName))
			rename($oldElementName, $newElementName);
	}

// --- Изменение файла ---
	public static function editFile($fullPath, $oldName, $newName, $fileContent)
	{
		if ($oldName != $newName) {
			rename($fullPath . $oldName, $fullPath . $newName);
		}

		file_put_contents($fullPath . $newName, $fileContent);
	}

// --- Удаление элемента ---
	public static function deleteElement($element)
	{
		if (is_file($element))
			unlink($element);
		elseif (is_dir($element)) {
			if (count(scandir($element)) <= 2)
				rmdir($element);
			else {
				$dd = opendir($element);
				while (($i = readdir($dd)) !== false) {
					if ($i == "." || $i == "..") continue;
					self::deleteElement($element . "/" . $i);
				}
				closedir($dd);
				rmdir($element);
			}
		}
	}

//Сохранение загруженного файла
	function saveUploadFile($fullPath)
	{
		if (!empty($_FILES['uploadFiles']['name'])) {
			$arFiles = $_FILES['uploadFiles'];
			foreach ($arFiles['tmp_name'] as $index => $tmpPath) {
				if (file_exists($tmpPath)) {
					$fileName = $arFiles['name'][$index];
					$fileName = self::getAvailableName($fileName);
					$fullFileName = $fullPath . $fileName;
					while (file_exists($fullFileName)) {
						$posToAdd = mb_strrpos($fullFileName, '.') ?: mb_strlen($fullFileName) - 1;
						$arFullFileName = preg_split('//u', $fullFileName, null, PREG_SPLIT_NO_EMPTY);
						array_splice($arFullFileName, $posToAdd, 0, ["_1"]);
						$fullFileName = implode("", $arFullFileName);
					};
					move_uploaded_file($tmpPath, $fullFileName);
				}
			}
		}
	}

//Редактирование имени файла/папки
	function getAvailableName($name)
	{
		$arr_changes = [
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
			'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
			'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
			'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
			'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
			'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
			'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
			'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
			'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
			'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch',
			'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
			'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
		];
		$preg = '/[^\w\-\.]+/';

		$name = strtr($name, $arr_changes);
		$name = preg_replace($preg, '_', $name);

		return $name;
	}

}
///////////////////////////////////////


if(!in_array('admin', $userGroups)){
	header('Location: /');
}



// из файла adminData.php
//Путь от корня диска до корня сайта
$rootPath = $_SERVER['DOCUMENT_ROOT'];
//Рабочий каталог от корня сайта
$path = $_REQUEST['path'] ?? "";
$fullPath = $rootPath . $path . "/";

//Список возможных типов файлов для создания и редактирования
define('FILE_TYPE', [
	'folder' => 'Папка',
	'.txt' => 'Файл .txt',
	'.html' => 'Файл .html',
	'.css' => 'Файл .css',
	'.js' => 'Файл .js'
]);

//Подготовка данных для редактирования элемента
if (isset($_REQUEST['edit'])) {
	$edit = $_REQUEST['edit'];
	$fullFileName = $fullPath . $edit;
	if (is_file($fullFileName)) {
		$fileType = '.' . pathinfo($edit, PATHINFO_EXTENSION);
		$edit = pathinfo($edit, PATHINFO_FILENAME);
		$fileContent = file_get_contents($fullFileName);
	}
} else
	$edit = false;

//Элемент для создания
$create = isset($_REQUEST['create']) ? true : false;

//Изменение элемента
if (isset($_REQUEST['saveElement'])) {
	if ($_REQUEST['extension'] == 'folder')
		ExplorerModel::renameFolder($fullPath . $_REQUEST['oldName'], $fullPath . $_REQUEST['fileName']);
	else
		ExplorerModel::editFile($fullPath, $_REQUEST['oldName'] . $_REQUEST['oldFileExtension'], $_REQUEST['fileName'] . $_REQUEST['extension'], $_REQUEST['fileContent'] ?? "");
} //Создание элемента
elseif (isset($_REQUEST['saveNewElement'])) {
	if ($_REQUEST['extension'] == 'folder')
		ExplorerModel::createNewFolder($fullPath, $_REQUEST['fileName']);
	else
		ExplorerModel::createNewFile($fullPath, $_REQUEST['fileName'], $_REQUEST['extension'], $_REQUEST['fileContent'] ?? "");
} //Удаление папки или файла
elseif (isset($_REQUEST['del'])) {
	ExplorerModel::deleteElement($fullPath . $_REQUEST['del']);
} //Запись загруженного файла
elseif (isset($_REQUEST['isUpload'])) {
	require_once './functions/upload.php';
	ExplorerModel::saveUploadFile($fullPath);
}

//Получение содержимого каталога
$dirContent = (scandir(realpath($fullPath)));
///////////////////////////////////////////////


//из файла functions.php


function fixUrlInData(&$arData)
{
	if (key_exists('image', $arData))
		$arData['image'] = str_replace("fakestoreapi.com", "fakestoreapi.herokuapp.com", $arData['image'])
			?: "https://via.placeholder.com/200";
	else
		foreach ($arData as &$item)
			$item['image'] = str_replace("fakestoreapi.com", "fakestoreapi.herokuapp.com", $item['image'])
				?: "https://via.placeholder.com/200";
}

function addToCart(&$cartData, $addItem)
{
	if (($product = DB::getInstance()->getLocalCatalogData($addItem)) != false) {
		++$cartData[$addItem];
		setcookie('cart', serialize($cartData), 0, '/');
	}
	header('Location: /catalog');
}

function delFromCart(&$cartData, $delItem)
{
	if ($cartData) {
		unset($cartData[$delItem]);
	}
	setcookie('cart', serialize($cartData), 0, '/');
	header('Location: /cart');
}

function getCartCount($cartData)
{
	$count = 0;
	if (is_array($cartData))
		$count = count($cartData);
	return $count;
}

function getCartCost($cartData)
{
	$sum = 0;
	if (is_array($cartData))
		foreach ($cartData as $id => $count)
			$sum += DB::getInstance()->getLocalCatalogData($id)['price'] * $count; //todo
	return $sum;
}

function getFullCartData($cartData)
{
	if (!is_array($cartData))
		return false;
	$fullCartData = [];
	foreach ($cartData as $id => $count) {
		$cartItem = DB::getInstance()->getLocalCatalogData($id);
		$cartItem['count'] = $count;
		$cartItem['cost'] = $cartItem['price'] * $count;
		$fullCartData[] = $cartItem;
	}
	return $fullCartData;
}

function createXML()
{
	$fileName = $_SERVER['DOCUMENT_ROOT'] . "/bd/products.xml";

	$xd = xmlwriter_open_uri($fileName);
	xmlwriter_set_indent($xd, true);
	xmlwriter_set_indent_string($xd, "    ");
	xmlwriter_start_document($xd, "1.0", "UTF-8");
	xmlwriter_start_element($xd, "products");
	xmlwriter_text($xd, "содержимое тега");
	xmlwriter_end_element($xd);
	xmlwriter_end_document($xd);
}

function addProductToXML()//todo
{
	$fileName = $_SERVER['DOCUMENT_ROOT'] . "/bd/products.xml";
	$xd = xmlwriter_open_uri($fileName);
}

function addLinkDetail(&$arCatalogData)
{
	foreach ($arCatalogData as &$product) {
		$title = trim($product['title']);
		$title = mb_strtolower($title);
		$linkDetail = preg_replace('/\W/', '_', $title) . "_" . $product['id'];
		$product['linkDetail'] = $linkDetail;
	}
}

//function sendOrder()
//{
//    mail("rakuvka@gmail.com", "Загаловок", "Текст письма \n 1-ая строчка \n 2-ая строчка \n 3-ая строчка");
//}

function checkAuth()
{
	if (!$_COOKIE['auth']) {
		return false;
	}
	session_id($_COOKIE['auth']);
	session_start();
	return $_SESSION['user']['auth'];
}

function logout()
{
	session_start();
	unset($_COOKIE['auth'], $_SESSION['user']);
	header('Location: ./');
}
//////////////////////////////////////////////






//из файла Users0.php
class Users0
{
	public $name = '';
//    protected $lastName = '';
	protected $groups = [];
	public $login = '';
	protected $password = '';

	const DEFAULT_USER = 'test';
	const DEFAULT_GROUP = 'guest';

	public function __construct($id)
	{
		$users = self::getUsersData();
		$user = $users[$id];
		if (isset($user)) {
			$this->name = $user['name'];
			$this->groups = $user['groups'];
			$this->login = $user['login'];
			$this->password = $user['password'];
		} else {
			throw new Exception('Пользователь не найден');
		}
	}

	private function getUsersData()
	{
		$usersJson = file_get_contents(USERS_PATH);
		$users = json_decode($usersJson, true);
		return $users;
	}

	public static function getAllUsers($props = ['name', 'login', 'groups'])
	{
		$users = self::getUsersData();

		foreach ($users as $user) {
			foreach ($user as $property => $value) {
				if (in_array($property, $props) && $property != 'password') {
					$arUser[$property] = $value;
				}
			}
			if (!empty($arUser)) {
				$arUsers[] = $arUser;
			}
		}
		return $arUsers;
	}

	public static function create($login = self::DEFAULT_USER, $password = self::DEFAULT_USER, $groups = self::DEFAULT_GROUP)
	{
		$newUser = [];

	}

	protected static function setData($data = [])
	{
		$res = false;
		if (!empty($data)) {
			$arUsers = self::getUsersData();
			$arUsers[] = $data;
			$jsonUsers = json_encode($arUsers);
			$res = file_put_contents(USERS_PATH, $jsonUsers);
		}
		return $res;
	}
}
////////////////////////////////////////////
///
///
///
///



