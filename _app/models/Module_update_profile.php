<?php 

class Module_update_profile
{
	public $data;
	private $out = '';

	public function __construct()
	{
		$Database = new Database("db_users", array(
			"method"=>"selectUserByUsername",
			"username"=>$_SESSION["user_data"]["username"]
		));

		$this->data = $Database->getter();
	}

	private function input($label, $className, $value){
		$out = "<div class=\"col-md-12\">"; 
		$out .= "<div class=\"form-group\">"; 
		$out .= sprintf("<label>%s</label>", $label); 
		$out .= sprintf(
			"<input type=\"text\" class=\"form-control %s\" value=\"%s\">",
			$className,
			htmlentities($value)
		); 
		$out .= "</div>"; 
		$out .= "</div>"; 
		return $out;
	}

	public function index()
	{

		if(isset($this->data)){
			$this->out .= "<form action=\"\" method=\"post\">"; 
			
			$this->out .= $this->input("სახელი", "firstname", $this->data["firstname"]);
			$this->out .= $this->input("გვარი", "lastname", $this->data["lastname"]);
			$this->out .= $this->input("ელ-ფოსტა", "contact_email", $this->data["contact_email"]);
			$this->out .= $this->input("საკონტაქტო ნომერი", "contact_phone", $this->data["contact_phone"]);

			$this->out .= "<div class=\"row\">
			<div class=\"update ml-auto mr-auto\">
			<button type=\"submit\" class=\"btn btn-primary btn-round updateProfileButton\">განახლება</button>
			</div>
			</div>";

			$this->out .= "</form>"; 
		}

		

		return $this->out;
	}
}