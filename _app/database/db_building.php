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

	// private function edit($args)
	// {
	// 	$insert = "UPDATE `shindi_companies` SET 
	// 	`title`=:title,
	// 	`identity`=:identity,
	// 	`contact_phone`=:contact_phone,
	// 	`contact_email`=:contact_email,
	// 	`address`=:address,
	// 	`website`=:website
	// 	WHERE
	// 	`id`=:id
	// 	";

	// 	$prepare = $this->conn->prepare($insert);
	// 	$prepare->execute(array(
	// 		":title"=>$args["title"],
	// 		":identity"=>$args["identity"],
	// 		":contact_phone"=>$args["contact_phone"],
	// 		":contact_email"=>$args["contact_email"],
	// 		":address"=>$args["address"],
	// 		":website"=>$args["website"],
	// 		":id"=>(int)$args["id"]
	// 	));

	// 	return true;
	// }

	// private function add($args)
	// {
	// 	$insert = "INSERT INTO `shindi_companies` SET 
	// 	`title`=:title,
	// 	`identity`=:identity,
	// 	`contact_phone`=:contact_phone,
	// 	`contact_email`=:contact_email,
	// 	`address`=:address,
	// 	`website`=:website,
	// 	`status`=:zero";

	// 	$prepare = $this->conn->prepare($insert);
	// 	$prepare->execute(array(
	// 		":title"=>$args["title"],
	// 		":identity"=>$args["identity"],
	// 		":contact_phone"=>$args["contact_phone"],
	// 		":contact_email"=>$args["contact_email"],
	// 		":address"=>$args["address"],
	// 		":website"=>$args["website"],
	// 		":zero"=>0
	// 	));

	// 	return true;
	// }

	private function deleteCompany($args)
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

		return true;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if($args["page"]){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::BUILDING_LIST_PERPAGE).','.Config::BUILDING_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shindi_buildings` WHERE `status`!=:one) as counted,
		(SELECT `shindi_companies`.`title` FROM `shindi_companies` WHERE `shindi_companies`.`id`=`shindi_buildings`.`company_id` AND `shindi_companies`.`status`!=:one) AS companyTitle,
		`shindi_buildings`.* 
		FROM 
		`shindi_buildings` 
		WHERE 
		`shindi_buildings`.`status`!=:one".$limit;
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectUserById($args)
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