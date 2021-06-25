<?php


namespace MyProject\classes;


class Explorer
{
	//Проверка возможности изменять элемент
	public static function canEdit($element, $fileType)
	{
		if (is_dir($element) &&
			substr($element, -2) != "..") // Запрет изменения родительского каталога
			return 'dir';

		if (is_file($element) &&
			array_key_exists("." . pathinfo($element, PATHINFO_EXTENSION), $fileType))
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
