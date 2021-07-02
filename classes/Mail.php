<?php


namespace MyProject\classes;


class Mail
{
	protected $pregEmail = '/^[a-z]([a-z0-9]*[-_.]?[a-z0-9]+)+@[a-z0-9]([a-z0-9]*[-_.]?[a-z0-9]+)+\.[a-z]{2,11}$/i';
	protected $pregName = '/[a-zа-я]{2}[a-z0-9а-я]+/i';
	protected $pregTel = '/^\+375\s?\d{2}\s?\d{3}[\-\s]?\d{2}[\-\s]?\d{2}$/';

	public function sendContactMessage($arParams)
	{
		$arResult = [];

		$arResult = $this->validateEmail($arParams['email'], $arResult);
		$arResult = $this->validateName($arParams['name'], $arResult);
		$arResult = $this->validateTel($arParams['telephone'], $arResult);
		$arResult = $this->validateMessage($arParams['message'], $arResult);

		if(empty($arResult)){
			$wasSend = mb_send_mail('siteAdmin@test.test',
				"Новое сообщение с сайта от {$arParams['name']}",
				$arParams['message']
			);
			$wasSend = true;//имитация успешной отправки письма
		}
		$arResult["was_send"] = $wasSend ?? false;

		header('Content-type: application/json');
		echo json_encode($arResult);
		die;
	}

	protected function validateEmail($email, $arResult)
	{
		if (!preg_match($this->pregEmail, $email)) {
			$arResult['contact_email'] = 'Неправильный email';
		}
		return $arResult;
	}

	protected function validateName($name, $arResult)
	{
		if (!preg_match($this->pregName, $name)) {
			$arResult['contact_name'] = 'Неправильное имя';
		}
		return $arResult;
	}

	protected function validateTel($tel, $arResult)
	{
		if (!preg_match($this->pregTel, $tel)) {
			$arResult['contact_phone'] = 'Введите телефон в формате +375 XX XXX XX XX';
		}
		return $arResult;
	}

	protected function validateMessage($message, $arResult)
	{
		if (strlen($message) < 15) {
			$arResult['contact_message_text'] = 'Сообщение слишком короткое';
		}
		return $arResult;
	}

}