<?php


namespace MyProject\classes;
use \MyProject\classes\DB as DB;

class Rooms
{
	protected $obDB;

	public function getRooms($arParams)
	{
		$arData['rooms'] = $this->obDB->get('rooms_table');
		foreach ($arData['rooms'] as $key => $room){
			$photo = $this->obDB->get('photos_table', ['photo'], [['room_id', '=', $room['id']]]);
			$arData['rooms'][$key]['photo'] = $photo[0]['photo'];
		}
		return $arData;
	}

	public function getRoomDetail($arParams)
	{
		$roomId = intval($arParams['room_id']);
		$arData['rooms'] = $this->obDB->get('rooms_table', [], [['id', '=', $roomId]]);
		foreach ($arData['rooms'] as $key => $room){
			$photo = $this->obDB->get('photos_table', ['photo'], [['room_id', '=', $room['id']]]);
			$arData['rooms'][$key]['photo'] = $photo[0]['photo'];
		}
		return $arData;
	}

	public function __construct()
	{
		$this->obDB = DB::getInstance();
	}
}