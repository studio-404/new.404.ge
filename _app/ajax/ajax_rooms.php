<?php 

class ajax_rooms
{
	public $message = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
	public function output($language)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");

		switch ($request->index("POST", "type")) {
			case 'addRoom':
				return $this->addRoom($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	
	private function addRoom($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_room", "add")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ დამატების უფლება!"
			);
			return $this->message;
			exit;
		}else if(
			!$request->index("POST", "building_id") ||
			!$request->index("POST", "entrance_id") || 
			!$request->index("POST", "floor_id") || 
			!$request->index("POST", "title") || 
			!$request->index("POST", "rooms") || 
			!$request->index("POST", "bedroom") || 
			!$request->index("POST", "bathrooms") || 
			!$request->index("POST", "square") || 
			!$request->index("POST", "ceil_height") || 
			!$request->index("POST", "description") 
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
			$Database = new Database("db_room", array(
				"method"=>"add",
				"building_id"=>$request->index("POST", "building_id"),
				"entrance_id"=>$request->index("POST", "entrance_id"),  
				"floor_id"=>$request->index("POST", "floor_id"),  
				"title"=>$request->index("POST", "title"),  
				"rooms"=>$request->index("POST", "rooms"),  
				"bedroom"=>$request->index("POST", "bedroom"),  
				"bathrooms"=>$request->index("POST", "bathrooms"),  
				"square"=>$request->index("POST", "square"),  
				"ceil_height"=>$request->index("POST", "ceil_height"),  
				"addInfo"=>$request->index("POST", "addInfo"),  
				"description"=>$request->index("POST", "description")  
			));

			$this->message = array(
				"error"=>false,
				"success"=>true,
				"message"=>"ოპერაცია წარმატებით შესრულდა!",
				"insertedId"=>$Database->getter()
			);
			http_response_code(200);

			return $this->message;
			exit;
		}
	}

}
