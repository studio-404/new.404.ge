<?php 

class Schedule extends Controller
{
	public function index($language='')
	{
		if(!isset($_SESSION["public_user"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Database = new Database("db_owners", array(
			"method"=>"selectOwnerByUsername",
			"owners_name"=>$_SESSION["public_user"]
		));
		$fetch = $Database->getter();


		$mainName = sprintf("%s %s", $fetch["firstname"], $fetch["lastname"]);
		$user_type = "public_user";

		// $Module_dashboard = $this->model('Module_dashboard');
		// $Module_dashboard->language = $language;

		$this->view('schedule/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"schedule",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName
		));
	}
}