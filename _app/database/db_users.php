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

	private function select($args)
	{
		$db_fetch = [];
		
		$select = "SELECT * FROM `shidni_users` WHERE `status`!=:one";
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