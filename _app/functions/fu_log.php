<?php 

class fu_log
{
	public function insert($type, $action, $user_id)
	{
		$Database = new Database("db_logs", array(
			"method"=>"add",
			"type"=>$type,
			"action"=>$action,
			"user_id"=>$user_id
		));

		return true;
	}
}