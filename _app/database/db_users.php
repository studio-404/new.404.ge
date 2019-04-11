<?php 

class db_users
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_users", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function changePassword($args)
	{
		$insert = "UPDATE `shidni_users` SET 
		`password`=:password
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":password"=>md5($args["password"]),
			":id"=>(int)$args["id"]
		));

		return true;
	}

	private function deleteUser($args)
	{
		$update = "UPDATE `shidni_users` SET 
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

	private function edit($args)
	{
		$insert = "UPDATE `shidni_users` SET 
		`created_date`=:created_date,
		`user_type`=:user_type,
		`firstname`=:firstname,
		`lastname`=:lastname,
		`contact_email`=:contact_email,
		`contact_phone`=:contact_phone,
		`permission_company`=:permission_company,
		`permission_buldings`=:permission_buldings,
		`permission_entrance`=:permission_entrance,
		`permission_floor`=:permission_floor,
		`permission_room`=:permission_room
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":created_date"=>time(),
			":user_type"=>(isset($args["user_type"])) ? $args["user_type"] : "user",
			":firstname"=>$args["firstname"],
			":lastname"=>$args["lastname"],
			":contact_email"=>$args["contact_email"],
			":contact_phone"=>$args["contact_phone"],
			":permission_company"=>(!empty($args["permission_company"])) ? $args["permission_company"] : "none",
			":permission_buldings"=>(!empty($args["permission_buldings"])) ? $args["permission_buldings"] : "none",
			":permission_entrance"=>(!empty($args["permission_entrance"])) ? $args["permission_entrance"] : "none",
			":permission_floor"=>(!empty($args["permission_floor"])) ? $args["permission_floor"] : "none",
			":permission_room"=>(!empty($args["permission_room"])) ? $args["permission_room"] : "none",
			":id"=>(int)$args["id"]
		));

		return true;
	}

	private function add($args)
	{
		$insert = "INSERT INTO `shidni_users` SET 
		`created_date`=:created_date,
		`user_type`=:user_type,
		`firstname`=:firstname,
		`lastname`=:lastname,
		`username`=:username,
		`password`=:password,
		`contact_email`=:contact_email,
		`contact_phone`=:contact_phone,
		`permission_company`=:permission_company,
		`permission_buldings`=:permission_buldings,
		`permission_entrance`=:permission_entrance,
		`permission_floor`=:permission_floor,
		`permission_room`=:permission_room,
		`status`=:status";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":created_date"=>time(),
			":user_type"=>(isset($args["user_type"])) ? $args["user_type"] : "user",
			":firstname"=>$args["firstname"],
			":lastname"=>$args["lastname"],
			":username"=>$args["username"],
			":password"=>md5($args["password"]),
			":contact_email"=>$args["contact_email"],
			":contact_phone"=>$args["contact_phone"],
			":permission_company"=>(!empty($args["permission_company"])) ? $args["permission_company"] : "none",
			":permission_buldings"=>(!empty($args["permission_buldings"])) ? $args["permission_buldings"] : "none",
			":permission_entrance"=>(!empty($args["permission_entrance"])) ? $args["permission_entrance"] : "none",
			":permission_floor"=>(!empty($args["permission_floor"])) ? $args["permission_floor"] : "none",
			":permission_room"=>(!empty($args["permission_room"])) ? $args["permission_room"] : "none",
			":status"=>0
		));

		return true;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if((int)$args["page"] > 0){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::USER_LIST_PERPAGE).','.Config::USER_LIST_PERPAGE;
		}
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shidni_users` WHERE `status`!=:one) as counted,
		`shidni_users`.* 
		FROM 
		`shidni_users` 
		WHERE 
		`shidni_users`.`status`!=:one".$limit;
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function checkifuserexists($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shidni_users` WHERE `username`=:username AND `password`=:password AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":username"=>$args["username"],
			":password"=>md5($args["password"]),
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectUserByUsername($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shidni_users` WHERE `username`=:username AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":username"=>$args["username"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectUserById($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shidni_users` WHERE `id`=:id AND `status`!=:one";
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

	private function update($args)
	{
		$db_fetch = [];
		$username = (isset($_SESSION["user_data"]["username"])) ? $_SESSION["user_data"]["username"] : "";
		
		$update = "UPDATE `shidni_users` SET `firstname`=:firstname, `lastname`=:lastname, `contact_email`=:contact_email, `contact_phone`=:contact_phone WHERE `username`=:username";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":firstname"=>$args["firstname"],
			":lastname"=>$args["lastname"],
			":contact_email"=>$args["contact_email"],
			":contact_phone"=>$args["contact_phone"],
			":username"=>$username
		));


		$fetchUserDate = $this->selectUserByUsername(array(
			"username"=>$username
		));

		$_SESSION["user_data"] = $fetchUserDate;		

		return true;
	}

	private function updatepassword($args)
	{
		$username = (isset($_SESSION["user_data"]["username"])) ? $_SESSION["user_data"]["username"] : "";
		
		$update = "UPDATE `shidni_users` SET `password`=:password WHERE `username`=:username";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":password"=>md5($args["password"]),
			":username"=>$username
		));

		return true;
	}

}