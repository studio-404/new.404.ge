<?php 

class Module_users_list
{
	public $page;
	public $language;
	private $out = '';

	public function __construct()
	{
		
	}

	public function index()
	{
		$Database = new Database("db_users", array(
			"method"=>"select",
			"page"=>$this->page
		));	

		$data = $Database->getter();

		if(isset($data)){
			$this->out .= "<div class=\"table-responsive\">";
			$this->out .= "<table class=\"table\">";
			$this->out .= "<thead class=\"text-primary\">";
			$this->out .= "<tr>";
			$this->out .= "<th>სახელი გვარი</th>";
			$this->out .= "<th>მომხ. სახელი</th>";
			$this->out .= "<th>მომხ. ტიპი</th>";
			$this->out .= "<th>მოქმედება</th>";
			$this->out .= "</tr>";
			$this->out .= "</thead>";
			$this->out .= "<tbody>";
			foreach ($data as $key => $value) {
				$this->out .= "<tr>";
				
				$this->out .= sprintf("<td>%s %s</td>", $value["firstname"], $value["lastname"]);
				$this->out .= sprintf("<td>%s</td>", $value["username"]);
				$this->out .= sprintf("<td>%s</td>", $value["user_type"]);

				$this->out .= "<td>";
				$this->out .= "<a href=\"\" class=\"nc-icon nc-settings\" style=\"font-size: 18px\"></a>";
				$this->out .= "<a href=\"\" class=\"nc-icon nc-simple-remove\" style=\"font-size: 18px; margin-left: 10px;\"></a>";
				$this->out .= "</td>";

				$this->out .= "</tr>";
			}
			$this->out .= '</tbody>';
			$this->out .= '</table>';
			$this->out .= '</div>';
			

			$buttons = (int)($data[0]["counted"] / Config::USER_LIST_PERPAGE);
			for($i=1; $i<=$buttons; $i++){
				$active = ($this->page==$i) ? ' active' : '';
				$this->out .= sprintf(
					"<a href=\"/%s/users/index/%s\" class=\"pagintayion%s\">%s</a>",
					$this->language,
					$i,
					$active,
					$i
				);
			}
		}		

		return $this->out;
	}
}