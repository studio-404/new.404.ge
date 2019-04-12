<?php 

class Module_ip_list
{
	public $page;
	public $language;
	private $out = '';

	public function __construct()
	{
		
	}

	public function index()
	{
		$Database = new Database("db_ip", array(
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
			$this->out .= "<th>IP მისამართი</th>";
			$this->out .= "<th>სახელი გვარი</th>";
			$this->out .= "<th>მოქმედება</th>";
			$this->out .= "</tr>";
			$this->out .= "</thead>";
			$this->out .= "<tbody>";
			foreach ($data as $key => $value) {
				$this->out .= "<tr>";
				
				$this->out .= sprintf("<td>%s</td>", $value["id"]);
				$this->out .= sprintf("<td>%s</td>", $value["ip"]);
				$this->out .= sprintf("<td>%s</td>", $value["name"]);			

				$this->out .= "<td>";
				$this->out .= sprintf(
					"<a href=\"/%s/ip/edit/%d\" class=\"nc-icon nc-settings\" title=\"რედაქტირება\" style=\"font-size: 18px\"></a>",
					$this->language,
					$value["id"]
				);

				$this->out .= sprintf(
					"<a href=\"javascript:void(0)\" class=\"nc-icon nc-simple-remove removeIp\" data-modalTitle=\"შეტყობინება\" data-modalBody=\"გნებავთ წაშალოთ IP მისამართი?\" data-yesText=\"დიახ\" data-noText=\"არა\" data-id=\"%d\" style=\"font-size: 18px; margin-left: 10px;\" title=\"წაშლა\"></a>",
					$value["id"]	
				);
				$this->out .= "</td>";

				$this->out .= "</tr>";
			}
			$this->out .= '</tbody>';
			$this->out .= '</table>';
			$this->out .= '</div>';
			

			$buttons = (int)ceil((int)@$data[0]["counted"] / Config::IP_LIST_PERPAGE);
			
			$this->out .= "<ul class=\"pagination\">";
			for($i=1; $i<=$buttons; $i++){
				$active = ($this->page==$i) ? ' active' : '';
				$this->out .= sprintf(
					"<li class=\"paginate_button page-item%s\"><a href=\"/%s/ip/index/%s\" class=\"page-link\">%s</a></li>",
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