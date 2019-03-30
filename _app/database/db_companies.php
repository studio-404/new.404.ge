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

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if($args["page"]){
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