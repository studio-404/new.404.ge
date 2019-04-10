<?php 

class db_room
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_room", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function deleteRoom($args)
	{
		$update = "UPDATE `shindi_rooms` SET 
		`status`=:one
		WHERE
		`id`=:id";

		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":one"=>1,
			":id"=>(int)$args["id"]
		));


		$update2 = "UPDATE `shindi_photos` SET 
		`status`=:one
		WHERE
		`attach_id`=:id";

		$prepare2 = $this->conn->prepare($update2);
		$prepare2->execute(array(
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
			$limit = ' LIMIT '.(($args["page"]-1) * Config::ROOM_LIST_PERPAGE).','.Config::ROOM_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shindi_rooms` WHERE `building_id`=:building_id AND `entrance_id`=:entrance_id AND `floor_id`=:floor_id AND `status`!=:one) AS counted,
		(SELECT `shindi_buildings`.`company_id` FROM `shindi_buildings` WHERE `shindi_buildings`.`id`=:building_id) AS company_id,
		(SELECT `shindi_buildings`.`title` FROM `shindi_buildings` WHERE `shindi_buildings`.`id`=:building_id) AS building_title,
		(SELECT `shindi_entrance`.`title` FROM `shindi_entrance` WHERE `shindi_entrance`.`id`=:entrance_id) AS entrance_title,
		(SELECT `shindi_floors`.`title` FROM `shindi_floors` WHERE `shindi_floors`.`id`=:floor_id) AS floor_title,
		(SELECT `shindi_companies`.`title` FROM `shindi_companies` WHERE `shindi_companies`.`id`=company_id AND `shindi_companies`.`status`!=:one) AS companyTitle,
		`shindi_rooms`.* 
		FROM 
		`shindi_rooms` 
		WHERE 
		`shindi_rooms`.`building_id`=:building_id AND 
		`shindi_rooms`.`entrance_id`=:entrance_id AND 
		`shindi_rooms`.`floor_id`=:floor_id AND 
		`shindi_rooms`.`status`!=:one ORDER BY `shindi_rooms`.`id` DESC".$limit;

		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":building_id"=>$args["building_id"],
			":entrance_id"=>$args["entrance_id"],
			":floor_id"=>$args["floor_id"],
			":one"=>1
		));
		
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}


	private function selectRoomById($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shindi_rooms` WHERE `id`=:id AND `building_id`=:building_id AND `entrance_id`=:entrance_id AND `floor_id`=:floor_id AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":building_id"=>$args["building_id"],
			":entrance_id"=>$args["entrance_id"],
			":floor_id"=>$args["floor_id"],
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
		$natural_air = 0;
		$central_hitting = 0;
		$tv_cable = 0;
		$internet = 0;
		$washing_machine = 0;
		$verandah = 0;
		$balcony = 0;
		$phone = 0;
		$tv = 0;
		$parking = 0;
		$iron_door = 0;
		$storeroom = 0;
		$alarms = 0;
		$furniture = 0;
		$fridge = 0;
		$elevator = 0;

		$addInfo = explode(",", $args["addInfo"]); 

		if(in_array("natural_air", $addInfo)){ $natural_air = 1; }
		if(in_array("central_hitting", $addInfo)){ $central_hitting = 1; }
		if(in_array("tv_cable", $addInfo)){ $tv_cable = 1; }
		if(in_array("internet", $addInfo)){ $internet = 1; }
		if(in_array("washing_machine", $addInfo)){ $washing_machine = 1; }
		if(in_array("verandah", $addInfo)){ $verandah = 1; }
		if(in_array("balcony", $addInfo)){ $balcony = 1; }
		if(in_array("phone", $addInfo)){ $phone = 1; }
		if(in_array("tv", $addInfo)){ $tv = 1; }
		if(in_array("parking", $addInfo)){ $parking = 1; }
		if(in_array("iron_door", $addInfo)){ $iron_door = 1; }
		if(in_array("storeroom", $addInfo)){ $storeroom = 1; }
		if(in_array("alarms", $addInfo)){ $alarms = 1; }
		if(in_array("furniture", $addInfo)){ $furniture = 1; }
		if(in_array("fridge", $addInfo)){ $fridge = 1; }
		if(in_array("elevator", $addInfo)){ $elevator = 1; }

		$insert = "INSERT INTO `shindi_rooms` SET 
		`title`=:title,
		`building_id`=:building_id,
		`entrance_id`=:entrance_id,
		`floor_id`=:floor_id,
		`rooms`=:rooms,
		`bedroom`=:bedroom,
		`bathrooms`=:bathrooms,
		`square`=:square,
		`ceil_height`=:ceil_height,
		`description`=:description,
		`natural_air`=:natural_air,
		`central_hitting`=:central_hitting,
		`tv_cable`=:tv_cable,
		`internet`=:internet,
		`washing_machine`=:washing_machine,
		`verandah`=:verandah,
		`balcony`=:balcony,
		`phone`=:phone,
		`tv`=:tv,
		`parking`=:parking,
		`iron_door`=:iron_door,
		`storeroom`=:storeroom,
		`alarms`=:alarms,
		`furniture`=:furniture,
		`fridge`=:fridge,
		`elevator`=:elevator,
		`available_status`=:available_status,
		`totalprice`=:totalprice,
		`pre_pay`=:pre_pay,
		`paying_start_day`=:paying_start_day,
		`payed_months`=:payed_months,
		`installment_months`=:installment_months
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":building_id"=>$args["building_id"],
			":entrance_id"=>$args["entrance_id"], 
			":floor_id"=>$args["floor_id"], 
			":rooms"=>$args["rooms"], 
			":bedroom"=>$args["bedroom"], 
			":bathrooms"=>$args["bathrooms"], 
			":square"=>$args["square"], 
			":ceil_height"=>$args["ceil_height"], 
			":description"=>$args["description"],
			":natural_air"=>$natural_air,
			":central_hitting"=>$central_hitting,
			":tv_cable"=>$tv_cable,
			":internet"=>$internet,
			":washing_machine"=>$washing_machine,
			":verandah"=>$verandah,
			":balcony"=>$balcony,
			":phone"=>$phone,
			":tv"=>$tv,
			":parking"=>$parking,
			":iron_door"=>$iron_door,
			":storeroom"=>$storeroom,
			":alarms"=>$alarms,
			":furniture"=>$furniture,
			":fridge"=>$fridge,
			":elevator"=>$elevator,
			":available_status"=>$args["available_status"],
			":totalprice"=>$args["totalprice"],
			":pre_pay"=>$args["pre_pay"],
			":payed_months"=>$args["payed_months"],
			":paying_start_day"=>$args["paying_start_day"],
			":installment_months"=>$args["installment_months"]
		));

		$lastInsertId = $this->conn->lastInsertId();

		return $lastInsertId;
	}

	private function edit($args)
	{
		$natural_air = 0;
		$central_hitting = 0;
		$tv_cable = 0;
		$internet = 0;
		$washing_machine = 0;
		$verandah = 0;
		$balcony = 0;
		$phone = 0;
		$tv = 0;
		$parking = 0;
		$iron_door = 0;
		$storeroom = 0;
		$alarms = 0;
		$furniture = 0;
		$fridge = 0;
		$elevator = 0;

		$addInfo = explode(",", $args["addInfo"]); 

		if(in_array("natural_air", $addInfo)){ $natural_air = 1; }
		if(in_array("central_hitting", $addInfo)){ $central_hitting = 1; }
		if(in_array("tv_cable", $addInfo)){ $tv_cable = 1; }
		if(in_array("internet", $addInfo)){ $internet = 1; }
		if(in_array("washing_machine", $addInfo)){ $washing_machine = 1; }
		if(in_array("verandah", $addInfo)){ $verandah = 1; }
		if(in_array("balcony", $addInfo)){ $balcony = 1; }
		if(in_array("phone", $addInfo)){ $phone = 1; }
		if(in_array("tv", $addInfo)){ $tv = 1; }
		if(in_array("parking", $addInfo)){ $parking = 1; }
		if(in_array("iron_door", $addInfo)){ $iron_door = 1; }
		if(in_array("storeroom", $addInfo)){ $storeroom = 1; }
		if(in_array("alarms", $addInfo)){ $alarms = 1; }
		if(in_array("furniture", $addInfo)){ $furniture = 1; }
		if(in_array("fridge", $addInfo)){ $fridge = 1; }
		if(in_array("elevator", $addInfo)){ $elevator = 1; }

		$insert = "UPDATE `shindi_rooms` SET 
		`title`=:title,
		`building_id`=:building_id,
		`entrance_id`=:entrance_id,
		`floor_id`=:floor_id,
		`rooms`=:rooms,
		`bedroom`=:bedroom,
		`bathrooms`=:bathrooms,
		`square`=:square,
		`ceil_height`=:ceil_height,
		`description`=:description,
		`natural_air`=:natural_air,
		`central_hitting`=:central_hitting,
		`tv_cable`=:tv_cable,
		`internet`=:internet,
		`washing_machine`=:washing_machine,
		`verandah`=:verandah,
		`balcony`=:balcony,
		`phone`=:phone,
		`tv`=:tv,
		`parking`=:parking,
		`iron_door`=:iron_door,
		`storeroom`=:storeroom,
		`alarms`=:alarms,
		`furniture`=:furniture,
		`fridge`=:fridge,
		`elevator`=:elevator,
		`available_status`=:available_status,
		`totalprice`=:totalprice,
		`pre_pay`=:pre_pay,
		`paying_start_day`=:paying_start_day,
		`payed_months`=:payed_months,
		`installment_months`=:installment_months
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":title"=>$args["title"],
			":building_id"=>$args["building_id"],
			":entrance_id"=>$args["entrance_id"], 
			":floor_id"=>$args["floor_id"], 
			":rooms"=>$args["rooms"], 
			":bedroom"=>$args["bedroom"], 
			":bathrooms"=>$args["bathrooms"], 
			":square"=>$args["square"], 
			":ceil_height"=>$args["ceil_height"], 
			":description"=>$args["description"],
			":natural_air"=>$natural_air,
			":central_hitting"=>$central_hitting,
			":tv_cable"=>$tv_cable,
			":internet"=>$internet,
			":washing_machine"=>$washing_machine,
			":verandah"=>$verandah,
			":balcony"=>$balcony,
			":phone"=>$phone,
			":tv"=>$tv,
			":parking"=>$parking,
			":iron_door"=>$iron_door,
			":storeroom"=>$storeroom,
			":alarms"=>$alarms,
			":furniture"=>$furniture,
			":fridge"=>$fridge,
			":elevator"=>$elevator,
			":available_status"=>$args["available_status"],
			":totalprice"=>$args["totalprice"],
			":pre_pay"=>$args["pre_pay"],
			":paying_start_day"=>$args["paying_start_day"],
			":payed_months"=>$args["payed_months"],
			":installment_months"=>$args["installment_months"],
			":id"=>$args["id"]
		));

		$lastInsertId = $this->conn->lastInsertId();

		return $lastInsertId;
	}
}