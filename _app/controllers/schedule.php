<?php 

class Schedule extends Controller
{
	public function index($language='', $page = 1)
	{
		if(!isset($_SESSION["public_user"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Database = new Database("db_owners", array(
			"method"=>"selectOwnerByUsername",
			"owners_name"=>$_SESSION["public_user"]
		));
		$fetch = $Database->getter();


		$mainName = sprintf("%s %s", $fetch["firstname"], $fetch["lastname"]);
		$user_type = "public_user";

		$Module_my_flats = $this->model('Module_my_flats');
		$Module_my_flats->language = $language;
		$Module_my_flats->page = $page;

		$this->view('schedule/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"schedule",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"flat_list"=>$Module_my_flats->index()
		));
	}

	public function room($language, $id)
	{
		if(!isset($_SESSION["public_user"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Database = new Database("db_owners", array(
			"method"=>"selectOwnerByUsername",
			"owners_name"=>$_SESSION["public_user"]
		));
		$fetch = $Database->getter();

		$rooms = new Database("db_room", array(
			"method"=>"selectRoomByIdAndOwner",
			"owner_id"=>$fetch["id"],
			"id"=>$id
		));

		if(!$rooms->getter() || !$Database->getter()){
			die("Opps permition denied...");
		}
		
		$Module_flat_view = $this->model('Module_flat_view');
		$Module_flat_view->language = $language;
		$Module_flat_view->data = $rooms->getter();


		$mainName = sprintf("%s %s", $fetch["firstname"], $fetch["lastname"]);
		$user_type = "public_user";

		$this->view('schedule/room', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"schedule",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"flat_view"=>$Module_flat_view->index()
		));
	}
}