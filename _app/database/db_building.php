<?php 

class db_building
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_building", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function edit($args)
	{
		$insert = "UPDATE `shindi_buildings` SET 
		`title`=:title,
		`company_id`=:company_id,
		`address`=:address,
		`map_coordinates`=:map_coordinates
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":company_id"=>$args["company_id"],
			":address"=>$args["address"],
			":map_coordinates"=>$args["map_coordinates"],
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"building",
			"edit",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function add($args)
	{
		$insert = "INSERT INTO `shindi_buildings` SET 
		`title`=:title,
		`address`=:address,
		`map_coordinates`=:map_coordinates,
		`company_id`=:company_id";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":address"=>$args["address"],
			":map_coordinates"=>$args["map_coordinates"],
			":company_id"=>$args["company_id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"building",
			"add",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function deleteBuildings($args)
	{
		$update = "UPDATE `shindi_buildings` SET 
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
			"building",
			"delete",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if((int)$args["page"]>0){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::BUILDING_LIST_PERPAGE).','.Config::BUILDING_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shindi_buildings` WHERE `status`!=:one) as counted,
		(SELECT `shindi_companies`.`title` FROM `shindi_companies` WHERE `shindi_companies`.`id`=`shindi_buildings`.`company_id` AND `shindi_companies`.`status`!=:one) AS companyTitle,
		`shindi_buildings`.* 
		FROM 
		`shindi_buildings` 
		WHERE 
		`shindi_buildings`.`status`!=:one ORDER BY `shindi_buildings`.`id` DESC".$limit."";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectBuildingById($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shindi_buildings` WHERE `id`=:id AND `status`!=:one";
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

}