<?php 

class Owners extends Controller
{
	public function __construct()
	{
		$IP = new Database("db_ip", array(
			"method"=>"select",
			"page"=>0,
			"noLimit"=>true
		));
		$fetchIps = $IP->getter();
		$allow = array();
		foreach ($fetchIps as $v) {
			$allow[] = $v["ip"];
		}

		if(!in_array($_SERVER["REMOTE_ADDR"], $allow)){ 
			die("Your Ip Address <b>(".$_SERVER["REMOTE_ADDR"].")</b> is not allowed. Please contact your administrator."); 
			exit; 
		}
	}
	
	public function index($language='', $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_owners_list = $this->model('Module_owners_list');
		$Module_owners_list->page = $page;
		$Module_owners_list->language = $language;
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('owners/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"owners",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"page"=>$page,
			"owenersList"=>$Module_owners_list->index()
		));
	}

	public function add($language)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_owners_form = $this->model('Module_owners_form');
		$Module_owners_form->type = "add";

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('owners/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"owners",
			"datepicker"=>true,
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"form"=>$Module_owners_form->index(),
		));
	}
}