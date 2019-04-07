<?php 

class db_data
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_data", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function select($args)
	{
		$db_fetch = [];
		$select = "SELECT 
		*,
		COUNT(`id`) AS userCount,
		(SELECT COUNT(`shindi_companies`.`id`) FROM `shindi_companies` WHERE `shindi_companies`.`status`!=:one) AS companyCount,
		(SELECT COUNT(`shindi_buildings`.`id`) FROM `shindi_buildings` WHERE `shindi_buildings`.`status`!=:one) AS buildingCount  
		FROM 
		`shidni_users` 
		WHERE 
		`shidni_users`.`status`!=:one";

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}	

		return $db_fetch;
	}

}