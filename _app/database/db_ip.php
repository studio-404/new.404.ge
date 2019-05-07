<?php 

class db_ip
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_ip", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if((int)$args["page"] > 0 && !isset($args["noLimit"])){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::IP_LIST_PERPAGE).','.Config::IP_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT count(`shindi_ip`.`id`) FROM `shindi_ip` WHERE `shindi_ip`.`status`!=:one) AS counted, 
		`shindi_ip`.* 
		FROM 
		`shindi_ip` 
		WHERE 
		`shindi_ip`.`status`!=:one ORDER BY `shindi_ip`.`id` DESC".$limit;

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
		$insert = "INSERT INTO `shindi_ip` SET 
		`name`=:name,
		`ip`=:ip";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":name"=>$args["name"],
			":ip"=>$args["ip"]
		));

		if(!isset($args["nologs"])){
			if(!isset($Functions)){ $Functions = new Functions; }
			$log = $Functions->load("fu_log");
			$log->insert(
				"ip",
				"add",
				$_SESSION["user_data"]["id"]
			);
		}

		return true;
	}

	private function deleteIP($args)
	{
		$update = "UPDATE `shindi_ip` SET 
		`status`=:one
		WHERE
		`id`=:id";

		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":one"=>1,
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"ip",
			"delete",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function selectIpById($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shindi_ip` WHERE `id`=:id AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":id"=>$args["id"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}		
		return $db_fetch;
	}

	private function edit($args)
	{
		$insert = "UPDATE `shindi_ip` SET 
		`name`=:name,
		`ip`=:ip
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":name"=>$args["name"],
			":ip"=>$args["ip"],
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"ip",
			"edit",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

}