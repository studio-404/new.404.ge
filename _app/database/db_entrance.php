<?php 

class db_entrance
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_entrance", $args['method']))
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
			$limit = ' LIMIT '.(($args["page"]-1) * Config::ENTRANCE_LIST_PERPAGE).','.Config::ENTRANCE_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shindi_entrance` WHERE `building_id`=:building_id AND `status`!=:one) AS counted,
		(SELECT `shindi_buildings`.`company_id` FROM `shindi_buildings` WHERE `shindi_buildings`.`id`=:building_id) AS company_id,
		(SELECT `shindi_buildings`.`title` FROM `shindi_buildings` WHERE `shindi_buildings`.`id`=:building_id) AS building_title,
		(SELECT `shindi_companies`.`title` FROM `shindi_companies` WHERE `shindi_companies`.`id`=company_id AND `shindi_companies`.`status`!=:one) AS companyTitle,
		`shindi_entrance`.* 
		FROM 
		`shindi_entrance` 
		WHERE 
		`shindi_entrance`.`building_id`=:building_id AND 
		`shindi_entrance`.`status`!=:one ORDER BY `shindi_entrance`.`id` DESC".$limit;

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":building_id"=>$args["building_id"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function deleteEntrance($args)
	{
		$update = "UPDATE `shindi_entrance` SET 
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
			"entrance",
			"delete",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function selectEntranceById($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shindi_entrance` WHERE `id`=:id AND `building_id`=:building_id AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":building_id"=>$args["building_id"],
			":id"=>$args["id"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}		
		return $db_fetch;
	}

	private function add($args)
	{
		$insert = "INSERT INTO `shindi_entrance` SET 
		`title`=:title,
		`building_id`=:building_id";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":building_id"=>$args["building_id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"entrance",
			"add",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function edit($args)
	{
		$insert = "UPDATE `shindi_entrance` SET 
		`title`=:title
		WHERE
		`building_id`=:building_id AND 
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":building_id"=>$args["building_id"],
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"entrance",
			"edit",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

}