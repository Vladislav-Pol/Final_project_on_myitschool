<?php
namespace MyProject\classes;

class DBOld
{
	protected $mySqlI;

	private static $instances = [];

	/**
	 * @param $table - имя обрабатываемой таблицы
	 * @param null $arSelect - массив возвращаемых полей
	 * @param null $arFilter - массив фильтров состоящий из массивов с элементами [field, operation, value]
	 * @param null $arOrder - массив массивов для сортировки вида поле->asc|desc
	 * @param null[] $arLimit - ограничение выборки параметры offset->, limit->
	 */
	public function get($table, $arSelect = null, $arFilter = null, $arOrder = null, $arLimit = ['offset' => 0, 'limit' => null])
	{
		$query = "SELECT ";

		if ($arSelect === null) {
			$query .= "* ";
		} else {
			foreach ($arSelect as $item) {
				$query .= $this->mySqlI->real_escape_string($item) . ", ";
			}
			$query = preg_replace('/, $/', '', $query);
		}

		$query .= " FROM " . $this->mySqlI->real_escape_string($table);

		if ($arFilter !== null){
			$query .= " WHERE ";
			foreach ($arFilter as $filter){
				$query .= $this->mySqlI->real_escape_string($filter[0]) . " ";
				$query .= $this->mySqlI->real_escape_string($filter[1]) . " ";
				$query .= $this->mySqlI->real_escape_string($filter[2]) . " AND ";
			}
			$query = preg_replace('/ AND $/', '', $query);
		}

		if ($arOrder !== null){
			$query .= " ORDER BY ";
			foreach ($arOrder as $field => $type){
				$query .= $this->mySqlI->real_escape_string($field) . " ";
				$query .= $this->mySqlI->real_escape_string($type) . ", ";
			}
			$query = preg_replace('/, $/', '', $query);
		}

		if ($arLimit['limit'] !== null){
			$query .= " LIMIT " . $this->mySqlI->real_escape_string($arLimit['offset']) . ", ";
			$query .= $this->mySqlI->real_escape_string($arLimit['limit']);
		}

		$result = $this->mySqlI->query($query);
		return $data = $result->fetch_all(MYSQLI_ASSOC);
	}

	public function getLocalCatalogData($id = false)
	{
		$query = "SELECT * FROM Products";

		if ($id !== false) {
			$query .= " WHERE id = {$this->mySqlI->real_escape_string($id)}";
		}
		$result = $this->mySqlI->query($query);
		return $data = $result->fetch_all(MYSQLI_ASSOC);
	}

	/** метод обновляет данные в БД
	 * @param $arData
	 * @return string
	 */
	public function updateLocalBase($arData)
	{
		if (file_exists(BD_PATH)
			&& (time() - filemtime(BD_PATH)) < TIME_ACTUAL_DB) {
			return 'Local base is actual';
		}
		if (($newData = $this->getCatalogData($arData)) !== false) {
			$newData = $this->updateLocalImagesBase($newData);

			foreach ($newData as $product) {
				$arProps = array_intersect_key($product, array_flip(['id', 'title', 'price', 'description', 'image']));
				$arProps['api_id'] = $arProps['id'];
				unset($arProps['id']);
				$this->put('Products', $arProps);
			}
//            $jsonData = json_encode($newData);
//            file_put_contents(BD_PATH, $jsonData);
			file_put_contents(BD_PATH, '');
			return 'Update success';
		}
		return "Base is not actual, update Error";
	}

	protected function updateLocalImagesBase($data)
	{
		foreach ($data as &$product) {
			$image = file_get_contents($product['image']);
			$fileData = pathinfo($product['image']);
			$fileName = $fileData['basename'];
			$newFilePath = DOCUMENT_ROOT . '/image/' . $fileName;
			file_put_contents($newFilePath, $image);
			$product['image'] = '/image/' . $fileName;
		}
		return $data;
	}

	/** метод забирает данные с API и возвращает в виде массива
	 * @param $arOptions
	 * @return false|mixed
	 */
	protected function getCatalogData($arOptions)
	{
		$ch = curl_init();
		curl_setopt_array($ch, $arOptions);
		$result = curl_exec($ch);
		curl_close($ch);
		if ($result == "null")
			return false;
		$arResult = json_decode($result, true);
		//fixUrlInData($arResult);
		return $arResult;
	}


	/**
	 * проверка на существование записи с таким api_id в базе, если есть, тогда обновляется запись, иначе создается новая
	 * @param null $tableName - имя таблицы
	 * @param null $arFields - массив значений ИмяПоля => значение
	 */
	public function put($tableName = null, $arFields = null)
	{
		$query = "SELECT id FROM $tableName WHERE api_id = {$arFields['api_id']}";
		if ($this->mySqlI->query($query)->fetch_assoc()) {
			$this->update($tableName, $arFields);
		} else {
			$this->insert($tableName, $arFields);
		}
	}

	protected function update($tableName, $arFields)
	{
		$query = "UPDATE $tableName  SET ";
		foreach ($arFields as $prop => $value) {
			$value = $this->mySqlI->real_escape_string($value);
			$query .= "$prop = '$value', ";
		}
		$query = preg_replace('/, $/', '', $query);
		$query .= "WHERE $tableName.api_id = {$arFields['api_id']};";

		$this->mySqlI->query($query);
	}

	protected function insert($tableName, $arFields)
	{
		$query = "INSERT INTO $tableName (";
		foreach ($arFields as $prop => $value) {
			$query .= $prop . ', ';
		}
		$query = preg_replace('/, $/', '', $query);
		$query .= ") VALUES (";
		foreach ($arFields as $prop => $value) {
			$query .= "'" . $this->mySqlI->real_escape_string($value) . "', ";
		}
		$query = preg_replace('/, $/', '', $query);
		$query .= ")";

		$this->mySqlI->query($query);
	}

	public function __construct()
	{
		$config = require_once $_SERVER['DOCUMENT_ROOT'] . '/db_mysql/db_config.php';
		$this->mySqlI = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']);
	}

	public function __destruct()
	{
		$this->mySqlI->close();
	}

	public static function getInstance()
	{
		$subclass = static::class;
		if (!isset(self::$instances[$subclass])) {
			self::$instances[$subclass] = new static();
		}
		return self::$instances[$subclass];
	}

	/**
	 * Клонирование и десериализация не разрешены для одиночек.
	 */
	protected function __clone()
	{
	}

	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize singleton");
	}

}
