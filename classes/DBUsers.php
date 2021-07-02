<?php


namespace MyProject\classes;
use \MyProject\classes\Abstruct_DB;

class DBUsers extends Abstruct_DB
{
	public function addUser($arParams)
	{
		$arParams = $this->prepareParams($arParams);
		$connection = $this->dbh;

		$query = 'INSERT INTO users_table (login, password, salt, email, name) VALUES (' . "{$arParams['login']},{$arParams['password']},{$arParams['salt']},{$arParams['email']},{$arParams['name']}" . ')';
		return $connection->exec($query);
	}

	public function updateUser($arParams)
	{
		$arParams = $this->prepareParams($arParams);
		$connection = $this->dbh;
		$query = 'UPDATE `users_table` SET ';

		$realKeys = $this->getTableColumns($this->config['database'], 'users_table');

		$prefix = '';
		foreach ($arParams as $param => $value){
			if(in_array($param, $realKeys)){
				$query .= ($prefix . $param . "=" . $value);
				$prefix = ',';
			}
		}
		$query .= " WHERE id = {$arParams['id']}";
		$result = $connection->exec($query);
		return $result;
	}

	public function getUsers($arParams)
	{
		$arResult['users'] = $this->get('users_table', ['id', 'login', 'email', 'name', 'groups_']);

		return $arResult;
	}

	public function getUser($arParams)
	{
		$arResult['edit_user'] = $this->get('users_table', ['id', 'login', 'email', 'name', 'groups_'], [['login', '=', $arParams["user_login"]]])[0];

		return $arResult;
	}
}