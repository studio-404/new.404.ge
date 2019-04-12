<?php 

class Module_ip_form
{
	public $type;
	public $language;
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
			$Database = new Database("db_ip", array(
				"method"=>"selectIpById",
				"id"=>$this->editId
			));
			$fetch = $Database->getter();

			$name = $fetch["name"];
			$ip = $fetch["ip"];
			$submitText = "რედაქტირება";
			$submitClass = "editIP";			
		}else{
			$name = "";
			$ip = "";
			$submitText = "დამატება";
			$submitClass = "addIP";			
		}
		$this->out .= "<form>";
		$this->out .= "<div class=\"row\">";
		
		$this->out .= "<div class=\"col-md-12\">";
		$this->out .= "<div class=\"ipFormMessageBox\">";
		$this->out .= "</div>";
		$this->out .= "</div>";
		
		$this->out .= $this->input("სახელი გვარი", "name", htmlentities($name), false, 12);		
		$this->out .= $this->input("IP მისამართი", "ip", htmlentities($ip), false, 12);		
		

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