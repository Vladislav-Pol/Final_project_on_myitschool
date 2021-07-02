<?php


namespace MyProject\classes;

use \MyProject\classes\DBUsers;

class AdminUsers
{
	protected $obDBUsers;

	public function users($arParams)
	{
		$arResult = $this->obDBUsers->getUsers($arParams);

		return $arResult;
	}

	public function edit_users($arParams)
	{
		$arResult = $this->obDBUsers->getUser($arParams);

		return $arResult;
	}

	public function edit($arParams)
	{
		$arResult = $this->obDBUsers->updateUser($arParams);

		if($arResult){
			header("Location: /admin/users/");
			die;
		}

		return $arResult;
	}

	public function __construct()
	{
		$this->obDBUsers = DBUsers::getInstance();
	}
}