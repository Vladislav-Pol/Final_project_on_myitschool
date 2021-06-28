<?php


namespace MyProject\classes;


class User
{
	public function check($arParams)
	{
		$arData = [];
		$arData['user']['auth'] = $this->checkAuth();
		$arData['user']['groups'] = $this->getGroups();

		return $arData;
	}

	protected function getGroups()
	{
		return ($_SESSION['user']['groups']) ?? [];
	}

	protected function checkAuth()
	{
		if (!$_COOKIE['auth']) {
			return false;
		}
		session_id($_COOKIE['auth']);
		session_start();
		return $_SESSION['user']['auth'];
	}

	public function logout()
	{
		session_start();
		unset($_COOKIE['auth'], $_SESSION['user']);
		header('Location: ./');
	}

	public function checkAccess()
	{
		$userGroups = $this->getGroups();
		if(!in_array('admin', $userGroups)){
			header('Location: /');
			die();
		}
	}
}