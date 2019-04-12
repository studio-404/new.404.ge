<?php 

class Ip extends Controller
{
	public function index($language='', $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_ip_list = $this->model('Module_ip_list');
		$Module_ip_list->page = $page;
		$Module_ip_list->language = $language;
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('ip/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"ip",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"page"=>$page,
			"ipList"=>$Module_ip_list->index()
		));
	}

	public function add($language)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_ip_form = $this->model('Module_ip_form');
		$Module_ip_form->type = "add";
		$Module_ip_form->language = $language;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('ip/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"ip",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"form"=>$Module_ip_form->index()
		));
	}

	public function edit($language, $id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_ip_form = $this->model('Module_ip_form');
		$Module_ip_form->type = "edit";
		$Module_ip_form->language = $language;
		$Module_ip_form->editId = $id;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('ip/edit', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"ip",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"id"=>$id,
			"form"=>$Module_ip_form->index()
		));
	}
}