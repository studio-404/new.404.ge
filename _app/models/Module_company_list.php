<?php 

class Module_company_list
{
	public $page;
	public $language;
	private $out = '';

	public function __construct()
	{
		
	}

	public function index()
	{
		$Database = new Database("db_companies", array(
			"method"=>"select",
			"page"=>$this->page
		));	

		$data = $Database->getter();

		if(isset($data)){
			$this->out .= "<div class=\"table-responsive\">";
			$this->out .= "<table class=\"table\">";
			$this->out .= "<thead class=\"text-primary\">";
			$this->out .= "<tr>";
			$this->out .= "<th>ს.კ.</th>";
			$this->out .= "<th>დასახელება</th>";
			$this->out .= "<th>საიდენთიფიკაციო კოდი</th>";
			$this->out .= "<th>საკ. ნომერი</th>";
			$this->out .= "<th>მოქმედება</th>";
			$this->out .= "</tr>";
			$this->out .= "</thead>";
			$this->out .= "<tbody>";
			foreach ($data as $key => $value) {
				$this->out .= "<tr>";
				
				$this->out .= sprintf("<td>%s</td>", $value["id"]);
				$this->out .= sprintf("<td>%s</td>", $value["title"]);
				$this->out .= sprintf("<td>%s</td>", $value["identity"]);
				$this->out .= sprintf("<td>%s</td>", $value["contact_phone"]);

				$this->out .= "<td>";
				$this->out .= sprintf(
					"<a href=\"/%s/company/edit/%d\" class=\"nc-icon nc-settings\" style=\"font-size: 18px\" title=\"რედაქტირება\"></a>",
					$this->language,
					$value["id"]
				);
				$this->out .= sprintf(
					"<a href=\"javascript:void(0)\" class=\"nc-icon nc-simple-remove removeCompany\" data-modalTitle=\"შეტყობინება\" data-modalBody=\"გნებავთ წაშალოთ კომპანია?\" data-yesText=\"დიახ\" data-noText=\"არა\" data-id=\"%d\" style=\"font-size: 18px; margin-left: 10px;\" title=\"წაშლა\"></a>",
					$value["id"]	
				);
				$this->out .= "</td>";

				$this->out .= "</tr>";
			}
			$this->out .= '</tbody>';
			$this->out .= '</table>';
			$this->out .= '</div>';
			
			$c = (isset($data[0]["counted"])) ? $data[0]["counted"] : 0;
			$buttons = (int)ceil($c / Config::COMPANY_LIST_PERPAGE);
			$this->out .= "<ul class=\"pagination\">";
			for($i=1; $i<=$buttons; $i++){
				$active = ($this->page==$i) ? ' active' : '';
				$this->out .= sprintf(
					"<li class=\"paginate_button page-item%s\"><a href=\"/%s/company/index/%s\" class=\"page-link\">%s</a></li>",
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