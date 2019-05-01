<?php 

class fu_checkusernames
{
	public $out;
	public function exists($username)
	{
		$this->out = false;

		$db_users = new Database("db_users", array(
			"method"=>"selectUserByUsername",
			"username"=>$username
		));

		if(count($db_users->getter())){
			$this->out = true;
		}

		$db_owners = new Database("db_owners", array(
			"method"=>"selectOwnerByUsername",
			"owners_name"=>$username
		));

		if(count($db_owners->getter())){
			$this->out = true;
		}


		return $this->out;
	}

	public function sign($username, $password){
		$this->out = false;

		$db_owners = new Database("db_owners", array(
			"method"=>"selectOwnerByUsernamePassword",
			"owners_name"=>$username,
			"owners_password"=>$password
		));

		if(count($db_owners->getter())){
			$this->out = true;
		}

		return $this->out;
	}
}