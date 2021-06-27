<?php


namespace MyProject\classes;
use \MyProject\classes\DB;

class Rooms
{
	public function getRooms($arParams)
	{
		$obDB = DB::getInstance();
		$arData['rooms'] = $obDB->get('rooms_table');
		foreach ($arData['rooms'] as $key => $room){
			$photo = $obDB->get('photos_table', ['photo'], [['room_id', '=', $room['id']]]);
			$arData['rooms'][$key]['photo'] = $photo[0]['photo'];
		}
		return $arData;
	}
}