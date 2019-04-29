<?php 

class ajax_owners
{
	public function __construct()
	{
		$IP = new Database("db_ip", array(
			"method"=>"select",
			"page"=>0,
			"noLimit"=>true
		));
		$fetchIps = $IP->getter();
		$allow = array();
		foreach ($fetchIps as $v) {
			$allow[] = $v["ip"];
		}

		if(!in_array($_SERVER["REMOTE_ADDR"], $allow)){ 
			die("Your Ip Address <b>(".$_SERVER["REMOTE_ADDR"].")</b> is not allowed. Please contact your administrator."); 
			exit; 
		}
	}
	
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'addOwner':
				return $this->addOwner($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function addOwner($request, $language)
	{
		if(
			!$request->index("POST", "firstname") || 
			!$request->index("POST", "lastname") || 
			!$request->index("POST", "owners_name") || 
			!$request->index("POST", "owners_password") || 
			!$request->index("POST", "owners_id") || 
			!$request->index("POST", "owners_birthday") || 
			!$request->index("POST", "owners_gender")  || 
			!$request->index("POST", "owners_phone")  || 
			!$request->index("POST", "owners_email")
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ შეავსოთ სავალდებულო ველები!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[0-9A-Za-z!@#$%]{6,12}$/', $request->index("POST", "owners_password"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"პაროლი უნდა შედგებოდეს 6-12 სიმბოლოსგან. [0-9A-Za-z!@#$%]"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $request->index("POST", "owners_email"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ გადაამოწმოთ ელ-ფოსტის ველი!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_owners", array(
				"method"=>"add",
				"firstname"=>$request->index("POST", "firstname"),
				"lastname"=>$request->index("POST", "lastname"),
				"owners_name"=>$request->index("POST", "owners_name"),
				"owners_password"=>$request->index("POST", "owners_password"),
				"owners_id"=>$request->index("POST", "owners_id"),
				"owners_birthday"=>$request->index("POST", "owners_birthday"),
				"owners_gender"=>$request->index("POST", "owners_gender"),
				"owners_phone"=>$request->index("POST", "owners_phone"),
				"owners_phone2"=>$request->index("POST", "owners_phone2"),
				"owners_email"=>$request->index("POST", "owners_email")
			));

			$this->message = array(
				"error"=>false,
				"success"=>true,
				"message"=>"ოპერაცია წარმატებით შესრულდა!"
			);
			http_response_code(200);

			return $this->message;
			exit;
		}
	}
}