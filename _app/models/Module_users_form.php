<?php 

class Module_users_form
{
	public $type;
	public $language;
	public $editId = 0;
	public $out = '';

	public function __construct()
	{
		
	}

	private function input($label, $className, $value, $disable = false){
		$out = "<div class=\"col-md-6\">"; 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $label); 
		$disable = ($disable) ? ' disabled="disabled"' : '';
		$out .= sprintf(
			"<input type=\"text\" class=\"form-control %s\" value=\"%s\" autocomplete=\"off\" %s />",
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
        $out .= sprintf("<input class=\"form-check-input %s\" type=\"checkbox\" %s value=\"%s\">", $className, $checked, $val);
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
		foreach ($list as $item):
			$checked = (in_array($item["id"], $selected)) ? true : false;
			$out .= $this->checkbox($className, $checked, $item["title"], $item["id"]);
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
			$Database = new Database("db_users", array(
				"method"=>"selectUserById",
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$firstname = $fetch["firstname"];
			$lastname = $fetch["lastname"];
			$username = $fetch["username"];
			$password = $fetch["password"];
			$contact_email = $fetch["contact_email"];
			$contact_phone = $fetch["contact_phone"];
			$user_type_manager = ($fetch["user_type"]=="manager") ? true : false;
			$user_type_user = ($fetch["user_type"]=="user") ? true : false;
			$submitText = "განახლება";
			$submitClass = "editUser";

			$permission_company = explode(",", $fetch["permission_company"]);
			$permission_owner = explode(",", $fetch["permission_owner"]);
			$permission_buldings = explode(",", $fetch["permission_buldings"]);
			$permission_entrance = explode(",", $fetch["permission_entrance"]);
			$permission_floor = explode(",", $fetch["permission_floor"]);
			$permission_room = explode(",", $fetch["permission_room"]);
			$own_company = explode(",", $fetch["own_company"]);
			
			$companyAdd = (in_array("add", $permission_company)) ? true : false;
			$companyEdit = (in_array("edit", $permission_company)) ? true : false;
			$companyDelete = (in_array("delete", $permission_company)) ? true : false;

			$ownerAdd = (in_array("add", $permission_owner)) ? true : false;
			$ownerEdit = (in_array("edit", $permission_owner)) ? true : false;
			$ownerDelete = (in_array("delete", $permission_owner)) ? true : false;

			$buildingAdd = (in_array("add", $permission_buldings)) ? true : false;
			$buildingEdit = (in_array("edit", $permission_buldings)) ? true : false;
			$buildingDelete = (in_array("delete", $permission_buldings)) ? true : false;

			$entranceAdd = (in_array("add", $permission_entrance)) ? true : false;
			$entranceEdit = (in_array("edit", $permission_entrance)) ? true : false;
			$entranceDelete = (in_array("delete", $permission_entrance)) ? true : false;

			$floorAdd = (in_array("add", $permission_floor)) ? true : false;
			$floorEdit = (in_array("edit", $permission_floor)) ? true : false;
			$floorDelete = (in_array("delete", $permission_floor)) ? true : false;

			$roomAdd = (in_array("add", $permission_room)) ? true : false;
			$roomEdit = (in_array("edit", $permission_room)) ? true : false;
			$roomDelete = (in_array("delete", $permission_room)) ? true : false;
		}else{
			$firstname = "";
			$lastname = "";
			$username = "";
			$password = "";
			$contact_email = "";
			$contact_phone = "";
			$user_type_manager = false;
			$user_type_user = true;
			$submitText = "დამატება";
			$submitClass = "addUser";

			$companyAdd = false;
			$companyEdit = false;
			$companyDelete = false;

			$ownerAdd = true;
			$ownerEdit = true;
			$ownerDelete = true;

			$buildingAdd = true;
			$buildingEdit = true;
			$buildingDelete = true;

			$entranceAdd = true;
			$entranceEdit = true;
			$entranceDelete = true;

			$floorAdd = true;
			$floorEdit = true;
			$floorDelete = true;

			$roomAdd = true;
			$roomEdit = true;
			$roomDelete = true;

			$own_company = [];
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"userFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("სახელი", "firstname", htmlentities($firstname));
		$this->out .= $this->input("გვარი", "lastname", htmlentities($lastname));
		
		if($this->type !== "edit"){
			$this->out .= $this->input("მომხმარებლის სახელი", "username", htmlentities($username));
			$this->out .= $this->input("პაროლი", "password", htmlentities($password));
		}else{
			$this->out .= $this->input("მომხმარებლის სახელი", "username", htmlentities($username), true);
		}
		$this->out .= $this->input("ელ-ფოსტა", "contact_email", htmlentities($contact_email));
		$this->out .= $this->input("საკონტაქტო ნომერი", "contact_phone", htmlentities($contact_phone));
		
		$Database2 = new Database("db_companies", array(
			"method"=>"select",
			"page"=>1,
			"noLimit"=>true
		));
		$fetch = $Database2->getter();
		// $this->out .= print_r($fetch, true);
		$this->out .= $this->select("კომპანია", "companiesOwned", $fetch, $own_company);


		
		$this->out .= "<div class=\"col-md-12\" style=\"margin: 25px 0 0 0\">";
		$this->out .= "<div class=\"typography-line\">";
        $this->out .= "<h5>ტიპი</h5>";
       	$this->out .= "</div>";
		$this->out .= $this->radio("user_type", "manager", "მენეჯერი ( შეუძლია მომხმარებლების დამატება/რედაქტირება/წაშლა )", $user_type_manager);
		$this->out .= $this->radio("user_type", "user", "მომხმარებელი", $user_type_user);
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
        $this->out .= "<h6>მეპატრონე</h6>";
       	$this->out .= "</div>";
       	$this->out .= $this->checkbox("ownerCheckbox addOwner", $ownerAdd, "დამატება", "add");
       	$this->out .= $this->checkbox("ownerCheckbox editOwner", $ownerEdit, "რედაქტირება", "edit");
       	$this->out .= $this->checkbox("ownerCheckbox deleteOwner", $ownerDelete, "წაშლა", "delete");
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
                      <button type=\"button\" class=\"btn btn-primary btn-round %s\" data-editid=\"%d\">%s</button>
                    </div>", $submitClass, (int)$this->editId, $submitText);
		$this->out .= "</div>";		
		$this->out .= "</div>";

		$this->out .= "</div>";
		$this->out .= "</form>";		
		return $this->out;
	}
}