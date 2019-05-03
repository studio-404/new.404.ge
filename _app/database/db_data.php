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
		if(isset($_SESSION["user_data"]["user_type"]) && $_SESSION["user_data"]["user_type"]=="manager"){
			$insert_admin = "";
			$insert_admin2 = "";
		}else{
			$insert_admin = (isset($_SESSION["user_data"]["username"])) ? " AND `shindi_buildings`.`insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
			$insert_admin2 = (isset($_SESSION["user_data"]["username"])) ? " AND `shindi_rooms`.`insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
		}

		$db_fetch = [];
		$select = "SELECT 
		*,
		COUNT(`id`) AS userCount,
		(SELECT COUNT(`shindi_companies`.`id`) FROM `shindi_companies` WHERE `shindi_companies`.`status`!=:one) AS companyCount,
		(SELECT COUNT(`shindi_buildings`.`id`) FROM `shindi_buildings` WHERE `shindi_buildings`.`status`!=:one".$insert_admin.") AS buildingCount,
		(SELECT COUNT(`shindi_rooms`.`id`) FROM `shindi_rooms` WHERE `shindi_rooms`.`available_status`='avaliable' AND `shindi_rooms`.`status`!=:one".$insert_admin2.") AS avaliableRooms, 
		(SELECT COUNT(`shindi_rooms`.`id`) FROM `shindi_rooms` WHERE `shindi_rooms`.`available_status`='internal_installment' AND `shindi_rooms`.`status`!=:one".$insert_admin2.") AS installmentRooms,  
		(SELECT COUNT(`shindi_rooms`.`id`) FROM `shindi_rooms` WHERE `shindi_rooms`.`available_status`='sold' AND `shindi_rooms`.`status`!=:one".$insert_admin2.") AS soldRooms   
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