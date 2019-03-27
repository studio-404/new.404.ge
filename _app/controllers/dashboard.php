<?php 

class Dashboard extends Controller
{
	public function index($language='', $name = '')
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;


		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];

		// $Module_name_list = $this->model('Module_name_list');

		$this->view('dashboard/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName
		));
	}
}