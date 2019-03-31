<?php 

class Building extends Controller
{
	public function index($language='', $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_building_list = $this->model('Module_building_list');
		$Module_building_list->page = $page;
		$Module_building_list->language = $language;
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('building/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"page"=>$page,
			"buildingList"=>$Module_building_list->index()
		));
	}

	public function add($language)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_building_form = $this->model('Module_building_form');
		$Module_building_form->type = "add";

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('building/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"form"=>$Module_building_form->index(),
			"map"=>$Module_building_form->map_coordinates
		));
	}

	public function edit($language, $id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_building_form = $this->model('Module_building_form');
		$Module_building_form->type = "edit";
		$Module_building_form->language = $language;
		$Module_building_form->editId = $id;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('building/edit', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"id"=>$id,
			"form"=>$Module_building_form->index(),
			"map"=>$Module_building_form->map_coordinates
		));
	}
}