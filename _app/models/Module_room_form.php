<?php 

class Module_room_form
{
	public $type;
	public $language;
	public $building_id = 0;
	public $entrance_id = 0;
	public $floor_id = 0;
	public $editId = 0;
	public $out = '';

	public function __construct()
	{
		
	}

	private function input($label, $className, $value, $readonly = false, $cols = 6){
		$out = sprintf("<div class=\"col-md-%d\">", $cols); 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $label); 
		$readonly = ($readonly) ? ' readonly="readonly"' : '';
		$out .= sprintf(
			"<input type=\"text\" class=\"form-control %s\" value=\"%s\" autocomplete=\"off\"%s />",
			$className,
			htmlentities($value),
			$readonly
		); 
		$out .= "</div>"; 
		$out .= "</div>"; 
		return $out;
	}

	private function checkbox($className, $checked, $name, $val = 1)
	{
		$out = "<div class=\"col-md-4\">";
		$out .= "<div class=\"form-check\">";
        $out .= "<label class=\"form-check-label\">";

        $checked = ($checked) ? 'checked="checked"' : '';
        $out .= sprintf("<input class=\"form-check-input additional_info\" data-column=\"%s\" type=\"checkbox\" %s value=\"%s\">", $className, $checked, $val);
        $out .= sprintf("%s <span class=\"form-check-sign\"></span>", $name);

        $out .= "</label>";
        $out .= "</div>";        
        $out .= "</div>";        

        return $out;
	}

	public function index()
	{
		if($this->type=="edit"){
			$Database = new Database("db_room", array(
				"method"=>"selectRoomById",
				"building_id"=>$this->building_id,
				"entrance_id"=>$this->entrance_id,
				"floor_id"=>$this->floor_id,
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$title = $fetch["title"];
			$rooms = $fetch["rooms"];
			$bedroom = $fetch["bedroom"];
			$bathrooms = $fetch["bathrooms"];
			$square = $fetch["square"];
			$ceil_height = $fetch["ceil_height"];

			$natural_air = $fetch["natural_air"];
			$central_hitting = $fetch["central_hitting"];
			$tv_cable = $fetch["tv_cable"];
			$internet = $fetch["internet"];
			$washing_machine = $fetch["washing_machine"];
			$verandah = $fetch["verandah"];
			$balcony = $fetch["balcony"];
			$phone = $fetch["phone"];
			$tv = $fetch["tv"];
			$parking = $fetch["parking"];
			$iron_door = $fetch["iron_door"];
			$storeroom = $fetch["storeroom"];
			$alarms = $fetch["alarms"];
			$furniture = $fetch["furniture"];
			$fridge = $fetch["fridge"];
			$elevator = $fetch["elevator"];
			$description = $fetch["description"];

			$submitText = "რედაქტირება";
			$submitClass = "editRoom";			
		}else{
			$title = "";
			$rooms = "";
			$bedroom = "";
			$bathrooms = "";
			$square = "";
			$ceil_height = "";
			
			$natural_air = 0;
			$central_hitting = 0;
			$tv_cable = 0;
			$internet = 0;
			$washing_machine = 0;
			$verandah = 0;
			$balcony = 0;
			$phone = 0;
			$tv = 0;
			$parking = 0;
			$iron_door = 0;
			$storeroom = 0;
			$alarms = 0;
			$furniture = 0;
			$fridge = 0;
			$elevator = 0;
			$description = 0;
			$submitText = "დამატება";
			$submitClass = "addRoom";			
		}
		$this->out .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" id=\"roomsForm\">";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"roomFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("დასახელება", "title", htmlentities($title), false, 12);
		$this->out .= $this->input("ოთახი", "rooms", htmlentities($rooms), false, 4);
		$this->out .= $this->input("საძინებელი", "bedroom", htmlentities($bedroom), false, 4);
		$this->out .= $this->input("სააბაზანო", "bathrooms", htmlentities($bathrooms), false, 4);
		$this->out .= $this->input("კვ.მ.", "square", htmlentities($square), false, 6);
		$this->out .= $this->input("ჭერის სიმაღლე", "ceil_height", htmlentities($ceil_height), false, 6);



		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"typography-line\"><h6>დამატებითი ინფორმაცია</h6></div>";
		$this->out .= "</div>";
		$this->out .= $this->checkbox("natural_air", $natural_air, "ბუნებრივი აირი", 1);
		$this->out .= $this->checkbox("central_hitting", $central_hitting, "ცენტრალური გათბობა", 1);
		$this->out .= $this->checkbox("tv_cable", $tv_cable, "ტელევიზია", 1);
		$this->out .= $this->checkbox("internet", $internet, "ინტერნეტი", 1);
		$this->out .= $this->checkbox("washing_machine", $washing_machine, "სარეცხი მანქანა", 1);
		$this->out .= $this->checkbox("verandah", $verandah, "ვერანდა", 1);
		$this->out .= $this->checkbox("balcony", $balcony, "აივანი", 1);
		$this->out .= $this->checkbox("phone", $phone, "ტელეფონი", 1);
		$this->out .= $this->checkbox("tv", $tv, "ტელევიზორი", 1);
		$this->out .= $this->checkbox("parking", $parking, "პარკინგი", 1);
		$this->out .= $this->checkbox("iron_door", $iron_door, "რკინის კარი", 1);
		$this->out .= $this->checkbox("storeroom", $storeroom, "სათავსო", 1);
		$this->out .= $this->checkbox("alarms", $alarms, "სიგნალიზაცია", 1);
		$this->out .= $this->checkbox("furniture", $furniture, "ავეჯი", 1);
		$this->out .= $this->checkbox("fridge", $fridge, "მაცივარი", 1);
		$this->out .= $this->checkbox("elevator", $elevator, "ლიფტი", 1);
		
		
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= "<label>ფოტო (jpg, png, gif, jpeg) <5mb</label>"; 
		
		$this->out .= "<div class=\"filex_box\">"; 
		$this->out .= "<input type=\"file\" name=\"files[]\" class=\"form-control files\" value=\"\" style=\"height:1px\" />"; 
		$this->out .= "</div>";

		// $this->out .= "<div class=\"row\">";
		$this->out .= "<div class=\"filex_photos\">";
		$this->out .= "<div class=\"row\">";
		$this->out .= "<div class=\"col-md-2\"><span class=\"photo_upload\">ატვირთვა</span></div>"; 
		$this->out .= "</div>";
		$this->out .= "</div>";
		// $this->out .= "</div>";

		$this->out .= "</div>";
		$this->out .= "</div>";	
		
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= "<label>აღწერა</label>"; 
		$this->out .= "<textarea name=\"description\" class=\"form-control description\"></textarea>"; 
		$this->out .= "</div>";
		$this->out .= "</div>";		
		

		$this->out .= "<div class=\"col-md-12\">"; 
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= sprintf("<div class=\"update ml-auto mr-auto\">
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\" data-editid=\"%d\" data-building=\"%d\" data-entrance=\"%d\" data-floor=\"%d\">%s</button>
                    </div>", $submitClass, (int)$this->editId, (int)$this->building_id, (int)$this->entrance_id, (int)$this->floor_id, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}
}