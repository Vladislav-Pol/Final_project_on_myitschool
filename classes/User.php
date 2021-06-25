<?php


namespace MyProject\classes;


class User
{
	public static function getGroups()
	{
		return ($_SESSION['user']['groups']) ?? [];
	}

	public static function checkAuth()
	{
		if (!$_COOKIE['auth']) {
			return false;
		}
		session_id($_COOKIE['auth']);
		session_start();
		return $_SESSION['user']['auth'];
	}

	public static function logout()
	{
		session_start();
		unset($_COOKIE['auth'], $_SESSION['user']);
		header('Location: ./');
	}

	public static function checkAccess()
	{
		$userGroups = self::getGroups();
		if(!in_array('admin', $userGroups)){
			header('Location: /');
			die();
		}
	}
}