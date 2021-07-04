<?php


namespace MyProject\classes;
use \MyProject\classes\Abstruct_DB;

class DBRooms extends Abstruct_DB
{
	public function getRumsData()
	{
		$query = 'SELECT rooms.name as name, params.name as property, valu.value as value
				FROM rooms_table rooms
				LEFT JOIN params_value_table valu ON rooms.id = valu.room_id
				LEFT JOIN params_table params ON valu.param_id = params.id';
		$stmt = $this->dbh->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}