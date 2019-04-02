<?php 

class Module_floor_form
{
	public $type;
	public $language;
	public $building_id = 0;
	public $entrance_id = 0;
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

	public function index()
	{
		if($this->type=="edit"){
			$Database = new Database("db_floor", array(
				"method"=>"selectFloorById",
				"building_id"=>$this->building_id,
				"entrance_id"=>$this->entrance_id,
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$title = $fetch["title"];
			$submitText = "რედაქტირება";
			$submitClass = "editFloor";			
		}else{
			$title = "";
			$submitText = "დამატება";
			$submitClass = "addFloor";			
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"floorFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("დასახელება", "title", htmlentities($title), false, 12);		
		

		$this->out .= "<div class=\"col-md-12\">"; 
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= sprintf("<div class=\"update ml-auto mr-auto\">
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\" data-editid=\"%d\" data-building=\"%d\" data-entrance=\"%d\">%s</button>
                    </div>", $submitClass, (int)$this->editId, (int)$this->building_id, (int)$this->entrance_id, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}
}