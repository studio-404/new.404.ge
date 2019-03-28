<?php 

class Users extends Controller
{
	public function index($language='', $name = '')
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_users_list = $this->model('Module_users_list');
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];

		

		$this->view('users/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"users",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"usersList"=>$Module_users_list->index()
		));
	}
}