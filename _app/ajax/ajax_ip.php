<?php 

class ajax_ip
{
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'addIP':
				return $this->addIP($request, $language);
				break;
			case 'deleteIP':
				return $this->deleteIP($request, $language);
				break;
			case 'editIP':
				return $this->editIP($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function editIP($request, $language)
	{
		if(
			!$request->index("POST", "editid") || 
			!$request->index("POST", "name") || 
			!$request->index("POST", "ip")
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
			$Database = new Database("db_ip", array(
				"method"=>"edit",
				"id"=>$request->index("POST", "editid"),
				"name"=>$request->index("POST", "name"),
				"ip"=>$request->index("POST", "ip")
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

	private function addIP($request, $language)
	{
		if(
			!$request->index("POST", "name") || 
			!$request->index("POST", "ip") 
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
			$Database = new Database("db_ip", array(
				"method"=>"add",
				"name"=>$request->index("POST", "name"),
				"ip"=>$request->index("POST", "ip")
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

	private function deleteIP($request, $language)
	{
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
			$Database = new Database("db_ip", array(
				"method"=>"deleteIP",
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

}
