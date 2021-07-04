<?php


namespace MyProject\classes;


interface DBInterface
{
	/**
	 * @param $table - имя обрабатываемой таблицы
	 * @param null $arSelect - массив возвращаемых полей
	 * @param null $arFilter - массив фильтров состоящий из массивов с элементами [field, operation, value], допустимые значения - =, !=, >, >=, <, <=
	 * @param null $arOrder - массив массивов для сортировки вида поле->asc|desc
	 * @param null[] $arLimit - ограничение выборки параметры offset->, limit->
	 */
	public function get($table, $arSelect = [], $arFilter = null, $arOrder = null, $arLimit = ['offset' => 0, 'limit' => null]);

	/**
	 * @param $table - имя таблицы для вставки
	 * @param null $arFields - массив, ключи - это имя свойства, значение - значение свойства
	 */
	public function add($table, $arFields = []);

	/**
	 * @param $table - имя обрабатываемой таблицы
	 * @param null $arIDs - массив, ключ - поле поиска редактируемого элемента, значение - значение для поиска
	 * @param null $arFields - массив, ключи - это имя свойства, значение - значение свойства
	 */
	public function update($table, $arIDs = [], $arFields = []);

	/**
	 * @param $table - имя таблицы для вставки
	 * @param null $arIDs - массив, ключ - поле поиска редактируемого элемента, значение - значение для поиска
	 */
	public function delete($table, $arIDs = []);

	public function prepareParams($arParams);

	public function __construct();

}