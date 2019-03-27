<?php 

class Ajax extends Controller
{
	public function index($language = '', $className = '')
	{
		$output = array("error"=>true, "success"=>false, "message"=>"მოთხოვნა ვერ მოიძებნა!");
		if(file_exists('../_app/ajax/' . $className . '.php')){
			require_once '../_app/ajax/' . $className . '.php';
			$object = @eval("return new ".$className.";");

			echo json_encode($object->output($language));
			exit;
		}
		http_response_code(404);
		echo json_encode($output);
	}
}