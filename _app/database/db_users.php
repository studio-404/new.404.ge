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
}