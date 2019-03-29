<?php 

class Module_users_form
{
	public $type;
	public $language;
	public $out = '';

	public function __construct()
	{
		
	}

	private function input($label, $className, $value){
		$out = "<div class=\"col-md-6\">"; 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $label); 
		$out .= sprintf(
			"<input type=\"text\" class=\"form-control %s\" value=\"%s\" autocomplete=\"off\" />",
			$className,
			htmlentities($value)
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
        $out .= sprintf("<input class=\"form-check-input %s\" type=\"checkbox\" %s value=\"%s\">", $className, $checked, $val);
        $out .= sprintf("%s <span class=\"form-check-sign\"></span>", $name);

        $out .= "</label>";
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
			$firstname = "hjajhdasd";
			$lastname = "hjajhdasd";
			$username = "hjajhdasd";
			$password = "hjajhdasd";
			$contact_email = "hjajhdasd";
			$contact_phone = "hjajhdasd";
			$submitText = "განახლება";
			$submitClass = "editUser";

			$companyAdd = false;
			$companyEdit = false;
			$companyDelete = false;

			$buildingAdd = false;
			$buildingEdit = false;
			$buildingDelete = false;

			$entranceAdd = false;
			$entranceEdit = false;
			$entranceDelete = false;

			$floorAdd = false;
			$floorEdit = false;
			$floorDelete = false;

			$roomAdd = false;
			$roomEdit = false;
			$roomDelete = false;
		}else{
			$firstname = "";
			$lastname = "";
			$username = "";
			$password = "";
			$contact_email = "";
			$contact_phone = "";
			$submitText = "დამატება";
			$submitClass = "addUser";

			$companyAdd = false;
			$companyEdit = false;
			$companyDelete = false;

			$buildingAdd = false;
			$buildingEdit = false;
			$buildingDelete = false;

			$entranceAdd = false;
			$entranceEdit = false;
			$entranceDelete = false;

			$floorAdd = false;
			$floorEdit = false;
			$floorDelete = false;

			$roomAdd = true;
			$roomEdit = true;
			$roomDelete = true;
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"userFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("სახელი", "firstname", htmlentities($firstname));
		$this->out .= $this->input("გვარი", "lastname", htmlentities($lastname));
		$this->out .= $this->input("მომხმარებლის სახელი", "username", htmlentities($username));
		$this->out .= $this->input("პაროლი", "password", htmlentities($password));
		$this->out .= $this->input("ელ-ფოსტა", "contact_email", htmlentities($contact_email));
		$this->out .= $this->input("საკონტაქტო ნომერი", "contact_phone", htmlentities($contact_phone));
		
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h5>ტიპი</h5>";
       	$this->out .= "</div>";
		$this->out .= $this->radio("user_type", "manager", "მენეჯერი ( შეუძლია მომხმარებლების დამატება/რედაქტირება/წაშლა )");
		$this->out .= $this->radio("user_type", "user", "მომხმარებელი", true);
		$this->out .= "</div>";

		
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";		
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h5>ნებართვა</h5>";
       	$this->out .= "</div>";
       	$this->out .= "</div>";

		$this->out .= "<div class=\"col-md-2\">";		
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h6>კომპანია</h6>";
       	$this->out .= "</div>";
       	$this->out .= $this->checkbox("companyCheckbox addChecked", $companyAdd, "დამატება", "add");
       	$this->out .= $this->checkbox("companyCheckbox editChecked", $companyEdit, "რედაქტირება", "edit");
       	$this->out .= $this->checkbox("companyCheckbox deleteChecked", $companyDelete, "წაშლა", "delete");
       	$this->out .= "</div>";

       	$this->out .= "<div class=\"col-md-2\">";		
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h6>მშენებლობა</h6>";
       	$this->out .= "</div>";
       	$this->out .= $this->checkbox("buildingCheckbox addChecked", $buildingAdd, "დამატება", "add");
       	$this->out .= $this->checkbox("buildingCheckbox editChecked", $buildingEdit, "რედაქტირება", "edit");
       	$this->out .= $this->checkbox("buildingCheckbox deleteChecked", $buildingDelete, "წაშლა", "delete");
       	$this->out .= "</div>";

       	$this->out .= "<div class=\"col-md-2\">";		
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h6>სადარბაზო</h6>";
       	$this->out .= "</div>";
       	$this->out .= $this->checkbox("entranceCheckbox addChecked", $entranceAdd, "დამატება", "add");
       	$this->out .= $this->checkbox("entranceCheckbox editChecked", $entranceEdit, "რედაქტირება", "edit");
       	$this->out .= $this->checkbox("entranceCheckbox deleteChecked", $entranceDelete, "წაშლა", "delete");
       	$this->out .= "</div>";

       	$this->out .= "<div class=\"col-md-2\">";		
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h6>სართული</h6>";
       	$this->out .= "</div>";
       	$this->out .= $this->checkbox("floorCheckbox addChecked", $floorAdd, "დამატება", "add");
       	$this->out .= $this->checkbox("floorCheckbox editChecked", $floorEdit, "რედაქტირება", "edit");
       	$this->out .= $this->checkbox("floorCheckbox deleteChecked", $floorDelete, "წაშლა", "delete");
       	$this->out .= "</div>";

       	$this->out .= "<div class=\"col-md-2\">";		
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h6>ბინა</h6>";
       	$this->out .= "</div>";
       	$this->out .= $this->checkbox("roomCheckbox addChecked", $roomAdd, "დამატება", "add");
       	$this->out .= $this->checkbox("roomCheckbox editChecked", $roomEdit, "რედაქტირება", "edit");
       	$this->out .= $this->checkbox("roomCheckbox deleteChecked", $roomDelete, "წაშლა", "delete");
       	$this->out .= "</div>";
        
		$this->out .= "<div class=\"col-md-12\">"; 
		$this->out .= "<div class=\"form-group\">"; 
		$this->out .= sprintf("<div class=\"update ml-auto mr-auto\">
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\">%s</button>
                    </div>", $submitClass, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}
}