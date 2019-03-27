<?php 

class Home extends Controller
{
	public function __construct()
	{
		if(isset($_SESSION["user_data"])):
			unset($_SESSION["user_data"]);
		endif;
	}

	public function index($language='', $name = '')
	{
		// $Module_name_list = $this->model('Module_name_list');		

		$this->view('home/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"language"=>$language
		));
	}
}