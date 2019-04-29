<?php 

class Dashboard extends Controller
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
	
	public function index($language='')
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;


		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];

		$Module_dashboard = $this->model('Module_dashboard');
		$Module_dashboard->language = $language;

		$this->view('dashboard/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"dashboard",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"dashboard_cards"=>$Module_dashboard->index()
		));
	}
}