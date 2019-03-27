<?php 

class vaime
{
	public function output($language = '')
	{
		http_response_code(200);
		return array("error"=>false, "success"=>true, "message"=>$language);
	}
}