<?php 

class db_companies
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_companies", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function edit($args)
	{
		$insert = "UPDATE `shindi_companies` SET 
		`title`=:title,
		`identity`=:identity,
		`contact_phone`=:contact_phone,
		`contact_email`=:contact_email,
		`address`=:address,
		`website`=:website
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":identity"=>$args["identity"],
			":contact_phone"=>$args["contact_phone"],
			":contact_email"=>$args["contact_email"],
			":address"=>$args["address"],
			":website"=>$args["website"],
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"companies",
			"edit",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function add($args)
	{
		$insert = "INSERT INTO `shindi_companies` SET 
		`title`=:title,
		`identity`=:identity,
		`contact_phone`=:contact_phone,
		`contact_email`=:contact_email,
		`address`=:address,
		`website`=:website,
		`status`=:zero";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":identity"=>$args["identity"],
			":contact_phone"=>$args["contact_phone"],
			":contact_email"=>$args["contact_email"],
			":address"=>$args["address"],
			":website"=>$args["website"],
			":zero"=>0
		));

		if(!isset($args["nolog"])){
			if(!isset($Functions)){ $Functions = new Functions; }
			$log = $Functions->load("fu_log");
			$log->insert(
				"companies",
				"add",
				$_SESSION["user_data"]["id"]
			);
		}
		return $this->conn->lastInsertId();
	}


	private function deleteCompany($args)
	{
		$update = "UPDATE `shindi_companies` SET 
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
			"companies",
			"delete",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if(((int)$args["page"] > 0) && !isset($args["noLimit"])){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::COMPANY_LIST_PERPAGE).','.Config::COMPANY_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shindi_companies` WHERE `status`!=:one) as counted,
		`shindi_companies`.* 
		FROM 
		`shindi_companies` 
		WHERE 
		`shindi_companies`.`status`!=:one".$limit;
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectOnlyOwn($args)
	{
		$own_company = ($_SESSION["user_data"]["user_type"]!="manager") ? "`id` IN (".$args["own_company"].") AND " : "";
		$db_fetch = [];
		
		$select = "SELECT 
		* 
		FROM 
		`shindi_companies` 
		WHERE 
		".$own_company."`status`!=:one";

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
		
		$select = "SELECT * FROM `shindi_companies` WHERE `id`=:id AND `status`!=:one";
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