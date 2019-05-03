<?php 

class Module_dashboard
{
	public $data;
	public $language;
	private $out = '';

	public function __construct()
	{
		$Database = new Database("db_data", array(
			"method"=>"select"
		));	

		$this->data = $Database->getter();
	}

	private function card($icon, $title, $num, $href)
	{
		$out = "<div class=\"col-lg-4 col-md-12 col-sm-12\">";
		$out .= "<div class=\"card card-stats\">";
		$out .= "<div class=\"card-body\">";
		$out .= "<div class=\"row\">";
		$out .= "<div class=\"col-5 col-md-4\">";
		$out .= "<div class=\"icon-big text-center icon-danger\">";
		$out .= sprintf("<i class=\"nc-icon %s text-danger\"></i>", $icon);
		$out .= "</div>";
		$out .= "</div>";
		$out .= "<div class=\"col-7 col-md-8\">";
		$out .= "<div class=\"numbers\">";
		$out .= sprintf("<p class=\"card-category\">%s</p>", $title);
		$out .= sprintf("<p class=\"card-title\">%s<p>", $num);
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "<div class=\"card-footer\">";
		$out .= "<hr>";
		$out .= "<div class=\"stats\">";
		$out .= sprintf("<a href=\"%s\">", $href);
		$out .= "<i class=\"fa fa-eye\"></i> ნახვა";
		$out .= "</a>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";
		$out .= "</div>";

		return $out;
	}

	private function permitions()
	{
		$Functions = new Functions();
		$permition = $Functions->load("fu_permision");

		$out = "<div class=\"col-lg-12 col-md-12 col-sm-12\">";
		$out .= "<div class=\"card card-stats\">";
		$out .= "<div class=\"card-header\">
                <h4 class=\"card-title\"> ნებართვები</h4>
              </div>";
		$out .= "<div class=\"card-body\">";
		
		$out .= "<div class=\"table-responsive\">";
		$out .= "<table class=\"table\">";
		$out .= "<thead class=\"text-primary\">";
		
		$out .= "<tr>";
		$out .= "<th>მოქმედება</th>";
		$out .= "<th>კომპანია</th>";
		$out .= "<th>მეპატრონე</th>";
		$out .= "<th>მშენებლობა</th>";
		$out .= "<th>სადარბაზო</th>";
		$out .= "<th>სართული</th>";
		$out .= "<th>ოთახი</th>";
		$out .= "</tr>";

		$out .= "</thead>";
		$out .= "<tbody>";
		
		$out .= "<tr>";
		$out .= "<td>დამატება</td>";		
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_company", "add")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');

		$out .= sprintf("<td>%s</td>", ($permition->check("permission_owner", "add")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_buldings", "add")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_entrance", "add")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_floor", "add")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_room", "add")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= "</tr>";

		$out .= "<tr>";
		$out .= "<td>რედაქტირება</td>";		
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_company", "edit")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_owner", "edit")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_buldings", "edit")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_entrance", "edit")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_floor", "edit")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_room", "edit")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= "</tr>";

		$out .= "<tr>";
		$out .= "<td>წაშლა</td>";		
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_company", "delete")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_owner", "delete")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_buldings", "delete")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_entrance", "delete")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_floor", "delete")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= sprintf("<td>%s</td>", ($permition->check("permission_room", "delete")) ? '<i class="fa fa-check" aria-hidden="true" style="color:green"></i>' : '<i class="fa fa-times" aria-hidden="true" style="color:red"></i');
		$out .= "</tr>";
		
		$out .= "</tbody>";
		$out .= "</table>";
		$out .= "</div>";
		

		$out .= "</div>";

		

		$out .= "</div>";
		$out .= "</div>";

		return $out;
	}

	private function logs()
	{
		$Database = new Database("db_logs", array(
			"method"=>"select",
			"page"=>1
		));

		$logs = $Database->getter();

		$out = "<div class=\"col-lg-12 col-md-12 col-sm-12\">";
		$out .= "<div class=\"card card-stats\">";
		
		$out .= "<div class=\"card-header\">";
		$out .= "<h4 class=\"card-title\">ლოგები</h4>";
		$out .= "</div>";
		
		$out .= "<div class=\"card-body\">";
		$out .= "<div class=\"table-responsive\">";
		
		$out .= "<table class=\"table\">";
		// $out .= print_r($logs, true);
		$out .= "<thead class=\"text-primary\">";
		$out .= "<tr>";
		$out .= "<th>თარიღი</th>";
		$out .= "<th>IP</th>";
		$out .= "<th>მომხმარებელი</th>";
		$out .= "<th>მოქმედება</th>";
		$out .= "</tr>";
		$out .= "</thead>";

		$out .= "<tbody>";
		foreach($logs as $log):
			$out .= "<tr>";
			$out .= sprintf(
				"<td>%s</td>",
				date("Y-m-d H:i:s", $log["date"])
			);
			$out .= sprintf("<td>%s</td>", $log["ip"]);
			$out .= sprintf("<td>%s</td>", $log["usersName"]);
			$out .= sprintf("<td>%s:%s</td>", $log["type"], $log["action"]);
			$out .= "</tr>";
		endforeach;
		
		$out .= "</tbody>";

		$out .= "</table>";

		$out .= "</div>";
		$out .= "</div>";
		
		$out .= "</div>";
		$out .= "</div>";

		return $out;
	}

	public function index()
	{
		if($_SESSION["user_data"]["user_type"]=="manager"){
			$href = "/".$this->language."/users/index";
			$this->out .= $this->card("nc-single-02","მომხმარებელი", (int)@$this->data["userCount"], $href);		

			$href = "/".$this->language."/company/index";
			$this->out .= $this->card("nc-alert-circle-i","კომპანია", (int)@$this->data["companyCount"], $href);

			$href = "/".$this->language."/building/index";
			$this->out .= $this->card("nc-bank","მშენებლობა", (int)@$this->data["buildingCount"], $href);
		}

		if($_SESSION["user_data"]["user_type"]=="user"){
			$href = "#";

			$own_company = count(explode(",", $_SESSION["user_data"]["own_company"]));
			$this->out .= $this->card("nc-alert-circle-i","კომპანია", (int)$own_company, $href);

			$href = "/".$this->language."/building/index";
			$this->out .= $this->card("nc-bank","მშენებლობა", (int)@$this->data["buildingCount"], $href);

			$href = "#";
			$flats = sprintf(
				"<font color=\"green\">%s</font> / <font color=\"yellow\">%s</font> / <font color=\"red\">%s</font>", 
				(int)@$this->data["avaliableRooms"],
				(int)@$this->data["installmentRooms"],
				(int)@$this->data["soldRooms"]
			);
			$this->out .= $this->card("nc-bank","ბინები (ხელ/გან/გაყ)", $flats, $href);
		}

		$this->out .= $this->permitions();
		
		if($_SESSION["user_data"]["user_type"]=="manager"){
			$this->out .= $this->logs();
		}

		return $this->out;
	}
}