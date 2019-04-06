<?php 

class Module_room_list
{
	public $page;
	public $language;
	public $building_id;
	public $entrance_id;
	public $floor_id;
	private $out = '';

	public function __construct()
	{
		
	}

	public function index()
	{
		$Database = new Database("db_room", array(
			"method"=>"select",
			"building_id"=>$this->building_id,
			"entrance_id"=>$this->entrance_id,
			"floor_id"=>$this->floor_id,
			"page"=>$this->page			
		));	

		$data = $Database->getter();

		if(isset($data)){
			$this->out .= "<div class=\"table-responsive\">";
			$this->out .= "<table class=\"table\">";
			$this->out .= "<thead class=\"text-primary\">";
			$this->out .= "<tr>";
			$this->out .= "<th>ს.კ.</th>";
			$this->out .= "<th>კომპანია</th>";
			$this->out .= "<th>მშენებლობა</th>";
			$this->out .= "<th>სადარბაზო</th>";
			$this->out .= "<th>სართული</th>";
			$this->out .= "<th>ბინა</th>";
			$this->out .= "<th>მოქმედება</th>";
			$this->out .= "</tr>";
			$this->out .= "</thead>";
			$this->out .= "<tbody>";
			foreach ($data as $key => $value) {
				$this->out .= "<tr>";
				
				$this->out .= sprintf("<td>%s</td>", $value["id"]);
				$this->out .= sprintf("<td>%s</td>", $value["companyTitle"]);
				$this->out .= sprintf("<td>%s</td>", $value["building_title"]);
				$this->out .= sprintf("<td>%s</td>", $value["entrance_title"]);
				$this->out .= sprintf("<td>%s</td>", $value["floor_title"]);
				$this->out .= sprintf("<td>%s</td>", $value["title"]);				

				$this->out .= "<td>";
				$this->out .= sprintf(
					"<a href=\"/%s/rooms/edit/%d/%d/%d/%d\" class=\"nc-icon nc-settings\" title=\"რედაქტირება\" style=\"font-size: 18px\"></a>",
					$this->language,
					$this->building_id,
					$this->entrance_id,
					$this->floor_id,
					$value["id"]
				);

				$this->out .= sprintf(
					"<a href=\"javascript:void(0)\" class=\"nc-icon nc-simple-remove removeRoom\" data-modalTitle=\"შეტყობინება\" data-modalBody=\"გნებავთ წაშალოთ ბინა?\" data-yesText=\"დიახ\" data-noText=\"არა\" data-id=\"%d\" style=\"font-size: 18px; margin-left: 10px;\" title=\"წაშლა\"></a>",
					$value["id"]	
				);
				$this->out .= "</td>";

				$this->out .= "</tr>";
			}
			$this->out .= '</tbody>';
			$this->out .= '</table>';
			$this->out .= '</div>';
			
			$counted = (isset($data[0]["counted"])) ? (int)$data[0]["counted"] : 1;
			$buttons = (int)ceil((int)$counted / Config::ROOM_LIST_PERPAGE);
			
			$this->out .= "<ul class=\"pagination\">";
			for($i=1; $i<=$buttons; $i++){
				$active = ($this->page==$i) ? ' active' : '';
				$this->out .= sprintf(
					"<li class=\"paginate_button page-item%s\"><a href=\"/%s/rooms/index/%d/%d/%d/%s\" class=\"page-link\">%s</a></li>",
					$active,
					$this->language,
					$this->building_id,
					$this->entrance_id,
					$this->floor_id,
					$i,
					$i
				);
			}
			$this->out .= "</ul>";
		}		

		return $this->out;
	}
}