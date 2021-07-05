<?php


namespace MyProject\classes;
use \MyProject\classes\Abstruct_DB;

class DBUsers extends Abstruct_DB
{
	protected $table = 'users_table';

	public function addUser($arParams)
	{
		$arFields["login"] = $arParams['login'];
		$arFields["password"] = $arParams['password'];
		$arFields["salt"] = $arParams['salt'];
		$arFields["email"] = $arParams['email'];
		$arFields["name"] = $arParams['name'];

		return $this->add($this->table, $arFields);
	}



	public function updateUser($arParams)
	{
		$realKeys = $this->getTableColumns($this->config['database'], 'users_table');
		$arFields = [];
		foreach ($arParams as $param => $value){
			if(in_array($param, $realKeys)){
				$arFields[$param] = $value;
			}
		}
		$arIDs['id'] = $arParams['id'];

		return $this->update($this->table, $arIDs, $arFields);
	}

	public function getUsers()
	{
		$arResult['users'] = $this->get($this->table, ['id', 'login', 'email', 'name', 'groups_']);

		return $arResult;
	}

	public function getUser($arParams)
	{
		$arResult['edit_user'] = $this->get($this->table, ['id', 'login', 'email', 'name', 'groups_'], [['login', '=', $arParams["user_login"]]])[0];

		return $arResult;
	}
}