<?php 

class Module_owners_form
{
	public $type;
	public $language;
	public $editId = 0;
	public $out = '';

	public function __construct()
	{
		
	}

	private function input($label, $className, $value, $disable = false, $input_type = "text")
	{
		$out = "<div class=\"col-md-6\">"; 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $label); 
		$disable = ($disable) ? ' disabled="disabled"' : '';
		$out .= sprintf(
			"<input type=\"%s\" class=\"form-control %s\" value=\"%s\" autocomplete=\"off\" %s />",
			$input_type,
			$className,
			htmlentities($value),
			$disable
		); 
		$out .= "</div>"; 
		$out .= "</div>"; 
		return $out;
	}

	private function checkbox($className, $checked, $name, $val = 1)
	{
		$out = "<div class=\"form-check\">";
        $out .= "<label class=\"form-check-label\">";

        $checked = ($checked) ? 'checked="checked"' : '';
        $out .= sprintf(
        	"<input class=\"form-check-input %s\" name=\"%s\" type=\"checkbox\" %s value=\"%s\">", 
        	$className, 
        	$className, 
        	$checked, 
        	$val
        );
        $out .= sprintf("%s <span class=\"form-check-sign\"></span>", $name);

        $out .= "</label>";
        $out .= "</div>";        

        return $out;
	}

	private function select($label, $className, $list, $selected = [])
	{
		$out = "<div class=\"col-md-12\">"; 
		$out .= sprintf("<label>%s</label>", $label); 

		$out .= "<div class=\"selectpicker\">";
		foreach ($list as $key => $item):
			$checked = ($key==$selected) ? true : false;
			$out .= $this->checkbox($className, $checked, $list[$key], $key);
		endforeach;
		$out .= "</div>";
		
		$out .= "</div>"; 
		return $out;
	}

	private function radio($radioName, $value, $text, $checked = false)
	{
		$out = "<div class=\"form-check-radio\">";
       	$out .= "<label class=\"form-check-label\">";
        
        $checked = ($checked) ? 'checked="checked"' : '';
        $out .= sprintf(
        	"<input class=\"form-check-input %s\" type=\"radio\" name=\"%s\" value=\"%s\" %s/> %s",
        	$radioName,
        	$radioName,
        	$value,
        	$checked,
        	$text
        );

        $out .= "<span class=\"form-check-sign\"></span>";
        $out .= "</label>";
        $out .= "</div>";

        return $out;
	}

	public function index()
	{
		if($this->type=="edit"){
			$Database = new Database("db_owners", array(
				"method"=>"selectOwnerById",
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			if(!count($fetch)){
				die("Opps permition denied...");
			}

			$firstname = $fetch["firstname"];
			$lastname = $fetch["lastname"];
			$owners_name = $fetch["owners_name"];
			$owners_id = $fetch["owners_id"];
			$owners_birthday = $fetch["owners_birthday"];
			$owners_gender = $fetch["owners_gender"];
			$owners_phone = $fetch["owners_phone"];
			$owners_phone2 = $fetch["owners_phone2"];
			$owners_email = $fetch["owners_email"];
			$submitText = "განახლება";
			$submitClass = "editOwner";	
		}else{
			$firstname = "";
			$lastname = "";
			$owners_name = "";
			$owners_id = "";
			$owners_birthday = "";
			$owners_gender = "male";
			$owners_phone = "";
			$owners_phone2 = "";
			$owners_email = "";

			$submitText = "დამატება";
			$submitClass = "addOwner";	
		}

		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"ownerFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("სახელი", "firstname", htmlentities($firstname));
		$this->out .= $this->input("გვარი", "lastname", htmlentities($lastname));
		
		if($this->type !== "edit"){
			$this->out .= $this->input("მომხმარებლის სახელი", "owners_name", htmlentities($owners_name));
			$this->out .= $this->input("პაროლი", "owners_password", "", false, "password");
		}else{
			$this->out .= $this->input("მომხმარებლის სახელი", "owners_name", htmlentities($owners_name), true);
		}
		$this->out .= $this->input("საიდენთიფიკაციო კოდი", "owners_id", htmlentities($owners_id));

		$this->out .= $this->input("დაბადბის თარიღი", "owners_birthday datepicker", htmlentities($owners_birthday));

		$this->out .= $this->input("საკონტაქტო ნომერი", "owners_phone", htmlentities($owners_phone));
		$this->out .= $this->input("საკონტაქტო ნომერი 2", "owners_phone2", htmlentities($owners_phone2));
		$this->out .= $this->input("ელ-ფოსტა", "owners_email", htmlentities($owners_email));

		$list = [
			"male"=>"მამრობითი",
			"female"=>"მდედრობითი"
		];
		$this->out .= $this->select("სქესი", "owners_gender", $list, $owners_gender);
        
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