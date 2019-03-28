<?php 

class Module_users_list
{
	public $data;
	private $out = '';

	public function __construct()
	{
		$Database = new Database("db_users", array(
			"method"=>"select"
		));	

		$this->data = $Database->getter();
	}

	public function index()
	{
		if(isset($this->data)){
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
			foreach ($this->data as $key => $value) {
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
		}		

		return $this->out;
	}
}