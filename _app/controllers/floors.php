<?php 

class Floors extends Controller
{
	public function index($language='', $building_id = 0, $entrance_id = 0, $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_floor_list = $this->model('Module_floor_list');
		$Module_floor_list->page = $page;
		$Module_floor_list->building_id = $building_id;
		$Module_floor_list->entrance_id = $entrance_id;
		$Module_floor_list->language = $language;
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('floors/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"page"=>$page,
			"building_id"=>$building_id,
			"entrance_id"=>$entrance_id,
			"floorsList"=>$Module_floor_list->index()
		));
	}

	public function add($language, $building_id = 0, $entrance_id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_floor_form = $this->model('Module_floor_form');
		$Module_floor_form->building_id = $building_id;
		$Module_floor_form->entrance_id = $entrance_id;
		$Module_floor_form->type = "add";

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('floors/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"building_id"=>$building_id,
			"entrance_id"=>$entrance_id,
			"form"=>$Module_floor_form->index()
		));
	}

	public function edit($language, $building_id = 0, $entrance_id = 0, $id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_floor_form = $this->model('Module_floor_form');
		$Module_floor_form->type = "edit";
		$Module_floor_form->language = $language;
		$Module_floor_form->building_id = $building_id;
		$Module_floor_form->entrance_id = $entrance_id;
		$Module_floor_form->editId = $id;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('floors/edit', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"id"=>$id,
			"building_id"=>$building_id,
			"entrance_id"=>$entrance_id,
			"form"=>$Module_floor_form->index()
		));
	}
}