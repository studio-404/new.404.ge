<?php 

class ajax_rooms
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
			case 'addRoom':
				return $this->addRoom($request, $language);
				break;
			case 'removePhoto':
				return $this->removePhoto($request, $language);
				break;
			case 'editRoom':
				return $this->editRoom($request, $language);
				break;
			case 'deleteRoom':
				return $this->deleteRoom($request, $language);
				break;
		}

		http_response_code(404);
		return $this->message;
	}

	private function deleteRoom($request, $language)
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
		}else if(!$permition->check("permission_room", "delete")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ წაშლის უფლება!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_room", array(
				"method"=>"deleteRoom",
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

	private function removePhoto($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_room", "edit")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ რედაქტირების უფლება!"
			);
			return $this->message;
			exit;
		}else if(!$request->index("POST", "id")){
			http_response_code(400);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"ყველა ველი სავალდებულოა!"
			);
			return $this->message;
			exit;
		}else{
			$Database = new Database("db_photos", array(
				"method"=>"deletePhoto",
				"id"=>$request->index("POST", "id"), 
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
			!$request->index("POST", "choose_status") || 
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
				"available_status"=>$request->index("POST", "choose_status"),  
				"totalprice"=>(int)$request->index("POST", "totalprice"),  
				"pre_pay"=>(int)$request->index("POST", "pre_pay"),  
				"paying_start_day"=>$request->index("POST", "paying_start_day"),  
				"installment_months"=>(int)$request->index("POST", "installment_months"),  
				"addInfo"=>$request->index("POST", "addInfo"),  
				"payed_months"=>$request->index("POST", "payed_months"),  
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

	private function editRoom($request, $language)
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");
		
		if(!$permition->check("permission_room", "edit")){
			http_response_code(401);
			$this->message = array(
				"error"=>true,
				"success"=>false,
				"message"=>"თქვენ არ გაქვთ რედაქტირების უფლება!"
			);
			return $this->message;
			exit;
		}else if(
			!$request->index("POST", "id") ||
			!$request->index("POST", "building_id") ||
			!$request->index("POST", "entrance_id") || 
			!$request->index("POST", "floor_id") || 
			!$request->index("POST", "title") || 
			!$request->index("POST", "rooms") || 
			!$request->index("POST", "bedroom") || 
			!$request->index("POST", "bathrooms") || 
			!$request->index("POST", "square") || 
			!$request->index("POST", "ceil_height") || 
			!$request->index("POST", "choose_status") || 
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
				"method"=>"edit",
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
				"payed_months"=>$request->index("POST", "payed_months"),  
				"available_status"=>$request->index("POST", "choose_status"),  
				"totalprice"=>(int)$request->index("POST", "totalprice"),  
				"pre_pay"=>(int)$request->index("POST", "pre_pay"),  
				"paying_start_day"=>$request->index("POST", "paying_start_day"),  
				"installment_months"=>(int)$request->index("POST", "installment_months"), 
				"description"=>$request->index("POST", "description"),  
				"id"=>$request->index("POST", "id")
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
