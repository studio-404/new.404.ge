<?php 

class ajax_floors
{
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'addFloor':
				return $this->addFloor($request, $language);
				break;
			case 'editFloor':
				return $this->editFloor($request, $language);
				break;
			case 'deleteFloor':
				return $this->deleteFloor($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function deleteFloor($request, $language)
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
		}else if(!$permition->check("permission_floor", "delete")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ წაშლის უფლება!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_floor", array(
				"method"=>"deleteFloor",
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

	private function editFloor($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_floor", "edit")){
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
			!$request->index("POST", "building_id") || 
			!$request->index("POST", "entrance_id")  
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
			$Database = new Database("db_floor", array(
				"method"=>"edit",
				"id"=>$request->index("POST", "editid"),
				"title"=>$request->index("POST", "title"),
				"building_id"=>$request->index("POST", "building_id"),
				"entrance_id"=>$request->index("POST", "entrance_id") 
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
	
	private function addFloor($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_floor", "add")){
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
			!$request->index("POST", "building_id") ||
			!$request->index("POST", "entrance_id") 
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
			$Database = new Database("db_floor", array(
				"method"=>"add",
				"title"=>$request->index("POST", "title"),
				"building_id"=>$request->index("POST", "building_id"),
				"entrance_id"=>$request->index("POST", "entrance_id") 
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
