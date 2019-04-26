<?php 

class db_logs
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_logs", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if((int)$args["page"] > 0){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::LOGS_LIST_PERPAGE).','.Config::LOGS_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT count(`id`) FROM `shindi_logs`) AS counted, 
		(
			SELECT 
			`shidni_users`.`username` 
			FROM 
			`shidni_users` 
			WHERE 
			`shidni_users`.`id`=`shindi_logs`.`user_id` AND 
			`shidni_users`.`status`!=:one
		) AS usersName, `shindi_logs`.* 
		FROM 
		`shindi_logs` 
		ORDER BY `shindi_logs`.`date` 
		DESC".$limit;

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function add($args)
	{
		$insert = "INSERT INTO `shindi_logs` SET 
		`date`=:date,
		`ip`=:ip,
		`type`=:type,
		`action`=:action,
		`user_id`=:user_id";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":date"=>time(),
			":ip"=>$_SERVER["REMOTE_ADDR"],
			":type"=>$args["type"],
			":action"=>$args["action"],
			":user_id"=>$args["user_id"]
		));

		return true;
	}
}