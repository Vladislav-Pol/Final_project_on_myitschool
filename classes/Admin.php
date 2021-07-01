<?php


namespace MyProject\classes;

use \MyProject\classes\User;
use \MyProject\classes\Explorer;


class Admin
{
	const FILE_TYPES = [
		'folder' => 'Папка',
		'.txt' => 'Файл .txt',
		'.html' => 'Файл .html',
		'.css' => 'Файл .css',
		'.js' => 'Файл .js',
		'.php' => 'Файл .php',
	];
	public array $arData = [];

	public function explorer()
	{
		$path = $this->arData['path'];
		$fullPath = $this->arData['fullPath'];

		$dirContent = (scandir(realpath($fullPath)));
		$content = [];
		foreach($dirContent as $key => $item){
			if($item == '.')continue;

			$content[$key]['name'] = $item;
			$content[$key]['canEdit'] = (Explorer::canEdit($fullPath . $item, self::FILE_TYPES)) ? true : false;

			$elementPath = $fullPath . $item;
			if(is_dir($elementPath)){
				$content[$key]['elementType'] = 'dir';
				$content[$key]['elementPath'] = Explorer::cleanPath($path . "/" . $item);
			}elseif(is_file($elementPath)){
				$content[$key]['elementType'] = 'file';
				$content[$key]['elementSize'] = Explorer::getFileSize($fullPath . $item);
				$content[$key]['elementDate'] = Explorer::getFileDate($fullPath . $item);
			}
			$content[$key]['elementType'] = is_dir($fullPath . $item) ? 'dir' : 'file';
		}

		$this->arData['dirContent'] = $content;

		return $this->arData;
	}

	public function createEdit($arParams)
	{
		$fullPath = $this->arData['fullPath'];

		if(!isset($arParams['path'])) {
			header('Location: /admin/explorer/');
			die();
		}

		$heading = 'Создание нового элемента';
		$edit = '';
		$fileType = '';
		$fileContent = '';
		//Подготовка данных для редактирования элемента
		if (isset($arParams['edit'])) {
			$edit = $arParams['edit'];
			$fullFileName = $this->arData['fullPath'] . $edit;
			if (is_file($fullFileName)) {
				$fileType = '.' . pathinfo($edit, PATHINFO_EXTENSION);
				$edit = pathinfo($edit, PATHINFO_FILENAME);
				$fileContent = file_get_contents($fullFileName);
			}
			$heading = 'Редактирование элемента';
		}

//Изменение элемента
		if (isset($arParams['saveElement'])) {
			if ($arParams['extension'] == 'folder')
				Explorer::renameFolder($fullPath . $arParams['oldName'], $fullPath . $arParams['fileName']);
			else
				Explorer::editFile($fullPath, $arParams['oldName'] . $arParams['oldFileExtension'], $arParams['fileName'] . $arParams['extension'], $arParams['fileContent'] ?? "");
		} //Создание элемента
		elseif (isset($arParams['saveNewElement'])) {
			if ($arParams['extension'] == 'folder')
				Explorer::createNewFolder($fullPath, $arParams['fileName']);
			else
				Explorer::createNewFile($fullPath, $arParams['fileName'], $arParams['extension'], $arParams['fileContent'] ?? "");
		} //Удаление папки или файла
		elseif (isset($arParams['del'])) {
			Explorer::deleteElement($fullPath . $arParams['del']);
		} //Запись загруженного файла
		elseif (isset($arParams['isUpload'])) {
			require_once './functions/upload.php';
			Explorer::saveUploadFile($fullPath);
		}

		$saveType = isset($arParams['create']) ? 'saveNewElement' : 'saveElement';

		$this->arData['fileType'] = $fileType;
		$this->arData['fileContent'] = $fileContent;
		$this->arData['FILE_TYPES'] = self::FILE_TYPES;
		$this->arData['buttonSaveName'] = $saveType;
		$this->arData['heading'] = $heading;
		$this->arData['edit'] = $edit;

		return $this->arData;
	}

	public function uploadFile($arParams)
	{
		if (isset($arParams['isUpload'])) {
			Explorer::saveUploadFile($this->arData['fullPath']);
		}

	}

	public function __construct($arParams)
	{
		$obUser = new User;
		if($obUser->checkAccess()){
			header('Location: /');
			die();
		}
		$this->arData['path'] = $arParams['path'] ?? "";
		$this->arData['fullPath'] = DOCUMENT_ROOT . $this->arData['path'] . "/";
	}
}