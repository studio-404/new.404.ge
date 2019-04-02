<?php 

class ajax_entrance
{
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'addEntrance':
				return $this->addEntrance($request, $language);
				break;
			case 'deleteEntrance':
				return $this->deleteEntrance($request, $language);
				break;
			case 'editEntrance':
				return $this->editEntrance($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}
	
	private function editEntrance($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_entrance", "edit")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ რედაქტირების უფლება!"
			);
			return $this->message;
			exit;
		}else if(
			!$request->index("POST", "editid") || 
			!$request->index("POST", "title") || 
			!$request->index("POST", "building")
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
			$Database = new Database("db_entrance", array(
				"method"=>"edit",
				"id"=>$request->index("POST", "editid"),
				"title"=>$request->index("POST", "title"),
				"building_id"=>$request->index("POST", "building")
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

	private function deleteEntrance($request, $language)
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
		}else if(!$permition->check("permission_entrance", "delete")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ წაშლის უფლება!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_entrance", array(
				"method"=>"deleteEntrance",
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

	private function addEntrance($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_entrance", "add")){
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
			!$request->index("POST", "building") 
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
			$Database = new Database("db_entrance", array(
				"method"=>"add",
				"title"=>$request->index("POST", "title"),
				"building_id"=>$request->index("POST", "building")
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
