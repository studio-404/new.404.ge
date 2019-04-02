<?php 

class Entrance extends Controller
{
	public function index($language='', $building_id = 0, $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_entrance_list = $this->model('Module_entrance_list');
		$Module_entrance_list->page = $page;
		$Module_entrance_list->building_id = $building_id;
		$Module_entrance_list->language = $language;
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('entrance/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"page"=>$page,
			"building_id"=>$building_id,
			"entranceList"=>$Module_entrance_list->index()
		));
	}

	public function add($language, $building_id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_entrance_form = $this->model('Module_entrance_form');
		$Module_entrance_form->building_id = $building_id;
		$Module_entrance_form->type = "add";

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('entrance/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"building_id"=>$building_id,
			"form"=>$Module_entrance_form->index()
		));
	}

	public function edit($language, $building_id = 0, $id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_entrance_form = $this->model('Module_entrance_form');
		$Module_entrance_form->type = "edit";
		$Module_entrance_form->language = $language;
		$Module_entrance_form->building_id = $building_id;
		$Module_entrance_form->editId = $id;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('entrance/edit', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"id"=>$id,
			"building_id"=>$building_id,
			"form"=>$Module_entrance_form->index()
		));
	}
}