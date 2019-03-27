<?php 

class ajax_users
{
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

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

		http_response_code(404);
		return $this->message;
	}
}