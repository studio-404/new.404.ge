<?php 

class Profile extends Controller
{
	public function index($language='', $name = '')
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_update_profile = $this->model('Module_update_profile');


		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];

		

		$this->view('profile/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"profile",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"profile_form"=>$Module_update_profile->index()
		));
	}
}