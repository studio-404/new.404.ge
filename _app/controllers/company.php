<?php 

class Company extends Controller
{
	public function index($language='', $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_company_list = $this->model('Module_company_list');
		$Module_company_list->page = $page;
		$Module_company_list->language = $language;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];


		$this->view('company/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"company",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"companyList"=>$Module_company_list->index()
		));
	}

	public function edit($language, $id = 0)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_company_form = $this->model('Module_company_form');
		$Module_company_form->type = "edit";
		$Module_company_form->language = $language;
		$Module_company_form->editId = $id;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('company/edit', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"company",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"id"=>$id,
			"form"=>$Module_company_form->index(),
		));
	}

	public function add($language)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_company_form = $this->model('Module_company_form');
		$Module_company_form->type = "add";

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('company/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"company",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"form"=>$Module_company_form->index(),
		));
	}
}