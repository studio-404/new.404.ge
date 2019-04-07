<?php 

class Rooms extends Controller
{
	public function index($language='', $building_id = 0, $entrance_id = 0, $floor_id = 0, $page = 1)
	{
		if(!isset($_SESSION["user_data"])):
			$Functions = new Functions;
			$redirect = $Functions->load("fu_redirect");
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_room_list = $this->model('Module_room_list');
		$Module_room_list->page = $page;
		$Module_room_list->building_id = $building_id;
		$Module_room_list->entrance_id = $entrance_id;
		$Module_room_list->floor_id = $floor_id;
		$Module_room_list->language = $language;
		
		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];		

		$this->view('rooms/index', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"page"=>$page,
			"building_id"=>$building_id,
			"entrance_id"=>$entrance_id,
			"floor_id"=>$floor_id,
			"roomsList"=>$Module_room_list->index()
		));
	}

	public function add($language, $building_id = 0, $entrance_id = 0, $floor_id = 0)
	{
		$Functions = new Functions;
		$request = $Functions->load("fu_request");
		$redirect = $Functions->load("fu_redirect");
		if(!isset($_SESSION["user_data"])):			
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_room_form = $this->model('Module_room_form');
		$Module_room_form->building_id = $building_id;
		$Module_room_form->entrance_id = $entrance_id;
		$Module_room_form->floor_id = $floor_id;
		$Module_room_form->type = "add";

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];	
		
		if(isset($_FILES["files"]["name"][0])){
			$upload_room_images = $Functions->load("fu_upload_room_images");
			$upload_room_images->images = $_FILES;
			$upload_room_images->room_id = (int)$request->index("POST","insertedId");
			$upload_room_images->upload();
			$redirect->gotoUrl("/".$language."/rooms/index/".$building_id."/".$entrance_id."/".$floor_id);
		}

		$this->view('rooms/add', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"building_id"=>$building_id,
			"entrance_id"=>$entrance_id,
			"floor_id"=>$floor_id,
			"form"=>$Module_room_form->index(),
			"maxFileSize"=>Config::MAX_FILE_UPLOAD_SIZE
		));
	}


	public function edit($language, $building_id = 0, $entrance_id = 0, $floor_id = 0, $id = 0)
	{
		$Functions = new Functions;
		$redirect = $Functions->load("fu_redirect");
		$request = $Functions->load("fu_request");
		if(!isset($_SESSION["user_data"])):
			$redirect->gotoUrl("/".$language."/home/index");
		endif;

		$Module_room_form = $this->model('Module_room_form');
		$Module_room_form->type = "edit";
		$Module_room_form->language = $language;
		$Module_room_form->building_id = $building_id;
		$Module_room_form->entrance_id = $entrance_id;
		$Module_room_form->floor_id = $floor_id;
		$Module_room_form->editId = $id;

		$mainName = $_SESSION["user_data"]["firstname"] . " " . $_SESSION["user_data"]["lastname"];
		$user_type = $_SESSION["user_data"]["user_type"];	

		if(isset($_FILES["files"]["name"][0])){
			$upload_room_images = $Functions->load("fu_upload_room_images");
			$upload_room_images->images = $_FILES;
			$upload_room_images->room_id = (int)$id;
			$upload_room_images->upload();
			$redirect->gotoUrl();
		}	

		$this->view('rooms/edit', array(
			"title"=>Config::WEBSITE_TITLE,
			"v"=>Config::WEBSITE_VERSION,
			"controller"=>"building",
			"language"=>$language,
			"user_type"=>$user_type,
			"mainName"=>$mainName,
			"id"=>$id,
			"building_id"=>$building_id,
			"entrance_id"=>$entrance_id,
			"floor_id"=>$floor_id,
			"form"=>$Module_room_form->index(),
			"maxFileSize"=>Config::MAX_FILE_UPLOAD_SIZE
		));
	}

}