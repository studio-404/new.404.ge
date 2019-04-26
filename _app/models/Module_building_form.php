<?php 

class Module_building_form
{
	public $type;
	public $language;
	public $map_coordinates;
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

	private function input_select($selectedName, $id, $list, $selected=0)
	{
		$out = "<div class=\"col-md-6\">"; 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $selectedName); 
		$out .= sprintf("<select class=\"form-control %s\" style=\"padding:0 10px\">", $id);
		foreach($list as $v):
		$selected_ = ($v["id"]==$selected) ? ' selected="selected"' : '';
		$out .= sprintf(
			"<option value=\"%d\"%s>%s</option>",
			$v["id"],
			$selected_,
			$v["title"]
		);
		endforeach;		
		$out .= "</select>";
		$out .= "</div>";
		$out .= "</div>";

		return $out;
	}

	public function index()
	{
		if($this->type=="edit"){
			$Database = new Database("db_building", array(
				"method"=>"selectBuildingById",
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$company_id = $fetch["company_id"];
			$title = $fetch["title"];
			$address = $fetch["address"];
			$this->map_coordinates = $fetch["map_coordinates"];
			$submitText = "რედაქტირება";
			$submitClass = "editBuilding";			
		}else{
			$company_id = "";
			$title = "";
			$address = "";
			$this->map_coordinates = "41.7003244,44.87244";
			$submitText = "დამატება";
			$submitClass = "addBuilding";			
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"buildingsFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("დასახელება", "title", htmlentities($title));
		$this->out .= $this->input("მისამართი", "address", htmlentities($address));

		$Countries = new Database("db_companies", array(
			"method"=>"selectOnlyOwn",
			"own_company"=>$_SESSION["user_data"]["own_company"]
		));
		$this->out .= $this->input_select(
			"აირჩიეთ კომპანია", 
			"choose_company", 
			$Countries->getter(),
			$company_id
		);

		$this->out .= $this->input("Map კოორდინატები", "map_coordinates", $this->map_coordinates, true, 6);
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div id=\"map-canvas\"></div>";
		$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-12\">"; 
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= sprintf("<div class=\"update ml-auto mr-auto\">
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\" data-editid=\"%d\">%s</button>
                    </div>", $submitClass, (int)$this->editId, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}
}