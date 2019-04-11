<?php 

class ajax_users
{
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'select':
				return $this->select($request, $language);
				break;
			case 'addUser':
				return $this->addUser($request, $language);
				break;
			case 'editUser':
				return $this->editUser($request, $language);
				break;
			case 'deleteUser':
				return $this->deleteUser($request, $language);
				break;
			case 'editUserPassword':
				return $this->editUserPassword($request, $language);
				break;
			case 'update':
				return $this->update($request, $language);
				break;
			case 'updatepassword':
				return $this->updatepassword($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function deleteUser($request, $language)
	{
		if(!isset($_SESSION["user_data"]["user_type"]) || $_SESSION["user_data"]["user_type"]!="manager"){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ აღნიშნული ოპერაციის უფლება!"
			);
			return $this->message;
			exit;
		}

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
		}else{
			$Database = new Database("db_users", array(
				"method"=>"deleteUser",
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

	private function editUserPassword($request, $language)
	{
		if(!isset($_SESSION["user_data"]["user_type"]) || $_SESSION["user_data"]["user_type"]!="manager"){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ აღნიშნული ოპერაციის უფლება!"
			);
			return $this->message;
			exit;
		}

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
		}else if(!preg_match('/^[0-9A-Za-z!@#$%]{6,12}$/', $request->index("POST", "newpassword"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"პაროლი უნდა შედგებოდეს 6-12 სიმბოლოსგან და არ უნდა შეიცავდეს არა ლეგალურ სიმბოლოებს!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_users", array(
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

	private function editUser($request, $language)
	{
		if(!isset($_SESSION["user_data"]["user_type"]) || $_SESSION["user_data"]["user_type"]!="manager"){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ აღნიშნული ოპერაციის უფლება!"
			);
			return $this->message;
			exit;
		}

		if(
			!$request->index("POST", "editid") || 
			!$request->index("POST", "firstname") || 
			!$request->index("POST", "lastname") || 
			!$request->index("POST", "username") || 
			!$request->index("POST", "contact_email") || 
			!$request->index("POST", "contact_phone") || 
			!$request->index("POST", "user_type") 
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
				"method"=>"edit",
				"id"=>(int)$request->index("POST", "editid"),
				"firstname"=>$request->index("POST", "firstname"),
				"lastname"=>$request->index("POST", "lastname"),
				"contact_email"=>$request->index("POST", "contact_email"),
				"contact_phone"=>$request->index("POST", "contact_phone"),
				"user_type"=>$request->index("POST", "user_type"),
				"permission_company"=>$request->index("POST", "permission_company"),
				"permission_buldings"=>$request->index("POST", "permission_buldings"),
				"permission_entrance"=>$request->index("POST", "permission_entrance"),
				"permission_floor"=>$request->index("POST", "permission_floor"),
				"permission_room"=>$request->index("POST", "permission_room")
			));

			$db_users = new Database("db_users", array(
				"method"=>"selectUserByUsername",
				"username"=>$_SESSION["user_data"]["username"]
			));

			$getter = $db_users->getter();
			if($getter){
				$_SESSION["user_data"] = $getter;
			}

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

	private function addUser($request, $language)
	{
		if(!isset($_SESSION["user_data"]["user_type"]) || $_SESSION["user_data"]["user_type"]!="manager"){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ აღნიშნული ოპერაციის უფლება!"
			);
			return $this->message;
			exit;
		}

		if(
			!$request->index("POST", "firstname") || 
			!$request->index("POST", "lastname") || 
			!$request->index("POST", "username") || 
			!$request->index("POST", "password") || 
			!$request->index("POST", "contact_email") || 
			!$request->index("POST", "contact_phone") || 
			!$request->index("POST", "user_type") 
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[0-9A-Za-z!@#$%]{6,12}$/', $request->index("POST", "password"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"პაროლი უნდა შედგებოდეს 6-12 სიმბოლოსგან და არ უნდა შეიცავდეს არა ლეგალურ სიმბოლოებს!"
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
				"method"=>"add",
				"firstname"=>$request->index("POST", "firstname"),
				"lastname"=>$request->index("POST", "lastname"),
				"username"=>$request->index("POST", "username"),
				"password"=>$request->index("POST", "password"),
				"contact_email"=>$request->index("POST", "contact_email"),
				"contact_phone"=>$request->index("POST", "contact_phone"),
				"user_type"=>$request->index("POST", "user_type"),
				"permission_company"=>$request->index("POST", "permission_company"),
				"permission_buldings"=>$request->index("POST", "permission_buldings"),
				"permission_entrance"=>$request->index("POST", "permission_entrance"),
				"permission_floor"=>$request->index("POST", "permission_floor"),
				"permission_room"=>$request->index("POST", "permission_room")
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
		if(!isset($_SESSION["user_data"]["user_type"]) || $_SESSION["user_data"]["user_type"]!="manager"){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ აღნიშნული ოპერაციის უფლება!"
			);
			return $this->message;
			exit;
		}

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

	private function updatepassword($request, $language)
	{
		if(!isset($_SESSION["user_data"]["user_type"]) || $_SESSION["user_data"]["user_type"]!="manager"){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ აღნიშნული ოპერაციის უფლება!"
			);
			return $this->message;
			exit;
		}
		
		if(
			!$request->index("POST", "oldpassword") || 
			!$request->index("POST", "newpassword") || 
			!$request->index("POST", "confirmpassword")
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else{
			$username = (isset($_SESSION["user_data"]["username"])) ? $_SESSION["user_data"]["username"] : "";
			$Database = new Database("db_users", array(
				"method"=>"checkifuserexists",
				"username"=>$username,
				"password"=>$request->index("POST", "oldpassword")
			));

			if($Database->getter()){

				if(
					$request->index("POST", "newpassword")!==$request->index("POST", "confirmpassword")
				){
					http_response_code(400);
					$this->message = array(
						"error"=>true,
						"success"=>false,
						"message"=>"პაროლები არ ემტხვევა ერთმანეთს!"
					);
					return $this->message;
					exit;
				}else if(!preg_match('/^[0-9A-Za-z!@#$%]{6,12}$/', $request->index("POST", "newpassword"))) {
				   http_response_code(400);
					$this->message = array(
						"error"=>true,
						"success"=>false,
						"message"=>"პაროლი უნდა შედგებოდეს 6-12 სიმბოლოსგან და არ უნდა შეიცავდეს არა ლეგალურ სიმბოლოებს!"
					);
					return $this->message;
					exit;
				}else{
					$Database = new Database("db_users", array(
						"method"=>"updatepassword",
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
			}else{
				http_response_code(400);
				$this->message = array(
					"error"=>true,
					"success"=>false,
					"message"=>"ძველი პაროლი არასწორია!"
				);
				return $this->message;
				exit;
			}
			
		}
	}

	private function select($request, $language)
	{
		if(
			!isset($_SESSION['captchaimg']) || 
			!$request->index("POST", "code") || 
			!$request->index("POST", "type") || 
			!$request->index("POST", "username") || 
			!$request->index("POST", "password") 
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else if(!isset($_SESSION['captchaimg']) || $_SESSION['captchaimg']!==$request->index("POST", "code")){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"დამცავი კოდი არასწორია!"
			);
			return $this->message;
			exit;
		}else if($request->index("POST", "type")==="select"){
			$Database = new Database("db_users", array(
				"method"=>"checkifuserexists",
				"username"=>$request->index("POST", "username"),
				"password"=>$request->index("POST", "password")
			));
			$getter = $Database->getter();

			if($getter){
				$_SESSION["user_data"] = $getter;

				if(!isset($Functions)){ $Functions = new Functions; }
				$log = $Functions->load("fu_log");
				$log->insert(
					"users",
					"logged",
					$_SESSION["user_data"]["id"]
				);
				
				$this->message = array(
					"error"=>false,
					"success"=>true,
					"message"=>"ოპერაცია წარმატებით შესრულდა!"
				);
				http_response_code(200);
			}else{
				$this->message = array(
					"error"=>true,
					"success"=>false,
					"message"=>"მომხმარებლის სახელი ან პაროლი არასწორია!"
				);
				http_response_code(400);
			}

			return $this->message;
			exit;
		}
	}
}