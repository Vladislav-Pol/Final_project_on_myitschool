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

	public function __construct()
	{
		$this->obDBUsers = DBUsers::getInstance();
	}
}