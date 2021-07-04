<?php


namespace MyProject\classes;
use \MyProject\classes\DBRooms;

class Rooms
{
	protected $obDBRooms;

	public function getRooms($arParams)
	{
		$arData['rooms'] = $this->obDBRooms->get('rooms_table');
		foreach ($arData['rooms'] as $key => $room){
			$photo = $this->obDBRooms->get('photos_table', ['photo'], [['room_id', '=', $room['id']]]);
			$arData['rooms'][$key]['photo'] = $photo[0]['photo'];
		}
		return $arData;
	}

	public function getRoomDetail($arParams)
	{
		$roomId = $arParams['room_code'];
		$arData['rooms'] = $this->obDBRooms->get('rooms_table', [], [['code', '=', $roomId]]);
		foreach ($arData['rooms'] as $key => $room){
			$photo = $this->obDBRooms->get('photos_table', ['photo'], [['room_id', '=', $room['id']]]);
			$arData['rooms'][$key]['photo'] = $photo[0]['photo'];
		}
		return $arData;
	}

	public function __construct()
	{
		$this->obDBRooms = new DBRooms;
	}
}