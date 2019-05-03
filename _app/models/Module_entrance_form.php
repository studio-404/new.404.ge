<?php 

class Module_entrance_form
{
	public $type;
	public $language;
	public $building_id = 0;
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
		$bulding = new Database("db_building", array(
			"method"=>"selectBuildingById",
			"id"=>$this->building_id
		));

		if(!$bulding->getter()){
			die("Opps permition denied...");
		}

		if($this->type=="edit"){
			$Database = new Database("db_entrance", array(
				"method"=>"selectEntranceById",
				"building_id"=>$this->building_id,
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$title = $fetch["title"];
			$submitText = "რედაქტირება";
			$submitClass = "editEntrance";			
		}else{
			$title = "";
			$submitText = "დამატება";
			$submitClass = "addEntrance";			
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"entranceFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("დასახელება", "title", htmlentities($title), false, 12);		
		

		$this->out .= "<div class=\"col-md-12\">"; 
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= sprintf("<div class=\"update ml-auto mr-auto\">
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\" data-editid=\"%d\" data-building=\"%d\">%s</button>
                    </div>", $submitClass, (int)$this->editId, (int)$this->building_id, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}
}