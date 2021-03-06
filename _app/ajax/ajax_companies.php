<?php 

class ajax_companies
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
			case 'addCompany':
				return $this->addCompany($request, $language);
				break;
			case 'editCompany':
				return $this->editCompany($request, $language);
				break;
			case 'deleteCompany':
				return $this->deleteCompany($request, $language);
				break;
			case 'update':
				return $this->update($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function deleteCompany($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");

		if(
			!$request->index("POST", "id")
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!$permition->check("permission_company", "delete")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ წაშლის უფლება!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_companies", array(
				"method"=>"deleteCompany",
				"id"=>$request->index("POST", "id")
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

	private function editCompany($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");

		if(!$permition->check("permission_company", "edit")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ განახლების უფლება!"
			);
			return $this->message;
			exit;
		}else if(
			!$request->index("POST", "editid") || 
			!$request->index("POST", "title") || 
			!$request->index("POST", "identity") || 
			!$request->index("POST", "contact_phone") || 
			!$request->index("POST", "contact_email") || 
			!$request->index("POST", "address") || 
			!$request->index("POST", "website") 
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $request->index("POST", "contact_email"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ გადაამოწმოთ ელ-ფოსტის ველი!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_companies", array(
				"method"=>"edit",
				"id"=>(int)$request->index("POST", "editid"),
				"title"=>$request->index("POST", "title"),
				"identity"=>$request->index("POST", "identity"),
				"contact_phone"=>$request->index("POST", "contact_phone"),
				"contact_email"=>$request->index("POST", "contact_email"),
				"address"=>$request->index("POST", "address"),
				"website"=>$request->index("POST", "website")
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

	private function addCompany($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_company", "add")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ დამატების უფლება!"
			);
			return $this->message;
			exit;
		}else if(
			!$request->index("POST", "title") || 
			!$request->index("POST", "identity") || 
			!$request->index("POST", "contact_phone") || 
			!$request->index("POST", "contact_email") || 
			!$request->index("POST", "address") || 
			!$request->index("POST", "website")  
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $request->index("POST", "contact_email"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ გადაამოწმოთ ელ-ფოსტის ველი!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_companies", array(
				"method"=>"add",
				"title"=>$request->index("POST", "title"),
				"identity"=>$request->index("POST", "identity"),
				"contact_phone"=>$request->index("POST", "contact_phone"),
				"contact_email"=>$request->index("POST", "contact_email"),
				"address"=>$request->index("POST", "address"),
				"website"=>$request->index("POST", "website")
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

	private function update($request, $language)
	{
		if(
			!$request->index("POST", "firstname") || 
			!$request->index("POST", "lastname") || 
			!$request->index("POST", "contact_email") || 
			!$request->index("POST", "contact_phone") 
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $request->index("POST", "contact_email"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ გადაამოწმოთ ელ-ფოსტის ველი!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_users", array(
				"method"=>"update",
				"firstname"=>$request->index("POST", "firstname"),
				"lastname"=>$request->index("POST", "lastname"),
				"contact_email"=>$request->index("POST", "contact_email"),
				"contact_phone"=>$request->index("POST", "contact_phone")
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