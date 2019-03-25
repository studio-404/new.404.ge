<?php 

class Dashboard extends Controller
{
	public function index($language='', $name = '')
	{
		// $Module_name_list = $this->model('Module_name_list');

		$this->view('dashboard/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"language"=>$language
		));
	}
}