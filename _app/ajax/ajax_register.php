<?php 

class ajax_register
{
	
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'adduser':
				return $this->adduser($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function adduser($request, $language)
	{
		$Functions = new Functions();
		$checkusernames = $Functions->load("fu_checkusernames");
		$fu_email = $Functions->load("fu_email");

		if(
			!$request->index("POST", "firstname") || 
			!$request->index("POST", "lastname") || 
			!$request->index("POST", "username") || 
			!$request->index("POST", "password") || 
			!$request->index("POST", "contact_email") || 
			!$request->index("POST", "contact_phone") || 
			!$request->index("POST", "company_title") || 
			!$request->index("POST", "company_identity") || 
			!$request->index("POST", "code") 
		){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ შეავსოთ სავალდებულო ველები!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[0-9A-Za-z!@#$%]{6,12}$/', $request->index("POST", "password"))) {
		   	http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"პაროლი უნდა შედგებოდეს 6-12 სიმბოლოსგან. [0-9A-Za-z!@#$%]"
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
		}else if($checkusernames->exists($request->index("POST", "username"))){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"გთხოვთ შეცვალოთ მომხმარებლის სახელი, მომხმარებლი აღნიშნული სახელით უკვე არსებობს!"
			);
			return $this->message;
			exit;
		}else if(!preg_match('/^[\p{Latin}[A-Za-z]+$/', $request->index("POST", "username"))){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"მომხმარებლის სახელი უნდა შეიცავდეს მხოლოდ ლათინურ სიმბოლოებს [a-zA-Z]!"
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
		}else{
			//company add
			$title = $request->index("POST", "company_title");
			$identity = $request->index("POST", "company_identity");
			$contact_phone1 = $request->index("POST", "company_contact_number");
			$contact_email1 = $request->index("POST", "company_email");
			$address = $request->index("POST", "company_address");
			$website = $request->index("POST", "company_website");

			$companies = new Database("db_companies", array(
				"method"=>"add",
				"title"=>$title,
				"identity"=>$identity,
				"contact_phone"=>$contact_phone1,
				"contact_email"=>$contact_email1,
				"address"=>$address,
				"insert_admin"=>$request->index("POST", "username"),
				"website"=>$website,
				"nolog"=>true
			));

			$own_company = $companies->getter();

			//user add
			$firstname = $request->index("POST", "firstname");
			$lastname = $request->index("POST", "lastname");
			$username = $request->index("POST", "username");
			$password = $request->index("POST", "password");
			$contact_email2 = $request->index("POST", "contact_email");
			$contact_phone2 = $request->index("POST", "contact_phone");

			$users = new Database("db_users", array(
				"method"=>"add",
				"firstname"=>$firstname,
				"lastname"=>$lastname,
				"username"=>$username,
				"password"=>$password,
				"contact_email"=>$contact_email2,
				"contact_phone"=>$contact_phone2,
				"own_company"=>$own_company,
				"nolog"=>true
			));

			$content_url = sprintf(
				"%s/mail.php?username=%s&firstname=%s&lastname=%s&email=%s&phone=%s&ltd=%s&ltdcode=%s&phone2=%s&email2=%s&address=%s&website=%s",
				Config::WEBSITE,
				urlencode($username),
				urlencode($firstname),
				urlencode($lastname),
				urlencode($contact_email2),
				urlencode($contact_phone2),
				urlencode($title),
				urlencode($identity),
				urlencode($contact_phone1),
				urlencode($contact_email1),
				urlencode($address),
				urlencode($website)
			);

			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$content_url);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);

			if (!empty($buffer)){
			   $fu_email->send(array(
					"sendTo"=>array($request->index("POST", "contact_email"), Config::EMAIL_REC),
					"subject"=>"Kombosto რეგისტრაცია",
					"body"=>$buffer
				));
			}

			$ip = new Database("db_ip", array(
				"method"=>"add",
				"name"=>$firstname." ".$lastname,
				"ip"=>$_SERVER["REMOTE_ADDR"],
				"nologs"=>true
			));

			$this->message = array(
				"error"=>false,
				"success"=>true,
				"message"=>"გთხოვთ გადაამოწმოთ თქვენი ელ-ფოსტა (".$request->index("POST", "contact_email").")"
			);
			
			http_response_code(200);

			return $this->message;
			exit;
		}
	}
}