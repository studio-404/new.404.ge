<?php 

class Module_entrance_list
{
	public $page;
	public $language;
	public $building_id;
	private $out = '';

	public function __construct()
	{
		
	}

	public function index()
	{
		$bulding = new Database("db_building", array(
			"method"=>"selectBuildingById",
			"id"=>$this->building_id
		));

		if(!$bulding->getter()){
			die("Opps permition denied...");
		}
		
		$Database = new Database("db_entrance", array(
			"method"=>"select",
			"building_id"=>$this->building_id,
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
			$this->out .= "<th>მოქმედება</th>";
			$this->out .= "</tr>";
			$this->out .= "</thead>";
			$this->out .= "<tbody>";
			foreach ($data as $key => $value) {
				$this->out .= "<tr>";
				
				$this->out .= sprintf("<td>%s</td>", $value["id"]);
				$this->out .= sprintf("<td>%s</td>", $value["companyTitle"]);
				$this->out .= sprintf("<td>%s</td>", $value["building_title"]);
				$this->out .= sprintf("<td>%s</td>", $value["title"]);				

				$this->out .= "<td>";
				$this->out .= sprintf(
					"<a href=\"/%s/entrance/edit/%d/%d\" class=\"nc-icon nc-settings\" title=\"რედაქტირება\" style=\"font-size: 18px\"></a>",
					$this->language,
					$this->building_id,
					$value["id"]
				);

				$this->out .= sprintf(
					"<a href=\"/%s/floors/index/%d/%d\" class=\"nc-icon nc-tile-56\" style=\"font-size: 18px; margin-left: 10px;\" title=\"სართული\"></a>",
					$this->language,
					$this->building_id,
					$value["id"]
				);

				$this->out .= sprintf(
					"<a href=\"javascript:void(0)\" class=\"nc-icon nc-simple-remove removeEntrance\" data-modalTitle=\"შეტყობინება\" data-modalBody=\"გნებავთ წაშალოთ სადარბაზო?\" data-yesText=\"დიახ\" data-noText=\"არა\" data-id=\"%d\" style=\"font-size: 18px; margin-left: 10px;\" title=\"წაშლა\"></a>",
					$value["id"]	
				);
				$this->out .= "</td>";

				$this->out .= "</tr>";
			}
			$this->out .= '</tbody>';
			$this->out .= '</table>';
			$this->out .= '</div>';
			

			$buttons = (int)ceil((int)@$data[0]["counted"] / Config::ENTRANCE_LIST_PERPAGE);
			
			$this->out .= "<ul class=\"pagination\">";
			for($i=1; $i<=$buttons; $i++){
				$active = ($this->page==$i) ? ' active' : '';
				$this->out .= sprintf(
					"<li class=\"paginate_button page-item%s\"><a href=\"/%s/entrance/index/%d/%s\" class=\"page-link\">%s</a></li>",
					$active,
					$this->language,
					$this->building_id,
					$i,
					$i
				);
			}
			$this->out .= "</ul>";
		}		

		return $this->out;
	}
}