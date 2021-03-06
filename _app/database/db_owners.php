<?php 

class db_owners
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("db_owners", $args['method']))
		{
			$out = $this->$args['method']($args);
		}
		return $out;
	}

	private function search($args)
	{
		$db_fetch = [];

		if(isset($_SESSION["user_data"]["user_type"]) && $_SESSION["user_data"]["user_type"]=="manager"){
			$insert_admin = "";
		}else{
			$insert_admin = (isset($_SESSION["user_data"]["username"])) ? " AND `insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
		}
		
		$select = "SELECT `id`,`owners_name` FROM `shidni_oweners` WHERE `owners_name` LIKE '%".$args["key"]."%' AND `status`!=:one".$insert_admin;
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function deleteOwner($args)
	{
		if(isset($_SESSION["user_data"]["user_type"]) && $_SESSION["user_data"]["user_type"]=="manager"){
			$insert_admin = "";
		}else{
			$insert_admin = (isset($_SESSION["user_data"]["username"])) ? " AND `insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
		}

		$update = "UPDATE `shidni_oweners` SET 
		`status`=:one
		WHERE
		`id`=:id".$insert_admin;

		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":one"=>1,
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"owner",
			"deleteOwner",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function changePassword($args)
	{
		if(isset($_SESSION["user_data"]["user_type"]) && $_SESSION["user_data"]["user_type"]=="manager"){
			$insert_admin = "";
		}else{
			$insert_admin = (isset($_SESSION["user_data"]["username"])) ? " AND `insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
		}

		$update = "UPDATE `shidni_oweners` SET 
		`owners_password`=:owners_password
		WHERE
		`id`=:id".$insert_admin;

		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":owners_password"=>md5($args["password"]),
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"owner",
			"changePassword",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function select($args)
	{
		$db_fetch = [];
		$limit = '';
		if((int)$args["page"] > 0){
			$limit = ' LIMIT '.(($args["page"]-1) * Config::USER_LIST_PERPAGE).','.Config::USER_LIST_PERPAGE;
		}

		if(isset($_SESSION["user_data"]["user_type"]) && $_SESSION["user_data"]["user_type"]=="manager"){
			$insert_admin = "";
		}else{
			$insert_admin = (isset($_SESSION["user_data"]["username"])) ? " AND `shidni_oweners`.`insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
		}
		
		
		$select = "SELECT 
		(SELECT COUNT(`id`) FROM `shidni_oweners` WHERE `status`!=:one) as counted,
		`shidni_oweners`.* 
		FROM 
		`shidni_oweners` 
		WHERE 
		`shidni_oweners`.`status`!=:one".$insert_admin.$limit;
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectOwnerById($args)
	{
		$db_fetch = [];

		if(isset($_SESSION["user_data"]["user_type"]) && $_SESSION["user_data"]["user_type"]=="manager"){
			$insert_admin = "";
		}else{
			$insert_admin = (isset($_SESSION["user_data"]["username"])) ? " AND `insert_admin`='".$_SESSION["user_data"]["username"]."' " : "";
		}
		
		$select = "SELECT * FROM `shidni_oweners` WHERE `id`=:id AND `status`!=:one".$insert_admin;
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

	private function selectOwnerByUsername($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shidni_oweners` WHERE `owners_name`=:owners_name AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":owners_name"=>$args["owners_name"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function selectOwnerByUsernamePassword($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shidni_oweners` WHERE `owners_name`=:owners_name AND `owners_password`=:owners_password AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":owners_name"=>$args["owners_name"],
			":owners_password"=>md5($args["owners_password"]),
			":one"=>1
		));
		if($prepare->rowCount()){
			$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}		

		return $db_fetch;
	}

	private function edit($args)
	{
		$update = "UPDATE `shidni_oweners` SET 
		`firstname`=:firstname,
		`lastname`=:lastname,
		`owners_name`=:owners_name,
		`owners_id`=:owners_id,
		`owners_birthday`=:owners_birthday,
		`owners_gender`=:owners_gender,
		`owners_phone`=:owners_phone,
		`owners_phone2`=:owners_phone2,
		`owners_email`=:owners_email
		WHERE
		`id`=:id
		";

		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":firstname"=>$args["firstname"],
			":lastname"=>$args["lastname"],
			":owners_name"=>$args["owners_name"],
			":owners_id"=>$args["owners_id"],
			":owners_birthday"=>$args["owners_birthday"],
			":owners_gender"=>$args["owners_gender"],
			":owners_phone"=>$args["owners_phone"],
			":owners_phone2"=>$args["owners_phone2"],
			":owners_email"=>$args["owners_email"],
			":id"=>(int)$args["id"]
		));

		if(!isset($Functions)){ $Functions = new Functions; }
		$log = $Functions->load("fu_log");
		$log->insert(
			"owener",
			"edit",
			$_SESSION["user_data"]["id"]
		);

		return true;
	}

	private function add($args)
	{
		$insert_admin = (isset($_SESSION["user_data"]["username"])) ? $_SESSION["user_data"]["username"] : "";
		
		$insert = "INSERT INTO `shidni_oweners` SET 
		`insert_admin`=:insert_admin,
		`created_time`=:created_time,
		`firstname`=:firstname,
		`lastname`=:lastname,
		`owners_name`=:owners_name,
		`owners_password`=:owners_password,
		`owners_id`=:owners_id,
		`owners_birthday`=:owners_birthday,
		`owners_gender`=:owners_gender,
		`owners_phone`=:owners_phone,
		`owners_phone2`=:owners_phone2,
		`owners_email`=:owners_email";

		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":created_time"=>time(),
			":insert_admin"=>$insert_admin,
			":firstname"=>$args["firstname"],
			":lastname"=>$args["lastname"],
			":owners_name"=>$args["owners_name"],
			":owners_password"=>md5($args["owners_password"]),
			":owners_id"=>$args["owners_id"],
			":owners_birthday"=>$args["owners_birthday"],
			":owners_gender"=>$args["owners_gender"],
			":owners_phone"=>$args["owners_phone"],
			":owners_phone2"=>$args["owners_phone2"],
			":owners_email"=>$args["owners_email"]
		));

		return true;
	}

}