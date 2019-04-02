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
		$out .= sprintf("<p class=\"card-title\">%d<p>", $num);
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

	public function index()
	{
		$href = "/".$this->language."/users/index";
		$this->out .= $this->card("nc-single-02","მომხმარებელი", (int)@$this->data["userCount"], $href);

		$href = "/".$this->language."/company/index";
		$this->out .= $this->card("nc-alert-circle-i","კომპანია", (int)@$this->data["companyCount"], $href);

		$href = "/".$this->language."/building/index";
		$this->out .= $this->card("nc-bank","მშენებლობა", (int)@$this->data["buildingCount"], $href);

		return $this->out;
	}
}