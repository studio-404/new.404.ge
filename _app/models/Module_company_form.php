<?php 

class Module_company_form
{
	public $type;
	public $language;
	public $editId = 0;
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

	public function index()
	{
		if($this->type=="edit"){
			$Database = new Database("db_companies", array(
				"method"=>"selectUserById",
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$title = $fetch["title"];
			$identity = $fetch["identity"];
			$contact_phone = $fetch["contact_phone"];
			$address = $fetch["address"];
			$contact_email = $fetch["contact_email"];
			$website = $fetch["website"];
			$status = $fetch["status"];
			$submitText = "განახლება";
			$submitClass = "editCompany";
		}else{
			$title = "";
			$identity = "";
			$contact_phone = "";
			$address = "";
			$contact_email = "";
			$website = "";
			$status = "";
			$submitText = "დამატება";
			$submitClass = "addCompany";
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"companiesFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("დასახელება", "title", htmlentities($title));
		$this->out .= $this->input("საიდენთიფიკაციო კოდი", "identity", htmlentities($identity));
		$this->out .= $this->input("საკონტაქტო ნომერი", "contact_phone", htmlentities($contact_phone));
		$this->out .= $this->input("ელ-ფოსტა", "contact_email", htmlentities($contact_email));
		$this->out .= $this->input("მისამართი", "address", htmlentities($address));
		$this->out .= $this->input("ვებ გვერდი", "website", htmlentities($website));
		
        
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