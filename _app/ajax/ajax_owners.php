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
			case 'editOwner':
				return $this->editOwner($request, $language);
				break;
			case 'editOwnerPassword':
				return $this->editOwnerPassword($request, $language);
				break;
			case 'deleteOwner':
				return $this->deleteOwner($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function deleteOwner($request, $language)
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
		}else if(!$permition->check("permission_owner", "delete")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ წაშლის უფლება!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_owners", array(
				"method"=>"deleteOwner",
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

	private function editOwnerPassword($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");

		if(
			!$request->index("POST", "editid") || 
			!$request->index("POST", "newpassword") 
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!$permition->check("permission_owner", "edit")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ რედაქტირების უფლება!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[0-9A-Za-z!@#$%]{6,12}$/', $request->index("POST", "newpassword"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"პაროლი უნდა შედგებოდეს 6-12 სიმბოლოსგან [0-9A-Za-z!@#$%]"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_owners", array(
				"method"=>"changePassword",
				"id"=>$request->index("POST", "editid"),
				"password"=>$request->index("POST", "newpassword")
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

	private function editOwner($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");

		if(
			!$request->index("POST", "editid") || 
			!$request->index("POST", "firstname") || 
			!$request->index("POST", "lastname") || 
			!$request->index("POST", "owners_name") || 
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
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!$permition->check("permission_owner", "edit")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ რედაქტირების უფლება!"
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
				"method"=>"edit",
				"id"=>(int)$request->index("POST", "editid"),
				"firstname"=>$request->index("POST", "firstname"),
				"lastname"=>$request->index("POST", "lastname"),
				"owners_name"=>$request->index("POST", "owners_name"),
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

	private function addOwner($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		$checkusernames = $Functions->load("fu_checkusernames");

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
		}else if(!$permition->check("permission_owner", "add")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ დამატების უფლება!"
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
		}else if($checkusernames->exists($request->index("POST", "owners_name"))){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ შეცვალოთ მომხმარებლის სახელი, მომხმარებლი აღნიშნული სახელით უკვე არსებობს!"
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