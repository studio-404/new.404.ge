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
				$this->out .= sprintf(
					"<a href=\"/%s/users/edit/%d\" class=\"nc-icon nc-settings\" style=\"font-size: 18px\" title=\"რედაქტირება\"></a>",
					$this->language,
					$value["id"]
				);
				
				$this->out .= sprintf(
					"<a href=\"javascript:void(0)\" class=\"nc-icon nc-simple-remove removeUser\" data-modalTitle=\"შეტყობინება\" data-modalBody=\"გნებავთ წაშალოთ მომხმარებელი?\" data-yesText=\"დიახ\" data-noText=\"არა\" data-id=\"%d\" style=\"font-size: 18px; margin-left: 10px;\" title=\"წაშლა\"></a>",
					$value["id"]	
				);
				$this->out .= "</td>";

				$this->out .= "</tr>";
			}
			$this->out .= '</tbody>';
			$this->out .= '</table>';
			$this->out .= '</div>';
			

			$buttons = (int)ceil((int)@$data[0]["counted"] / Config::USER_LIST_PERPAGE);
			
			$this->out .= "<ul class=\"pagination\">";
			for($i=1; $i<=$buttons; $i++){
				$active = ($this->page==$i) ? ' active' : '';
				$this->out .= sprintf(
					"<li class=\"paginate_button page-item%s\"><a href=\"/%s/users/index/%s\" class=\"page-link\">%s</a></li>",
					$active,
					$this->language,
					$i,
					$i
				);
			}
			$this->out .= "</ul>";
		}		

		return $this->out;
	}
}