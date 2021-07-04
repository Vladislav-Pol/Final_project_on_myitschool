<?php


namespace MyProject\classes;

use MyProject\classes\DBUsers;

class User
{
	public $login;
	protected $password;
	protected $confirm_password;
	public $email;
	public $name;
	public $dateErrors;

	protected $pregLogin = '/^[a-z0-9]{6,}$/i';
	protected $pregPassword = '/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=])(.{6,})/';
	protected $pregEmail = '/^[a-z]([a-z0-9]*[-_.]?[a-z0-9]+)+@[a-z0-9]([a-z0-9]*[-_.]?[a-z0-9]+)+\.[a-z]{2,11}$/i';
	protected $pregName = '/[a-z0-9а-я]{2,}/i';
	protected $authLifeTime = 60 * 60 * 24 * 30;


	public function check($arParams)
	{
		$arData = [];
		$arData['user']['auth'] = $this->checkAuth();
		$arData['user']['groups_'] = $this->getGroups();

		return $arData;
	}

	protected function getGroups()
	{
		return ($_SESSION['user']['groups_']) ?? [];
	}

	public function checkAccess()
	{
		$userGroups = $this->getGroups();
		if (!in_array('admin', $userGroups)) {
			header('Location: /');
			die();
		}
	}


	/** метод регистрирует нового пользователя
	 * @param array $data принимает массив данных для регистрации
	 */
	public function addNewUser($data)
	{
		$this->login = $data['login'];
		$this->password = $data['password'];
		$this->confirm_password = $data['confirm_password'];
		$this->email = strtolower($data['email']);
		$this->name = $data['name'];

		if ($this->validateRegData() && $this->isUniqueUser()) {
			$this->salt = md5(mt_rand());

			$newUser['login'] = $this->login;
			$newUser['password'] = $this->getPasswordHash($this->password, $this->salt);
			$newUser['salt'] = $this->salt;
			$newUser['email'] = $this->email;
			$newUser['name'] = $this->name;

			$obDBUsers = new DBUsers;
			if ($obDBUsers->addUser($newUser)) {
				echo json_encode(['registr' => true]);
				die;
			};
		}
		echo json_encode($this->dateErrors);
		die;
	}

	/** метотд авторизации пользователя
	 * @param array $data принимает массив с данными для авторизации
	 */
	public function auth($data)
	{
		$result = ['login_error' => "Неверный логин или пароль"];
		if ($this->checkAuth()){
			$result = ['auth' => true];
		}else {

			$obDBUsers = new DBUsers;
			$userData = $obDBUsers->get('users_table', [], [['login', '=', $data['login']]])[0];

			if (!empty($userData)) {
				if ($userData['password'] == $this->getPasswordHash($data['password'], (string)$userData['salt'])) {
					$sessionId = session_id();
					if ($data['remember'] === 'on') {
						setcookie("key", $sessionId, time() + $this->authLifeTime, "/");
						$userData['cookie'] = $sessionId;
					}
					$_SESSION['auth'] = true;
					$_SESSION['user_login'] = $data['login'];
					$_SESSION['user_name'] = (string)$userData['name'];
					$_SESSION['user']['groups_'] = [$userData['groups_']];
					$userData['sessionId'] = $sessionId;
					$obDBUsers->updateUser($userData);
					$result = ['auth' => true];

				}
			}
		}
		header('Content-type: application/json');
		echo json_encode($result);
		die;
	}

	/**
	 * метод для разавторизации пользователя
	 */
	public function logout()
	{
		$obDBUsers = new DBUsers;

		$userByCookie = $obDBUsers->get('users_table', ['id'], [['cookie', '=', $_COOKIE['key']]])[0];
		$userBySession = $obDBUsers->get('users_table', ['id'], [['sessionId', '=', session_id()]])[0];
		if($userByCookie) {
			$userByCookie['cookie'] = '';
			$userByCookie['sessionId'] = '';
			$obDBUsers->updateUser($userByCookie);
		}
		if($userBySession) {
			$userBySession['cookie'] = '';
			$userBySession['sessionId'] = '';
			$obDBUsers->updateUser($userBySession);
		}

		setcookie("key", '', time() - 3600, "/");
		unset($_SESSION['auth'], $_SESSION['user_login'], $_SESSION['user_name']);

		header('Location: /');
	}

	protected function getPasswordHash($password, $salt)
	{
		return md5($salt . md5($password));
	}

	/**возвращает true если все поля соответстуют условиям валидации, иначе false и добавляет поле с ошибкой в массив dateErrors
	 * @return bool
	 */
	protected function validateRegData()
	{
		$result = true;

		if (!preg_match($this->pregLogin, $this->login)) {
			$this->dateErrors['login'] = 'Логин ' . $this->login . ' не подходит. Логин должен состоять только из букв латинского алфавита и цифр. Минимальная длина логина - 6 символов';
			$result = false;
		}
		if (!preg_match($this->pregPassword, $this->password)) {
			$this->dateErrors['password'] = 'Пароль слишком легкий';
			$result = false;
		}
		if ($this->password != $this->confirm_password) {
			$this->dateErrors['confirm_password'] = 'Пароли не совпадают';
			$result = false;
		}
		if (!preg_match($this->pregEmail, $this->email)) {
			$this->dateErrors['email'] = 'Неправильный email';
			$result = false;
		}
		if (!preg_match($this->pregName, $this->name)) {
			$this->dateErrors['name'] = 'Неправильное имя';
			$result = false;
		}

		return $result;
	}

	/**метод проверяет еникальность логина и почты пользователя
	 * @return bool
	 */
	protected function isUniqueUser()
	{
		$result = true;

		$obDBUsers = new DBUsers;
		$unicLogin = empty($obDBUsers->get('users_table', ['id'], [['login', '=', $this->login]]));
		$unicEmail = empty($obDBUsers->get('users_table', ['id'], [['email', '=', $this->email]]));

		if (!$unicLogin) {
			$this->dateErrors['login'] = 'Пользователь с логином ' . $this->login . ' уже существует.';
			$result = false;
		}
		if (!$unicEmail) {
			$this->dateErrors['email'] = 'Адрес ' . $this->email . ' занят другим пользователем.';
			$result = false;
		}


		return $result;
	}

	/** метод проверяет авторизацию в сессии, а затем к куках
	 * @return bool
	 */
	public static function checkAuth()
	{
		$result = false;

		if ($_SESSION['auth']) {
			$result = true;
		} elseif ($_COOKIE['key']) {

			$arUsers = DbUsers::getUsers();

			foreach ($arUsers as $user) {
				if ($user->cookie == $_COOKIE['key']) {
					$_SESSION['auth'] = true;
					$_SESSION['user_name'] = (string)$user->name;
					$user->sessionId = session_id();
					DbUsers::updateUsers($arUsers);
					break;
				}
			}
		}

		return $result;
	}


}