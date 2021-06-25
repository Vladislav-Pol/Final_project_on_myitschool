<?php


namespace MyProject\classes;

use \MyProject\classes\User;
use \MyProject\classes\Explorer;


class Admin
{
	const FILE_TYPE = [
		'folder' => 'Папка',
		'.txt' => 'Файл .txt',
		'.html' => 'Файл .html',
		'.css' => 'Файл .css',
		'.js' => 'Файл .js'
	];
	public array $arData = [];
	public string $path = '';
	protected bool $edit = false;

	public function explorer($arParams)
	{

		$path = $this->path;
		$fullPath = DOCUMENT_ROOT . $path . "/";

		$dirContent = (scandir(realpath($fullPath)));
		$content = [];
		foreach($dirContent as $key => $item){
			if($item == '.')continue;

			$content[$key]['name'] = $item;
			$content[$key]['canEdit'] = (Explorer::canEdit($fullPath . $item, self::FILE_TYPE)) ? true : false;

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
		$this->arData['path'] = $path;
		$this->arData['fullPath'] = $fullPath;

		return $this->arData;
	}

	protected function createEdit($arParams)
	{
		if(!isset($_REQUEST['path']))
			header('Location: ./index.php');

		//Подготовка данных для редактирования элемента
		if (isset($arParams['edit'])) {
			$edit = $arParams['edit'];
			$fullFileName = $this->arData['fullPath'] . $edit;
			if (is_file($fullFileName)) {
				$fileType = '.' . pathinfo($edit, PATHINFO_EXTENSION);
				$edit = pathinfo($edit, PATHINFO_FILENAME);
				$fileContent = file_get_contents($fullFileName);
			}
		}

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


	}

	public function __construct($requestData)
	{
		$this->path = $_REQUEST['path'] ?? "";

//		User::checkAccess();  todo реализовать авторизацию и раскоментировать
	}
}